<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\StoreCatalogService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly StoreCatalogService $catalog,
    ) {}

    public function index(): View
    {
        $featuredProducts = $this->catalog->getShuffledProductsPaginated(12);

        return view('home', compact('featuredProducts'));
    }

    public function phoneAccessories(): View
    {
        return view('phone-accessories');
    }
}
