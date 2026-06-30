document.addEventListener('alpine:init', () => {
    Alpine.store('adminUi', {
        sidebarOpen: false,
        toast: { visible: false, message: '', type: 'success' },
        scrollLockCount: 0,

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        notify(message, type = 'success') {
            this.toast = { visible: true, message, type };
            setTimeout(() => { this.toast.visible = false; }, 3000);
        },

        lockScroll() {
            this.scrollLockCount += 1;
            document.body.classList.add('overflow-hidden');
        },

        unlockScroll() {
            this.scrollLockCount = Math.max(0, this.scrollLockCount - 1);
            if (this.scrollLockCount === 0) {
                document.body.classList.remove('overflow-hidden');
            }
        },
    });

    Alpine.store('adminConfirm', {
        open: false,
        title: 'Are you sure?',
        message: '',
        confirmLabel: 'Confirm',
        cancelLabel: 'Cancel',
        tone: 'danger',
        pendingForm: null,

        ask(options = {}) {
            this.title = options.title ?? 'Are you sure?';
            this.message = options.message ?? '';
            this.confirmLabel = options.confirmLabel ?? 'Confirm';
            this.cancelLabel = options.cancelLabel ?? 'Cancel';
            this.tone = options.tone ?? 'danger';
            this.pendingForm = options.form ?? null;
            this.open = true;
            Alpine.store('adminUi').lockScroll();
        },

        cancel() {
            this.open = false;
            this.pendingForm = null;
            Alpine.store('adminUi').unlockScroll();
        },

        confirm() {
            const form = this.pendingForm;
            this.open = false;
            this.pendingForm = null;
            Alpine.store('adminUi').unlockScroll();
            if (form) {
                form.submit();
            }
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
        menuOrder: null,
        menuTop: 0,
        menuRight: 16,
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
            this.closeMenu();
            Alpine.store('adminUi').unlockScroll();
        },

        closeMenu() {
            this.menuOpenId = null;
            this.menuOrder = null;
        },

        toggleMenu(id, event) {
            if (this.menuOpenId === id) {
                this.closeMenu();
                return;
            }

            const rect = event.currentTarget.getBoundingClientRect();
            const menuHeight = 96;
            const spaceBelow = window.innerHeight - rect.bottom;
            this.menuTop = spaceBelow >= menuHeight
                ? rect.bottom + 4
                : rect.top - menuHeight - 4;
            this.menuRight = Math.max(16, window.innerWidth - rect.right);
            this.menuOpenId = id;
            this.menuOrder = window.EMPIRE_ADMIN.orders.find((order) => order.id === id) ?? null;
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
            this.closeMenu();
            this.selectedOrder = order;
            this.statusDrawerOpen = false;
            this.openDrawer('detailDrawerOpen');
        },

        openStatus(order) {
            this.closeMenu();
            this.selectedOrder = order;
            this.statusForm = { status: order.status, message: '' };
            this.detailDrawerOpen = false;
            this.openDrawer('statusDrawerOpen');
        },

        async submitStatus() {
            if (!this.selectedOrder?.dbId) return;

            try {
                const response = await fetch(`/admin/orders/${this.selectedOrder.dbId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ status: this.statusForm.status }),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    Alpine.store('adminUi').notify('Unable to update order status.', 'error');
                    return;
                }

                const index = window.EMPIRE_ADMIN.orders.findIndex((entry) => entry.dbId === data.order.dbId);
                if (index !== -1) {
                    window.EMPIRE_ADMIN.orders[index] = data.order;
                }

                if (this.selectedOrder?.dbId === data.order.dbId) {
                    this.selectedOrder = data.order;
                }

                Alpine.store('adminUi').notify(`Order ${data.order.id} updated to ${data.order.status}`);
                this.closeDrawer('statusDrawerOpen');
            } catch (error) {
                Alpine.store('adminUi').notify('Network error while updating order.', 'error');
            }
        },
    }));
});
