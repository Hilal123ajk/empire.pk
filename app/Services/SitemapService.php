<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapService
{
    private const CACHE_KEY = 'sitemap.xml';

    private const CACHE_TTL_SECONDS = 3600;

    public function generate(): Sitemap
    {
        $sitemap = Sitemap::create();

        $sitemap->add(
            Url::create(route('store.home'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        $sitemap->add(
            Url::create(route('store.collections.index'))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        $sitemap->add(
            Url::create(route('store.products.index'))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        Category::query()
            ->where('is_active', true)
            ->select(['id', 'title', 'slug', 'image_url', 'updated_at'])
            ->orderBy('title')
            ->each(function (Category $category) use ($sitemap): void {
                $url = Url::create(route('store.collections.show', $category->slug))
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($category->updated_at);

                if ($imageUrl = $category->image_public_url) {
                    $url->addImage($imageUrl, $category->title);
                }

                $sitemap->add($url);
            });

        Product::query()
            ->where('is_active', true)
            ->with(['images:id,product_id,image_url,label,sort_order'])
            ->select(['id', 'name', 'slug', 'image_url', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->each(function (Product $product) use ($sitemap): void {
                $url = Url::create(route('store.products.show', $product->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($product->updated_at);

                if ($imageUrl = $product->image_public_url) {
                    $url->addImage($imageUrl, $product->name);
                }

                foreach ($product->images as $image) {
                    if ($galleryUrl = $image->image_public_url) {
                        $url->addImage($galleryUrl, $image->label ?: $product->name);
                    }
                }

                $sitemap->add($url);
            });

        return $sitemap;
    }

    public function render(): string
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function (): string {
            return $this->generate()->render();
        });
    }

    public function writeToPublic(): string
    {
        $path = public_path('sitemap.xml');
        $this->generate()->writeToFile($path);

        Cache::put(self::CACHE_KEY, (string) file_get_contents($path), self::CACHE_TTL_SECONDS);

        return $path;
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
