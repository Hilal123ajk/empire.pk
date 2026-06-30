@extends('layouts.app')

@section('title', $product['name'] . ' — Empire.pk')
@section('meta_description', $product['description'] ?? 'Shop ' . $product['name'] . ' at Empire.pk with cash on delivery in Pakistan.')

@section('content')
<section x-data="{
    product: @js($product),
    relatedProducts: @js($relatedProducts),
    quantity: 1,
    selectedImage: 0,
    get images() {
        if (!this.product?.images?.length) {
            return this.product?.image ? [this.product.image] : [];
        }
        return this.product.images;
    }
}">
    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="text-xs text-gray-400 flex items-center gap-2 flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-empire-600">Home</a>
                <span>/</span>
                @if ($product['category'])
                <a href="{{ url('/categories/' . $product['category']) }}" class="hover:text-empire-600">{{ $product['categoryName'] }}</a>
                <span>/</span>
                @endif
                <span class="text-gray-600 line-clamp-1">{{ $product['name'] }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6 md:py-10">
        <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
            {{-- Images --}}
            <div>
                <div class="aspect-square rounded-2xl overflow-hidden bg-white border border-gray-200 mb-3">
                    <img :src="images[selectedImage]" :alt="product.name" class="w-full h-full object-cover">
                </div>
                <div class="flex gap-2 flex-wrap" x-show="images.length > 1">
                    <template x-for="(img, idx) in images" :key="idx">
                        <button @click="selectedImage = idx"
                                :class="selectedImage === idx ? 'ring-2 ring-empire-500' : 'ring-1 ring-gray-200'"
                                class="w-16 h-16 md:w-20 md:h-20 rounded-xl overflow-hidden shrink-0">
                            <img :src="img" :alt="product.gallery?.[idx - 1]?.label || product.name" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Details --}}
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wide" x-text="product.brand || 'Empire.pk'"></p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-navy-900 mt-1 leading-tight" x-text="product.name"></h1>

                <div class="mt-5 flex items-baseline gap-3">
                    <span class="text-3xl md:text-4xl font-extrabold text-navy-900" x-text="EMPIRE_STORE.formatPrice(product.price)"></span>
                </div>

                <p class="mt-2 text-sm font-medium flex items-center gap-1"
                   :class="product.inStock ? 'text-emerald-600' : 'text-red-600'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span x-text="product.inStock ? 'In Stock — Ready to Ship' : 'Out of Stock'"></span>
                </p>

                <p class="mt-4 text-sm text-gray-600 leading-relaxed" x-text="product.description || 'Premium quality mobile accessory from Empire.pk. Genuine product with warranty. Free delivery on orders above Rs. 2,500 in major cities.'"></p>

                {{-- Quantity & Add to cart --}}
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden w-fit">
                        <button @click="quantity = Math.max(1, quantity - 1)" class="px-4 py-3 hover:bg-gray-100 transition text-lg font-medium">−</button>
                        <span class="px-4 py-3 font-semibold min-w-[3rem] text-center" x-text="quantity"></span>
                        <button @click="quantity++" class="px-4 py-3 hover:bg-gray-100 transition text-lg font-medium">+</button>
                    </div>
                    <button @click="$store.cart.add(product, quantity)" :disabled="!product.inStock"
                            class="flex-1 py-3.5 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-300 text-white font-bold rounded-xl transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Cart
                    </button>
                </div>

                <button @click="$store.cart.add(product, quantity, false); window.location.href = '{{ url('/checkout') }}'"
                        :disabled="!product.inStock"
                        class="mt-3 w-full py-3 border-2 border-navy-900 text-navy-900 font-bold rounded-xl hover:bg-navy-900 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    Buy Now
                </button>

                {{-- Trust info --}}
                <div class="mt-8 grid grid-cols-2 gap-3">
                    @foreach([
                        ['title' => 'Free Delivery', 'sub' => 'Orders above Rs. 2,500'],
                        ['title' => 'Cash on Delivery', 'sub' => 'Pay when you receive'],
                        ['title' => '7-Day Returns', 'sub' => 'Easy exchange policy'],
                        ['title' => '100% Genuine', 'sub' => 'Authentic products only'],
                    ] as $info)
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs font-semibold text-navy-900">{{ $info['title'] }}</p>
                        <p class="text-[10px] text-gray-500">{{ $info['sub'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Related products --}}
        <div class="mt-14 border-t border-gray-200 pt-10" x-show="relatedProducts.length">
            <h2 class="text-xl md:text-2xl font-extrabold text-navy-900 mb-6">You May Also Like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
                <template x-for="related in relatedProducts" :key="related.id">
                    <a :href="'/products/' + related.slug" class="bg-white rounded-2xl border border-gray-200 overflow-hidden group hover:shadow-md transition">
                        <div class="aspect-square overflow-hidden bg-gray-50">
                            <img :src="related.image" :alt="related.name" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-semibold text-navy-900 line-clamp-2" x-text="related.name"></p>
                            <p class="text-sm font-bold text-empire-600 mt-1" x-text="EMPIRE_STORE.formatPrice(related.price)"></p>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </div>
</section>
@endsection
