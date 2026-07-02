@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of your store performance')

@section('content')
<div x-data="{}">
    {{-- Stats widgets --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Orders</span>
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.stats.totalOrders"></p>
            <p class="text-xs text-gray-500 mt-1"><span x-text="EMPIRE_ADMIN.stats.pendingOrders"></span> pending · <span x-text="EMPIRE_ADMIN.stats.deliveredOrders"></span> delivered</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Customers</span>
                <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.stats.totalCustomers"></p>
            <p class="text-xs text-gray-500 mt-1">Unique checkout customers</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Completed Revenue</span>
                <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.formatPrice(EMPIRE_ADMIN.stats.completedRevenue)"></p>
            <p class="text-xs text-gray-500 mt-1"><span x-text="EMPIRE_ADMIN.stats.completedOrderCount"></span> delivered orders</p>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6 md:mb-8">
        <a href="{{ url('/admin/products') }}" class="flex items-center gap-3 p-4 bg-navy-900 text-white rounded-2xl hover:bg-navy-800 transition">
            <svg class="w-6 h-6 text-empire-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span class="text-sm font-semibold">Add Product</span>
        </a>
        <a href="{{ url('/admin/categories') }}" class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-2xl hover:shadow-md transition">
            <svg class="w-6 h-6 text-empire-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span class="text-sm font-semibold text-navy-900">Add Category</span>
        </a>
        <a href="{{ url('/admin/orders') }}" class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-2xl hover:shadow-md transition">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span class="text-sm font-semibold text-navy-900">View Orders</span>
        </a>
        <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 p-4 bg-white border border-gray-200 rounded-2xl hover:shadow-md transition">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span class="text-sm font-semibold text-navy-900">View Store</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Recent orders --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-navy-900">Recent Orders</h2>
                <a href="{{ url('/admin/orders') }}" class="text-xs font-semibold text-empire-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold">Order</th>
                            <th class="text-left px-5 py-3 font-semibold hidden sm:table-cell">Customer</th>
                            <th class="text-left px-5 py-3 font-semibold">Total</th>
                            <th class="text-left px-5 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-if="EMPIRE_ADMIN.orders.length === 0">
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-500">No orders yet. Checkouts will appear here.</td>
                            </tr>
                        </template>
                        <template x-for="order in EMPIRE_ADMIN.orders.slice(0, 5)" :key="order.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <a href="{{ url('/admin/orders') }}" class="font-semibold text-navy-900 hover:text-empire-600" x-text="order.id"></a>
                                    <p class="text-xs text-gray-400 sm:hidden" x-text="order.customer"></p>
                                </td>
                                <td class="px-5 py-3 hidden sm:table-cell text-gray-600" x-text="order.customer"></td>
                                <td class="px-5 py-3 font-medium" x-text="EMPIRE_ADMIN.formatPrice(order.total)"></td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize"
                                          :class="EMPIRE_ADMIN.statusColors[order.status]"
                                          x-text="order.status"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar widgets --}}
        <div class="space-y-6">
            {{-- Activity log --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-bold text-navy-900 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-empire-500 rounded-full"></span>
                    Activity Log
                </h2>
                <div class="space-y-3 max-h-[22rem] overflow-y-auto pr-1">
                    <template x-if="EMPIRE_ADMIN.activity.length === 0">
                        <p class="text-sm text-gray-500">No admin activity recorded yet.</p>
                    </template>
                    <template x-for="entry in EMPIRE_ADMIN.activity" :key="entry.id">
                        <div class="flex gap-3 text-sm border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                            <div class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center"
                                 :class="{
                                    'bg-blue-100 text-blue-600': entry.subject_type === 'order',
                                    'bg-empire-100 text-empire-700': entry.subject_type === 'product',
                                    'bg-indigo-100 text-indigo-600': entry.subject_type === 'category',
                                    'bg-gray-100 text-gray-600': entry.subject_type === 'brand',
                                 }">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-navy-900 leading-snug" x-text="entry.description"></p>
                                <p class="text-[11px] text-gray-400 mt-1">
                                    <span x-text="entry.user"></span> · <span x-text="entry.created_at_human"></span>
                                </p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Bestsellers --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-bold text-navy-900 mb-4">Bestsellers</h2>
                <div class="space-y-3">
                    <template x-if="EMPIRE_ADMIN.bestsellers.length === 0">
                        <p class="text-sm text-gray-500">No sales data yet.</p>
                    </template>
                    <template x-for="(item, i) in EMPIRE_ADMIN.bestsellers" :key="i">
                        <div class="flex items-start gap-3 text-sm">
                            <span class="w-6 h-6 bg-empire-100 text-empire-700 rounded-lg flex items-center justify-center text-xs font-bold shrink-0" x-text="i + 1"></span>
                            <div class="min-w-0">
                                <p class="font-medium text-navy-900 line-clamp-2" x-text="item.name"></p>
                                <p class="text-xs text-gray-500"><span x-text="item.sold"></span> sold</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.EMPIRE_ADMIN.stats = @json($dashboardStats);
    window.EMPIRE_ADMIN.orders = @json($dashboardRecentOrders);
    window.EMPIRE_ADMIN.bestsellers = @json($dashboardBestsellers);
    window.EMPIRE_ADMIN.activity = @json($dashboardActivity);
</script>
@endpush
