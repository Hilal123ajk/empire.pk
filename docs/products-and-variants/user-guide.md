# Products & Color Variants — User Guide

This guide explains how **products and colors** work in Empire.pk—for admins managing the catalog and for understanding the customer experience.

---

## For customers

### Product page

1. Customer opens a product (e.g. from a category or search).
2. They see the **main product photo** and the price.
3. If the product has **color options**, small thumbnails appear below the main image.
4. Tapping a color updates the large photo to that variant.
5. **Add to Cart** adds the selected color. Choosing a different color and adding again creates a **separate cart line** (same product, different color).

### Default color

When the page loads, **Main** is selected—the primary product image uploaded in admin.

---

## For admins: Adding a product

1. Go to **Admin → Products**.
2. Click **Add Product**.
3. Fill in name, SKU, **main category** (required), optional **sub category**, brand, price, stock, etc.
4. Upload the **main product image** (required for good display).
5. Optionally upload **Color Images** in the gallery section:
   - Upload one image per color
   - Enter a **label** for each (e.g. `Black`, `Midnight Blue`, `Clear`)
6. Set **Active** to show on the store; **Featured** for homepage prominence.
7. Save.

### Tips

- **Always label color images** — Labels are what customers see as color names.
- **Use clear photos** — Each color thumbnail should match the actual variant.
- **Stock is shared** — Stock count applies to the whole product, not each color separately.
- **SKU is one per product** — Not per color.

---

## For admins: Editing colors

1. Open **Products** → three-dot menu → **Edit Product**.
2. Existing gallery images show with editable **labels**.
3. Upload new images to add colors.
4. Mark images for removal if a color is discontinued.
5. Save changes.

---

## For admins: Product visibility

| Action | Customer sees |
|--------|----------------|
| Active = on | Product on store |
| Active = off | Hidden (still in admin) |
| Move to Trash | Hidden; can restore later |
| Delete Permanently | Gone forever |

---

## Product page layout (what customers see)

- **Phone:** Large square product image, easy tap targets for colors and Add to Cart.
- **Computer:** Slightly smaller text and buttons; product image uses most of the left column for a clean, premium look.

---

## Viewing on the store

After saving a product, use **View Detail** in admin or visit `/products/{slug}` to confirm colors and images look correct before sharing links.
