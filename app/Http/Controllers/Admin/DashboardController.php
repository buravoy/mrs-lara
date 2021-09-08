<?php

namespace App\Http\Controllers\Admin;


use App\Models\Categories;
use App\Models\Products;

class DashboardController
{
    public function index()
    {
        $productsCount = Products::withTrashed()->count();
        $productsActive = Products::count();
        $productsTrashed = Products::withTrashed()->where('deleted_at', '<>', null)->count();
        $categoriesCount = Categories::count();

        return view('vendor.backpack.base.dashboard', [
            'productsCount' => [
                'all' => $productsCount,
                'active' => $productsActive,
                'trashed' => $productsTrashed
            ],
            'categoriesCount' => $categoriesCount,
        ]);
    }
}

