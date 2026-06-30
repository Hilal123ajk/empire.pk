@extends('layouts.app')

@section('title', 'All Products — Empire.pk')

@section('content')
<section x-data="productFilters()" x-init="
    category = '{{ request('category', '') }}';
    brand = '{{ request('brand', '') }}';
    search = '{{ request('q', '') }}';
    sort = '{{ request('sort', 'featured') }}';
">
    {{-- Page header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <nav class="text-xs text-gray-400 mb-2 flex items-center gap-2">
                <a href="{{ url('/') }}" class="hover:text-empire-600">Home</a>
                <span>/</span>
                <span class="text-gray-600">All Products</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-navy-900">All Products</h1>
                    <p class="text-sm text-gray-500 mt-1"><span x-text="filteredProducts.length"></span> products found</p>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="mobileFiltersOpen = true" class="lg:hidden flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filters
                    </button>
                    <select x-model="sort" class="store-select px-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Top Rated</option>
                        <option value="discount">Best Discount</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
        <div class="flex gap-8">
            {{-- Sidebar filters (desktop) --}}
            <aside class="hidden lg:block w-64 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 sticky top-36 space-y-6">
                    <div>
                        <label class="text-sm font-semibold text-navy-900 block mb-2">Search</label>
                        <input type="search" x-model="search" placeholder="Search products..."
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-navy-900 block mb-2">Category</label>
                        <select x-model="category" class="store-select w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                            <option value="">All Categories</option>
                            <template x-for="cat in EMPIRE_STORE.categories" :key="cat.slug">
                                <option :value="cat.slug" x-text="cat.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-navy-900 block mb-2">Brand</label>
                        <select x-model="brand" class="store-select w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                            <option value="">All Brands</option>
                            <template x-for="b in EMPIRE_STORE.brands" :key="b">
                                <option :value="b" x-text="b"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-navy-900 block mb-2">Price Range</label>
                        <div class="space-y-2">
                            <input type="range" x-model.number="minPrice" min="0" max="50000" step="500" class="w-full accent-empire-500">
                            <input type="range" x-model.number="maxPrice" min="0" max="50000" step="500" class="w-full accent-empire-500">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span x-text="EMPIRE_STORE.formatPrice(minPrice)"></span>
                                <span x-text="EMPIRE_STORE.formatPrice(maxPrice)"></span>
                            </div>
                        </div>
                    </div>
                    <button @click="resetFilters()" class="w-full py-2 text-sm text-gray-600 hover:text-navy-900 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Clear Filters
                    </button>
                </div>
            </aside>

            {{-- Product grid --}}
            <div class="flex-1 min-w-0">
                <div x-show="filteredProducts.length === 0" class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-gray-500 font-medium">No products match your filters</p>
                    <button @click="resetFilters()" class="mt-4 text-sm text-empire-600 font-semibold hover:underline">Clear all filters</button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-5">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden group hover:shadow-lg transition flex flex-col">
                            <a :href="'/products/' + product.slug" class="relative aspect-square overflow-hidden bg-gray-50 block">
                                <img :src="product.image" :alt="product.name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span x-show="!product.inStock" class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <span class="px-3 py-1 bg-white text-gray-800 text-xs font-bold rounded-full">Out of Stock</span>
                                </span>
                            </a>
                            <div class="p-3 md:p-4 flex flex-col flex-1">
                                <p class="text-xs text-gray-500 uppercase" x-text="product.brand"></p>
                                <a :href="'/products/' + product.slug" class="text-sm font-semibold text-navy-900 line-clamp-2 mt-0.5 hover:text-empire-600 transition" x-text="product.name"></a>
                                <div class="mt-auto pt-3 flex items-end justify-between gap-2">
                                    <div>
                                        <p class="text-base md:text-lg font-bold text-navy-900" x-text="EMPIRE_STORE.formatPrice(product.price)"></p>
                                        <p x-show="product.originalPrice > product.price" class="text-xs text-gray-400 line-through" x-text="EMPIRE_STORE.formatPrice(product.originalPrice)"></p>
                                    </div>
                                    <button @click="$store.cart.add(product)" :disabled="!product.inStock"
                                            class="p-2.5 md:px-3 md:py-2 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-300 text-white rounded-xl transition shrink-0 flex items-center justify-center"
                                            aria-label="Add to cart">
                                        <svg class="w-4 h-4 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        <span class="hidden md:inline text-xs font-semibold">Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile filters drawer --}}
    <div x-show="mobileFiltersOpen" x-cloak class="lg:hidden fixed inset-0 z-50">
        <div @click="mobileFiltersOpen = false" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto p-5 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-navy-900">Filters</h3>
                <button @click="mobileFiltersOpen = false" class="p-2 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <input type="search" x-model="search" placeholder="Search..." class="w-full px-3 py-2 border rounded-lg text-sm">
            <select x-model="category" class="store-select w-full px-3 py-2 border border-gray-200 rounded-xl text-sm">
                <option value="">All Categories</option>
                <template x-for="cat in EMPIRE_STORE.categories" :key="cat.slug">
                    <option :value="cat.slug" x-text="cat.name"></option>
                </template>
            </select>
            <select x-model="brand" class="store-select w-full px-3 py-2 border border-gray-200 rounded-xl text-sm">
                <option value="">All Brands</option>
                <template x-for="b in EMPIRE_STORE.brands" :key="b">
                    <option :value="b" x-text="b"></option>
                </template>
            </select>
            <button @click="mobileFiltersOpen = false" class="w-full py-3 bg-navy-900 text-white font-semibold rounded-xl">Apply Filters</button>
        </div>
    </div>
</section>
@endsection
