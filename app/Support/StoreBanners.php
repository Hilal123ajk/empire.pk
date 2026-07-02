<?php

declare(strict_types=1);

namespace App\Support;

final class StoreBanners
{
    /**
     * @return array<int, array<string, string>>
     */
    public static function heroSlides(): array
    {
        return [
            [
                'title' => 'iPhone & Mobile Accessories',
                'subtitle' => 'Premium cases, screen protectors, chargers & MagSafe gear for every iPhone model',
                'cta' => 'Shop iPhone Gear',
                'link' => '/collections',
                'image' => asset('images/banners/iphone-accessories.jpg'),
                'color' => 'from-indigo-900/80 to-indigo-900/30',
            ],
            [
                'title' => 'Summer Accessory Sale',
                'subtitle' => 'Up to 40% off on cases, chargers, AirPods & more — limited time only',
                'cta' => 'Shop Deals',
                'link' => '/collections/all',
                'image' => asset('images/banners/summer-sale.jpg'),
                'color' => 'from-slate-900/80 to-slate-900/40',
            ],
            [
                'title' => 'Premium Furniture',
                'subtitle' => 'Stylish sofas, beds & home essentials — comfort meets modern design',
                'cta' => 'Explore Furniture',
                'link' => '/collections/all',
                'image' => asset('images/banners/furniture.jpg'),
                'color' => 'from-amber-900/75 to-amber-900/25',
            ],
            [
                'title' => 'Free Delivery on Cases & Covers',
                'subtitle' => 'Free delivery on mobile cases & covers when your order is above Rs. 2,500',
                'cta' => 'Shop Cases',
                'link' => '/collections/cases-covers',
                'image' => asset('images/banners/cases-covers.jpg'),
                'color' => 'from-navy-900/80 to-navy-900/35',
            ],
        ];
    }
}
