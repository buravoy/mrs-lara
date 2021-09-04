<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Modules\Functions;
use App\Modules\Generator;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index($category = null)
    {
        if(!$category || !Categories::where('slug', $category)->exists()) abort(404);

        $productsData = Functions::productsData($category);
        $productsQuery = $productsData['query'];
        $sorting = Functions::sorting();

        return view('category', [
            'products' => $productsQuery->orderBy($sorting['column'], $sorting['direction'])
                ->orderBy('price', 'asc')
                ->paginate($_COOKIE['pagination'] ?? 20),
            'discountAvailable' => $productsQuery->where('discount','<>' , null)->first(),
            'category' => $productsData['category'],
            'filters' => Functions::collectFilters($productsData['productsId']),
            'meta' => Generator::categoryMeta($productsData),
            'discountSet' => false,
            'page' => 'category'
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
