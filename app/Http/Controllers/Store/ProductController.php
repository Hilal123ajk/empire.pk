<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\StoreCatalogService;
use App\Support\SeoMeta;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly StoreCatalogService $catalog,
    ) {}

    public function index(): View
    {
        return view('products.index', [
            'seo' => SeoMeta::forPage(
                title: 'All Products',
                description: 'Browse all mobile accessories at Empire.pk. Phone cases, screen protectors, chargers, AirPods and more with cash on delivery in Pakistan.',
                canonical: route('store.products.index'),
                keywords: 'all products, mobile accessories, phone cases, Empire.pk',
            ),
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['category.parent:id,slug,title', 'category:id,slug,title,parent_id', 'brand:id,title,slug', 'images'])
            ->firstOrFail();

        $relatedProducts = $this->catalog->transformProducts(
            Product::query()
                ->where('is_active', true)
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->with(['category.parent:id,slug,title', 'category:id,slug,title,parent_id', 'brand:id,title,slug', 'images'])
                ->limit(4)
                ->get()
        );

        return view('products.show', [
            'product' => $this->catalog->transformProduct($product),
            'relatedProducts' => $relatedProducts,
            'seo' => SeoMeta::forProduct($product),
        ]);
    }
}
