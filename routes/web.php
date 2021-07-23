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

Route::get('category', [CategoriesController::class, 'index'])->name('category');
Route::get('product', [ProductsController::class, 'index']);
