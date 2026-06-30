<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\StoreCatalogService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly StoreCatalogService $catalog,
    ) {}

    public function index(): View
    {
        return view('products.index');
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['category:id,slug,title', 'brand:id,title,slug', 'images'])
            ->firstOrFail();

        $relatedProducts = $this->catalog->transformProducts(
            Product::query()
                ->where('is_active', true)
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->with(['category:id,slug,title', 'brand:id,title,slug', 'images'])
                ->limit(4)
                ->get()
        );

        return view('products.show', [
            'product' => $this->catalog->transformProduct($product),
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
