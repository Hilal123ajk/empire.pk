<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Store\CategoryController as StoreCategoryController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ProductController as StoreProductController;
use App\Http\Controllers\Store\SitemapController;
use App\Support\SeoMeta;
use Illuminate\Support\Facades\Route;

Route::name('store.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/collections/all', [StoreProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [StoreProductController::class, 'show'])->name('products.show');

    Route::get('/collections', [HomeController::class, 'phoneAccessories'])->name('collections.index');
    Route::get('/collections/{slug}', [StoreCategoryController::class, 'show'])->name('collections.show');

    Route::get('/checkout', fn () => view('checkout', [
        'seo' => SeoMeta::forPage(
            title: 'Checkout',
            description: 'Complete your order at Empire.pk. Cash on delivery available across Pakistan.',
            canonical: route('store.checkout'),
            keywords: 'checkout, order, cash on delivery, Empire.pk',
        ),
    ]))->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('throttle:10,1')->name('checkout.store');
    Route::redirect('/cart', '/checkout')->name('cart');

    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
    Route::get('/sitemap/generate', [SitemapController::class, 'generate'])
        ->middleware('throttle:6,1')
        ->name('sitemap.generate');
});

Route::redirect('/phone-accessories', '/collections', 301);
Route::redirect('/products', '/collections/all', 301);
Route::get('/categories/{slug}', fn (string $slug) => redirect("/collections/{$slug}", 301));

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{productId}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
        Route::delete('/products/{productId}/force', [AdminProductController::class, 'forceDestroy'])->name('products.force-destroy');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{categoryId}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('/categories/{categoryId}/force', [CategoryController::class, 'forceDestroy'])->name('categories.force-destroy');

        Route::get('/brands', [BrandController::class, 'index'])->name('brands');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/customers', fn () => view('admin.customers.index'))->name('customers');
    });
});
