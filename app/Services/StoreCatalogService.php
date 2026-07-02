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
        $roots = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($query) => $query->where('is_active', true)->orderBy('title')])
            ->orderBy('title')
            ->get();

        return $roots
            ->map(fn (Category $category) => $this->transformRootCategory($category))
            ->values()
            ->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSubcategoriesForCategory(Category $category): array
    {
        $parent = $category->isRoot() ? $category : $category->parent;

        if ($parent === null) {
            return [];
        }

        return Category::query()
            ->where('parent_id', $parent->id)
            ->where('is_active', true)
            ->orderBy('title')
            ->get()
            ->map(fn (Category $sub) => $this->transformSubcategory($sub, $parent))
            ->values()
            ->all();
    }

    public function getProductsForStore(): array
    {
        return $this->transformProducts(
            Product::query()
                ->where('is_active', true)
                ->with(['category.parent:id,slug,title', 'category:id,slug,title,parent_id', 'brand:id,title,slug', 'images'])
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getNewArrivals(int $limit = 5): array
    {
        $products = Product::query()
            ->where('is_active', true)
            ->where('created_at', '>=', now()->subMonth())
            ->with(['category.parent:id,slug,title', 'category:id,slug,title,parent_id', 'brand:id,title,slug', 'images'])
            ->get()
            ->shuffle()
            ->take($limit);

        return $this->transformProducts($products);
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
            ->with(['category.parent:id,slug,title', 'category:id,slug,title,parent_id', 'brand:id,title,slug', 'images'])
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
     * @return array<int, array<string, mixed>>
     */
    public function getCategoriesForAdminSelect(): array
    {
        $categories = Category::query()
            ->whereNotNull('parent_id')
            ->where('is_active', true)
            ->with('parent:id,title')
            ->orderBy('title')
            ->get(['id', 'title', 'parent_id']);

        return $categories
            ->map(fn (Category $category) => [
                'id' => $category->id,
                'title' => $category->parent
                    ? $category->parent->title.' › '.$category->title
                    : $category->title,
            ])
            ->values()
            ->all();
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

        $category = $product->category;
        $rootCategorySlug = $category?->isSubcategory()
            ? ($category->parent?->slug ?? '')
            : ($category?->slug ?? '');

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'brand' => $product->brand?->title ?? '',
            'brandSlug' => $product->brand?->slug ?? '',
            'category' => $category?->slug ?? '',
            'categoryName' => $category?->title ?? '',
            'categoryUrl' => $category?->storeUrl() ?? '',
            'parentCategory' => $rootCategorySlug,
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
            'colors' => $product->has_variants
                ? $product->images
                    ->map(fn ($image) => [
                        'id' => $image->id,
                        'url' => $image->image_public_url,
                        'label' => $image->label ?: 'Color',
                    ])
                    ->values()
                    ->all()
                : [],
            'hasVariants' => $product->has_variants,
            'hasColors' => $product->has_variants && $product->images->isNotEmpty(),
            'description' => $product->description,
            'featured' => $product->is_featured,
            'inStock' => $product->stock_quantity > 0,
            'sku' => $product->sku,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformRootCategory(Category $category): array
    {
        $categoryIds = $category->descendantIds();

        $count = Product::query()
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->count();

        return [
            'slug' => $category->slug,
            'name' => $category->title,
            'image' => $category->image_public_url,
            'count' => $count,
            'description' => $category->description,
            'subcategories' => $category->children
                ->map(fn (Category $sub) => $this->transformSubcategory($sub, $category))
                ->values()
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformSubcategory(Category $subcategory, Category $parent): array
    {
        $count = Product::query()
            ->where('is_active', true)
            ->where('category_id', $subcategory->id)
            ->count();

        return [
            'slug' => $subcategory->slug,
            'name' => $subcategory->title,
            'image' => $subcategory->image_public_url,
            'count' => $count,
            'description' => $subcategory->description,
            'parentSlug' => $parent->slug,
            'url' => route('store.categories.sub.show', [
                'parentSlug' => $parent->slug,
                'slug' => $subcategory->slug,
            ]),
        ];
    }
}
