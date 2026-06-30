document.addEventListener('alpine:init', () => {
    Alpine.store('adminUi', {
        sidebarOpen: false,
        toast: { visible: false, message: '', type: 'success' },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        notify(message, type = 'success') {
            this.toast = { visible: true, message, type };
            setTimeout(() => { this.toast.visible = false; }, 3000);
        },

        lockScroll() {
            document.body.classList.add('overflow-hidden');
        },

        unlockScroll() {
            document.body.classList.remove('overflow-hidden');
        },
    });

    Alpine.data('adminDrawer', () => ({
        openDrawer(flag) {
            this[flag] = true;
            Alpine.store('adminUi').lockScroll();
        },

        closeDrawer(flag) {
            this[flag] = false;
            if (!this.hasOpenDrawer()) {
                Alpine.store('adminUi').unlockScroll();
            }
        },

        hasOpenDrawer() {
            return false;
        },
    }));

    Alpine.data('adminProducts', () => ({
        search: '',
        categoryFilter: '',
        statusFilter: '',
        formDrawerOpen: false,
        detailDrawerOpen: false,
        menuOpenId: null,
        editing: null,
        selectedProduct: null,
        form: {},

        init() {
            this.resetForm();
        },

        hasOpenDrawer() {
            return this.formDrawerOpen || this.detailDrawerOpen;
        },

        openDrawer(flag) {
            this[flag] = true;
            Alpine.store('adminUi').lockScroll();
        },

        closeDrawer(flag) {
            this[flag] = false;
            if (!this.hasOpenDrawer()) {
                Alpine.store('adminUi').unlockScroll();
            }
        },

        closeAllDrawers() {
            this.formDrawerOpen = false;
            this.detailDrawerOpen = false;
            this.menuOpenId = null;
            Alpine.store('adminUi').unlockScroll();
        },

        toggleMenu(id) {
            this.menuOpenId = this.menuOpenId === id ? null : id;
        },

        get products() {
            let list = [...window.EMPIRE_ADMIN.products];
            if (this.search) {
                const q = this.search.toLowerCase();
                list = list.filter(p =>
                    p.name.toLowerCase().includes(q) ||
                    p.sku.toLowerCase().includes(q) ||
                    p.brand.toLowerCase().includes(q)
                );
            }
            if (this.categoryFilter) {
                list = list.filter(p => p.category === this.categoryFilter);
            }
            if (this.statusFilter === 'active') list = list.filter(p => p.is_active);
            if (this.statusFilter === 'inactive') list = list.filter(p => !p.is_active);
            if (this.statusFilter === 'low') list = list.filter(p => p.stock_quantity <= 10);
            return list;
        },

        resetForm() {
            this.form = {
                name: '', brand: 'Apple', category: 'phone-cases', price: '',
                cost_price: '', stock_quantity: '', sku: '', is_active: true, is_featured: false,
            };
        },

        openCreate() {
            this.menuOpenId = null;
            this.editing = null;
            this.resetForm();
            this.detailDrawerOpen = false;
            this.openDrawer('formDrawerOpen');
        },

        openEdit(product) {
            this.menuOpenId = null;
            this.editing = product.id;
            this.form = { ...product };
            this.detailDrawerOpen = false;
            this.openDrawer('formDrawerOpen');
        },

        openDetail(product) {
            this.menuOpenId = null;
            this.selectedProduct = product;
            this.formDrawerOpen = false;
            this.openDrawer('detailDrawerOpen');
        },

        save() {
            Alpine.store('adminUi').notify(this.editing ? 'Product updated (demo)' : 'Product created (demo)');
            this.closeDrawer('formDrawerOpen');
        },

        deleteProduct(id) {
            this.menuOpenId = null;
            if (confirm('Delete this product? (Demo — no backend)')) {
                Alpine.store('adminUi').notify('Product deleted (demo)');
            }
        },
    }));

    Alpine.data('adminOrders', () => ({
        search: '',
        statusFilter: '',
        menuOpenId: null,
        detailDrawerOpen: false,
        statusDrawerOpen: false,
        selectedOrder: null,
        statusForm: { status: '', message: '' },

        hasOpenDrawer() {
            return this.detailDrawerOpen || this.statusDrawerOpen;
        },

        openDrawer(flag) {
            this[flag] = true;
            Alpine.store('adminUi').lockScroll();
        },

        closeDrawer(flag) {
            this[flag] = false;
            if (!this.hasOpenDrawer()) {
                Alpine.store('adminUi').unlockScroll();
            }
        },

        closeAllDrawers() {
            this.detailDrawerOpen = false;
            this.statusDrawerOpen = false;
            this.menuOpenId = null;
            Alpine.store('adminUi').unlockScroll();
        },

        toggleMenu(id) {
            this.menuOpenId = this.menuOpenId === id ? null : id;
        },

        get orders() {
            let list = [...window.EMPIRE_ADMIN.orders];
            if (this.search) {
                const q = this.search.toLowerCase();
                list = list.filter(o =>
                    o.id.toLowerCase().includes(q) ||
                    o.customer.toLowerCase().includes(q)
                );
            }
            if (this.statusFilter) {
                list = list.filter(o => o.status === this.statusFilter);
            }
            return list;
        },

        openDetail(order) {
            this.menuOpenId = null;
            this.selectedOrder = order;
            this.statusDrawerOpen = false;
            this.openDrawer('detailDrawerOpen');
        },

        openStatus(order) {
            this.menuOpenId = null;
            this.selectedOrder = order;
            this.statusForm = { status: order.status, message: '' };
            this.detailDrawerOpen = false;
            this.openDrawer('statusDrawerOpen');
        },

        submitStatus() {
            const order = window.EMPIRE_ADMIN.orders.find(o => o.id === this.selectedOrder?.id);
            if (order) {
                order.status = this.statusForm.status;
            }
            Alpine.store('adminUi').notify(`Order ${this.selectedOrder.id} updated to ${this.statusForm.status}`);
            this.closeDrawer('statusDrawerOpen');
        },
    }));
});
