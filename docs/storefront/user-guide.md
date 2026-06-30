# Storefront & URLs — User Guide

This guide is for **customers** browsing the Empire.pk website and for **staff** who need to understand how shoppers find products.

---

## How customers browse the store

### Homepage

- URL: `/` (your site root)
- Shows featured and shuffled products in a mobile-friendly grid
- Header links take customers to collections and categories

### Collections hub

- URL: `/collections`
- Overview page for browsing product groupings (phone accessories focus)
- Entry point from marketing links and navigation

### All products

- URL: `/collections/all`
- Full catalog listing of active products

### Category pages

- URL pattern: `/collections/{category-name}`
- Example: `/collections/phone-cases`
- Shows only products in that category

### Product detail

- URL pattern: `/products/{product-name}`
- Example: `/products/spigen-ultra-hybrid-iphone-15-case`
- One product per page with images, price, add-to-cart

---

## Old links still work

If bookmarks or external sites use older URLs, visitors are redirected automatically:

| Old link | Goes to |
|----------|---------|
| `/phone-accessories` | `/collections` |
| `/products` | `/collections/all` |
| `/categories/phone-cases` | `/collections/phone-cases` |

No action needed from staff—these redirects are permanent.

---

## What customers see in the header

The store header includes:

- Logo / home link
- Navigation to collections and categories
- Cart access (opens cart drawer)

Announcement and delivery bars were removed for a cleaner layout.

---

## Tips for store managers

1. **Category slugs matter** — The URL uses the category slug set in Admin → Categories. Changing a slug changes the public URL.
2. **Inactive categories/products are hidden** — Toggle “Active” off in admin to remove items from the storefront without deleting them.
3. **Trashed items never appear** — Products or categories moved to Trash in admin are hidden from the store until restored.

---

## Checking the live store from admin

When editing a category or product in admin, use **View on Store** (or **View Store** on category cards) to open the public page in a new tab and verify how it looks to customers.
