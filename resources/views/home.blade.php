@extends('layouts.app')

@section('title', 'Empire.pk — Premium Mobile Accessories in Pakistan')

@section('content')
{{-- Hero Slider --}}
<section class="relative" x-data="heroSlider()">
    <div class="relative h-[220px] sm:h-[320px] md:h-[420px] overflow-hidden bg-navy-900">
        <template x-for="(banner, index) in banners" :key="index">
            <div x-show="current === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute inset-0">
                <img :src="banner.image" :alt="banner.title" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r" :class="banner.color"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 w-full">
                        <div class="max-w-lg">
                            <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-white mb-2 md:mb-4 leading-tight" x-text="banner.title"></h1>
                            <p class="text-sm sm:text-base md:text-lg text-gray-200 mb-4 md:mb-6" x-text="banner.subtitle"></p>
                            <a :href="banner.link" class="inline-flex items-center gap-2 px-5 py-2.5 md:px-6 md:py-3 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl text-sm transition shadow-lg">
                                <span x-text="banner.cta"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Slider controls --}}
        <button @click="prev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur rounded-full flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur rounded-full flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            <template x-for="(banner, index) in banners" :key="'dot-'+index">
                <button @click="goTo(index)" :class="current === index ? 'bg-empire-500 w-6' : 'bg-white/50 w-2'" class="h-2 rounded-full transition-all"></button>
            </template>
        </div>
    </div>
</section>

