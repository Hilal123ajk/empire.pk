window.EMPIRE_ADMIN = {
    stats: {
        totalOrders: 0,
        pendingOrders: 0,
        deliveredOrders: 0,
        totalCustomers: 0,
        completedRevenue: 0,
        completedOrderCount: 0,
    },

    orders: [],
    orderDetails: {},
    customers: [],
    bestsellers: [],
    activity: [],

    statusColors: {
        pending: 'bg-amber-100 text-amber-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-indigo-100 text-indigo-800',
        delivered: 'bg-emerald-100 text-emerald-800',
        cancelled: 'bg-red-100 text-red-800',
    },

    formatPrice(amount) {
        return 'Rs. ' + amount.toLocaleString('en-PK');
    },

    formatDate(dateStr) {
        return new Date(dateStr).toLocaleDateString('en-PK', { day: 'numeric', month: 'short', year: 'numeric' });
    },
};

// Extend store products with admin fields
window.EMPIRE_ADMIN.products = window.EMPIRE_STORE.products.map((p, i) => ({
    ...p,
    sku: 'EMP-' + String(p.id).padStart(4, '0'),
    stock_quantity: p.inStock ? (i % 5 === 0 ? 3 : 15 + i * 2) : 0,
    cost_price: Math.round(p.price * 0.6),
    is_active: p.inStock || p.id !== 16,
    is_featured: p.featured,
}));

window.EMPIRE_ADMIN.categories = window.EMPIRE_STORE.categories.map(c => ({
    ...c,
    id: c.slug,
    is_active: true,
    parent_id: null,
}));
