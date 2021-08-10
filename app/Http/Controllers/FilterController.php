<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use App\Modules\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FilterController extends Controller
{
    public function index($category = null, $params = null)
    {
        if(!$params || !$category) abort(404);


        return view('category', [
            'products' => '',
            'category' => '',
            'description' => '',
            'filters' => ''
        ]);
    }
}
