document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: JSON.parse(localStorage.getItem('empire_cart') || '[]'),
        drawerOpen: false,

        get count() {
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        },

        get total() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },

        get deliveryFee() {
            if (this.total === 0) return 0;
            return this.total >= 2500 ? 0 : 199;
        },

        get grandTotal() {
            return this.total + this.deliveryFee;
        },

        save() {
            localStorage.setItem('empire_cart', JSON.stringify(this.items));
        },

        openDrawer() {
            this.drawerOpen = true;
            document.body.classList.add('overflow-hidden');
        },

        closeDrawer() {
            this.drawerOpen = false;
            document.body.classList.remove('overflow-hidden');
        },

        add(product, quantity = 1, openDrawer = true) {
            const existing = this.items.find(i => i.id === product.id);
            if (existing) {
                existing.quantity += quantity;
            } else {
                this.items.push({
                    id: product.id,
                    slug: product.slug,
                    name: product.name,
                    brand: product.brand,
                    price: product.price,
                    image: product.image,
                    quantity,
                });
            }
            this.save();
            this.showToast(`${product.name} added to cart`);
            if (openDrawer) {
                this.openDrawer();
            }
        },

        remove(id) {
            this.items = this.items.filter(i => i.id !== id);
            this.save();
        },

        updateQuantity(id, quantity) {
            const item = this.items.find(i => i.id === id);
            if (!item) return;
            if (quantity <= 0) {
                this.remove(id);
            } else {
                item.quantity = quantity;
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
        brand: '',
        minPrice: 0,
        maxPrice: 50000,
        sort: 'featured',
        mobileFiltersOpen: false,

        get filteredProducts() {
            let products = [...window.EMPIRE_STORE.products];

            if (this.category) {
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

        placeOrder() {
            if (this.$store.cart.items.length === 0) return;
            this.placed = true;
            this.$store.cart.clear();
        },
    }));
});
