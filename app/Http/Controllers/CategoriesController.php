<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use App\Modules\Functions;
use App\Modules\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    public function index($category = null)
    {
        if(!$category) abort(404);

        $productsData = Functions::productsData($category);
        $productsQuery = $productsData['query'];

        return view('category', [
            'products' => $productsQuery->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::categoryDescription($productsData['category']),
            'filters' => Functions::collectFilters($productsData['productsId'])
        ]);
    }

    public function RequestCountProductsInCategory(Request $request)
    {
        return self::countProductsInCategory($request->slug);
    }

    public static function countProductsInCategory($catSlug)
    {
        $productsData = Functions::productsData($catSlug);
        $productsQuery = $productsData['query'];
        $productsCount = $productsQuery->count();
        Categories::where('slug', $catSlug)->update([ 'count' => $productsCount ]);

        return $productsCount;
    }

    public static function countAllProductsInCategories()
    {
        $categories = Categories::all()->pluck('slug');
        foreach ($categories as $category) {
            self::countProductsInCategory($category);
        }

        return true;
    }
}
