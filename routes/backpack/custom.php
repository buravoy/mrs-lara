<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Admin\CategoriesCrudController;
use App\Http\Controllers\Admin\GroupsCrudController;
use App\Modules\Parser;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

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

    Route::post('upload-categories', [FileUploadController::class, 'categoryXmlPostUpload'])->name('xml-category-upload');
    Route::post('import-categories', [CategoriesCrudController::class, 'categoryXmlImport'])->name('xml-category-import');
    Route::post('delete-categories', [CategoriesCrudController::class, 'deleteAllCategories'])->name('delete-all-categories');

    Route::post('get-group-type', [GroupsCrudController::class, 'getGroupType'])->name('get-type');

    Route::post('download-feed', [FileUploadController::class, 'downloadXml'])->name('download-feed');
    Route::post('get-size', [FileUploadController::class, 'getSize'])->name('get-size');

    Route::post('handle-offers', [Parser::class, 'handleOffers'])->name('handle-offers');

}); // this should be the absolute last line of this file