{{-- Trust badges --}}
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            @foreach([
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Genuine Products', 'sub' => '100% Authentic'],
                ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'title' => 'Cash on Delivery', 'sub' => 'Pay when you receive'],
                ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'title' => 'Easy Returns', 'sub' => '7-day return policy'],
            ] as $badge)
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 p-2">
                <div class="w-10 h-10 bg-empire-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-empire-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badge['icon'] }}"/></svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-sm font-semibold text-navy-900">{{ $badge['title'] }}</p>
                    <p class="text-xs text-gray-500">{{ $badge['sub'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Shop by Category --}}
<section class="max-w-7xl mx-auto px-4 py-10 md:py-14">
    <div class="flex items-center justify-between mb-6 md:mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900">Shop by Category</h2>
        </div>
        <a href="{{ route('store.categories.index') }}" class="hidden sm:flex items-center gap-1 text-sm font-semibold text-empire-600 hover:text-empire-700 transition">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 md:gap-4" x-data="{}">
        <template x-for="cat in EMPIRE_STORE.categories.slice(0, 12)" :key="cat.slug">
            <a :href="'/categories/' + cat.slug" class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-empire-300 transition-all duration-300">
                <div class="aspect-square overflow-hidden bg-gray-100">
                    <img :src="cat.image" :alt="cat.name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-2 md:p-3 text-center">
                    <p class="text-xs md:text-sm font-semibold text-navy-900 line-clamp-2 leading-tight" x-text="cat.name"></p>
                    <p class="text-[10px] md:text-xs text-gray-400 mt-0.5" x-text="cat.count + ' items'"></p>
                </div>
            </a>
        </template>
    </div>
</section>

{{-- Featured Products --}}
<section class="bg-white border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-10 md:py-14">
        <div class="flex items-center justify-between mb-6 md:mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900">Featured Products</h2>
                <p class="text-gray-500 text-sm mt-1">Hand-picked bestsellers for you</p>
            </div>
            <a href="{{ route('store.products.index') }}" class="text-sm font-semibold text-empire-600 hover:text-empire-700 transition">See All →</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
            @forelse ($featuredProducts as $product)
            <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden group hover:shadow-lg transition-all duration-300 flex flex-col">
                <a href="{{ route('store.products.show', $product['slug']) }}" class="relative block aspect-square overflow-hidden bg-white">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @unless ($product['inStock'])
                    <span class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="px-3 py-1 bg-white text-gray-800 text-xs font-bold rounded-full">Out of Stock</span>
                    </span>
                    @endunless
                </a>
                <div class="p-3 md:p-4 flex flex-col flex-1">
                    @if ($product['brand'])
                    <p class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide">{{ $product['brand'] }}</p>
                    @endif
                    <a href="{{ route('store.products.show', $product['slug']) }}" class="text-xs md:text-sm font-semibold text-navy-900 line-clamp-2 mt-0.5 hover:text-empire-600 transition">{{ $product['name'] }}</a>
                    <div class="mt-auto pt-3 flex items-end justify-between gap-2">
                        <div>
                            <p class="text-base md:text-lg font-bold text-navy-900">Rs. {{ number_format($product['price'], 0) }}</p>
                        </div>
                        <button type="button" @click="$store.cart.add(@js($product))" @disabled(!$product['inStock'])
                                class="p-2.5 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-300 text-white rounded-xl transition shrink-0"
                                aria-label="Add to cart">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p>No products available yet.</p>
            </div>
            @endforelse
        </div>

        @if ($featuredProducts->hasPages())
        <nav class="mt-8 flex flex-wrap items-center justify-center gap-2" aria-label="Featured products pagination">
            @if ($featuredProducts->onFirstPage())
            <span class="px-4 py-2 text-sm text-gray-300 border border-gray-200 rounded-xl bg-gray-50">Previous</span>
            @else
            <a href="{{ $featuredProducts->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-navy-900 border border-gray-200 rounded-xl hover:bg-gray-50 transition">Previous</a>
            @endif

            <span class="px-4 py-2 text-sm text-gray-500">
                Page {{ $featuredProducts->currentPage() }} of {{ $featuredProducts->lastPage() }}
            </span>

            @if ($featuredProducts->hasMorePages())
            <a href="{{ $featuredProducts->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-navy-900 border border-gray-200 rounded-xl hover:bg-gray-50 transition">Next</a>
            @else
            <span class="px-4 py-2 text-sm text-gray-300 border border-gray-200 rounded-xl bg-gray-50">Next</span>
            @endif
        </nav>
        @endif
    </div>
</section>

{{-- Promo banner --}}
<section class="max-w-7xl mx-auto px-4 py-12 md:py-14">
    <div class="relative rounded-3xl overflow-hidden bg-navy-900">
        <img src="https://images.unsplash.com/photo-1601784551445-20c9e3ced8ca?w=1400&h=400&fit=crop" alt="Phone cases collection" class="w-full h-56 sm:h-60 md:h-64 object-cover opacity-40">
        <div class="absolute inset-0 flex items-center justify-center text-center px-6 py-12 sm:px-8 sm:py-14 md:p-6">
            <div>
                <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-3 md:mb-2">Protect Your Phone in Style</h2>
                <p class="text-gray-300 text-sm md:text-base mb-6 md:mb-6 max-w-md mx-auto leading-relaxed">Premium cases from Spigen, UAG, and more — starting at Rs. 899</p>
                <a href="{{ route('store.categories.show', 'phone-cases') }}" class="inline-flex px-6 py-3 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl transition">Shop Cases</a>
            </div>
        </div>
    </div>
</section>

{{-- New Arrivals --}}
<section class="max-w-7xl mx-auto px-4 pb-14">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900">New Arrivals</h2>
        <a href="{{ route('store.products.index') }}" class="text-sm font-semibold text-empire-600 hover:text-empire-700 transition">View All →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
        @forelse ($newArrivals as $product)
        <a href="{{ route('store.products.show', $product['slug']) }}" class="bg-white rounded-2xl border border-gray-200 p-3 hover:shadow-md transition group">
            <div class="aspect-square rounded-xl overflow-hidden bg-gray-50 mb-3 flex items-center justify-center">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" class="max-w-full max-h-full w-full h-full object-contain group-hover:scale-105 transition-transform">
            </div>
            <p class="text-xs font-semibold text-navy-900 line-clamp-2">{{ $product['name'] }}</p>
            <p class="text-sm font-bold text-empire-600 mt-1">Rs. {{ number_format($product['price'], 0) }}</p>
        </a>
        @empty
        <div class="col-span-full text-center py-8 text-gray-500 text-sm">
            No new products in the last 30 days. Check back soon!
        </div>
        @endforelse
    </div>
</section>
@endsection
