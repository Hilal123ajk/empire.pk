window.EMPIRE_ADMIN = {
    users: [
        { email: 'admin@empire.pk.com', password: 'password', name: 'Admin', role: 'admin' },
        { email: 'manager@empire.pk.com', password: 'password', name: 'Manager', role: 'manager' },
    ],

    stats: {
        ordersToday: 12,
        ordersWeek: 84,
        ordersMonth: 312,
        revenueToday: 45890,
        revenueWeek: 312450,
        revenueMonth: 1245800,
        revenueChange: 12.4,
        newCustomers: 28,
        customersChange: 8.2,
        lowStockCount: 3,
    },

    orders: [
        { id: 'EMP-1042', customer: 'Ahmed Khan', email: 'ahmed@email.com', phone: '0300-1112233', city: 'Lahore', total: 7498, status: 'pending', payment: 'cod', paymentStatus: 'pending', items: 2, createdAt: '2026-06-29 10:32' },
        { id: 'EMP-1041', customer: 'Sara Malik', email: 'sara@email.com', phone: '0321-4455667', city: 'Islamabad', total: 3499, status: 'processing', payment: 'cod', paymentStatus: 'pending', items: 1, createdAt: '2026-06-29 09:15' },
        { id: 'EMP-1040', customer: 'Usman Ali', email: 'usman@email.com', phone: '0333-9876543', city: 'Karachi', total: 12497, status: 'shipped', payment: 'cod', paymentStatus: 'pending', items: 3, createdAt: '2026-06-28 18:40' },
        { id: 'EMP-1039', customer: 'Fatima Noor', email: 'fatima@email.com', phone: '0345-2233445', city: 'Lahore', total: 899, status: 'delivered', payment: 'cod', paymentStatus: 'paid', items: 1, createdAt: '2026-06-28 14:20' },
        { id: 'EMP-1038', customer: 'Bilal Hussain', email: 'bilal@email.com', phone: '0312-5566778', city: 'Faisalabad', total: 5999, status: 'delivered', payment: 'cod', paymentStatus: 'paid', items: 1, createdAt: '2026-06-27 11:05' },
        { id: 'EMP-1037', customer: 'Ayesha Raza', email: 'ayesha@email.com', phone: '0300-7788990', city: 'Rawalpindi', total: 4298, status: 'cancelled', payment: 'cod', paymentStatus: 'refunded', items: 2, createdAt: '2026-06-27 08:50' },
        { id: 'EMP-1036', customer: 'Hamza Sheikh', email: 'hamza@email.com', phone: '0322-3344556', city: 'Multan', total: 1499, status: 'delivered', payment: 'cod', paymentStatus: 'paid', items: 1, createdAt: '2026-06-26 16:30' },
        { id: 'EMP-1035', customer: 'Zainab Tariq', email: 'zainab@email.com', phone: '0331-6677889', city: 'Lahore', total: 8999, status: 'processing', payment: 'cod', paymentStatus: 'pending', items: 1, createdAt: '2026-06-26 12:00' },
    ],

    orderDetails: {
        'EMP-1042': {
            address: 'House 42, Block C, Johar Town',
            items: [
                { name: 'Spigen Ultra Hybrid Case iPhone 15', qty: 1, price: 3499 },
                { name: '9H Tempered Glass Screen Protector iPhone 15 Pro', qty: 1, price: 899 },
            ],
        },
        'EMP-1041': {
            address: 'Flat 5, G-11 Markaz',
            items: [{ name: 'Spigen Ultra Hybrid Case iPhone 15', qty: 1, price: 3499 }],
        },
    },

    customers: [
        { id: 1, name: 'Ahmed Khan', email: 'ahmed@email.com', phone: '0300-1112233', city: 'Lahore', orders: 5, spent: 24500, joined: '2026-01-15' },
        { id: 2, name: 'Sara Malik', email: 'sara@email.com', phone: '0321-4455667', city: 'Islamabad', orders: 3, spent: 12800, joined: '2026-02-20' },
        { id: 3, name: 'Usman Ali', email: 'usman@email.com', phone: '0333-9876543', city: 'Karachi', orders: 8, spent: 45200, joined: '2025-11-08' },
        { id: 4, name: 'Fatima Noor', email: 'fatima@email.com', phone: '0345-2233445', city: 'Lahore', orders: 2, spent: 5600, joined: '2026-04-12' },
        { id: 5, name: 'Bilal Hussain', email: 'bilal@email.com', phone: '0312-5566778', city: 'Faisalabad', orders: 6, spent: 32100, joined: '2025-12-03' },
        { id: 6, name: 'Ayesha Raza', email: 'ayesha@email.com', phone: '0300-7788990', city: 'Rawalpindi', orders: 1, spent: 4298, joined: '2026-06-01' },
    ],

    bestsellers: [
        { name: 'Anker 65W GaN USB-C Fast Charger', sold: 203, revenue: 1216797 },
        { name: 'USB-C to Lightning Cable 2M MFi Certified', sold: 178, revenue: 444822 },
        { name: 'Baseus 20000mAh 65W Power Bank', sold: 156, revenue: 1169844 },
        { name: 'Spigen Ultra Hybrid Case iPhone 15', sold: 124, revenue: 433876 },
    ],

    lowStock: [
        { name: 'Privacy Tempered Glass iPhone 15', sku: 'SPG-PRIV-15', stock: 3 },
        { name: 'Apple Watch Sport Band 45mm', sku: 'APL-WB-45', stock: 5 },
        { name: 'Premium Screen Cleaning Kit', sku: 'BAS-CLN-01', stock: 8 },
    ],

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
