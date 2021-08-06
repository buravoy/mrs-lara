<?php

namespace App\Http\ViewComposers;

use App\Http\Controllers\CategoriesController;
use App\Models\CategoryProduct;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Models\Categories;

class CategoriesComposer
{
    public function compose(View $view)
    {
        return $view->with('categories',
            Categories::where('show', true)
                ->orderBy('sort', 'asc')
                ->get()
        );
    }
}