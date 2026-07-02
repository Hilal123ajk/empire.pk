<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Category;
use App\Models\Product;

final class SeoMeta
{
    private const DEFAULT_DESCRIPTION = 'Empire.pk - Premium mobile accessories in Pakistan. Phone cases, screen protectors, chargers, AirPods & more.';

    private const DEFAULT_KEYWORDS = 'mobile accessories, phone cases, screen protectors, Pakistan, Empire.pk';

    private const SITE_NAME = 'Empire.pk';

    /**
     * @param  array<string, mixed>|null  $jsonLd
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $keywords = null,
        public readonly ?string $canonical = null,
        public readonly string $ogType = 'website',
        public readonly ?string $ogImage = null,
        public readonly ?array $jsonLd = null,
    ) {}

    public static function defaults(?string $canonical = null): self
    {
        return new self(
            title: self::SITE_NAME.' — Premium Mobile Accessories in Pakistan',
            description: self::DEFAULT_DESCRIPTION,
            keywords: self::DEFAULT_KEYWORDS,
            canonical: $canonical ?? url('/'),
            ogType: 'website',
            ogImage: self::defaultOgImage(),
        );
    }

    public static function forProduct(Product $product): self
    {
        $description = self::truncate(strip_tags($product->description ?? ''))
            ?: 'Shop '.$product->name.' at Empire.pk with cash on delivery in Pakistan.';

        $canonical = route('store.products.show', $product->slug);
        $image = $product->image_public_url ?: self::defaultOgImage();

        return new self(
            title: $product->name.' — '.self::SITE_NAME,
            description: $description,
            keywords: $product->meta_keywords ?: self::DEFAULT_KEYWORDS,
            canonical: $canonical,
            ogType: 'product',
            ogImage: $image,
            jsonLd: self::productJsonLd($product, $description, $image, $canonical),
        );
    }

    public static function forCategory(Category $category): self
    {
        $description = self::truncate(strip_tags($category->description ?? ''))
            ?: 'Shop '.$category->title.' at Empire.pk. Premium mobile accessories delivered across Pakistan.';

        $canonical = $category->storeUrl();
        $image = $category->image_public_url ?: self::defaultOgImage();

        return new self(
            title: $category->title.' — '.self::SITE_NAME,
            description: $description,
            keywords: $category->meta_keywords ?: self::DEFAULT_KEYWORDS,
            canonical: $canonical,
            ogType: 'website',
            ogImage: $image,
        );
    }

    public static function forPage(
        string $title,
        string $description,
        ?string $canonical = null,
        ?string $keywords = null,
        ?string $ogImage = null,
    ): self {
        return new self(
            title: str_contains($title, self::SITE_NAME) ? $title : $title.' — '.self::SITE_NAME,
            description: self::truncate(strip_tags($description)),
            keywords: $keywords ?: self::DEFAULT_KEYWORDS,
            canonical: $canonical ?? url()->current(),
            ogType: 'website',
            ogImage: $ogImage ?: self::defaultOgImage(),
        );
    }

    public function pageTitle(): string
    {
        if (str_contains($this->title, 'Mobile Accessories Store') || str_contains($this->title, 'Empire.pk')) {
            return $this->title;
        }

        return $this->title.' — Mobile Accessories Store';
    }

    private static function truncate(string $text, int $limit = 160): string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($text === '') {
            return '';
        }

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $limit - 3)).'...';
    }

    private static function defaultOgImage(): ?string
    {
        return null;
    }

    /**
     * @return array<string, mixed>
     */
    private static function productJsonLd(Product $product, string $description, string $image, string $url): array
    {
        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $description,
            'image' => $image,
            'url' => $url,
            'sku' => $product->sku,
            'offers' => [
                '@type' => 'Offer',
                'url' => $url,
                'priceCurrency' => 'PKR',
                'price' => (string) $product->price,
                'availability' => $product->stock_quantity > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ],
        ];

        if ($product->brand?->title) {
            $data['brand'] = [
                '@type' => 'Brand',
                'name' => $product->brand->title,
            ];
        }

        return $data;
    }
}
