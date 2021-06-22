<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Admin\CategoryCrudController;

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

Route::get('/category', [CategoryController::class, 'index']);

Route::get('/product', [ProductController::class, 'index']);

Route::post('/upload-categories', [FileUploadController::class, 'categoryXmlPostUpload'])->name('xml-category-upload');
Route::post('/import-categories', [CategoryCrudController::class, 'categoryXmlImport'])->name('xml-category-import');
Route::post('/delete-categories', [CategoryCrudController::class, 'deleteAllCategories'])->name('delete-all-categories');
