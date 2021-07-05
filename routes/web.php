<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Admin\CategoriesCrudController;
use App\Http\Controllers\Admin\GroupsCrudController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/category', [CategoriesController::class, 'index']);

Route::get('/product', [ProductsController::class, 'index']);

Route::post('/upload-categories', [FileUploadController::class, 'categoryXmlPostUpload'])->name('xml-category-upload');
Route::post('/import-categories', [CategoriesCrudController::class, 'categoryXmlImport'])->name('xml-category-import');
Route::post('/delete-categories', [CategoriesCrudController::class, 'deleteAllCategories'])->name('delete-all-categories');

Route::post('/get-group-type', [GroupsCrudController::class, 'getGroupType'])->name('get-type');
