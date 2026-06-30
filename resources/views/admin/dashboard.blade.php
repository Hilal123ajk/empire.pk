@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of your store performance')

@section('content')
<div x-data="{}">
    {{-- Stats widgets --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Orders Today</span>
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.stats.ordersToday"></p>
            <p class="text-xs text-gray-500 mt-1"><span x-text="EMPIRE_ADMIN.stats.ordersWeek"></span> this week · <span x-text="EMPIRE_ADMIN.stats.ordersMonth"></span> this month</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Revenue Today</span>
                <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.formatPrice(EMPIRE_ADMIN.stats.revenueToday)"></p>
            <p class="text-xs text-emerald-600 mt-1 font-medium">+<span x-text="EMPIRE_ADMIN.stats.revenueChange"></span>% vs last week</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">New Customers</span>
                <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_ADMIN.stats.newCustomers"></p>
            <p class="text-xs text-emerald-600 mt-1 font-medium">+<span x-text="EMPIRE_ADMIN.stats.customersChange"></span>% this month</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Low Stock</span>
                <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-extrabold text-red-600" x-text="EMPIRE_ADMIN.stats.lowStockCount"></p>
            <p class="text-xs text-gray-500 mt-1">Products need restocking</p>
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
            {{-- Low stock --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-bold text-navy-900 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    Low Stock Alerts
                </h2>
                <div class="space-y-3">
                    <template x-for="item in EMPIRE_ADMIN.lowStock" :key="item.sku">
                        <div class="flex items-center justify-between text-sm">
                            <div class="min-w-0 pr-2">
                                <p class="font-medium text-navy-900 truncate" x-text="item.name"></p>
                                <p class="text-xs text-gray-400" x-text="item.sku"></p>
                            </div>
                            <span class="shrink-0 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full" x-text="item.stock + ' left'"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Bestsellers --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h2 class="font-bold text-navy-900 mb-4">Bestsellers</h2>
                <div class="space-y-3">
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
