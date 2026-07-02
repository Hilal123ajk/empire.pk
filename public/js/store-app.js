document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: [],
        drawerOpen: false,

        init() {
            this.items = this.loadItems();
            this.syncFromCatalog();
        },

        loadItems() {
            try {
                return JSON.parse(localStorage.getItem('empire_cart') || '[]')
                    .filter((item) => item && typeof item.id === 'number')
                    .map((item) => ({
                        lineKey: item.lineKey ?? `${item.id}-${item.variantImageId ?? 'default'}`,
                        id: item.id,
                        quantity: Math.min(99, Math.max(1, parseInt(item.quantity, 10) || 1)),
                        variantImageId: item.variantImageId ?? null,
                        variantLabel: item.variantLabel ?? null,
                    }));
            } catch {
                return [];
            }
        },

        catalogProduct(item) {
            return window.EMPIRE_STORE?.products?.find((entry) => entry.id === item.id) ?? null;
        },

        unitPrice(item) {
            const product = this.catalogProduct(item);

            return product ? Number(product.price) : 0;
        },

        displayItem(item) {
            const product = this.catalogProduct(item);

            if (!product) {
                return null;
            }

            const variant = item.variantImageId
                ? (product.gallery || []).find((entry) => entry.id === item.variantImageId)
                : null;

            return {
                ...item,
                slug: product.slug,
                name: product.name,
                brand: product.brand,
                category: product.category ?? '',
                price: Number(product.price),
                image: variant?.url ?? product.image,
                variantLabel: variant?.label ?? item.variantLabel ?? 'Main',
                inStock: product.inStock,
            };
        },

        get displayItems() {
            return this.items
                .map((item) => this.displayItem(item))
                .filter(Boolean);
        },

        get count() {
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        },

        get total() {
            return this.items.reduce((sum, item) => sum + this.unitPrice(item) * item.quantity, 0);
        },

        get deliveryFee() {
            if (this.total === 0) return 0;

            return Number(window.EMPIRE_STORE.delivery?.fee ?? 199);
        },

        get grandTotal() {
            return this.total + this.deliveryFee;
        },

        syncFromCatalog() {
            if (!window.EMPIRE_STORE?.products?.length) {
                return;
            }

            const synced = [];

            for (const item of this.items) {
                const product = this.catalogProduct(item);

                if (!product || !product.inStock) {
                    continue;
                }

                synced.push({
                    lineKey: item.lineKey,
                    id: item.id,
                    quantity: Math.min(99, Math.max(1, parseInt(item.quantity, 10) || 1)),
                    variantImageId: item.variantImageId ?? null,
                    variantLabel: item.variantLabel ?? null,
                });
            }

            this.items = synced;
            this.save();
        },

        save() {
            localStorage.setItem('empire_cart', JSON.stringify(
                this.items.map(({ lineKey, id, quantity, variantImageId, variantLabel }) => ({
                    lineKey,
                    id,
                    quantity,
                    variantImageId,
                    variantLabel,
                })),
            ));
        },

        openDrawer() {
            this.drawerOpen = true;
            document.body.classList.add('overflow-hidden');
        },

        closeDrawer() {
            this.drawerOpen = false;
            document.body.classList.remove('overflow-hidden');
        },

        buildLineKey(productId, variantImageId = null) {
            return `${productId}-${variantImageId ?? 'default'}`;
        },

        add(product, quantity = 1, openDrawer = true, variant = null) {
            const resolvedVariant = variant ?? {
                id: null,
                url: product.image,
                label: 'Main',
            };

            const variantImageId = resolvedVariant.id ?? null;
            const variantLabel = resolvedVariant.label ?? null;
            const image = resolvedVariant.url ?? product.image;
            const lineKey = this.buildLineKey(product.id, variantImageId);
            const existing = this.items.find((item) => item.lineKey === lineKey);

            if (existing) {
                existing.quantity = Math.min(99, existing.quantity + quantity);
            } else {
                this.items.push({
                    lineKey,
                    id: product.id,
                    quantity: Math.min(99, Math.max(1, quantity)),
                    variantImageId,
                    variantLabel,
                });
            }

            this.save();
            this.showToast(`${product.name} added to cart`);
            if (openDrawer) {
                this.openDrawer();
            }
        },

        remove(lineKey) {
            this.items = this.items.filter((item) => item.lineKey !== lineKey);
            this.save();
        },

        updateQuantity(lineKey, quantity) {
            const item = this.items.find((entry) => entry.lineKey === lineKey);
            if (!item) return;
            if (quantity <= 0) {
                this.remove(lineKey);
            } else {
                item.quantity = Math.min(99, Math.max(1, parseInt(quantity, 10) || 1));
                this.save();
            }
        },

        clear() {
            this.items = [];
            this.save();
        },

        showToast(message) {
            window.dispatchEvent(new CustomEvent('empire-toast', { detail: { message } }));
        },
    });

    Alpine.data('productFilters', () => ({
        search: '',
        category: '',
        rootCategory: '',
        includeChildProducts: false,
        brand: '',
        minPrice: 0,
        maxPrice: 50000,
        sort: 'featured',
        mobileFiltersOpen: false,

        get filteredProducts() {
            let products = [...window.EMPIRE_STORE.products];

            if (this.includeChildProducts && this.rootCategory) {
                products = products.filter(p =>
                    p.parentCategory === this.rootCategory || p.category === this.rootCategory
                );
            } else if (this.category) {
                products = products.filter(p => p.category === this.category);
            }
            if (this.brand) {
                products = products.filter(p => p.brand === this.brand);
            }
            if (this.search) {
                const q = this.search.toLowerCase();
                products = products.filter(p =>
                    p.name.toLowerCase().includes(q) ||
                    p.brand.toLowerCase().includes(q)
                );
            }
            products = products.filter(p => p.price >= this.minPrice && p.price <= this.maxPrice);

            switch (this.sort) {
                case 'price-low':
                    products.sort((a, b) => a.price - b.price);
                    break;
                case 'price-high':
                    products.sort((a, b) => b.price - a.price);
                    break;
                case 'rating':
                    products.sort((a, b) => b.rating - a.rating);
                    break;
                case 'discount':
                    products.sort((a, b) => (b.discount || 0) - (a.discount || 0));
                    break;
                default:
                    products.sort((a, b) => (b.featured ? 1 : 0) - (a.featured ? 1 : 0));
            }

            return products;
        },

        resetFilters() {
            this.search = '';
            this.category = '';
            this.rootCategory = '';
            this.includeChildProducts = false;
            this.brand = '';
            this.minPrice = 0;
            this.maxPrice = 50000;
            this.sort = 'featured';
        },
    }));

    Alpine.data('heroSlider', () => ({
        current: 0,
        banners: window.EMPIRE_STORE.banners,
        interval: null,

        init() {
            this.interval = setInterval(() => this.next(), 5000);
        },

        next() {
            this.current = (this.current + 1) % this.banners.length;
        },

        prev() {
            this.current = (this.current - 1 + this.banners.length) % this.banners.length;
        },

        goTo(index) {
            this.current = index;
        },
    }));

    Alpine.data('toast', () => ({
        visible: false,
        message: '',

        init() {
            window.addEventListener('empire-toast', (e) => {
                this.message = e.detail.message;
                this.visible = true;
                setTimeout(() => { this.visible = false; }, 3000);
            });
        },
    }));

    Alpine.data('checkoutForm', () => ({
        firstName: '',
        lastName: '',
        phone: '',
        address: '',
        city: localStorage.getItem('empire_city') || 'Lahore',
        notes: '',
        payment: 'cod',
        placed: false,
        orderNumber: '',
        submitting: false,
        confirmOpen: false,
        error: '',
        fieldErrors: {},

        sanitizeInput(value) {
            if (typeof value !== 'string') return '';
            return value.trim().replace(/[<>]/g, '');
        },

        normalizePhone(value) {
            let digits = String(value || '').replace(/\D+/g, '');

            if (digits.startsWith('92') && digits.length === 12) {
                digits = '0' + digits.slice(2);
            }

            if (digits.startsWith('3') && digits.length === 10) {
                digits = '0' + digits;
            }

            return digits;
        },

        countWords(value) {
            return value.trim().split(/\s+/).filter(Boolean).length;
        },

        validateForm() {
            this.fieldErrors = {};
            this.error = '';

            this.firstName = this.sanitizeInput(this.firstName);
            this.lastName = this.sanitizeInput(this.lastName);
            this.address = this.sanitizeInput(this.address);
            this.notes = this.sanitizeInput(this.notes);
            this.phone = this.normalizePhone(this.phone);

            if (this.firstName.length < 2) {
                this.fieldErrors.firstName = 'First name is required (at least 2 characters).';
            }

            if (this.lastName.length < 2) {
                this.fieldErrors.lastName = 'Last name is required (at least 2 characters).';
            }

            if (!/^03[0-9]{9}$/.test(this.phone)) {
                this.fieldErrors.phone = 'Enter a valid Pakistani mobile number (e.g. 03001234567).';
            }

            if (this.countWords(this.address) < 4) {
                this.fieldErrors.address = 'Address must be at least 4 words (village, tehsil, district, city).';
            }

            if (!this.city) {
                this.error = 'Please select a delivery city.';
            }

            return Object.keys(this.fieldErrors).length === 0 && !this.error;
        },

        requestPlaceOrder() {
            if (this.$store.cart.items.length === 0 || this.submitting) return;

            if (!this.validateForm()) {
                this.error = this.error || 'Please fix the highlighted fields before placing your order.';
                return;
            }

            this.confirmOpen = true;
        },

        confirmPlaceOrder() {
            this.confirmOpen = false;
            this.placeOrder();
        },

        async placeOrder() {
            if (this.$store.cart.items.length === 0 || this.submitting) return;

            if (!this.validateForm()) {
                return;
            }

            this.submitting = true;
            this.error = '';

            try {
                const response = await fetch(window.EMPIRE_STORE.checkoutUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        first_name: this.firstName,
                        last_name: this.lastName,
                        phone: this.phone,
                        address: this.address,
                        city: this.city,
                        notes: this.notes || null,
                        payment: this.payment,
                        items: this.$store.cart.items.map((item) => ({
                            product_id: item.id,
                            quantity: Math.min(99, Math.max(1, parseInt(item.quantity, 10) || 1)),
                            variant_image_id: item.variantImageId ?? null,
                        })),
                    }),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    const validationMessage = data.errors
                        ? Object.values(data.errors).flat()[0]
                        : null;
                    this.error = data.message || validationMessage || 'Unable to place order. Please try again.';
                    return;
                }

                this.orderNumber = data.order_number;
                this.placed = true;
                this.$store.cart.clear();
            } catch (error) {
                this.error = 'Network error. Please check your connection and try again.';
            } finally {
                this.submitting = false;
            }
        },
    }));
});
