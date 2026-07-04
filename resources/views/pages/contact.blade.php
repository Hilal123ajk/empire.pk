@extends('layouts.app')

@section('content')
<x-page-hero
    title="Contact Us"
    subtitle="We are here to help with orders, product questions, and support."
/>

<section class="max-w-4xl mx-auto px-4 py-10 md:py-14">
    <p class="text-gray-600 leading-relaxed mb-10">
        Have a question about an order, product, or delivery? Reach out through any of the channels below. Our team responds on WhatsApp and phone during business hours.
    </p>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="w-12 h-12 bg-empire-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-empire-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-navy-900 mb-2">Phone</h2>
            <a href="tel:+923233790913" class="text-empire-600 font-semibold hover:underline">+92 323 3790913</a>
            <p class="text-sm text-gray-500 mt-2">Call or SMS for order updates and support.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-navy-900 mb-2">WhatsApp</h2>
            <a href="https://wa.me/923233790913" target="_blank" rel="noopener noreferrer" class="text-emerald-600 font-semibold hover:underline">+92 323 3790913</a>
            <p class="text-sm text-gray-500 mt-2">Fastest way to reach us — send a message anytime.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-navy-900 mb-2">Email</h2>
            <a href="mailto:contact.empire.pk@gmail.com" class="text-blue-600 font-semibold hover:underline break-all">contact.empire.pk@gmail.com</a>
            <p class="text-sm text-gray-500 mt-2">For detailed inquiries and feedback.</p>
        </div>
    </div>

    <div class="mt-12 bg-navy-50 rounded-2xl border border-navy-100 p-6 md:p-8">
        <h2 class="text-lg font-bold text-navy-900 mb-3">Before You Contact Us</h2>
        <p class="text-gray-600 text-sm leading-relaxed mb-4">
            Many common questions are answered on our <a href="{{ route('store.pages.faqs') }}" class="text-empire-600 hover:underline">FAQs</a> page — including delivery times, cash on delivery, product authenticity, and returns.
        </p>
        <p class="text-gray-600 text-sm leading-relaxed">
            When messaging about an order, please include your <strong>order number</strong> and the <strong>phone number</strong> used at checkout so we can help you faster.
        </p>
    </div>
</section>
@endsection
