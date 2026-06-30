<?php

namespace App\Providers;

use App\Services\StoreCatalogService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view): void {
            $catalog = app(StoreCatalogService::class);

            $view->with([
                'storeCatalogCategories' => $catalog->getCategoriesForStore(),
                'storeCatalogProducts' => $catalog->getProductsForStore(),
                'storeCatalogBrands' => $catalog->getBrandsForStore(),
            ]);
        });

        View::composer('components.header', function ($view): void {
            if (! $view->offsetExists('storeCatalogCategories')) {
                $view->with(
                    'storeCatalogCategories',
                    app(StoreCatalogService::class)->getCategoriesForStore()
                );
            }
        });
    }
}
