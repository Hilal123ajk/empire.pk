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

    newArrivals: [
        { id: 'mock-1', slug: 'spigen-ultra-hybrid-iphone-15', name: 'Spigen Ultra Hybrid Case iPhone 15', brand: 'Spigen', price: 3499, image: 'https://images.unsplash.com/photo-1601784551445-20c9e3ced8ca?w=600&h=600&fit=crop', inStock: true },
        { id: 'mock-2', slug: 'tempered-glass-iphone-15-pro', name: '9H Tempered Glass Screen Protector iPhone 15 Pro', brand: 'Baseus', price: 899, image: 'https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=600&h=600&fit=crop', inStock: true },
        { id: 'mock-3', slug: 'anker-65w-gan-charger', name: 'Anker 65W GaN USB-C Fast Charger', brand: 'Anker', price: 5999, image: 'https://images.unsplash.com/photo-1591290619762-d2a4a2697a2e?w=600&h=600&fit=crop', inStock: true },
        { id: 'mock-4', slug: 'apple-airpods-pro-2-case', name: 'Silicone AirPods Pro 2 Case with Carabiner', brand: 'Apple', price: 1499, image: 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=600&fit=crop', inStock: true },
        { id: 'mock-5', slug: 'magsafe-wallet-iphone', name: 'MagSafe Leather Wallet for iPhone', brand: 'Apple', price: 5999, image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=600&fit=crop', inStock: true },
    ],

    banners: [
        { title: 'Summer Accessory Sale', subtitle: 'Up to 40% off on cases, chargers & more', cta: 'Shop Deals', link: '/products?sort=discount', image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1400&h=500&fit=crop', color: 'from-slate-900/80 to-slate-900/40' },
        { title: 'New iPhone 16 Accessories', subtitle: 'Cases, protectors & MagSafe gear in stock', cta: 'Explore iPhone', link: '/phone-accessories', image: 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=1400&h=500&fit=crop', color: 'from-indigo-900/80 to-indigo-900/30' },
        { title: 'Free Delivery in Lahore', subtitle: 'On orders above Rs. 2,500', cta: 'Shop Now', link: '/phone-accessories', image: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1400&h=500&fit=crop', color: 'from-amber-900/70 to-amber-900/30' },
    ],
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
