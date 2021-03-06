<?php

use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\CategoriesCrudController;
use App\Http\Controllers\Admin\GroupsCrudController;
use App\Http\Controllers\Admin\ProductsCrudController;
use App\Modules\Parser;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.
Route::get('admin/products/restore/{id}', [ProductsCrudController::class, 'restore']);
Route::get('admin/products/disable/{id}', [ProductsCrudController::class, 'disable']);
Route::get('admin/products/delete/{id}', [ProductsCrudController::class, 'delete']);

Route::get('admin/category/restore/{id}', [CategoriesCrudController::class, 'restore']);
Route::get('admin/category/disable/{id}', [CategoriesCrudController::class, 'disable']);
Route::get('admin/category/delete/{id}', [CategoriesCrudController::class, 'delete']);

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('products', 'ProductsCrudController');
    Route::crud('category', 'CategoriesCrudController');
    Route::crud('attributes', 'AttributesCrudController');
    Route::crud('groups', 'GroupsCrudController');
    Route::crud('feeds', 'FeedsCrudController');
    Route::crud('feeds', 'FeedsCrudController');

    Route::post('admin/upload-categories', [FileUploadController::class, 'categoryXmlPostUpload'])->name('xml-category-upload');
    Route::post('admin/import-categories', [CategoriesCrudController::class, 'categoryXmlImport'])->name('xml-category-import');
    Route::post('admin/delete-categories', [CategoriesCrudController::class, 'deleteAllCategories'])->name('delete-all-categories');

    Route::post('admin/get-group-type', [GroupsCrudController::class, 'getGroupType'])->name('get-type');

    Route::post('admin/download-feed', [FileUploadController::class, 'downloadXml'])->name('download-feed');
    Route::post('admin/get-size', [FileUploadController::class, 'getSize'])->name('get-size');


    Route::post('admin/handle-offers', [Parser::class, 'handleOffers'])->name('handle-offers');
    Route::post('admin/parse-xml', [Parser::class, 'parseXml'])->name('parse-xml');
    Route::post('admin/save-function', [Parser::class, 'saveFunction'])->name('save-function');
    Route::post('admin/delete-all-goods', [Parser::class, 'deleteAllGoods'])->name('delete-all-goods');
}); // this should be the absolute last line of this file