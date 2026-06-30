# Storefront & URLs — Technical Guide

## Overview

The public storefront serves Blade views with data shaped by `StoreCatalogService`. Routes use a **collections-first URL scheme** (Spigen-style) with permanent redirects from legacy paths.

---

## Routes

Defined in `routes/web.php` under the `store.*` name prefix:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/collections/all', [StoreProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [StoreProductController::class, 'show'])->name('products.show');
Route::get('/collections', [HomeController::class, 'phoneAccessories'])->name('collections.index');
Route::get('/collections/{slug}', [StoreCategoryController::class, 'show'])->name('collections.show');
```

### Legacy redirects

| Old path | New path | Status |
|----------|----------|--------|
| `/phone-accessories` | `/collections` | 301 |
| `/products` | `/collections/all` | 301 |
| `/categories/{slug}` | `/collections/{slug}` | 301 |

---

## Controllers

| Controller | Methods | Views |
|------------|---------|-------|
| `Store\HomeController` | `index`, `phoneAccessories` | `home.blade.php`, `phone-accessories.blade.php` |
| `Store\ProductController` | `index`, `show` | `products/index.blade.php`, `products/show.blade.php` |
| `Store\CategoryController` | `show` | `categories/show.blade.php` |

Controllers inject catalog data from `StoreCatalogService` and pass arrays to Blade (storefront JS reads `EMPIRE_STORE` from embedded JSON / `store-data.js` patterns).

---

## StoreCatalogService

**File:** `app/Services/StoreCatalogService.php`

Key methods:

| Method | Purpose |
|--------|---------|
| `getCategoriesForStore()` | Active categories with product counts |
| `getProductsForStore()` | Active products with category, brand, images |
| `getBrandsForStore()` | Brands that have active products |
| `getShuffledProductsPaginated()` | Homepage grid with session-persisted shuffle |
| `getProductBySlug()` | Single product for detail page |
| `getProductsByCategorySlug()` | Category page listing |
| `transformProducts()` | Normalizes DB models to store JSON shape (includes `colors`, `gallery`, `hasColors`) |

### Soft delete behavior

All queries use `Product::query()` and `Category::query()` without `withTrashed()`. Soft-deleted records are **automatically excluded** by Eloquent.

### Active flags

Store listings filter `where('is_active', true)` on products and categories.

---

## Views & Layout

| File | Role |
|------|------|
| `resources/views/layouts/app.blade.php` | Store layout (Tailwind CDN, Alpine, header/footer) |
| `resources/views/components/header.blade.php` | Navigation links to collections |
| `resources/views/components/footer.blade.php` | Footer links |
| `resources/views/home.blade.php` | Homepage product grid |

Header was simplified: announcement and delivery bars removed.

---

## Frontend Assets

| File | Role |
|------|------|
| `public/js/store-app.js` | Cart, checkout Alpine components |
| `public/js/store-data.js` | Static/demo data helpers if used |

Tailwind is loaded via CDN in `layouts/app.blade.php`, not via Vite build in production views.

---

## Named Routes in Blade

Use named routes instead of hardcoded paths:

```blade
{{ route('store.collections.index') }}
{{ route('store.products.index') }}
{{ route('store.collections.show', $category->slug) }}
{{ route('store.products.show', $product->slug) }}
```

Admin “View on Store” links should use these routes for consistency.

---

## Session Usage

`getShuffledProductsPaginated()` stores shuffled product IDs in session key `home_product_ids` so pagination across homepage pages stays consistent within a visit.

---

## Extension Notes

- Adding new store pages: register route in `store.*` group, add controller method, create Blade view, update header/footer nav.
- For API-style catalog: extract `StoreCatalogService` return shapes into DTOs or API resources.
- SEO: meta tags per page are partially implemented; extend `@section` blocks in layout per `.cursorrules` guidance.
