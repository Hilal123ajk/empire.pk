# Storefront & URLs — Technical Guide

## Overview

The public storefront serves Blade views with data shaped by `StoreCatalogService`. Routes use a **categories-first URL scheme** with a **two-level category hierarchy** (main categories and sub-categories). Legacy `/collections/*` and other old paths redirect with 301 responses.

---

## Routes

Defined in `routes/web.php` under the `store.*` name prefix:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories/all', [StoreProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [StoreProductController::class, 'show'])->name('products.show');

Route::get('/categories', [HomeController::class, 'categories'])->name('categories.index');
Route::get('/categories/{parentSlug}/{slug}', [StoreCategoryController::class, 'showSubcategory'])->name('categories.sub.show');
Route::get('/categories/{slug}', [StoreCategoryController::class, 'show'])->name('categories.show');
```

### Legacy redirects

| Old path | New path | Status |
|----------|----------|--------|
| `/phone-accessories` | `/categories` | 301 |
| `/products` | `/categories/all` | 301 |
| `/collections` | `/categories` | 301 |
| `/collections/all` | `/categories/all` | 301 |
| `/collections/{slug}` | `/categories/{slug}` | 301 |

---

## Category hierarchy

### Database

Migration `2026_07_02_000001_add_parent_id_to_categories_table.php` adds `parent_id` (nullable FK to `categories.id`) on the `categories` table.

| Level | `parent_id` | Store URL |
|-------|-------------|-----------|
| Main category | `null` | `/categories/{slug}` |
| Sub-category | main category ID | `/categories/{parent-slug}/{slug}` |

### Model

**`App\Models\Category`**

- `parent()` / `children()` relationships
- `isRoot()` / `isSubcategory()` helpers
- `descendantIds()` for aggregating products under a main category
- `storeUrl()` builds the correct public URL for main or sub categories

### Store behavior

| Page | Controller method | Product scope |
|------|-------------------|---------------|
| Main category | `show()` | Products in main category **and** all its sub-categories (`includeChildProducts = true`) |
| Sub-category | `showSubcategory()` | Products assigned **only** to that sub-category |

Both use `resources/views/categories/show.blade.php` with Alpine `productFilters()` in `public/js/store-app.js`.

### Sub-category navbar

When a main category has active sub-categories, `categories/show.blade.php` renders a sticky sub-nav:

- First tab: **All** (links to main category URL; shows aggregated products)
- Remaining tabs: one per sub-category
- On mobile, a **back arrow** is the first item in the sub-nav row

Categories without sub-categories use `<x-mobile-back-nav>` above the page content instead.

---

## Controllers

| Controller | Methods | Views |
|------------|---------|-------|
| `Store\HomeController` | `index`, `categories` | `home.blade.php`, `categories/index.blade.php` |
| `Store\ProductController` | `index`, `show` | `products/index.blade.php`, `products/show.blade.php` |
| `Store\CategoryController` | `show`, `showSubcategory` | `categories/show.blade.php` |

Controllers inject catalog data from `StoreCatalogService` and pass arrays to Blade (storefront JS reads `EMPIRE_STORE` from embedded JSON / `store-data.js`).

---

## StoreCatalogService

**File:** `app/Services/StoreCatalogService.php`

Key methods:

| Method | Purpose |
|--------|---------|
| `getCategoriesForStore()` | Active **root** categories only (excludes sub-categories from homepage/header nav) |
| `getSubcategoriesForCategory()` | Sub-categories for a main category (navbar + cards) |
| `getProductsForStore()` | Active products with category, brand, images, `parentCategory`, `categoryUrl` |
| `getBrandsForStore()` | Brands that have active products |
| `getShuffledProductsPaginated()` | Homepage grid with session-persisted shuffle |
| `getProductBySlug()` | Single product for detail page |
| `transformProducts()` | Normalizes DB models to store JSON shape (includes `colors`, `gallery`, `hasColors`, `rootCategory`) |

### Soft delete behavior

All queries use `Product::query()` and `Category::query()` without `withTrashed()`. Soft-deleted records are **automatically excluded** by Eloquent.

### Active flags

Store listings filter `where('is_active', true)` on products and categories.

---

## Views & Layout

| File | Role |
|------|------|
| `resources/views/layouts/app.blade.php` | Store layout (Vite CSS, Alpine, header/footer) |
| `resources/views/components/header.blade.php` | Navigation links to categories hub and main categories |
| `resources/views/components/mobile-back-nav.blade.php` | Mobile-only back bar (uses `EMPIRE_STORE.goBack()`) |
| `resources/views/components/footer.blade.php` | Footer links |
| `resources/views/home.blade.php` | Homepage product grid |
| `resources/views/categories/index.blade.php` | Generic categories hub (replaces legacy `phone-accessories.blade.php`) |
| `resources/views/categories/show.blade.php` | Main and sub category product listings |

Header was simplified: announcement bar and free-delivery messaging removed.

---

## Mobile back navigation

**Component:** `resources/views/components/mobile-back-nav.blade.php`

**JS:** `EMPIRE_STORE.goBack(fallbackUrl)` in `public/js/store-data.js`

- Uses `history.back()` when `document.referrer` is same-origin
- Otherwise navigates to the provided fallback URL

Used on:

- Category detail (when no sub-category navbar)
- Product detail (`products/show.blade.php`) — fallback to category URL or all products
- Checkout — fallback to homepage

---

## Frontend Assets

| File | Role |
|------|------|
| `public/js/store-app.js` | Cart, checkout, `productFilters()` Alpine component |
| `public/js/store-data.js` | `EMPIRE_STORE` helpers, `goBack()`, price formatting |
| `resources/css/app.css` | Tailwind v4 + global cursor styles for interactive elements |

Styles are loaded via `@vite(['resources/css/app.css', ...])` in layouts. Run `npm run build` (or `npm run dev`) after CSS changes.

---

## Named Routes in Blade

Use named routes instead of hardcoded paths:

```blade
{{ route('store.categories.index') }}
{{ route('store.products.index') }}
{{ route('store.categories.show', $category->slug) }}
{{ route('store.categories.sub.show', [$parent->slug, $sub->slug]) }}
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
- SEO: Open Graph, Twitter Card, canonical URLs, and JSON-LD on product pages via `App\Support\SeoMeta` and `resources/views/components/seo-meta.blade.php`. Sitemap served at `/sitemap.xml` (`SitemapService`, `spatie/laravel-sitemap`).
- Deeper category nesting (3+ levels): extend `parent_id` logic, URL scheme, and admin UI before implementing.
