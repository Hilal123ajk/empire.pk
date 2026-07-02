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
        fee: 199,
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

window.EMPIRE_STORE.goBack = function (fallbackUrl) {
    const fallback = fallbackUrl || '/';

    try {
        const referrer = document.referrer;

        if (referrer && new URL(referrer).origin === window.location.origin) {
            window.history.back();

            return;
        }
    } catch (error) {
        // Ignore invalid referrer URLs and use fallback.
    }

    window.location.href = fallback;
};
