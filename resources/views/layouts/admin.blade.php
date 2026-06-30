<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Empire.pk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        empire: { 50: '#fffbeb', 100: '#fef3c7', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309' },
                        navy: { 800: '#1e293b', 900: '#0f172a', 950: '#020617' },
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link.active {
            background: #fffbeb;
            color: #b45309;
            border-right: 3px solid #f59e0b;
            font-weight: 600;
        }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased" x-data x-cloak>

    @unless($guest ?? false)
    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            @include('admin.partials.topbar')

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any() && ! ($guest ?? false))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <div x-show="$store.adminUi.sidebarOpen" x-cloak @click="$store.adminUi.sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

    <div x-show="$store.adminUi.toast.visible" x-transition
         :class="$store.adminUi.toast.type === 'error' ? 'bg-red-600' : 'bg-navy-900'"
         class="fixed bottom-6 right-6 z-[100] text-white px-5 py-3 rounded-xl shadow-xl text-sm font-medium">
        <span x-text="$store.adminUi.toast.message"></span>
    </div>
    @else
        @yield('content')
    @endunless

    <script src="{{ asset('js/store-data.js') }}"></script>
    <script src="{{ asset('js/admin-data.js') }}"></script>
    <script src="{{ asset('js/admin-app.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
