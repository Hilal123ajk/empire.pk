# Cart & Checkout — Technical Guide

## Overview

The cart is **client-side** (Alpine.js + `localStorage` via `store-app.js`). Checkout submits cart contents to the server, which validates input, creates an `orders` record, and decrements stock inside a transaction.

---

## Frontend

### Files

| File | Role |
|------|------|
| `public/js/store-app.js` | `Alpine.store('cart')`, checkout form, confirm modal |
| `resources/views/components/cart-drawer.blade.php` | Slide-out cart UI |
| `resources/views/checkout.blade.php` | Checkout form + order confirm dialog |
| `resources/views/layouts/app.blade.php` | Includes cart drawer, `.store-select` styles |

### Cart store

Cart items structure (approximate):

```javascript
{
  productId,
  slug,
  name,
  price,
  quantity,
  image,
  variantImageId,   // null for Main
  variantLabel,
  variantImage
}
```

- Lines are unique by product + variant combination
- **Continue Shopping** in cart drawer links to `route('store.home')`
- `/cart` redirects to `/checkout` (`routes/web.php`)

### Checkout confirm modal

Before POST, Alpine sets `confirmOpen = true`. User must confirm in a styled modal (not `window.confirm`). On confirm, form submits via `confirmPlaceOrder()`.

---

## Backend

### Route

```php
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('checkout.store');
```

Rate limit: **10 requests per minute** per IP.

### Controller

**`App\Http\Controllers\Store\CheckoutController`**

- Validates via `StoreCheckoutRequest`
- Passes validated data to `OrderService::createFromCheckout()`
- Returns JSON success or validation/error response for AJAX handling

### Validation — `StoreCheckoutRequest`

| Field | Rules |
|-------|--------|
| `first_name`, `last_name` | Required, 2–100 chars, letters/spaces |
| `phone` | Required, Pakistani mobile: `03XXXXXXXXX` (normalized in `prepareForValidation`) |
| `email` | Optional, valid email |
| `address` | Required, min length, sanitized; custom rule: **minimum 4 words** |
| `city` | Required, whitelist of Pakistani cities |
| `notes` | Optional, max 1000 chars |
| `payment` | Required, must be `cod` |
| `items` | 1–50 lines; each with `product_id`, `quantity`, optional `variant_image_id` |

Input sanitization strips control characters and normalizes phone format before validation.

### OrderService

**File:** `app/Services/OrderService.php`

`createFromCheckout()`:

1. Opens DB transaction
2. For each item: loads active product, checks stock, resolves variant image
3. Builds `order_items` with snapshot fields (`variant_label`, `variant_image_url`, `product_image_id`)
4. Creates `Order` with totals, customer fields, `status = pending`, `payment_status = unpaid`
5. Decrements `products.stock_quantity`
6. Commits transaction

Throws `InvalidArgumentException` on insufficient stock.

---

## Database

### `orders` — migration `2026_06_29_000007`

Customer info, totals, `status`, `payment_status`, `payment_method`, timestamps.

### `order_items` — migration `2026_06_29_000008`

`order_id`, `product_id`, `product_name`, `product_sku`, `quantity`, `unit_price`, `line_total`, variant snapshot columns.

---

## Models

- `App\Models\Order` — `hasMany` items
- `App\Models\OrderItem` — `belongsTo` order and product

---

## Security notes

- CSRF token required on POST (meta tag + form field)
- Server re-validates product IDs and prices (never trust client price alone)
- Throttling on checkout endpoint
- Active products only (`where('is_active', true)`)

---

## Extension notes

- Payment gateway: add new `payment` rule values and gateway service before order creation
- Persistent cart: replace localStorage with authenticated user cart table
- Email confirmations: hook into `OrderService` after commit
- Inventory per variant: extend schema before changing stock logic
