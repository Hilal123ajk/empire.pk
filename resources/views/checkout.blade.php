@extends('layouts.app')

@section('title', 'Checkout — Empire.pk')

@section('content')
<x-mobile-back-nav :fallback="route('store.home')" />

<section class="max-w-7xl mx-auto px-4 py-6 md:py-10" x-data="checkoutForm()">
    {{-- Success state --}}
    <div x-show="placed" x-cloak class="max-w-lg mx-auto text-center py-16">
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-navy-900 mb-2">Order Placed!</h1>
        <p class="text-gray-500 text-sm mb-2">Thank you for your order. We'll contact you shortly to confirm delivery.</p>
        <p class="text-sm font-semibold text-navy-900 mb-6" x-show="orderNumber">
            Order number: <span x-text="orderNumber"></span>
        </p>
        <a href="{{ route('store.home') }}" class="inline-flex px-6 py-3 bg-navy-900 text-white font-bold rounded-xl hover:bg-navy-800 transition">
            Continue Shopping
        </a>
    </div>

    {{-- Empty cart redirect --}}
    <div x-show="!placed && $store.cart.items.length === 0" x-cloak class="text-center py-16 bg-white rounded-2xl border border-gray-200">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Nothing to checkout</h2>
        <p class="text-sm text-gray-500 mb-6">Add products to your cart first.</p>
        <a href="{{ route('store.home') }}" class="inline-flex px-6 py-3 bg-navy-900 text-white font-bold rounded-xl hover:bg-navy-800 transition">
            Start Shopping
        </a>
    </div>

    {{-- Checkout form --}}
    <div x-show="!placed && $store.cart.items.length > 0" x-cloak>
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-2">
            <a href="{{ route('store.home') }}" class="hover:text-empire-600">Home</a>
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
                            <label class="text-xs font-semibold text-gray-600 block mb-1">First Name <span class="text-red-500">*</span></label>
                            <input type="text" x-model="firstName" maxlength="100" autocomplete="given-name"
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500"
                                   :class="fieldErrors.firstName ? 'border-red-400 bg-red-50' : 'border-gray-200'">
                            <p x-show="fieldErrors.firstName" x-text="fieldErrors.firstName" class="text-xs text-red-600 mt-1"></p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" x-model="lastName" maxlength="100" autocomplete="family-name"
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500"
                                   :class="fieldErrors.lastName ? 'border-red-400 bg-red-50' : 'border-gray-200'">
                            <p x-show="fieldErrors.lastName" x-text="fieldErrors.lastName" class="text-xs text-red-600 mt-1"></p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" x-model="phone" maxlength="15" inputmode="tel" autocomplete="tel"
                                   placeholder="03001234567"
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500"
                                   :class="fieldErrors.phone ? 'border-red-400 bg-red-50' : 'border-gray-200'">
                            <p x-show="fieldErrors.phone" x-text="fieldErrors.phone" class="text-xs text-red-600 mt-1"></p>
                            <p x-show="!fieldErrors.phone" class="text-[11px] text-gray-400 mt-1">Pakistani mobile number starting with 03</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Address <span class="text-red-500">*</span></label>
                            <input type="text" x-model="address" maxlength="500" autocomplete="street-address"
                                   placeholder="e.g. Chak 12, Tehsil Kasur, District Kasur, Lahore"
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500"
                                   :class="fieldErrors.address ? 'border-red-400 bg-red-50' : 'border-gray-200'">
                            <p x-show="fieldErrors.address" x-text="fieldErrors.address" class="text-xs text-red-600 mt-1"></p>
                            <p x-show="!fieldErrors.address" class="text-[11px] text-gray-400 mt-1">Minimum 4 words: village, tehsil, district, city</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 block mb-1">City <span class="text-red-500">*</span></label>
                            <select x-model="city" class="store-select w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
                                @foreach(['Lahore', 'Islamabad', 'Rawalpindi', 'Karachi', 'Faisalabad', 'Multan', 'Sialkot', 'Gujranwala'] as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 block mb-1">Order Notes <span class="text-gray-400 font-normal">(optional)</span></label>
                            <textarea x-model="notes" rows="2" maxlength="1000" placeholder="Delivery instructions..."
                                      class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500 resize-none"></textarea>
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
                        <template x-for="item in $store.cart.displayItems" :key="item.lineKey">
                            <div class="flex gap-3">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-50 shrink-0 border border-gray-100">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-navy-900 line-clamp-2" x-text="item.name"></p>
                                    <p x-show="item.variantLabel" class="text-[11px] text-gray-500 mt-0.5">
                                        Color: <span x-text="item.variantLabel"></span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">Qty: <span x-text="item.quantity"></span></p>
                                </div>
                                <p class="text-sm font-bold text-navy-900 shrink-0" x-text="EMPIRE_STORE.formatPrice($store.cart.unitPrice(item) * item.quantity)"></p>
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
                            <span class="font-medium text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.deliveryFee)"></span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between text-base pt-1">
                            <span class="font-bold text-navy-900">Total</span>
                            <span class="font-extrabold text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.grandTotal)"></span>
                        </div>
                    </div>

                    <button type="button" @click="requestPlaceOrder()"
                            :disabled="submitting"
                            class="w-full mt-5 py-3.5 bg-empire-500 hover:bg-empire-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-navy-900 font-bold rounded-xl transition">
                        <span x-show="!submitting">Place Order</span>
                        <span x-show="submitting">Placing Order...</span>
                    </button>

                    <p x-show="error" x-text="error" class="mt-3 text-sm text-red-600 text-center"></p>

                    <button type="button" @click="$store.cart.openDrawer()" class="w-full mt-2 py-2 text-sm text-gray-500 hover:text-navy-900 transition">
                        ← Back to cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Order confirmation dialog --}}
    <div x-show="confirmOpen" x-cloak @keydown.escape.window="confirmOpen = false"
         class="fixed inset-0 z-[70] flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div x-show="confirmOpen" x-transition.opacity @click="confirmOpen = false" class="absolute inset-0 bg-navy-900/50 backdrop-blur-[2px]"></div>
        <div x-show="confirmOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 md:p-7 border border-gray-100">
            <div class="w-12 h-12 rounded-full bg-empire-50 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-empire-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-navy-900 mb-2">Confirm your order?</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-1">
                You are about to place a cash on delivery order for
                <span class="font-semibold text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.grandTotal)"></span>.
            </p>
            <p class="text-xs text-gray-400 mb-6">Please verify your address and phone number before confirming.</p>
            <div class="flex gap-3">
                <button type="button" @click="confirmOpen = false"
                        class="flex-1 py-3 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    No, Go Back
                </button>
                <button type="button" @click="confirmPlaceOrder()" :disabled="submitting"
                        class="flex-1 py-3 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-400 text-white rounded-xl text-sm font-bold transition">
                    Yes, Place Order
                </button>
            </div>
        </div>
    </div>
</section>
@endsection
