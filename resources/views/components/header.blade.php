{{-- Main header --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm" x-data="{ mobileMenu: false, mobileSearch: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-2 sm:gap-3 h-14">
            {{-- Left: menu + logo --}}
            <div class="flex items-center gap-0.5 sm:gap-2 shrink-0 min-w-0 h-full">
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 -ml-2 text-gray-600 hover:text-navy-900" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <a href="{{ url('/') }}" class="inline-flex items-center h-full shrink-0 font-logo font-medium leading-none tracking-[-0.06em] sm:tracking-[-0.07em] text-[1.65rem] sm:text-[1.85rem] md:text-[2rem] select-none" aria-label="Empire.pk Home">
                    <span class="text-brand-navy">empire</span>
                    <span class="text-brand-gold text-[1em] leading-none mt-4">•</span>
                    <span class="text-brand-gold">pk</span>
                </a>
            </div>

            {{-- Search (desktop) --}}
            <form action="{{ route('store.products.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-4">
                <div class="relative w-full">
                    <input type="search" name="q" placeholder="Search cases, chargers, screen protectors..."
                           class="w-full pl-4 pr-12 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500 focus:border-transparent transition">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 bg-navy-900 text-white rounded-lg hover:bg-navy-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Actions --}}
            <div class="flex items-center gap-1 sm:gap-3 ml-auto shrink-0">
                <button @click="mobileSearch = !mobileSearch" class="md:hidden p-2 text-gray-600 hover:text-navy-900" aria-label="Search">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <a href="#" class="hidden sm:flex items-center gap-1.5 p-2 text-gray-600 hover:text-navy-900 transition text-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="hidden lg:inline font-medium">Account</span>
                </a>
                <button type="button" @click="$store.cart.openDrawer()" class="relative flex items-center gap-1.5 p-2 text-gray-600 hover:text-navy-900 transition" aria-label="Open cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span class="hidden lg:inline text-sm font-medium">Cart</span>
                    <span x-show="$store.cart.count > 0"
                          x-text="$store.cart.count"
                          class="absolute -top-0.5 -right-0.5 lg:static lg:ml-0 min-w-[20px] h-5 px-1.5 bg-empire-500 text-white text-xs font-bold rounded-full flex items-center justify-center"></span>
                </button>
            </div>
        </div>

        {{-- Mobile search --}}
        <div x-show="mobileSearch" x-cloak class="md:hidden pb-3">
            <form action="{{ route('store.products.index') }}" method="GET">
                <input type="search" name="q" placeholder="Search products..."
                       class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-empire-500">
            </form>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="border-t border-gray-100 bg-gray-50/80 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4">
            <ul class="flex items-center gap-1 py-0 overflow-x-auto scrollbar-hide">
                <li>
                    <a href="{{ route('store.collections.index') }}"
                       class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-navy-900 hover:bg-white hover:text-empire-600 transition border-b-2 border-transparent hover:border-empire-500 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                        All Accessories
                    </a>
                </li>
                @foreach(array_slice($storeCatalogCategories ?? [], 0, 8) as $nav)
                <li>
                    <a href="{{ route('store.collections.show', $nav['slug']) }}"
                       class="block px-4 py-3 text-sm font-medium text-gray-600 hover:text-navy-900 hover:bg-white transition whitespace-nowrap">
                        {{ $nav['name'] }}
                    </a>
                </li>
                @endforeach
                <li>
                    <a href="{{ route('store.products.index', ['sort' => 'discount']) }}"
                       class="block px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 transition whitespace-nowrap">
                        🔥 Deals
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Mobile menu drawer --}}
    <div x-show="mobileMenu" x-cloak class="lg:hidden fixed inset-0 z-50">
        <div @click="mobileMenu = false" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute left-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <span class="font-bold text-navy-900">Menu</span>
                <button @click="mobileMenu = false" class="p-2 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-4 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-lg font-medium text-navy-900 hover:bg-gray-100">Home</a>
                <a href="{{ route('store.collections.index') }}" class="block px-3 py-2.5 rounded-lg font-medium text-navy-900 hover:bg-gray-100">Shop Collections</a>
                <a href="{{ route('store.products.index') }}" class="block px-3 py-2.5 rounded-lg font-medium text-navy-900 hover:bg-gray-100">All Products</a>
                <hr class="my-3 border-gray-200">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Categories</p>
                @foreach($storeCatalogCategories ?? [] as $nav)
                <a href="{{ route('store.collections.show', $nav['slug']) }}" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100">{{ $nav['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</header>
