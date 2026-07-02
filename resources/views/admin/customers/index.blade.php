@extends('layouts.admin')

@section('title', 'Customers')
@section('page_title', 'Customers')
@section('page_subtitle', 'Customers from checkout orders — grouped by phone number')

@section('content')
<div x-data="{ search: '' }">
    <div class="bg-white rounded-2xl border border-gray-200 p-4 mb-6">
        <input type="search" x-model="search" placeholder="Search by name, email, or phone..."
               class="w-full sm:w-80 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">Customer</th>
                        <th class="text-left px-5 py-3 font-semibold hidden md:table-cell">Phone</th>
                        <th class="text-left px-5 py-3 font-semibold hidden lg:table-cell">City</th>
                        <th class="text-left px-5 py-3 font-semibold">Orders</th>
                        <th class="text-left px-5 py-3 font-semibold">Total Spent</th>
                        <th class="text-left px-5 py-3 font-semibold hidden sm:table-cell">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-if="EMPIRE_ADMIN.customers.length === 0">
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">No customers yet. They will appear here after the first checkout.</td>
                        </tr>
                    </template>
                    <template x-for="customer in EMPIRE_ADMIN.customers.filter(c => !search || c.name.toLowerCase().includes(search.toLowerCase()) || (c.email !== '—' && c.email.toLowerCase().includes(search.toLowerCase())) || c.phone.includes(search))" :key="customer.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-navy-900 text-empire-400 rounded-full flex items-center justify-center font-bold text-sm shrink-0" x-text="customer.name.charAt(0)"></div>
                                    <div>
                                        <p class="font-semibold text-navy-900" x-text="customer.name"></p>
                                        <p class="text-xs text-gray-400" x-text="customer.email"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 hidden md:table-cell text-gray-600" x-text="customer.phone"></td>
                            <td class="px-5 py-3 hidden lg:table-cell text-gray-600" x-text="customer.city"></td>
                            <td class="px-5 py-3 font-medium" x-text="customer.orders"></td>
                            <td class="px-5 py-3 font-semibold text-navy-900" x-text="EMPIRE_ADMIN.formatPrice(customer.spent)"></td>
                            <td class="px-5 py-3 hidden sm:table-cell text-xs text-gray-500" x-text="EMPIRE_ADMIN.formatDate(customer.joined)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.EMPIRE_ADMIN.customers = @json($adminCustomers);
</script>
@endpush
