<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use App\Modules\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoriesController extends Controller
{
    public function index($category = null, $discount = null)
    {
        if($discount != null && $discount != 'discount') abort(404);
        if(!$category) abort(404);

        $catIdWithChild = Categories::where('slug', $category)->with('allChild')->first();
        $idArray = Arr::flatten(self::collectId(collect([$catIdWithChild])));
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->get('product_id');
        $products = Products::whereIn('id', $productsId);
        if($discount) $products->where('discount','<>', null);

        $attributesGroups = Groups::with('attributes')->get();
        $productsAttributes = Products::whereIn('id', $productsId)->pluck('attributes')->toArray();

        $mergedAttributes = [];
        foreach ($productsAttributes as $attribute) $mergedAttributes = array_merge_recursive($mergedAttributes, (array)json_decode($attribute));
        $mergedAttributes = array_map('array_unique', $mergedAttributes);

        foreach ($attributesGroups as $key => $group) {
            if ( array_key_exists($group->slug, $mergedAttributes) === false ) {
                unset($attributesGroups[$key]);
                continue;
            }

            foreach ($group->attributes as $k => $attribute) {
                if ( array_search($attribute->id, $mergedAttributes[$group->slug]) === false ) {
                    unset($group->attributes[$k]);
                }
            }
        }

        $filters = collect([
            'route' => 'category',
            'discount' => [
                'link' => $discount ? null : 'discount',
//                'count' =>
            ],
            'category' => $catIdWithChild,
            'attributes' => $attributesGroups
        ]);

        return view('category', [
            'products' => $products->orderBy('price', 'asc')->paginate(10),
            'title' => $catIdWithChild->name,
            'description' => Generator::categoryDescription($catIdWithChild),
            'filters' => $filters
        ]);
    }


    public static function countProductsInCategory($catId)
    {
        $categoriesWithChild = Categories::where('id', $catId)->with('allChild')->get();
        $idArray = Arr::flatten(self::collectId($categoriesWithChild));
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


    static function collectId($collection){
        $arr = [];
        foreach ($collection as $item) {
            if(isset($item->id)) $arr[] = $item->id;
            if(!empty($item->allChild)) $arr[] = self::collectId($item->allChild);
        }
        return $arr;
    }
}
