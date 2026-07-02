# Storefront & URLs — User Guide

This guide is for **customers** browsing the Empire.pk website and for **staff** who need to understand how shoppers find products.

---

## How customers browse the store

### Homepage

- URL: `/` (your site root)
- Shows featured and shuffled products in a mobile-friendly grid
- Header links take customers to the categories hub and main categories

### Categories hub

- URL: `/categories`
- Lists all **main categories** (e.g. Phone Cases, Screen Protectors)
- Sub-categories are **not** listed here—they appear on their parent category page

### All products

- URL: `/categories/all`
- Full catalog listing of active products

### Main category pages

- URL pattern: `/categories/{category-name}`
- Example: `/categories/phone-cases`
- Shows products assigned to that main category **and** all of its sub-categories
- If sub-categories exist, a sticky navbar appears:
  - **All** — everything under this main category
  - Individual sub-category tabs — narrower product sets

### Sub-category pages

- URL pattern: `/categories/{main-category}/{sub-category}`
- Example: `/categories/phone-cases/iphone-cases`
- Shows **only** products assigned to that sub-category

### Product detail

- URL pattern: `/products/{product-name}`
- Example: `/products/spigen-ultra-hybrid-iphone-15-case`
- One product per page with images, price, add-to-cart

---

## Mobile back button

On phones and small tablets, these pages show a **Back** control at the top:

- Category pages (in the sub-category bar or as a standalone bar)
- Product detail pages
- Checkout

Back returns the customer to the previous page they visited on the site. If there is no previous page (e.g. opened from an external link), they are sent to a sensible default (categories list, product’s category, or homepage).

---

## Old links still work

If bookmarks or external sites use older URLs, visitors are redirected automatically:

| Old link | Goes to |
|----------|---------|
| `/phone-accessories` | `/categories` |
| `/products` | `/categories/all` |
| `/collections` | `/categories` |
| `/collections/all` | `/categories/all` |
| `/collections/phone-cases` | `/categories/phone-cases` |

No action needed from staff—these redirects are permanent.

---

## What customers see in the header

The store header includes:

- Logo / home link
- Navigation to the categories hub and main categories
- Cart access (opens cart drawer)

Announcement and free-delivery bars were removed for a cleaner layout. Delivery is charged at a flat rate (see checkout).

---

## Tips for store managers

1. **Category slugs matter** — URLs use slugs from Admin → Categories and Admin → Sub Categories. Changing a slug changes the public URL.
2. **Main vs sub assignment** — Products can be assigned to a main category only, or to a main category plus a sub-category. Main category pages show the full tree; sub-category pages show only that sub’s products.
3. **Inactive categories/products are hidden** — Toggle “Active” off in admin to remove items from the storefront without deleting them.
4. **Trashed items never appear** — Products or categories moved to Trash in admin are hidden from the store until restored.

---

## Checking the live store from admin

When editing a category, sub-category, or product in admin, use **View on Store** (or **View Store** on category cards) to open the public page in a new tab and verify how it looks to customers.
