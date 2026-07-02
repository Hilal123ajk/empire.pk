@props(['fallback' => null])

<div class="lg:hidden bg-white border-b border-gray-200 sticky top-14 z-30">
    <div class="max-w-7xl mx-auto px-2">
        <button type="button"
                onclick="window.EMPIRE_STORE.goBack(@js($fallback ?? route('store.home')))"
                class="inline-flex items-center gap-1.5 px-3 py-2.5 text-sm font-medium text-navy-900 hover:text-empire-600 transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </button>
    </div>
</div>
