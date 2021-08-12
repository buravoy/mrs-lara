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

class FilterController extends Controller
{
    public function query($params = null)
    {
        $params = collect(explode('/', $params));
        $productsData = Functions::productsData($params->first());
        $params->forget($params->keys()->first());

        if ($params->last() == 'discount') {
            $params->forget($params->keys()->last());
        }


        dump($params);



        $productsQuery = $productsData['query'];

        foreach ($params as $param) {
            $param = explode('_', $param);
            $groupSlug = $param[0];
            unset($param[0]);

            foreach ($param as $seekSlug) {
                $seekId = Attributes::where('slug', $seekSlug)->pluck('id');


            }
//


//            dd($attrArr[1]);

            $products->whereJsonContains('attributes->' . $attrArr[0], $attrValue);

//            dump($products);

        }



//        if ($attr && $attr != 'all') {
//
//        }

//        $allowDiscount = (boolean)Products::whereIn('id', $productsId)->where('discount', '<>', null)->first();
//        return view('category', [
//            'products' => '',
//            'category' => '',
//            'description' => '',
//            'filters' => ''
//        ]);
    }

    public static function availableFilters($productsId)
    {
        $attributesGroups = Groups::with('attributes')->get();

//        dd($attributesGroups);
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

        return $attributesGroups;


    }
}
