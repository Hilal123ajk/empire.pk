<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    @php
        $resolvedSeo = $seo ?? null;

        if (! $resolvedSeo) {
            $fallbackTitle = trim(strip_tags((string) $__env->yieldContent('title'))) ?: 'Empire.pk';
            $fallbackDescription = trim(strip_tags((string) $__env->yieldContent('meta_description')))
                ?: 'Empire.pk - Premium mobile accessories in Pakistan. Phone cases, screen protectors, chargers, AirPods & more.';

            $resolvedSeo = \App\Support\SeoMeta::forPage(
                title: $fallbackTitle,
                description: $fallbackDescription,
            );
        }
    @endphp
    <x-seo-meta :seo="$resolvedSeo" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased overflow-x-hidden" x-data="toast()" x-cloak>
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.cart-drawer')

    {{-- Toast notification --}}
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] bg-navy-900 text-white px-6 py-3 rounded-full shadow-xl text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span x-text="message"></span>
    </div>

    <script src="{{ asset('js/store-data.js') }}"></script>
    <script>
        window.EMPIRE_STORE.checkoutUrl = @json(route('store.checkout.store'));
        window.EMPIRE_STORE.newsletterUrl = @json(route('store.newsletter.subscribe'));
        window.EMPIRE_STORE.categories = @json($storeCatalogCategories ?? []);
        window.EMPIRE_STORE.products = @json($storeCatalogProducts ?? []);
        window.EMPIRE_STORE.brands = @json($storeCatalogBrands ?? []);
        window.EMPIRE_STORE.delivery = @json($storeDeliveryConfig ?? \App\Support\DeliveryPolicy::frontendConfig());
        @if (! empty($heroBanners))
        window.EMPIRE_STORE.banners = @json($heroBanners);
        @endif
    </script>
    <script src="{{ asset('js/store-app.js') }}"></script>
    <script defer src="{{ asset('js/vendor/alpine.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
