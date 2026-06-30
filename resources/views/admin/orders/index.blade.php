@extends('layouts.admin')

@section('title', 'Orders')
@section('page_title', 'Orders')
@section('page_subtitle', 'Track and manage customer orders')

@section('content')
<div x-data="adminOrders()" @click.outside="closeMenu()" @keydown.escape.window="closeMenu()">
    <div class="bg-white rounded-2xl border border-gray-200 p-4 mb-6 flex flex-col sm:flex-row gap-3">
        <input type="search" x-model="search" placeholder="Search order ID or customer..."
               class="flex-1 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
        <select x-model="statusFilter" class="px-4 py-2 border border-gray-200 rounded-xl text-sm bg-white">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div x-show="orders.length === 0" class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
        No orders yet. Customer checkouts will appear here.
    </div>

    <div x-show="orders.length > 0" class="bg-white rounded-2xl border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">Order ID</th>
                        <th class="text-left px-5 py-3 font-semibold">Customer</th>
                        <th class="text-left px-5 py-3 font-semibold hidden md:table-cell">City</th>
                        <th class="text-left px-5 py-3 font-semibold hidden sm:table-cell">Items</th>
                        <th class="text-left px-5 py-3 font-semibold">Total</th>
                        <th class="text-left px-5 py-3 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 font-semibold hidden lg:table-cell">Date</th>
                        <th class="text-right px-5 py-3 font-semibold w-12"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="order in orders" :key="order.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <button type="button" @click="openDetail(order)" class="font-semibold text-navy-900 hover:text-empire-600" x-text="order.id"></button>
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-navy-900" x-text="order.customer"></p>
                                <p class="text-xs text-gray-400" x-text="order.phone"></p>
                            </td>
                            <td class="px-5 py-3 hidden md:table-cell text-gray-600" x-text="order.city"></td>
                            <td class="px-5 py-3 hidden sm:table-cell text-gray-600" x-text="order.items"></td>
                            <td class="px-5 py-3 font-semibold" x-text="EMPIRE_ADMIN.formatPrice(order.total)"></td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize"
                                      :class="EMPIRE_ADMIN.statusColors[order.status]"
                                      x-text="order.status"></span>
                            </td>
                            <td class="px-5 py-3 hidden lg:table-cell text-xs text-gray-500" x-text="order.createdAt"></td>
                            <td class="px-5 py-3 text-right">
                                <button type="button" @click.stop="toggleMenu(order.id, $event)" class="p-2 text-gray-500 hover:text-navy-900 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Shared row actions menu --}}
    <div x-show="menuOpenId && menuOrder" x-cloak
         class="fixed w-48 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-[100] text-left"
         :style="`top: ${menuTop}px; right: ${menuRight}px`">
        <button type="button" @click="openDetail(menuOrder)" class="w-full px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 text-left flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            View Detail
        </button>
        <button type="button" @click="openStatus(menuOrder)" class="w-full px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 text-left flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Update Status
        </button>
    </div>

    {{-- Order detail drawer --}}
    <div x-show="detailDrawerOpen" x-cloak @keydown.escape.window="detailDrawerOpen && closeAllDrawers()"
         class="fixed inset-0 z-[60]" role="dialog">
        <div x-show="detailDrawerOpen" x-transition.opacity @click="closeAllDrawers()" class="absolute inset-0 bg-black/40"></div>
        <div x-show="detailDrawerOpen"
             x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 bottom-0 w-full max-w-lg bg-white shadow-2xl flex flex-col border-l border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 shrink-0">
                <div>
                    <h2 class="text-lg font-bold text-navy-900">Order Detail</h2>
                    <p class="text-xs text-gray-500" x-show="selectedOrder" x-text="selectedOrder?.id"></p>
                </div>
                <button type="button" @click="closeAllDrawers()" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <template x-if="selectedOrder">
                <div class="flex-1 overflow-y-auto p-5 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize"
                              :class="EMPIRE_ADMIN.statusColors[selectedOrder.status]"
                              x-text="selectedOrder.status"></span>
                        <span class="text-xs text-gray-500" x-text="selectedOrder.createdAt"></span>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Customer</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between"><dt class="text-gray-500">Name</dt><dd class="font-medium text-navy-900" x-text="selectedOrder.customer"></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd class="font-medium" x-text="selectedOrder.phone"></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd class="font-medium" x-text="selectedOrder.email"></dd></div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Delivery Address</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between"><dt class="text-gray-500">City</dt><dd class="font-medium" x-text="selectedOrder.city"></dd></div>
                            <div x-show="selectedOrder.address">
                                <dt class="text-gray-500 mb-1">Address</dt>
                                <dd class="font-medium text-navy-900" x-text="selectedOrder.address"></dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Order Items</h3>
                        <div class="space-y-3" x-show="selectedOrder.lineItems?.length">
                            <template x-for="(item, i) in selectedOrder.lineItems" :key="i">
                                <div class="flex gap-3 py-3 border-b border-gray-100 last:border-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                                        <img x-show="item.image" :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                        <div x-show="!item.image" class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-navy-900 text-sm" x-text="item.name"></p>
                                        <p x-show="item.color" class="text-xs text-gray-500 mt-0.5">
                                            Color: <span class="font-medium text-gray-700" x-text="item.color"></span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">Qty: <span x-text="item.qty"></span></p>
                                    </div>
                                    <p class="font-semibold text-sm shrink-0" x-text="EMPIRE_ADMIN.formatPrice(item.price * item.qty)"></p>
                                </div>
                            </template>
                        </div>
                        <p x-show="!selectedOrder.lineItems?.length" class="text-sm text-gray-500">
                            <span x-text="selectedOrder.items"></span> item(s)
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Payment</span><span class="uppercase font-medium" x-text="selectedOrder.payment"></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Payment Status</span><span class="capitalize font-medium" x-text="selectedOrder.paymentStatus"></span></div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between text-base font-bold text-navy-900"><span>Total</span><span x-text="EMPIRE_ADMIN.formatPrice(selectedOrder.total)"></span></div>
                    </div>
                </div>
            </template>
            <div class="border-t border-gray-200 p-5 shrink-0 bg-gray-50">
                <button type="button" @click="openStatus(selectedOrder); closeDrawer('detailDrawerOpen')" class="w-full py-2.5 bg-navy-900 text-white rounded-xl text-sm font-semibold hover:bg-navy-800">Update Status</button>
            </div>
        </div>
    </div>

    {{-- Update status drawer --}}
    <div x-show="statusDrawerOpen" x-cloak @keydown.escape.window="statusDrawerOpen && closeAllDrawers()"
         class="fixed inset-0 z-[60]" role="dialog">
        <div x-show="statusDrawerOpen" x-transition.opacity @click="closeAllDrawers()" class="absolute inset-0 bg-black/40"></div>
        <div x-show="statusDrawerOpen"
             x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 shrink-0">
                <div>
                    <h2 class="text-lg font-bold text-navy-900">Update Status</h2>
                    <p class="text-xs text-gray-500" x-show="selectedOrder" x-text="selectedOrder?.id"></p>
                </div>
                <button type="button" @click="closeAllDrawers()" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form @submit.prevent="submitStatus()" class="flex-1 overflow-y-auto p-5 space-y-5">
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-2">Order Status</label>
                    <select x-model="statusForm.status" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-empire-500">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-2">Message <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea x-model="statusForm.message" rows="4" placeholder="Add a note for the customer or internal team..."
                              class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500 resize-none"></textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Saved with the order for fulfillment reference.</p>
                </div>
            </form>
            <div class="border-t border-gray-200 p-5 shrink-0 flex gap-3 bg-gray-50">
                <button type="button" @click="closeAllDrawers()" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-medium bg-white hover:bg-gray-50">Cancel</button>
                <button type="button" @click="submitStatus()" class="flex-1 py-2.5 bg-empire-500 text-navy-900 rounded-xl text-sm font-bold hover:bg-empire-600">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.EMPIRE_ADMIN.orders = @json($adminOrders);
</script>
@endpush
