# Products & Color Variants — Technical Guide

## Overview

Products have a **main image** (`products.image_url`) and optional **gallery images** (`product_images`) with optional **labels** (used as color names). The storefront treats labeled gallery images as selectable color variants.

---

## Database

### `products`

Key columns: `name`, `slug`, `sku`, `category_id`, `brand_id`, `price`, `cost_price`, `stock_quantity`, `image_url`, `meta_keywords`, `is_active`, `is_featured`, `deleted_at` (soft delete).

### `product_images`

| Column | Purpose |
|--------|---------|
| `product_id` | FK to product |
| `image_url` | Storage path on `public` disk |
| `label` | Color/variant name (e.g. "Black", "Blue") |
| `sort_order` | Display order |

Migration: `2026_06_29_000006_create_product_images_table.php`

---

## Models

**`App\Models\Product`**

- `SoftDeletes` trait
- Relations: `category`, `brand`, `images`
- `HasPublicStorageImage` → `image_public_url` accessor
- On **force delete**: removes main image file and deletes all `ProductImage` records (which trigger their own file cleanup)

**`App\Models\ProductImage`**

- `deleting` hook removes stored file via `HasPublicStorageImage`

---

## Admin: Creating variants

**Controller:** `App\Http\Controllers\Admin\ProductController`

- Create/update forms accept `gallery_images[]` (files) and `gallery_labels[]` (parallel array)
- Edit form supports `gallery_labels[{id}]` for relabeling existing images
- `remove_gallery_ids[]` removes selected gallery images on update

**Validation:** `StoreProductRequest`, `UpdateProductRequest`, trait `ValidatesProductUploads`

---

## StoreCatalogService transformation

`transformProducts()` builds storefront payload including:

```php
'colors' => [...],      // [{ id, label, image }, ...]
'hasColors' => bool,
'gallery' => [...],     // all images with ids
```

- **Main** variant uses product featured image when no gallery label is selected
- Gallery entries with labels appear as color swatches on product page

---

## Storefront UI

**View:** `resources/views/products/show.blade.php`

- Hero image switches when customer selects a color thumbnail
- Default selection: **Main** (featured product image)
- Add to cart passes `variantImageId` and `variantLabel` to cart state

**Layout sizing (product page):**

- Mobile: full-width square image
- Desktop (`md+`): image ~80% column width; smaller title/price/button typography

---

## Cart integration

**File:** `public/js/store-app.js`

Cart line identity includes variant:

- Same product + different `variantImageId` → separate cart lines
- Stored fields: `variantImageId`, `variantLabel`, `variantImage`

---

## Order snapshot

On checkout, `OrderService` resolves variant:

- If `variant_image_id` present → loads `ProductImage`, stores label + public URL on `order_items`
- Else → `variant_label = 'Main'`, uses product main image URL

See [cart-and-checkout/technical.md](../cart-and-checkout/technical.md).

---

## Slug generation

`Product::generateUniqueSlug()` uses `withTrashed()` so restored or trashed products do not collide on slug.

---

## Extension notes

- True SKU-per-variant would need a `product_variants` table; current design uses images + labels only
- Stock is at **product** level, not per color
- To hide a color: remove gallery image in admin or clear its label
