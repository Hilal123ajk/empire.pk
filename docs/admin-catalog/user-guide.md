# Admin Catalog — User Guide

How to manage **products, categories, sub-categories, and brands** in the Empire.pk admin panel.

---

## Logging in

1. Open `/admin/login` in your browser.
2. Enter your admin email and password (provided by your system administrator).
3. If prompted, enter the **5-digit verification code** sent to your email (OTP step).
4. After login you land on the **Dashboard**.

If the code does not arrive, use **Resend code** on the verification page. Your technical team must have the email queue worker running in production.

---

## Products

### Viewing products

Go to **Admin → Products**.

Filter by:

- Search (name, SKU, slug)
- Category (main categories and their sub-categories in grouped dropdown)
- Brand
- Status: Active, Inactive, Low Stock, or **Trash**

### Adding a product

1. Click **Add Product**.
2. Complete required fields: name, SKU, **main category**, price, stock, main image.
3. **Sub category** is optional — leave as “None (main category only)” to assign the product directly to the main category, or pick a sub-category for more specific placement.
4. Brand is optional.
5. Optionally add **Color Images** with labels (see [products-and-variants user guide](../products-and-variants/user-guide.md)).
6. Toggle **Active** and **Featured** as needed.
7. Click **Save**.

### Editing a product

Row menu **⋮ → Edit Product**, or open detail then edit.

When editing, the form pre-selects the correct main category and sub-category (if any).

### Removing a product

Row menu **⋮ → Move to Trash**.

- A confirmation dialog appears (not a browser popup).
- Product disappears from the store but can be recovered.

See [soft-deletes user guide](../soft-deletes/user-guide.md) for Trash, Restore, and permanent delete.

---

## Categories (main)

Main categories are top-level groupings shown in the store header and on `/categories`.

### Viewing categories

Go to **Admin → Categories**.

- Search by title or slug.
- Use **Trash** filter to see deleted categories.

### Adding a category

1. Click **Add Category**.
2. Enter title, description, and upload a **category image** (shown on store category pages).
3. Slug is auto-generated from title if left blank.
4. Set **Active** and save.

### Editing / viewing

Click a category card to open **detail**, or use **Edit** on the card.

### Deleting a category

From the detail drawer: **Move to Trash**.

**Important:** You cannot delete a category that still has products assigned or active sub-categories. Reassign or remove products and sub-categories first.

---

## Sub Categories

Sub-categories live under a main category (e.g. “iPhone Cases” under “Phone Cases”).

### Viewing sub-categories

Go to **Admin → Sub Categories**.

- Filter by parent main category or search.
- Use **Trash** filter for deleted sub-categories.

### Adding a sub-category

1. Click **Add Sub Category**.
2. Select the **parent main category**.
3. Enter title, description, and upload an image.
4. Set **Active** and save.

Sub-categories appear in the sticky navbar on the parent’s store category page and have their own URL: `/categories/{main-slug}/{sub-slug}`.

### Editing / deleting

Same drawer pattern as main categories. Cannot delete if products are still assigned.

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

When reviewing a category, sub-category, or product, use **View Store** or **View on Store** to open the public page and confirm images and text look correct.

---

## Good practices

| Do | Avoid |
|----|--------|
| Keep stock counts updated | Leaving sold-out items active |
| Use clear category images | Empty or blurry category photos |
| Create sub-categories when a main category has many product types | Putting everything on the main category when sub-groupings help customers |
| Label every color image | Uploading colors without names |
| Use Trash instead of permanent delete | Permanent delete unless sure |
| Deactivate seasonal items | Deleting data you might need later |

---

## Who can access admin?

Accounts are created by developers via database seeding. Roles include **admin** and **manager**. Contact your technical team for new accounts or password resets.
