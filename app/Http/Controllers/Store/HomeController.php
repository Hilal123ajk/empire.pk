<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\StoreCatalogService;
use App\Support\SeoMeta;
use App\Support\StoreBanners;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly StoreCatalogService $catalog,
    ) {}

    public function index(): View
    {
        $featuredProducts = $this->catalog->getShuffledProductsPaginated(12);

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $this->catalog->getNewArrivals(5),
            'heroBanners' => StoreBanners::heroSlides(),
            'seo' => SeoMeta::defaults(route('store.home')),
        ]);
    }

    public function categories(): View
    {
        return view('categories.index', [
            'seo' => SeoMeta::forPage(
                title: 'Shop by Category',
                description: 'Browse all categories at Empire.pk. Mobile accessories and more with cash on delivery in Pakistan.',
                canonical: route('store.categories.index'),
                keywords: 'categories, mobile accessories, shop, Empire.pk',
            ),
        ]);
    }
}
