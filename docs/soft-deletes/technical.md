# Soft Deletes & Confirmations — Technical Guide

## Overview

Products and categories use Laravel **soft deletes**. Admin destructive actions use a shared **Alpine confirm modal** instead of native browser dialogs.

---

## Soft deletes

### Migration

**File:** `database/migrations/2026_06_29_000009_add_soft_deletes_to_products_and_categories_table.php`

Adds `deleted_at` to `products` and `categories`.

Run:

```bash
php artisan migrate
```

### Models

Both `Product` and `Category` use:

```php
use Illuminate\Database\Eloquent\SoftDeletes;
```

### Delete behavior

| Action | DB | Files |
|--------|-----|-------|
| `$model->delete()` (soft) | Sets `deleted_at` | **Kept** |
| `$model->forceDelete()` | Row removed | **Deleted** from storage |

### Model hooks

**Product** (`booted` → `deleting`):

```php
if ($product->isForceDeleting()) {
    static::deleteStoredImage($product);
    $product->images()->get()->each(fn (ProductImage $image) => $image->delete());
}
```

**Category** — deletes category image file only on force delete.

**ProductImage** — always deletes file on record delete (runs during product force delete cascade).

### Slug uniqueness

`generateUniqueSlug()` on Product and Category uses `withTrashed()` to prevent slug collisions with trashed records.

---

## Admin routes

### Products

```php
Route::delete('/products/{product}', ... 'destroy');           // soft
Route::post('/products/{productId}/restore', ... 'restore');
Route::delete('/products/{productId}/force', ... 'forceDestroy');
```

### Categories

Same pattern under `/admin/categories/` and `/admin/sub-categories/`.

Restore/force routes use `{productId}` / `{categoryId}` with `onlyTrashed()->findOrFail()` because implicit route model binding excludes trashed models by default.

---

## Controllers

### ProductController

- `destroy()` — soft delete, flash success message
- `restore()` — `onlyTrashed()->findOrFail`, `restore()`
- `forceDestroy()` — permanent delete + file cleanup via model hooks

### CategoryController

- `destroy()` — blocked if `$category->products()->exists()` or (main categories) active sub-categories exist
- `forceDestroy()` — same product check before permanent delete

---

## Admin UI filters

| Page | Filter value | Query |
|------|--------------|-------|
| Products | `status=trashed` | `Product::onlyTrashed()` |
| Categories | `status=trashed` | `Category::onlyTrashed()` |

Trashed rows show **In Trash** badge. Actions: Restore (POST), Delete Permanently (DELETE + confirm).

---

## Confirm dialog system

### Component

**`resources/views/components/admin-confirm-dialog.blade.php`**

Included in `layouts/admin.blade.php` for authenticated admin layout.

### Alpine store

**`public/js/admin-app.js` — `Alpine.store('adminConfirm')`**

```javascript
ask({ title, message, confirmLabel, cancelLabel, tone, form })
confirm()  // submits pendingForm
cancel()
```

### Scroll lock

`adminUi.lockScroll()` / `unlockScroll()` use a **reference counter** so overlapping drawers + confirm modal do not unlock scroll prematurely.

### Usage in Blade

```blade
<button type="button"
        @click="$store.adminConfirm.ask({
            title: 'Move product to trash?',
            message: '...',
            confirmLabel: 'Move to Trash',
            form: $el.closest('form')
        })">
```

Form uses `@method('DELETE')` where needed; confirm submits the form programmatically.

---

## Storefront impact

Default Eloquent queries exclude soft-deleted models. No changes required in `StoreCatalogService` for exclusion.

Trashed products with existing orders: order line snapshots remain valid; product FK may reference soft-deleted product ID.

---

## Brands

Brands do **not** use soft deletes yet—`BrandController@destroy` hard-deletes.

---

## Extension notes

- Add `SoftDeletes` to Brand with parallel trash UI
- Global scopes for admin list default view (hide trashed unless filter)
- Scheduled job: `forceDelete()` trashed items older than N days
- Audit log table for delete/restore actions
