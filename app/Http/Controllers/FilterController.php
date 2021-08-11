<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use App\Modules\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FilterController extends Controller
{
    public function index($category = null, $params = null, $discount = null)
    {

        dump($params);

        if($discount != null && $discount != 'discount') abort(404);

        if(!$category) abort(404);

        $catIdWithChild = Categories::where('slug', $category)->first();
        $idArray = Arr::flatten(CategoriesController::collectId(collect([$catIdWithChild])));
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

        $allowDiscount = (boolean)Products::whereIn('id', $productsId)->where('discount','<>', null)->first();

        $filters = collect([
            'route' => 'filter',
            'discount' => [
                'link' => $discount ? null : 'discount',
                'count' => $allowDiscount
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
}
