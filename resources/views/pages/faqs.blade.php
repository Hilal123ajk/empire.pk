@extends('layouts.app')

@section('content')
<x-page-hero
    title="Frequently Asked Questions"
    subtitle="Answers to common questions about shopping at Empire.pk."
/>

<section class="max-w-3xl mx-auto px-4 py-10 md:py-14">
    <div class="space-y-3" x-data="{ open: 0 }">
        @foreach ($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <button type="button"
                        @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left hover:bg-gray-50 transition"
                        :aria-expanded="open === {{ $index }}">
                    <span class="font-semibold text-navy-900 text-sm md:text-base">{{ $faq['question'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform"
                         :class="open === {{ $index }} ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $index }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                    {{ $faq['answer'] }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <p class="text-gray-500 text-sm mb-4">Still have questions?</p>
        <a href="{{ route('store.pages.contact') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-empire-500 hover:bg-empire-600 text-navy-900 font-semibold rounded-xl text-sm transition">
            Contact Us
        </a>
    </div>
</section>
@endsection
