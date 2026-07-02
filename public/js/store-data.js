window.EMPIRE_STORE = {
    site: {
        name: 'Empire.pk',
        tagline: 'Premium Mobile Accessories',
        phone: '042-111-EMPIRE',
        whatsapp: '0300-1234567',
        email: 'hello@empire.pk',
    },

    categories: [],
    brands: [],
    products: [],

    banners: [],
    delivery: {
        minimum: 2500,
        fee: 199,
        categorySlugs: ['cases-covers', 'phone-cases', 'iphone-cases', 'mobile-cases'],
        categoryPatterns: ['case', 'cover'],
    },
};

window.EMPIRE_STORE.getProduct = function (slug) {
    return this.products.find(p => p.slug === slug);
};

window.EMPIRE_STORE.getCategory = function (slug) {
    return this.categories.find(c => c.slug === slug);
};

window.EMPIRE_STORE.getProductsByCategory = function (slug) {
    return this.products.filter(p => p.category === slug);
};

window.EMPIRE_STORE.formatPrice = function (amount) {
    return 'Rs. ' + Number(amount ?? 0).toLocaleString('en-PK');
};
