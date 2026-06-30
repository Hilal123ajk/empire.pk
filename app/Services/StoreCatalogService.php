<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

class StoreCatalogService
{
    public function getCategoriesForStore(): array
    {
        return Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('title')
            ->get()
            ->map(fn (Category $category) => [
                'slug' => $category->slug,
                'name' => $category->title,
                'image' => $category->image_public_url,
                'count' => $category->products_count,
                'description' => $category->description,
            ])
            ->values()
            ->all();
    }

    public function getProductsForStore(): array
    {
        return $this->transformProducts(
            Product::query()
                ->where('is_active', true)
                ->with(['category:id,slug,title', 'brand:id,title,slug', 'images'])
                ->orderByDesc('is_featured')
                ->orderByDesc('created_at')
                ->get()
        );
    }

    public function getBrandsForStore(): array
    {
        return Brand::query()
            ->where('is_active', true)
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->orderBy('title')
            ->pluck('title')
            ->all();
    }

    public function getShuffledProductsPaginated(int $perPage = 12): LengthAwarePaginator
    {
        $page = max(1, (int) request()->query('page', 1));

        if ($page === 1) {
            $ids = Product::query()
                ->where('is_active', true)
                ->pluck('id')
                ->shuffle()
                ->values()
                ->all();

            session(['home_product_ids' => $ids]);
        } else {
            $ids = session('home_product_ids', []);

            if ($ids === []) {
                $ids = Product::query()
                    ->where('is_active', true)
                    ->pluck('id')
                    ->shuffle()
                    ->values()
                    ->all();

                session(['home_product_ids' => $ids]);
            }
        }

        $total = count($ids);
        $pageIds = array_slice($ids, ($page - 1) * $perPage, $perPage);

        if ($pageIds === []) {
            return new Paginator([], $total, $perPage, $page, [
                'path' => url('/'),
                'pageName' => 'page',
            ]);
        }

        $order = array_flip($pageIds);

        $products = Product::query()
            ->whereIn('id', $pageIds)
            ->with(['category:id,slug,title', 'brand:id,title,slug', 'images'])
            ->get()
            ->sortBy(fn (Product $product) => $order[$product->id] ?? 0)
            ->values();

        return new Paginator(
            $this->transformProducts($products),
            $total,
            $perPage,
            $page,
            [
                'path' => url('/'),
                'pageName' => 'page',
            ]
        );
    }

    /**
     * @param  Collection<int, Product>  $products
     * @return array<int, array<string, mixed>>
     */
    public function transformProducts(Collection $products): array
    {
        return $products
            ->map(fn (Product $product) => $this->transformProduct($product))
            ->values()
            ->all();
    }

    public function transformProduct(Product $product): array
    {
        $galleryUrls = $product->images
            ->map(fn ($image) => $image->image_public_url)
            ->filter()
            ->values()
            ->all();

        $images = array_values(array_unique(array_filter([
            $product->image_public_url,
            ...$galleryUrls,
        ])));

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'brand' => $product->brand?->title ?? '',
            'brandSlug' => $product->brand?->slug ?? '',
            'category' => $product->category?->slug ?? '',
            'categoryName' => $product->category?->title ?? '',
            'price' => (float) $product->price,
            'originalPrice' => (float) $product->price,
            'discount' => 0,
            'rating' => 0,
            'reviews' => 0,
            'image' => $product->image_public_url,
            'images' => $images,
            'gallery' => $product->images
                ->map(fn ($image) => [
                    'id' => $image->id,
                    'url' => $image->image_public_url,
                    'label' => $image->label,
                ])
                ->values()
                ->all(),
            'colors' => $product->images
                ->map(fn ($image) => [
                    'id' => $image->id,
                    'url' => $image->image_public_url,
                    'label' => $image->label ?: 'Color',
                ])
                ->values()
                ->all(),
            'hasColors' => $product->images->isNotEmpty(),
            'description' => $product->description,
            'featured' => $product->is_featured,
            'inStock' => $product->stock_quantity > 0,
            'sku' => $product->sku,
        ];
    }
}
