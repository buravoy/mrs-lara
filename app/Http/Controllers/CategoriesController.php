<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;

class CategoriesController extends Controller
{
    public function index($slug = null)
    {
        $catIdWithChild = Categories::where('slug', $slug)->with('allChild')->get('id');
        $idMultiArray = self::collectId($catIdWithChild);
        $idArray = [];
        array_walk_recursive($idMultiArray, function ($item) use (&$idArray) { $idArray[] = $item; });
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->get('product_id');


        $products = Products::whereIn('id', $productsId)->get();
        return view('category', ['products' => $products]);
    }

    static function collectId($collection){
        $arr = [];
        foreach ($collection as $item) {
            if(isset($item->id)) $arr[] = $item->id;
            if(!empty($item->allChild)) $arr[] = self::collectId($item->allChild);
        }
        return $arr;
    }

    static function countProducts($catId)
    {
        $catIdWithChild = Categories::where('id', $catId)->with('allChild')->get('id');
        $idMultiArray = self::collectId($catIdWithChild);
        $idArray = [];
        array_walk_recursive($idMultiArray, function ($item) use (&$idArray) { $idArray[] = $item; });

        return CategoryProduct::whereIn('category_id', $idArray)->count();
    }
}
