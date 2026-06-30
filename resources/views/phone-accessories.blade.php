@extends('layouts.app')

@section('title', 'Phone Accessories — Empire.pk')
@section('meta_description', 'Shop phone accessories at Empire.pk. Cases, screen protectors, chargers, AirPods, iPad & MacBook accessories with free delivery in Pakistan.')

@section('content')
{{-- Page hero --}}
<section class="bg-navy-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-2">
            <a href="{{ url('/') }}" class="hover:text-empire-400 transition">Home</a>
            <span>/</span>
            <span class="text-gray-300">Collections</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Phones & Accessories</h1>
        <p class="text-gray-400 text-sm md:text-base max-w-2xl">Browse our complete collection of mobile accessories — from protective cases and tempered glass to fast chargers and premium audio gear.</p>
    </div>
</section>

{{-- Shop by Category (Al-Fatah style grid) --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-14">
    <h2 class="text-xl md:text-2xl font-extrabold text-navy-900 mb-6 md:mb-8 text-center">Shop by Category</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3 md:gap-5">
        <template x-for="cat in EMPIRE_STORE.categories" :key="cat.slug">
            <a :href="'/collections/' + cat.slug"
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
                <a :href="'/collections/all?brand=' + encodeURIComponent(brand)"
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

{{-- CTA --}}
<section class="max-w-7xl mx-auto px-4 pb-14">
    <div class="bg-gradient-to-r from-empire-500 to-empire-600 rounded-3xl p-8 md:p-12 text-center">
        <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900 mb-2">Need Help Choosing?</h2>
        <p class="text-navy-800 mb-6">Chat with us on WhatsApp for personalized recommendations</p>
        <a href="https://wa.me/923001234567" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 px-6 py-3 bg-navy-900 text-white font-bold rounded-xl hover:bg-navy-800 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Chat on WhatsApp
        </a>
    </div>
</section>
@endsection
