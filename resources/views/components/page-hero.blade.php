@props([
    'title',
    'subtitle' => null,
    'breadcrumb' => null,
])

<section class="bg-navy-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-2">
            <a href="{{ route('store.home') }}" class="hover:text-empire-400 transition">Home</a>
            <span>/</span>
            <span class="text-gray-300">{{ $breadcrumb ?? $title }}</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-gray-400 text-sm md:text-base max-w-2xl">{{ $subtitle }}</p>
        @endif
    </div>
</section>
