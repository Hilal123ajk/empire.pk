# Admin Catalog — User Guide

How to manage **products, categories, and brands** in the Empire.pk admin panel.

---

## Logging in

1. Open `/admin/login` in your browser.
2. Enter your admin email and password (provided by your system administrator).
3. After login you land on the **Dashboard**.

---

## Products

### Viewing products

Go to **Admin → Products**.

Filter by:

- Search (name, SKU, slug)
- Category
- Brand
- Status: Active, Inactive, Low Stock, or **Trash**

### Adding a product

1. Click **Add Product**.
2. Complete required fields: name, SKU, category, brand, price, stock, main image.
3. Optionally add **Color Images** with labels (see [products-and-variants user guide](../products-and-variants/user-guide.md)).
4. Toggle **Active** and **Featured** as needed.
5. Click **Save**.

### Editing a product

Row menu **⋮ → Edit Product**, or open detail then edit.

### Removing a product

Row menu **⋮ → Move to Trash**.

- A confirmation dialog appears (not a browser popup).
- Product disappears from the store but can be recovered.

See [soft-deletes user guide](../soft-deletes/user-guide.md) for Trash, Restore, and permanent delete.

---

## Categories

### Viewing categories

Go to **Admin → Categories**.

- Search by title or slug.
- Use **Trash** filter to see deleted categories.

### Adding a category

1. Click **Add Category**.
2. Enter title, description, and upload a **category image** (shown on store collection pages).
3. Slug is auto-generated from title if left blank.
4. Set **Active** and save.

### Editing / viewing

Click a category card to open **detail**, or use **Edit** on the card.

### Deleting a category

From the detail drawer: **Move to Trash**.

**Important:** You cannot delete a category that still has products assigned. Move or delete products first.

---

## Brands

Go to **Admin → Brands**.

- Add brands used on products (Apple, Samsung, Spigen, etc.).
- Edit or delete brands from the list.
- Deleting a brand may fail if products still use it—reassign products first.

---

## SEO fields

Products and categories support **meta keywords**. Category **title and description** are used for SEO on category pages. Fill these with clear, relevant text for better search visibility.

---

## View on store

When reviewing a category or product, use **View Store** or **View on Store** to open the public page and confirm images and text look correct.

---

## Good practices

| Do | Avoid |
|----|--------|
| Keep stock counts updated | Leaving sold-out items active |
| Use clear category images | Empty or blurry collection photos |
| Label every color image | Uploading colors without names |
| Use Trash instead of permanent delete | Permanent delete unless sure |
| Deactivate seasonal items | Deleting data you might need later |

---

## Who can access admin?

Accounts are created by developers via database seeding. Roles include **admin** and **manager**. Contact your technical team for new accounts or password resets.
