@extends('layouts.admin', ['guest' => true])

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('admin.login') }}" class="inline-flex justify-center">
                <x-admin-logo size="lg" />
            </a>
            <p class="text-gray-500 text-sm mt-3">Sign in to manage your store</p>
        </div>

        @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-800">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-200 space-y-5">
            @csrf

            @if ($errors->any())
            <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                {{ $errors->first() }}
            </div>
            @endif

            <div>
                <label for="email" class="text-xs font-semibold text-gray-600 block mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500 @error('email') border-red-300 @enderror">
            </div>
            <div>
                <label for="password" class="text-xs font-semibold text-gray-600 block mb-1.5">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" value="1" class="rounded accent-empire-500" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>

            <button type="submit" class="w-full py-3 bg-navy-900 hover:bg-navy-800 text-white font-bold rounded-xl transition">
                Sign In
            </button>
        </form>

        <p class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-empire-600 transition">← Back to store</a>
        </p>
    </div>
</div>
@endsection
