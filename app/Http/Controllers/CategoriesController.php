<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index($slug = null)
    {
        $catId = Categories::where('slug', $slug)->first()->id;



        $productsId = CategoryProduct::where('category_id', $catId)->select('product_id')->get()->pluck('product_id');


        $products = Products::whereIn('id', $productsId)->get();

        return view('category', ['products' => $products]);
    }
}
