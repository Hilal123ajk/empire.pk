# Empire.pk — Project Documentation

Empire.pk is a Laravel-based e-commerce platform focused on mobile accessories (phone cases, screen protectors, AirPods accessories, and related products). The storefront is mobile-first; the admin panel provides catalog, order, and content management.

This documentation covers **implemented features as of June 2026**. Each module has two guides:

| Guide | Audience |
|-------|----------|
| `technical.md` | Developers, DevOps, technical maintainers |
| `user-guide.md` | Store managers, admins, non-technical staff |

---

## Documentation Index

| Module | Folder | What it covers |
|--------|--------|----------------|
| Storefront & URLs | [storefront/](storefront/) | Collections routing, navigation, SEO-friendly URLs |
| Products & Color Variants | [products-and-variants/](products-and-variants/) | Product detail pages, color/gallery selection |
| Cart & Checkout | [cart-and-checkout/](cart-and-checkout/) | Shopping cart, checkout, order placement |
| Admin Orders | [admin-orders/](admin-orders/) | Viewing orders, status updates, variant display |
| Admin Catalog | [admin-catalog/](admin-catalog/) | Products, categories, brands CRUD |
| Soft Deletes & Confirmations | [soft-deletes/](soft-deletes/) | Trash, restore, permanent delete, confirm modals |

---

## Technology Stack

### Backend

| Component | Version / Detail |
|-----------|------------------|
| PHP | ^8.3 |
| Laravel | ^13.8 |
| Database | MySQL (via WAMP in local development) |
| Authentication | Laravel session auth (admin panel) |
| File storage | Laravel `public` disk (`storage/app/public`) |

### Frontend (Store & Admin)

| Component | Detail |
|-----------|--------|
| Templates | Blade |
| CSS | Tailwind CSS (CDN on store/admin layouts) |
| Interactivity | Alpine.js 3.x (CDN) |
| Store scripts | `public/js/store-app.js`, `public/js/store-data.js` |
| Admin scripts | `public/js/admin-app.js`, `public/js/admin-data.js` |

### Build tooling (optional dev)

| Package | Purpose |
|---------|---------|
| Vite ^8 | Asset bundling (Laravel default) |
| Tailwind CSS ^4 | Available via Vite; storefront uses CDN |
| PHPUnit ^12 | Automated tests |

### Composer packages (production)

- `laravel/framework` — core framework
- `laravel/tinker` — REPL for debugging

No third-party e-commerce or payment SDK is integrated yet. Checkout uses **Cash on Delivery (COD)** only.

---

## Architecture Overview

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin panel (auth, CRUD, orders)
│   │   └── Store/          # Public storefront
│   ├── Middleware/         # AdminMiddleware
│   └── Requests/           # Form validation (Admin + Store)
├── Models/                 # Product, Category, Brand, Order, etc.
├── Services/
│   ├── StoreCatalogService.php   # Store product/category data shaping
│   └── OrderService.php          # Checkout → order persistence
└── Traits/
    └── HasPublicStorageImage.php # Public URL helpers for uploads
```

**Patterns in use:**

- Controllers delegate business logic to **Services** where complexity warrants it (`OrderService`, `StoreCatalogService`).
- **Form Requests** validate admin and checkout input.
- **Eloquent relationships** with eager loading to avoid N+1 queries on listings.
- **Soft deletes** on products and categories for recoverable deletion.

---

## Database Entities

| Table | Purpose |
|-------|---------|
| `users` | Admin/manager accounts (`role`: admin, manager) |
| `categories` | Product categories (slug, image, SEO keywords) |
| `brands` | Product brands |
| `products` | Catalog items (price, stock, featured flag, soft deletes) |
| `product_images` | Gallery / color variant images with optional labels |
| `orders` | Customer orders from checkout |
| `order_items` | Line items with variant snapshot (color, image URL) |

Migrations live in `database/migrations/` (prefix `2026_06_29_*` for domain tables).

---

## Store Routes (Public)

| URL | Name | Description |
|-----|------|-------------|
| `/` | `store.home` | Homepage |
| `/collections` | `store.collections.index` | Collections hub |
| `/collections/all` | `store.products.index` | All products |
| `/collections/{slug}` | `store.collections.show` | Category listing |
| `/products/{slug}` | `store.products.show` | Product detail |
| `/checkout` | `store.checkout` | Checkout page |
| `POST /checkout` | `store.checkout.store` | Place order (rate limited) |

**Legacy redirects (301):** `/phone-accessories` → `/collections`, `/products` → `/collections/all`, `/categories/{slug}` → `/collections/{slug}`.

---

## Admin Routes

| Area | Base path | Auth |
|------|-----------|------|
| Login | `/admin/login` | Guest only |
| Dashboard | `/admin` | Admin middleware |
| Products | `/admin/products` | Admin middleware |
| Categories | `/admin/categories` | Admin middleware |
| Brands | `/admin/brands` | Admin middleware |
| Orders | `/admin/orders` | Admin middleware |

Admin accounts are seeded via `database/seeders/UserSeeder.php` (roles: `admin`, `manager`).

---

## Feature Summary

### User-facing (customer) features

- Browse collections and categories with responsive, mobile-first layout
- View product details with **color/variant image selection**
- Add items to cart (separate lines per color variant)
- Checkout with **Cash on Delivery**, Pakistani phone validation, and order confirmation modal
- Cart drawer with continue-shopping link back to homepage

### Admin / manager features

- Secure login and session-based admin access
- **Product CRUD** with main image, gallery/color images, labels, stock, pricing, SEO keywords
- **Category CRUD** with image and slug management
- **Brand CRUD**
- **Order list** with status updates and variant/color shown per line item
- **Soft delete** for products and categories (move to trash, restore, delete permanently)
- **Custom confirm dialogs** before destructive actions (no browser `confirm()` popups)
- Trash filter on products and categories admin lists

### Technical / platform features

- Laravel Form Request validation on admin and checkout endpoints
- Checkout rate limiting (`throttle:10,1`)
- Order creation in DB transaction with stock checks
- Variant snapshot on `order_items` (preserves color/image at order time)
- Soft deletes (`deleted_at`) on products and categories; images removed only on **force delete**
- Slug uniqueness checks include trashed records
- 301 redirects for old URL structure
- CSRF protection on all POST/PUT/DELETE forms

---

## Local Development

```bash
# Install dependencies
composer install

# Configure .env (DB credentials for WAMP MySQL)
cp .env.example .env
php artisan key:generate

# Run migrations and seed admin users
php artisan migrate
php artisan db:seed

# Start server (upload-friendly PHP limits)
php -d post_max_size=64M -d upload_max_filesize=15M artisan serve
```

Or use `serve.bat` if present in the project root.

Link storage for public uploads:

```bash
php artisan storage:link
```

---

## Conventions

- Product/category URLs use **slugs** (lowercase, hyphenated).
- Store queries automatically exclude soft-deleted records.
- Currency display: **PKR (Rs.)**
- Admin UI: drawers for create/edit/detail, filter bars on list pages, toast notifications via Alpine store.

---

## Planned / Not Yet Implemented

The following are referenced in project rules or UI but not fully built:

- Customer accounts on storefront
- Payment gateways (card, wallet)
- Sitemap package (`spatie/laravel-sitemap`)
- Full SEO meta/JSON-LD on every page
- Admin customers module (placeholder view only)
- Brand soft deletes
- Repository pattern layer (services used instead for now)

---

## How to Read Module Docs

1. Start with the **user-guide** if you operate the store or admin panel day to day.
2. Use the **technical** guide when changing code, debugging, or extending a module.
3. Return to this README for stack context and cross-module navigation.
