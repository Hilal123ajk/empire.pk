@extends('layouts.app')

@section('title', $product['name'] . ' — Empire.pk')
@section('meta_description', $product['description'] ?? 'Shop ' . $product['name'] . ' at Empire.pk with cash on delivery in Pakistan.')

@section('content')
<section x-data="{
    product: @js($product),
    relatedProducts: @js($relatedProducts),
    quantity: 1,
    selectedImageKey: 'main',
    get thumbnails() {
        const items = [{ key: 'main', url: this.product.image, label: 'Main' }];

        if (this.product.hasVariants) {
            (this.product.colors || []).forEach((color) => {
                items.push({ key: String(color.id), url: color.url, label: color.label, id: color.id });
            });
        } else {
            (this.product.gallery || []).forEach((image) => {
                items.push({
                    key: String(image.id),
                    url: image.url,
                    label: image.label || 'View',
                    id: null,
                });
            });
        }

        return items;
    },
    get displayImage() {
        const thumb = this.thumbnails.find((item) => item.key === this.selectedImageKey);
        return thumb?.url || this.product.image;
    },
    get displayCaption() {
        if (this.selectedImageKey === 'main') {
            return null;
        }

        const thumb = this.thumbnails.find((item) => item.key === this.selectedImageKey);
        return thumb?.label && thumb.label !== 'View' ? thumb.label : null;
    },
    get selectedColor() {
        if (!this.product.hasVariants || this.selectedImageKey === 'main') {
            return null;
        }

        return (this.product.colors || []).find((color) => String(color.id) === this.selectedImageKey) ?? null;
    },
    get selectedVariant() {
        if (!this.product.hasVariants) {
            return { id: null, url: this.product.image, label: 'Main' };
        }

        if (this.selectedColor) {
            return this.selectedColor;
        }

        return { id: null, url: this.product.image, label: 'Main' };
    },
    selectThumbnail(key) {
        this.selectedImageKey = key;
    },
    addToCart(openDrawer = true) {
        this.$store.cart.add(this.product, this.quantity, openDrawer, this.selectedVariant);
    }
}">
    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="text-xs text-gray-400 flex items-center gap-2 flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-empire-600">Home</a>
                <span>/</span>
                @if ($product['category'])
                <a href="{{ route('store.collections.show', $product['category']) }}" class="hover:text-empire-600">{{ $product['categoryName'] }}</a>
                <span>/</span>
                @endif
                <span class="text-gray-600 line-clamp-1">{{ $product['name'] }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-5 lg:py-6">
        <div class="grid md:grid-cols-2 gap-6 md:gap-8 lg:gap-10 md:items-start">
            {{-- Images --}}
            <div class="w-full">
                <div class="aspect-square w-full rounded-2xl overflow-hidden bg-gray-50 border border-gray-200 mb-3 flex items-center justify-center">
                    <img :src="displayImage" :alt="product.name" class="w-full h-full object-contain">
                </div>
                <p class="text-xs text-gray-500 mb-2 min-h-[1rem]" x-show="!product.hasVariants && displayCaption" x-text="displayCaption"></p>
                <div class="flex gap-2 flex-wrap" x-show="thumbnails.length > 1">
                    <template x-for="thumb in thumbnails" :key="thumb.key">
                        <button type="button"
                                @click="selectThumbnail(thumb.key)"
                                :title="thumb.label"
                                :class="selectedImageKey === thumb.key ? 'ring-2 ring-empire-500' : 'ring-1 ring-gray-200'"
                                class="w-[4.25rem] h-[4.25rem] md:w-20 md:h-20 rounded-xl overflow-hidden shrink-0 transition bg-gray-50 flex items-center justify-center">
                            <img :src="thumb.url" :alt="thumb.label" class="max-w-full max-h-full w-full h-full object-contain">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Details --}}
            <div>
                <p class="text-xs md:text-sm text-gray-500 uppercase tracking-wide" x-text="product.brand || 'Empire.pk'"></p>
                <h1 class="text-xl md:text-2xl font-extrabold text-navy-900 mt-1 leading-snug" x-text="product.name"></h1>

                <div class="mt-3 md:mt-2 flex items-baseline gap-3">
                    <span class="text-2xl md:text-3xl font-extrabold text-navy-900" x-text="EMPIRE_STORE.formatPrice(product.price)"></span>
                </div>

                <p class="mt-2 text-xs md:text-sm font-medium flex items-center gap-1"
                   :class="product.inStock ? 'text-emerald-600' : 'text-red-600'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span x-text="product.inStock ? 'In Stock — Ready to Ship' : 'Out of Stock'"></span>
                </p>

                <div class="mt-3 md:mt-2" x-show="product.hasVariants && product.hasColors">
                    <p class="text-xs md:text-sm font-semibold text-navy-900">
                        Color:
                        <span class="font-normal text-gray-600" x-text="selectedVariant.label"></span>
                    </p>
                </div>

                <p class="mt-3 md:mt-2 text-xs md:text-sm text-gray-600 leading-relaxed line-clamp-3 md:line-clamp-4" x-text="product.description || 'Premium quality mobile accessory from Empire.pk. Genuine product with warranty. Free delivery on cases & covers above Rs. 2,500.'"></p>

                {{-- Quantity & Add to cart --}}
                <div class="mt-4 md:mt-3 flex flex-col sm:flex-row gap-2.5">
                    <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden w-fit text-sm">
                        <button @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 md:py-2.5 hover:bg-gray-100 transition font-medium">−</button>
                        <span class="px-3 py-2 md:py-2.5 font-semibold min-w-[2.5rem] text-center" x-text="quantity"></span>
                        <button @click="quantity++" class="px-3 py-2 md:py-2.5 hover:bg-gray-100 transition font-medium">+</button>
                    </div>
                    <button @click="addToCart()" :disabled="!product.inStock"
                            class="flex-1 py-2.5 md:py-3 bg-navy-900 hover:bg-navy-800 disabled:bg-gray-300 text-white text-sm font-bold rounded-xl transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Cart
                    </button>
                </div>

                <button @click="addToCart(false); window.location.href = '{{ route('store.checkout') }}'"
                        :disabled="!product.inStock"
                        class="mt-2.5 w-full py-2.5 md:py-3 text-sm border-2 border-navy-900 text-navy-900 font-bold rounded-xl hover:bg-navy-900 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    Buy Now
                </button>

                {{-- Trust info --}}
                <div class="mt-4 md:mt-5 grid grid-cols-2 gap-2 md:gap-2.5">
                    @foreach([
                        ['title' => 'Free Delivery', 'sub' => 'Cases & covers above Rs. 2,500'],
                        ['title' => 'Cash on Delivery', 'sub' => 'Pay when you receive'],
                        ['title' => '7-Day Returns', 'sub' => 'Easy exchange policy'],
                        ['title' => '100% Genuine', 'sub' => 'Authentic products only'],
                    ] as $info)
                    <div class="p-2.5 md:p-3 bg-gray-50 rounded-xl border border-gray-100">
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
