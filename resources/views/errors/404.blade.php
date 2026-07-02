@extends('layouts.app')

@php
    $seo = \App\Support\SeoMeta::forPage(
        title: 'Page Not Found',
        description: 'This page could not be found. Browse phone cases, screen protectors, and mobile accessories at Empire.pk.',
        canonical: url('/'),
        keywords: '404, page not found, Empire.pk, mobile accessories',
    );
@endphp

@section('content')
<section class="relative min-h-[calc(100vh-12rem)] flex items-center overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0 bg-navy-950">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-950 to-navy-900"></div>
        <div class="absolute top-0 right-0 w-[480px] h-[480px] bg-empire-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[360px] h-[360px] bg-empire-400/5 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-24 w-full">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            {{-- Copy & actions --}}
            <div class="text-center lg:text-left order-2 lg:order-1">
                <p class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-empire-500/15 border border-empire-500/30 text-empire-400 text-xs font-semibold uppercase tracking-wider mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-empire-400 animate-pulse"></span>
                    Error 404
                </p>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    Oops! This page
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-empire-400 to-empire-600">doesn&apos;t exist</span>
                </h1>

                <p class="text-gray-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto lg:mx-0 mb-8">
                    The link may be broken, the product might have moved, or the URL was typed incorrectly. Let&apos;s get you back to shopping.
                </p>

                <div class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-3 mb-10">
                    <a href="{{ route('store.home') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl text-sm transition shadow-lg shadow-empire-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Back to Home
                    </a>
                    <a href="{{ route('store.collections.index') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/15 text-white font-semibold rounded-xl text-sm border border-white/10 transition backdrop-blur-sm">
                        Browse Collections
                    </a>
                </div>

                @if (! empty($storeCatalogCategories))
                    <div class="text-left">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Popular categories</p>
                        <div class="flex flex-wrap gap-2 justify-center lg:justify-start">
                            @foreach (collect($storeCatalogCategories)->take(5) as $category)
                                <a href="{{ route('store.collections.show', $category['slug']) }}"
                                   class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-empire-500/20 border border-white/10 hover:border-empire-500/40 text-gray-300 hover:text-empire-400 text-xs font-medium transition">
                                    {{ $category['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Illustration --}}
            <div class="order-1 lg:order-2 flex justify-center" x-data="{ float: true }">
                <div class="relative">
                    <div class="absolute inset-0 bg-empire-500/20 rounded-full blur-3xl scale-75 animate-pulse"></div>

                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96">
                        {{-- Large 404 --}}
                        <div class="absolute inset-0 flex items-center justify-center select-none pointer-events-none">
                            <span class="text-[8rem] sm:text-[10rem] md:text-[12rem] font-extrabold text-white/[0.04] leading-none">404</span>
                        </div>

                        {{-- Phone illustration --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative animate-[bounce_3s_ease-in-out_infinite]">
                                <div class="w-36 sm:w-44 md:w-52 aspect-[9/19] rounded-[2rem] bg-gradient-to-b from-gray-700 to-gray-900 border-4 border-gray-600 shadow-2xl shadow-black/50 flex flex-col items-center overflow-hidden">
                                    <div class="w-16 h-4 bg-gray-800 rounded-b-xl mt-2"></div>
                                    <div class="flex-1 w-full m-2 mt-3 rounded-2xl bg-navy-900 relative overflow-hidden border border-gray-700">
                                        <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                                            <div class="w-14 h-14 rounded-2xl bg-empire-500/20 border border-empire-500/40 flex items-center justify-center mb-3">
                                                <svg class="w-7 h-7 text-empire-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-[10px] sm:text-xs text-gray-400 text-center font-medium">Page not found</p>
                                        </div>
                                        {{-- Crack lines --}}
                                        <svg class="absolute inset-0 w-full h-full text-white/10" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M50 20 L35 55 L55 70 L45 95" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                            <path d="M50 20 L65 45 L48 65" fill="none" stroke="currentColor" stroke-width="0.5"/>
                                        </svg>
                                    </div>
                                    <div class="w-10 h-1 bg-gray-600 rounded-full mb-3"></div>
                                </div>

                                {{-- Floating accessory chips --}}
                                <div class="absolute -top-4 -right-6 w-12 h-12 bg-empire-500 rounded-xl rotate-12 flex items-center justify-center shadow-lg shadow-empire-500/30 animate-[bounce_2.5s_ease-in-out_infinite]">
                                    <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="absolute -bottom-2 -left-8 w-10 h-10 bg-white/10 backdrop-blur border border-white/20 rounded-full flex items-center justify-center animate-[bounce_3.5s_ease-in-out_infinite]">
                                    <span class="text-empire-400 font-extrabold text-sm">?</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search bar --}}
        <div class="mt-14 max-w-xl mx-auto">
            <p class="text-center text-xs text-gray-500 mb-3">Or search for what you need</p>
            <form action="{{ route('store.products.index') }}" method="GET" class="relative">
                <input type="search" name="q" placeholder="Search cases, chargers, screen protectors..."
                       class="w-full pl-5 pr-14 py-3.5 bg-white/5 border border-white/10 rounded-2xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-empire-500 focus:border-transparent transition backdrop-blur-sm">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl text-xs transition">
                    Search
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('head')
<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush
