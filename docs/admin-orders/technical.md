# Admin Orders — Technical Guide

## Overview

Orders created via checkout appear in the admin orders list. Admins can view details and update order status via AJAX. Line items display variant color and image snapshots from checkout time.

---

## Routes

```php
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
```

Protected by `admin` middleware.

---

## Controller

**File:** `app/Http/Controllers/Admin/OrderController.php`

### `index()`

- Loads orders with `items` relationship (eager loaded)
- Passes data to `resources/views/admin/orders/index.blade.php`
- May hydrate `window.EMPIRE_ADMIN.orders` for Alpine list (check view for embedded JSON)

### `updateStatus()`

- Accepts JSON: `{ "status": "..." }`
- Valid statuses defined in controller or model (e.g. pending, processing, shipped, delivered, cancelled)
- Returns JSON `{ success, order }` for frontend to update list without reload

---

## OrderService (read side)

**File:** `app/Services/OrderService.php`

May include methods to format orders for admin display (order number, customer name, line items with variant fields). Inspect service for `formatForAdmin()` or similar helpers used by controller.

---

## Admin UI

**View:** `resources/views/admin/orders/index.blade.php`

Features:

- Search/filter by order ID, customer, status
- Three-dot **action menu** per row
- **Fixed-position dropdown** (opens up or down based on viewport space)—prevents clipping in scrollable tables
- Detail drawer: customer info, address, line items
- Status update drawer

**JS:** `public/js/admin-app.js` — `Alpine.data('adminOrders')`

- `toggleMenu()` calculates `menuTop` / `menuRight` for fixed positioning
- `closeMenu()` on outside click, Escape, and after actions
- `submitStatus()` — `fetch` PUT to `/admin/orders/{id}/status` with CSRF header

---

## Variant display on line items

Each `order_items` row stores at checkout:

| Column | Content |
|--------|---------|
| `variant_label` | Color name or `Main` |
| `variant_image_url` | Public URL at order time |
| `product_image_id` | FK to `product_images` if variant selected |

Admin detail view should render variant thumbnail + label so warehouse staff pick the correct color.

---

## Data model

**`App\Models\Order`**

- Relations: `items()`, possibly `user()` if guest checkout (currently guest-only)
- Status and payment_status enums/strings

**`App\Models\OrderItem`**

- Snapshot fields preserve product name/SKU/price even if catalog changes later

---

## Extension notes

- Add order export (CSV): query orders with items in controller command
- Email on status change: listener on status update
- Link orders to customer accounts: add `user_id` nullable on orders
- Print packing slip: new route + Blade PDF view per order
