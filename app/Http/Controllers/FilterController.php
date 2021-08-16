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

        $productsQuery = $productsData['query'];

        if ($params->last() == 'discount') {
            $productsQuery->where('discount', true);
            $params->forget($params->keys()->last());
        }



        foreach ($params as $param) {
            $param = explode('_', $param);
            $groupSlug = $param[0];
            unset($param[0]);

            $seekId = Attributes::whereIn('slug', $param)->pluck('id');

            $productsQuery = $productsQuery->where(function($query) use($seekId, $groupSlug) {
                foreach($seekId as $id) {
                    $query->orWhereJsonContains('attributes->' . $groupSlug , $id);
                }
            });
        }

        $filteredProducts = $productsQuery;

        $filteredProductsId = Functions::collectId($productsQuery->get('id'));

        $availableCategoryFilters = CategoriesController::availableCategoryFilters($productsData['productsId']);

        $availableFilters = self::availableFilters($availableCategoryFilters, $filteredProductsId, $params);

        return view('category', [
            'products' => $filteredProducts->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::filterDescription($params),
            'filters' => $availableFilters
        ]);
    }


    public function availableFilters($categoryFilters, $filteredId, $params)
    {
        $params = array_map(function ($item) { return explode('_',$item)[0]; }, $params->toArray());

        $attributesGroups = Groups::with('attributes')->get()->toArray();

        $productsAttributes = Products::whereIn('id', $filteredId)->pluck('attributes')->toArray();

        $mergedAttributes = [];
        foreach ($productsAttributes as $attribute) {
            $mergedAttributes = array_merge_recursive($mergedAttributes, (array)json_decode($attribute));
        }

        $mergedAttributes = array_map('array_unique', $mergedAttributes);

        foreach ($attributesGroups as $key => $group) {
            if ( !array_key_exists($group['slug'], $mergedAttributes ) ) {
                unset($attributesGroups[$key]);
                continue;
            }

            $attributesGroups[$key]['attributes'] = array_filter(array_map(function ($item) use ($group,$mergedAttributes){
                if ( array_search($item['id'],$mergedAttributes[$group['slug']]) ) return $item;
                return null;
            }, $group['attributes']));
        }


        dump($attributesGroups);
        dump($categoryFilters);



        return $attributesGroups;
    }
}
