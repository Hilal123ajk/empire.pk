@extends('layouts.admin', ['guest' => true])

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 bg-gray-50">
    <div class="text-center max-w-md">
        <p class="text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-empire-400 to-empire-600 mb-2">404</p>
        <h1 class="text-xl font-bold text-navy-900 mb-2">Admin page not found</h1>
        <p class="text-sm text-gray-500 mb-8">This admin URL doesn&apos;t exist or you may not have access.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-empire-500 hover:bg-empire-600 text-navy-900 font-bold rounded-xl text-sm transition">
                Go to Dashboard
            </a>
            <a href="{{ route('store.home') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:border-empire-500 text-gray-700 font-semibold rounded-xl text-sm transition">
                View Storefront
            </a>
        </div>
    </div>
</div>
@endsection
