<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoriesComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('sections.categories', CategoriesComposer::class);
    }
}
