{{-- Cart drawer overlay --}}
<div x-show="$store.cart.drawerOpen"
     x-cloak
     @keydown.escape.window="$store.cart.closeDrawer()"
     class="fixed inset-0 z-[60]"
     aria-modal="true"
     role="dialog">
    {{-- Backdrop --}}
    <div x-show="$store.cart.drawerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.cart.closeDrawer()"
         class="absolute inset-0 bg-black/50"></div>

    {{-- Drawer panel --}}
    <div x-show="$store.cart.drawerOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         @click.outside="$store.cart.closeDrawer()"
         class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 shrink-0">
            <div>
                <h2 class="text-lg font-bold text-navy-900">Your Cart</h2>
                <p class="text-xs text-gray-500" x-show="$store.cart.count > 0">
                    <span x-text="$store.cart.count"></span> item(s)
                </p>
            </div>
            <button @click="$store.cart.closeDrawer()" class="p-2 text-gray-500 hover:text-navy-900 rounded-lg hover:bg-gray-100 transition" aria-label="Close cart">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Empty state --}}
        <div x-show="$store.cart.items.length === 0" class="flex-1 flex flex-col items-center justify-center px-6 text-center">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <p class="font-semibold text-gray-700 mb-1">Your cart is empty</p>
            <p class="text-sm text-gray-500 mb-6">Add items to get started</p>
            <button @click="$store.cart.closeDrawer(); window.location.href = '{{ route('store.home') }}'" class="px-5 py-2.5 bg-navy-900 text-white text-sm font-semibold rounded-xl hover:bg-navy-800 transition">
                Continue Shopping
            </button>
        </div>

        {{-- Cart items --}}
        <div x-show="$store.cart.items.length > 0" class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
            <template x-for="item in $store.cart.items" :key="item.lineKey">
                <div class="flex gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <a :href="'/products/' + item.slug" @click="$store.cart.closeDrawer()" class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 shrink-0 border border-gray-100">
                        <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                    </a>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-gray-500 uppercase" x-text="item.brand"></p>
                        <a :href="'/products/' + item.slug" @click="$store.cart.closeDrawer()" class="text-sm font-semibold text-navy-900 line-clamp-2 hover:text-empire-600" x-text="item.name"></a>
                        <p x-show="item.variantLabel" class="text-xs text-gray-500 mt-0.5">
                            Color: <span class="font-medium text-gray-700" x-text="item.variantLabel"></span>
                        </p>
                        <p class="text-sm font-bold text-navy-900 mt-1" x-text="EMPIRE_STORE.formatPrice(item.price)"></p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden text-sm">
                                <button @click="$store.cart.updateQuantity(item.lineKey, item.quantity - 1)" class="px-2.5 py-1 hover:bg-gray-100">−</button>
                                <span class="px-2.5 py-1 font-medium min-w-[1.75rem] text-center" x-text="item.quantity"></span>
                                <button @click="$store.cart.updateQuantity(item.lineKey, item.quantity + 1)" class="px-2.5 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <button @click="$store.cart.remove(item.lineKey)" class="text-xs text-red-500 hover:text-red-700 font-medium">Remove</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Footer / summary --}}
        <div x-show="$store.cart.items.length > 0" class="border-t border-gray-200 px-5 py-4 bg-gray-50 shrink-0 space-y-3">
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.total)"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Delivery</span>
                    <span class="font-medium" :class="$store.cart.deliveryFee === 0 ? 'text-emerald-600' : 'text-navy-900'"
                          x-text="$store.cart.deliveryFee === 0 ? 'FREE' : EMPIRE_STORE.formatPrice($store.cart.deliveryFee)"></span>
                </div>
                <div class="flex justify-between pt-2 border-t border-gray-200">
                    <span class="font-bold text-navy-900">Estimated Total</span>
                    <span class="font-extrabold text-navy-900" x-text="EMPIRE_STORE.formatPrice($store.cart.grandTotal)"></span>
                </div>
            </div>

            <p class="text-[10px] text-gray-400 text-center">Taxes and discounts calculated at checkout</p>

            <a href="{{ url('/checkout') }}"
               @click="$store.cart.closeDrawer()"
               class="block w-full py-3.5 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl text-center transition">
                Proceed to Checkout
            </a>

            <a href="{{ route('store.home') }}"
               @click="$store.cart.closeDrawer()"
               class="block w-full py-2.5 text-sm font-medium text-gray-600 hover:text-navy-900 transition text-center">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
