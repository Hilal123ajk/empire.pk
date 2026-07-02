@extends('layouts.app')

@section('title', 'Shop by Category — Empire.pk')
@section('meta_description', 'Browse all categories at Empire.pk. Mobile accessories, cases, chargers, and more with cash on delivery in Pakistan.')

@section('content')
{{-- Page hero --}}
<section class="bg-navy-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-2">
            <a href="{{ url('/') }}" class="hover:text-empire-400 transition">Home</a>
            <span>/</span>
            <span class="text-gray-300">Categories</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Shop by Category</h1>
        <p class="text-gray-400 text-sm md:text-base max-w-2xl">Browse our full range of products organized by category.</p>
    </div>
</section>

{{-- Category grid --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-14">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3 md:gap-5">
        <template x-for="cat in EMPIRE_STORE.categories" :key="cat.slug">
            <a :href="'/categories/' + cat.slug"
               class="group relative bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-empire-300 transition-all duration-300">
                <div class="relative aspect-[4/3] sm:aspect-square overflow-hidden">
                    <img :src="cat.image" :alt="cat.name" loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-3 md:p-4 text-center border-t border-gray-100">
                    <p class="text-sm md:text-base font-bold text-navy-900 group-hover:text-empire-600 transition leading-snug" x-text="cat.name"></p>
                    <p class="text-xs text-gray-400 mt-1" x-text="cat.count + ' products'"></p>
                </div>
            </a>
        </template>
    </div>
</section>

{{-- Popular brands --}}
<section class="bg-white border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-xl font-extrabold text-navy-900 mb-6 text-center">Shop by Brand</h2>
        <div class="flex flex-wrap justify-center gap-3">
            <template x-for="brand in EMPIRE_STORE.brands" :key="brand">
                <a :href="'/categories/all?brand=' + encodeURIComponent(brand)"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-navy-900 hover:text-white text-sm font-semibold text-gray-700 rounded-full transition"
                   x-text="brand"></a>
            </template>
        </div>
    </div>
</section>

{{-- Trending products --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-14">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl md:text-2xl font-extrabold text-navy-900">Trending Now</h2>
        <a href="{{ route('store.products.index') }}" class="text-sm font-semibold text-empire-600 hover:text-empire-700">View All Products →</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
        <template x-for="product in EMPIRE_STORE.products.slice(0, 8)" :key="'trend-'+product.id">
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden group hover:shadow-lg transition flex flex-col">
                <a :href="'/products/' + product.slug" class="relative aspect-square overflow-hidden bg-gray-50 block">
                    <img :src="product.image" :alt="product.name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </a>
                <div class="p-3 md:p-4 flex flex-col flex-1">
                    <p class="text-xs text-gray-500" x-text="product.brand"></p>
                    <a :href="'/products/' + product.slug" class="text-sm font-semibold text-navy-900 line-clamp-2 mt-0.5 hover:text-empire-600" x-text="product.name"></a>
                    <div class="mt-auto pt-3 flex items-center justify-between">
                        <p class="text-base font-bold text-navy-900" x-text="EMPIRE_STORE.formatPrice(product.price)"></p>
                        <button @click="$store.cart.add(product)" :disabled="!product.inStock"
                                class="p-2.5 md:px-3 md:py-1.5 bg-navy-900 text-white rounded-lg hover:bg-navy-800 disabled:bg-gray-300 transition shrink-0 flex items-center justify-center"
                                aria-label="Add to cart">
                            <svg class="w-4 h-4 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span class="hidden md:inline text-xs font-medium">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</section>
@endsection
