# Admin Catalog — Technical Guide

## Overview

Admin catalog management covers **Products**, **Main Categories**, **Sub Categories**, and **Brands** with full CRUD, image uploads, validation via Form Requests, and Blade + Alpine drawer UIs.

---

## Authentication

- Middleware: `App\Http\Middleware\AdminMiddleware`
- Login: `AuthController` + `LoginRequest`
- Optional **email OTP** step after password validation (`AdminOtpService`, `SendAdminLoginOtp` job, `verify-otp.blade.php`)
- OTP routes: `admin.login.verify`, `admin.login.verify.submit`, `admin.login.verify.resend`
- Roles on `users.role`: `admin`, `manager` (both access admin routes currently)

When OTP is required, credentials are validated first; a 5-digit code is queued to the admin’s email. Session stores pending user ID until verification succeeds. Run `php artisan queue:work` in development so OTP emails send.

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

Product forms submit **`main_category_id`** (required) and **`sub_category_id`** (optional). Requests merge these into `category_id` in `prepareForValidation()`:

- If sub-category selected → product `category_id` = sub-category
- If sub-category empty → product `category_id` = main category

`withValidator()` ensures a selected sub-category belongs to the chosen main category. Validated output strips `main_category_id` and `sub_category_id` before persistence.

### View

**`resources/views/admin/products/index.blade.php`**

- Inline Alpine component (not `adminProducts` demo component)
- Drawers: create/edit, detail view
- Three-dot row menu: view, edit, move to trash / restore / force delete

---

## Categories (main)

Main categories have `parent_id = null`. Managed under **Admin → Categories**.

### Routes

Same CRUD pattern as products plus restore/force-destroy.

### Controller

**`App\Http\Controllers\Admin\CategoryController`**

- Manages root categories only (`whereNull('parent_id')`)
- `destroy()` blocked if `$category->products()->exists()` or active sub-categories exist
- Image stored under `categories/` on public disk
- Slug auto-generated from title if empty (`Category::generateUniqueSlug`)

### View

**`resources/views/admin/categories/index.blade.php`**

- Grid cards with image, status badge
- Search + **Trash** filter
- Detail drawer with edit / trash actions

---

## Sub Categories

Sub-categories have `parent_id` set to a main category. Managed under **Admin → Sub Categories** (`/admin/sub-categories`).

### Routes

| Method | URI | Action |
|--------|-----|--------|
| GET | `/admin/sub-categories` | List + filters |
| POST | `/admin/sub-categories` | Create |
| PUT | `/admin/sub-categories/{category}` | Update |
| DELETE | `/admin/sub-categories/{category}` | Soft delete |
| POST | `/admin/sub-categories/{categoryId}/restore` | Restore |
| DELETE | `/admin/sub-categories/{categoryId}/force` | Permanent delete |

### Controller

**`App\Http\Controllers\Admin\SubCategoryController`**

- CRUD for categories with non-null `parent_id`
- Parent must be an active main category
- Same image/slug/soft-delete patterns as main categories

### View

**`resources/views/admin/subcategories/index.blade.php`**

- Grid cards grouped by parent category
- Parent category selector on create/edit forms

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
| Sidebar | `resources/views/admin/partials/sidebar.blade.php` — Catalog section: Products, Categories, Sub Categories, Brands |
| Admin Alpine stores | `public/js/admin-app.js` — `adminUi`, `adminConfirm` |
| Global cursor styles | `resources/css/app.css` — pointer cursor on buttons, links, selects, labels |

### Image handling

**Trait:** `App\Traits\HasPublicStorageImage`

- `image_public_url` accessor for Blade/JSON
- `deleteStoredImage()` on model delete hooks

Requires `php artisan storage:link` for `/storage/...` URLs.

---

## Validation highlights

| Entity | Notable rules |
|--------|----------------|
| Product | Unique SKU; `main_category_id` required; `sub_category_id` optional; resolved `category_id`; positive price/stock; image mime/size |
| Main category | Title required, unique slug, image required on create, `parent_id` null |
| Sub-category | Title required, `parent_id` required (main category FK), unique slug per scope |
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
