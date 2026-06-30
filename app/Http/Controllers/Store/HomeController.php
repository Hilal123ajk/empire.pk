<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\StoreCatalogService;
use App\Support\SeoMeta;
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
            'seo' => SeoMeta::defaults(route('store.home')),
        ]);
    }

    public function phoneAccessories(): View
    {
        return view('phone-accessories', [
            'seo' => SeoMeta::forPage(
                title: 'Phone Accessories',
                description: 'Shop phone accessories at Empire.pk. Cases, screen protectors, chargers, AirPods, iPad & MacBook accessories with free delivery in Pakistan.',
                canonical: route('store.collections.index'),
                keywords: 'phone accessories, mobile cases, screen protectors, Pakistan',
            ),
        ]);
    }
}
