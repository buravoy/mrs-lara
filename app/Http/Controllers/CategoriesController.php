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
            'filters' => FilterController::availableFilters($productsData['productsId'])
        ]);
    }

    public static function countProductsInCategory($catId)
    {
        $categoriesWithChild = Categories::where('id', $catId)->with('allChild')->get();
        $idArray = Arr::flatten(Functions::collectId($categoriesWithChild));
        $productsCount = CategoryProduct::whereIn('category_id', $idArray)->count();
        Categories::where('id', $catId)->update([ 'count' => $productsCount ]);

        return $productsCount;
    }


    public function RequestCountProductsInCategory(Request $request)
    {
        return self::countProductsInCategory($request->id);
    }


    public static function countAllProductsInCategories()
    {
        $categories = Categories::all();
        foreach ($categories as $category) {
            self::countProductsInCategory($category->id);
        }
    }



}
