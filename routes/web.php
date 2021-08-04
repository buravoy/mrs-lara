<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;


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

Route::get('category/{slug?}', [CategoriesController::class, 'index'])->name('category');



Route::get('product', [ProductsController::class, 'index']);
