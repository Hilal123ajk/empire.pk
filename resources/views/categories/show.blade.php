@extends('layouts.app')

@section('title', $category->title . ' — Empire.pk')
@section('meta_description', $category->description ?? 'Shop ' . $category->title . ' at Empire.pk. Premium mobile accessories delivered across Pakistan.')

@section('content')
@php
    $backFallback = $parentCategory
        ? route('store.categories.show', $parentCategory->slug)
        : route('store.categories.index');
@endphp

@if (! ($showSubcategorySection && count($subcategories) > 0))
<x-mobile-back-nav :fallback="$backFallback" />
@endif

<section x-data="productFilters()" x-init="
    rootCategory = '{{ $rootCategorySlug }}';
    category = '{{ $filterSlug }}';
    includeChildProducts = {{ $includeChildProducts ? 'true' : 'false' }};
">
    {{-- Category hero --}}
    <div class="bg-navy-900 text-white">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-10">
            <nav class="text-xs text-gray-400 mb-3 flex items-center gap-2 flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-empire-400">Home</a>
                <span>/</span>
                <a href="{{ route('store.categories.index') }}" class="hover:text-empire-400">Categories</a>
                @if ($parentCategory)
                <span>/</span>
                <a href="{{ route('store.categories.show', $parentCategory->slug) }}" class="hover:text-empire-400">{{ $parentCategory->title }}</a>
                @endif
                <span>/</span>
                <span class="text-gray-300">{{ $category->title }}</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold">{{ $category->title }}</h1>
                    <p class="text-gray-400 text-sm mt-1"><span x-text="filteredProducts.length"></span> products available</p>
                </div>
                <select x-model="sort" class="px-4 py-2 bg-navy-800 border border-gray-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-empire-500 w-full md:w-auto">
                    <option value="featured">Featured</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="rating">Top Rated</option>
                    <option value="discount">Best Discount</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Sub-category navbar --}}
    @if ($showSubcategorySection && count($subcategories) > 0)
    @php
        $navParent = $parentCategory ?? $category;
        $isAllActive = $parentCategory === null;
    @endphp
    <nav class="sticky top-14 z-30 bg-white border-b border-gray-200 shadow-sm" aria-label="Sub-categories">
        <div class="max-w-7xl mx-auto px-4">
            <ul class="flex items-center gap-0 overflow-x-auto scrollbar-hide -mb-px">
                <li class="shrink-0 lg:hidden">
                    <button type="button"
                            onclick="window.EMPIRE_STORE.goBack(@js($backFallback))"
                            class="inline-flex items-center px-3 py-3.5 text-navy-900 hover:text-empire-600 transition"
                            aria-label="Go back">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                </li>
                <li class="shrink-0">
                    <a href="{{ route('store.categories.show', $navParent->slug) }}"
                       class="flex items-center gap-2 px-4 py-3.5 text-sm font-semibold whitespace-nowrap transition border-b-2 {{ $isAllActive ? 'text-navy-900 border-empire-500' : 'text-gray-600 border-transparent hover:text-navy-900 hover:border-gray-300' }}">
                        All
                    </a>
                </li>
                @foreach ($subcategories as $sub)
                <li class="shrink-0">
                    <a href="{{ $sub['url'] }}"
                       class="block px-4 py-3.5 text-sm font-medium whitespace-nowrap transition border-b-2 {{ $sub['slug'] === $category->slug ? 'text-navy-900 border-empire-500' : 'text-gray-600 border-transparent hover:text-navy-900 hover:border-gray-300' }}">
                        {{ $sub['name'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
        <div x-show="filteredProducts.length === 0" class="text-center py-16">
            <p class="text-gray-500">No products in this category yet.</p>
            <a href="{{ route('store.products.index') }}" class="mt-4 inline-block text-empire-600 font-semibold text-sm hover:underline">Browse all products</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden group hover:shadow-lg transition flex flex-col">
                    <a :href="'/products/' + product.slug" class="relative aspect-square overflow-hidden bg-gray-50 block">
                        <img :src="product.image" :alt="product.name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-3 md:p-4 flex flex-col flex-1">
                        <p class="text-xs text-gray-500" x-text="product.brand"></p>
                        <a :href="'/products/' + product.slug" class="text-sm font-semibold text-navy-900 line-clamp-2 mt-0.5 hover:text-empire-600" x-text="product.name"></a>
                        <div class="mt-auto pt-3 flex items-end justify-between gap-2">
                            <div>
                                <p class="text-base font-bold text-navy-900" x-text="EMPIRE_STORE.formatPrice(product.price)"></p>
                                <p x-show="product.originalPrice > product.price" class="text-xs text-gray-400 line-through" x-text="EMPIRE_STORE.formatPrice(product.originalPrice)"></p>
                            </div>
                            <button @click="$store.cart.add(product)" :disabled="!product.inStock"
                                    class="p-2.5 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-300 text-white rounded-xl transition shrink-0"
                                    aria-label="Add to cart">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
@endsection
