# Admin Catalog — Technical Guide

## Overview

Admin catalog management covers **Products**, **Categories**, and **Brands** with full CRUD, image uploads, validation via Form Requests, and Blade + Alpine drawer UIs.

---

## Authentication

- Middleware: `App\Http\Middleware\AdminMiddleware`
- Login: `AuthController` + `LoginRequest`
- Roles on `users.role`: `admin`, `manager` (both access admin routes currently)

---

## Products

### Routes

| Method | URI | Action |
|--------|-----|--------|
| GET | `/admin/products` | List + filters |
| POST | `/admin/products` | Create |
| PUT | `/admin/products/{product}` | Update |
| DELETE | `/admin/products/{product}` | Soft delete |
| POST | `/admin/products/{productId}/restore` | Restore from trash |
| DELETE | `/admin/products/{productId}/force` | Permanent delete |

### Controller

**`App\Http\Controllers\Admin\ProductController`**

- Filters: search, category_id, brand_id, status (`active`, `inactive`, `low`, `trashed`)
- Handles main image upload to `products/` on public disk
- Gallery sync: upload, label sync, remove by ID
- Redirects preserve filter query params via request input

### Requests

- `StoreProductRequest`
- `UpdateProductRequest`
- `ValidatesProductUploads` trait (file size/type rules)

### View

**`resources/views/admin/products/index.blade.php`**

- Inline Alpine component (not `adminProducts` demo component)
- Drawers: create/edit, detail view
- Three-dot row menu: view, edit, move to trash / restore / force delete

---

## Categories

### Routes

Same CRUD pattern as products plus restore/force-destroy.

### Controller

**`App\Http\Controllers\Admin\CategoryController`**

- `destroy()` blocked if `$category->products()->exists()`
- Image stored under `categories/` on public disk
- Slug auto-generated from title if empty (`Category::generateUniqueSlug`)

### View

**`resources/views/admin/categories/index.blade.php`**

- Grid cards with image, status badge
- Search + **Trash** filter
- Detail drawer with edit / trash actions

---

## Brands

### Routes

Standard CRUD without soft deletes (hard delete only).

### Controller

**`App\Http\Controllers\Admin\BrandController`**

### View

**`resources/views/admin/brands/index.blade.php`**

Uses native `confirm()` for delete (not yet migrated to admin confirm dialog).

---

## Shared UI patterns

| Component | Location |
|-----------|----------|
| Admin layout | `resources/views/layouts/admin.blade.php` |
| Confirm dialog | `resources/views/components/admin-confirm-dialog.blade.php` |
| Sidebar | `resources/views/admin/partials/sidebar.blade.php` |
| Admin Alpine stores | `public/js/admin-app.js` — `adminUi`, `adminConfirm` |

### Image handling

**Trait:** `App\Traits\HasPublicStorageImage`

- `image_public_url` accessor for Blade/JSON
- `deleteStoredImage()` on model delete hooks

Requires `php artisan storage:link` for `/storage/...` URLs.

---

## Validation highlights

| Entity | Notable rules |
|--------|----------------|
| Product | Unique SKU, positive price/stock, category/brand FKs, image mime/size |
| Category | Title required, unique slug, image required on create |
| Brand | Title, slug, optional logo |

---

## Dashboard

**`DashboardController`** + `admin/dashboard.blade.php` — summary widgets (orders, products); extent depends on implementation.

---

## Customers module

Route returns placeholder view only:

```php
Route::get('/customers', fn () => view('admin.customers.index'))->name('customers');
```

No backend CRUD yet.

---

## Extension notes

- Implement Repository layer per `.cursorrules` if queries grow complex
- Migrate brands to soft deletes for parity with products/categories
- Bulk product import: new command + CSV parser
- Role permissions: restrict manager vs admin in middleware or policies
