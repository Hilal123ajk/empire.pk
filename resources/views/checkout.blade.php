@extends('layouts.app')

@section('title', 'Checkout — Empire.pk')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-6 md:py-10" x-data="checkoutForm()">
    {{-- Success state --}}
    <div x-show="placed" x-cloak class="max-w-lg mx-auto text-center py-16">
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-navy-900 mb-2">Order Placed!</h1>
        <p class="text-gray-500 text-sm mb-6">Thank you for your order. We'll contact you shortly to confirm delivery. (Demo — no backend yet.)</p>
        <a href="{{ url('/phone-accessories') }}" class="inline-flex px-6 py-3 bg-navy-900 text-white font-bold rounded-xl hover:bg-navy-800 transition">
            Continue Shopping
        </a>
    </div>

    {{-- Empty cart redirect --}}
    <div x-show="!placed && $store.cart.items.length === 0" x-cloak class="text-center py-16 bg-white rounded-2xl border border-gray-200">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Nothing to checkout</h2>
        <p class="text-sm text-gray-500 mb-6">Add products to your cart first.</p>
        <a href="{{ url('/phone-accessories') }}" class="inline-flex px-6 py-3 bg-navy-900 text-white font-bold rounded-xl hover:bg-navy-800 transition">
            Start Shopping
        </a>
    </div>

    {{-- Checkout form --}}
    <div x-show="!placed && $store.cart.items.length > 0" x-cloak>
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-2">
            <a href="{{ url('/') }}" class="hover:text-empire-600">Home</a>
            <span>/</span>
            <span class="text-gray-600">Checkout</span>
        </nav>

        <h1 class="text-2xl md:text-3xl font-extrabold text-navy-900 mb-6">Checkout</h1>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Delivery details --}}
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 md:p-6">
                    <h2 class="text-lg font-bold text-navy-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-navy-900 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                        Delivery Details
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 block mb-1">First Name</label>
                            <input type="text" x-model="firstName" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Last Name</label>
                            <input type="text" x-model="lastName" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Phone Number</label>
                            <input type="tel" x-model="phone" placeholder="03XX-XXXXXXX" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Address</label>
                            <input type="text" x-model="address" placeholder="House no, street, area" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 block mb-1">City</label>
                            <select x-model="city" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-empire-500">
                                @foreach(['Lahore', 'Islamabad', 'Rawalpindi', 'Karachi', 'Faisalabad', 'Multan', 'Sialkot', 'Gujranwala'] as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Order Notes <span class="text-gray-400 font-normal">(optional)</span></label>
                            <textarea x-model="notes" rows="2" placeholder="Delivery instructions..." class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500 resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-5 md:p-6">
                    <h2 class="text-lg font-bold text-navy-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-navy-900 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                        Payment Method
                    </h2>
                    <label class="flex items-center gap-3 p-4 border-2 border-empire-500 bg-empire-50 rounded-xl cursor-pointer">
                        <input type="radio" x-model="payment" value="cod" class="accent-empire-500">
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">Cash on Delivery</p>
                            <p class="text-xs text-gray-500">Pay when your order arrives</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Order summary --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 md:p-6 sticky top-36">
                    <h2 class="text-lg font-bold text-navy-900 mb-4">Order Summary</h2>

                    <div class="space-y-3 max-h-64 overflow-y-auto mb-4">
                        <template x-for="item in $store.cart.items" :key="item.id">
                            <div class="flex gap-3">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-50 shrink-0 border border-gray-100">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-navy-900 line-clamp-2" x-text="item.name"></p>
                                    <p class="text-xs text-gray-500 mt-0.5">Qty: <span x-text="item.quantity"></span></p>
                                </div>
                                <p class="text-sm font-bold text-navy-900 shrink-0" x-text="EMPIRE_STORE.formatPrice(item.price * item.quantity)"></p>
                            </div>
                        </template>
                    </div>

                    <hr class="border-gray-200 mb-4">

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium" x-text="EMPIRE_STORE.formatPrice($store.cart.total)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Delivery</span>
                            <span class="font-medium text-emerald-600" x-text="$store.cart.deliveryFee === 0 ? 'FREE' : EMPIRE_STORE.formatPrice($store.cart.deliveryFee)"></span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between text-base pt-1">
                            <span class="font-bold text-navy-900">Total</span>
                            <span class="font-extrabold text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.grandTotal)"></span>
                        </div>
                    </div>

                    <button @click="placeOrder()"
                            :disabled="!firstName || !lastName || !phone || !address"
                            class="w-full mt-5 py-3.5 bg-empire-500 hover:bg-empire-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-navy-900 font-bold rounded-xl transition">
                        Place Order
                    </button>

                    <button type="button" @click="$store.cart.openDrawer()" class="w-full mt-2 py-2 text-sm text-gray-500 hover:text-navy-900 transition">
                        ← Back to cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
