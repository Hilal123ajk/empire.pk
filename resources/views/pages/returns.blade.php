@extends('layouts.app')

@section('content')
<x-page-hero
    title="Returns & Exchange"
    subtitle="A simple, customer-friendly return policy."
/>

<section class="max-w-4xl mx-auto px-4 py-10 md:py-14">
    <div class="bg-empire-50 border border-empire-200 rounded-2xl p-6 md:p-8 mb-10">
        <h2 class="text-xl font-bold text-navy-900 mb-3">Our Policy Is Simple</h2>
        <p class="text-gray-700 leading-relaxed">
            If the product does not match your requirements, <strong>you can return it at any time</strong>. We believe shopping online should be risk-free. Whether the colour is not what you expected, the fit is wrong, or you simply changed your mind — contact us and we will help you with a return or exchange.
        </p>
    </div>

    <h2 class="text-lg font-bold text-navy-900 mb-4">When Can I Return?</h2>
    <ul class="space-y-3 text-gray-600 mb-10">
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>The product does not match your requirements or expectations.</span>
        </li>
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>You received a damaged, defective, or wrong item.</span>
        </li>
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>You would like to exchange for a different variant (e.g. colour or model).</span>
        </li>
    </ul>

    <h2 class="text-lg font-bold text-navy-900 mb-4">How to Request a Return or Exchange</h2>
    <ol class="list-decimal list-inside space-y-3 text-gray-600 mb-10">
        <li>Contact us on <a href="https://wa.me/923233790913" target="_blank" rel="noopener noreferrer" class="text-empire-600 hover:underline">WhatsApp (+92 323 3790913)</a> or call the same number.</li>
        <li>Share your order number, phone number, and a brief reason for the return.</li>
        <li>Our team will confirm eligibility and guide you through the next steps.</li>
        <li>Once we receive the product back (if applicable), we process your refund or send a replacement.</li>
    </ol>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Conditions</h2>
    <ul class="space-y-3 text-gray-600 mb-10">
        <li class="flex items-start gap-3">
            <span class="text-gray-400 shrink-0">•</span>
            <span>Products should be in original condition with tags and packaging where possible.</span>
        </li>
        <li class="flex items-start gap-3">
            <span class="text-gray-400 shrink-0">•</span>
            <span>Opened screen protectors or items that cannot be resold for hygiene reasons may be handled case by case.</span>
        </li>
        <li class="flex items-start gap-3">
            <span class="text-gray-400 shrink-0">•</span>
            <span>Refunds for COD orders are processed via bank transfer or JazzCash/EasyPaisa as agreed with our support team.</span>
        </li>
    </ul>

    <p class="text-gray-600 text-sm">
        Questions? Visit our <a href="{{ route('store.pages.contact') }}" class="text-empire-600 hover:underline">Contact Us</a> page or read the <a href="{{ route('store.pages.faqs') }}" class="text-empire-600 hover:underline">FAQs</a>.
    </p>
</section>
@endsection
