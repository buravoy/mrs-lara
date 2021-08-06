<?php

namespace App\Providers;

use App\Http\Controllers\CategoriesController;
use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
