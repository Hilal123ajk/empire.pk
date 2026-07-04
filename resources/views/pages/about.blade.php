@extends('layouts.app')

@section('content')
<x-page-hero
    title="About Us"
    subtitle="Pakistan's trusted destination for premium mobile accessories."
/>

<section class="max-w-4xl mx-auto px-4 py-10 md:py-14">
    <div class="prose prose-gray max-w-none">
        <p class="text-gray-600 leading-relaxed mb-6">
            <strong class="text-navy-900">Empire.pk</strong> was built with a simple goal: make it easy for Pakistanis to buy genuine, high-quality mobile accessories online — without the hassle of hunting through markets or worrying about fakes.
        </p>
        <p class="text-gray-600 leading-relaxed mb-6">
            From phone cases and tempered glass screen protectors to chargers, cables, AirPods accessories, and cleaning kits, we curate products that protect your devices and fit your lifestyle. Every item in our catalog is sourced from trusted suppliers so you get real products, not cheap imitations.
        </p>

        <h2 class="text-xl font-bold text-navy-900 mt-10 mb-4">Why Shop With Us?</h2>
        <ul class="space-y-3 text-gray-600">
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span><strong class="text-navy-900">Genuine products</strong> — we only sell authentic accessories from reliable brands and distributors.</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span><strong class="text-navy-900">Cash on Delivery</strong> — pay when your order arrives at your doorstep. No advance payment needed.</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span><strong class="text-navy-900">Nationwide delivery</strong> — we ship to Lahore, Karachi, Islamabad, and cities across Pakistan.</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span><strong class="text-navy-900">Simple returns</strong> — if a product does not match your requirements, you can return it. See our <a href="{{ route('store.pages.returns') }}" class="text-empire-600 hover:underline">Returns & Exchange</a> policy.</span>
            </li>
        </ul>

        <p class="text-gray-600 leading-relaxed mt-10">
            Thank you for choosing Empire.pk. We are committed to earning your trust with every order.
        </p>
    </div>
</section>
@endsection
