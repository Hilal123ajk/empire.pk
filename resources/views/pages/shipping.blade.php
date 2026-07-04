@extends('layouts.app')

@php
    $deliveryFee = (int) config('empire.standard_delivery_fee', 199);
@endphp

@section('content')
<x-page-hero
    title="Shipping Policy"
    subtitle="Nationwide delivery across Pakistan with cash on delivery."
/>

<section class="max-w-4xl mx-auto px-4 py-10 md:py-14">
    <p class="text-gray-600 leading-relaxed mb-10">
        Empire.pk delivers mobile accessories to customers across Pakistan. Below is everything you need to know about how we ship your orders.
    </p>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Delivery Areas</h2>
    <p class="text-gray-600 leading-relaxed mb-4">
        We currently deliver to the following cities:
    </p>
    <div class="flex flex-wrap gap-2 mb-10">
        @foreach (['Lahore', 'Karachi', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Sialkot', 'Gujranwala'] as $city)
            <span class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full">{{ $city }}</span>
        @endforeach
    </div>
    <p class="text-gray-600 leading-relaxed mb-10">
        If your city is not listed, contact us on WhatsApp — we may still be able to arrange delivery depending on courier coverage in your area.
    </p>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Delivery Fee</h2>
    <p class="text-gray-600 leading-relaxed mb-10">
        A flat delivery fee of <strong class="text-navy-900">Rs. {{ number_format($deliveryFee) }}</strong> applies to all orders, regardless of order size. The fee is shown at checkout before you place your order.
    </p>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Processing & Delivery Time</h2>
    <ul class="space-y-3 text-gray-600 mb-10">
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span><strong class="text-navy-900">Order processing:</strong> 1–2 business days after confirmation.</span>
        </li>
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span><strong class="text-navy-900">Major cities:</strong> 2–4 business days after dispatch.</span>
        </li>
        <li class="flex items-start gap-3">
            <svg class="w-5 h-5 text-empire-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span><strong class="text-navy-900">Other areas:</strong> 4–7 business days depending on location.</span>
        </li>
    </ul>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Cash on Delivery</h2>
    <p class="text-gray-600 leading-relaxed mb-10">
        All orders are shipped with <strong class="text-navy-900">Cash on Delivery (COD)</strong>. Pay the total amount (product price + delivery fee) to the courier when your package arrives. No advance payment is required.
    </p>

    <h2 class="text-lg font-bold text-navy-900 mb-4">Order Tracking</h2>
    <p class="text-gray-600 leading-relaxed mb-10">
        Once your order is dispatched, our team will contact you via phone or WhatsApp with delivery updates. For any shipping questions, reach us at
        <a href="https://wa.me/923233790913" target="_blank" rel="noopener noreferrer" class="text-empire-600 hover:underline">+92 323 3790913</a>.
    </p>

    <p class="text-gray-600 text-sm">
        See also: <a href="{{ route('store.pages.returns') }}" class="text-empire-600 hover:underline">Returns & Exchange</a> ·
        <a href="{{ route('store.pages.faqs') }}" class="text-empire-600 hover:underline">FAQs</a>
    </p>
</section>
@endsection
