<?php

namespace App\Http\Controllers\Admin;


use App\Models\Categories;
use App\Models\Products;

class DashboardController
{
    public function index()
    {
        $productsCount = Products::count();
        $categoriesCount = Categories::count();


        return view('vendor.backpack.base.dashboard', [
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
        ]);
    }
}

