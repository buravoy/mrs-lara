<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FilterController;


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

Route::get('/', [MainController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/favorites', function () {
    return view('favorites');
})->name('favorites');


//Route::name('category')->namespace('category')->prefix('category')->group(function () {
//    Route::get('/', [CategoriesController::class, 'index'])->name('index');
//    Route::get('{reviewSlug}', [Front\NewsResearch\ReviewController::class, 'show'])->name('show');
//});

Route::get('/category/{category?}/{discount?}', [CategoriesController::class, 'index'])->name('category');

Route::get('/filter/{category?}/{params?}', [FilterController::class, 'index'])->name('filter');



Route::get('/away/{slug?}', [ProductsController::class, 'away'])->name('away');
Route::get('/product/{slug?}', [ProductsController::class, 'index'])->name('product');
Route::post('/product-info', [ProductsController::class, 'getInfo'])->name('product-info');
