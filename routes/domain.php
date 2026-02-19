<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/domain/{username}'], function () {

    Route::get('/', [SiteController::class, 'index'])->name('domain.index');
    Route::get('/products', [SiteController::class, 'products'])->name('domain.products');
    Route::get('/page/{slug}', [SiteController::class, 'page'])->name('domain.page');
    Route::get('/product/{slug}', [SiteController::class, 'product'])->name('domain.product');
    Route::get('/category/{slug}', [SiteController::class, 'category'])->name('domain.category');
    Route::get('/search', [SiteController::class, 'search'])->name('domain.search');
    Route::post('/contact', [SiteController::class, 'contact'])->name('domain.contact');
});
