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

        $availableFilters = self::availableCategoryFilters($productsData['productsId']);

//        Session::flash('availableFilters', $availableFilters);

        return view('category', [
            'products' => $productsQuery->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::categoryDescription($productsData['category']),
            'filters' => $availableFilters
        ]);
    }

    public static function availableCategoryFilters($productsId)
    {
        $attributesGroups = Groups::with('attributes')->get();
        $productsAttributes = Products::whereIn('id', $productsId)->pluck('attributes')->toArray();

        $mergedAttributes = [];
        foreach ($productsAttributes as $attribute) $mergedAttributes = array_merge_recursive($mergedAttributes, (array)json_decode($attribute));
        $mergedAttributes = array_map('array_unique', $mergedAttributes);

        foreach ($attributesGroups as $key => $group) {
            if ( array_key_exists($group->slug, $mergedAttributes) === false) {
                unset($attributesGroups[$key]);
                continue;
            }

            foreach ($group->attributes as $k => $attribute) {
                if ( array_search($attribute->id, $mergedAttributes[$group->slug]) === false ) {
                    unset($group->attributes[$k]);
                }
            }
        }

        return $attributesGroups;
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

        return true;
    }
}
