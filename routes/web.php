<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MainController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['auth:sanctum', 'verified'])->get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/category/{category?}', [CategoriesController::class, 'index'])->name('category');
Route::get('/filter/{params?}', [FilterController::class, 'query'])->where('params', '(.*)')->name('filter');
Route::post('/filter-ajax', [FilterController::class, 'ajaxQuery'])->name('filter-ajax');
Route::get('/away/{slug?}', [ProductsController::class, 'away'])->name('away');
Route::get('/product/{slug?}', [ProductsController::class, 'index'])->name('product');
Route::post('/product-info', [ProductsController::class, 'getInfo'])->name('product-info');


Route::prefix('sitemap')->name('sitemap.')->group(function () {
    Route::get('/', [SitemapController::class, 'index'])->name('index');
    Route::get('/categories', [SitemapController::class, 'categories'])->name('categories');
    Route::get('/products/{count?}', [SitemapController::class, 'products'])->name('products');
});