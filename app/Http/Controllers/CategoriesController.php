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

//    public static function availableCategoryFilters($productsId)
//    {
//        $attributesGroups = Groups::with('attributes')->get()->toArray();
//
//        $productsAttributes = Products::whereIn('id', $productsId)->pluck('attributes')->toArray();
//
//        $mergedAttributes = array_map('array_unique', array_merge_recursive(...array_map(function ($attribute) {
//            return (array)json_decode($attribute);
//        }, $productsAttributes)));
//
//        foreach ($attributesGroups as $key => $group) {
//            if ( !array_key_exists($group['slug'], $mergedAttributes ) ) {
//                unset($attributesGroups[$key]);
//                continue;
//            }
//
//            $attributesGroups[$key]['attributes'] = array_filter(array_map(function ($item) use ($group,$mergedAttributes){
//                if ( array_search($item['id'],$mergedAttributes[$group['slug']]) ) return $item;
//                return null;
//            }, $group['attributes']));
//        }
//
//        return $attributesGroups;
//    }

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
