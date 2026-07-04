<footer class="bg-navy-900 text-gray-300 mt-16">
    {{-- Newsletter --}}
    <div class="border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold text-white mb-1">Subscribe to our Newsletter</h3>
                    <p class="text-sm text-gray-400">Get the latest deals on mobile accessories</p>
                </div>
                <form x-data="newsletterForm()" @submit.prevent="subscribe" class="flex w-full md:w-auto gap-2">
                    <input type="email" x-model="email" placeholder="Your email address" required
                           :disabled="loading"
                           class="flex-1 md:w-72 px-4 py-3 bg-navy-800 border border-gray-700 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-empire-500 disabled:opacity-60">
                    <button type="submit" :disabled="loading"
                            class="px-6 py-3 bg-empire-500 hover:bg-empire-600 text-navy-900 font-semibold rounded-xl text-sm transition whitespace-nowrap disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-text="loading ? 'Please wait…' : 'Subscribe'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main footer --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-empire-500 rounded-lg flex items-center justify-center">
                        <span class="text-navy-900 font-extrabold">E</span>
                    </div>
                    <span class="text-lg font-bold text-white">Empire.pk</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">Pakistan's trusted destination for premium mobile accessories — cases, protectors, chargers, and more.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 bg-navy-800 rounded-lg flex items-center justify-center hover:bg-empire-500 hover:text-navy-900 transition" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 bg-navy-800 rounded-lg flex items-center justify-center hover:bg-empire-500 hover:text-navy-900 transition" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849C2.945 3.99 4.456 2.458 7.68 2.163 8.945 2.105 9.325 2.093 12 2.093zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('store.categories.index') }}" class="hover:text-empire-400 transition">Shop Categories</a></li>
                    <li><a href="{{ route('store.products.index') }}" class="hover:text-empire-400 transition">All Products</a></li>
                    <li><a href="{{ route('store.products.index', ['sort' => 'discount']) }}" class="hover:text-empire-400 transition">Deals & Offers</a></li>
                    <li><a href="{{ route('store.pages.about') }}" class="hover:text-empire-400 transition">About Us</a></li>
                    <li><a href="{{ route('store.pages.contact') }}" class="hover:text-empire-400 transition">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('store.pages.shipping') }}" class="hover:text-empire-400 transition">Shipping Policy</a></li>
                    <li><a href="{{ route('store.pages.returns') }}" class="hover:text-empire-400 transition">Returns & Exchange</a></li>
                    <li><a href="{{ route('store.pages.shipping') }}" class="hover:text-empire-400 transition">Cash on Delivery</a></li>
                    <li><a href="{{ route('store.pages.faqs') }}" class="hover:text-empire-400 transition">FAQs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-empire-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div>
                            <a href="tel:+923233790913" class="text-white font-medium hover:text-empire-400 transition">+92 323 3790913</a>
                            <p class="text-gray-500 text-xs">Call or SMS</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-empire-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <div>
                            <a href="https://wa.me/923233790913" target="_blank" rel="noopener noreferrer" class="text-white font-medium hover:text-empire-400 transition">+92 323 3790913</a>
                            <p class="text-gray-500 text-xs">WhatsApp</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-empire-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:contact.empire.pk@gmail.com" class="hover:text-empire-400 transition break-all">contact.empire.pk@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Empire.pk — All Rights Reserved</p>
            <div class="flex items-center gap-4">
                <span>Cash on Delivery</span>
                <span>•</span>
                <span>Secure Shopping</span>
                <span>•</span>
                <span>Easy Returns</span>
            </div>
        </div>
    </div>
</footer>
