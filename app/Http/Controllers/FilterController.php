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

        $filteredProductsAttributes = Products::whereIn('id', $filteredId)->pluck('attributes')->toArray();

        $mergedAttributes = array_map('array_unique', array_merge_recursive(...array_map(function ($attribute) {
            return (array)json_decode($attribute);
        }, $filteredProductsAttributes)));

        dump($categoryFilters);
        dump($mergedAttributes);

        return $categoryFilters;
    }
}
