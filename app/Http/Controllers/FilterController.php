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

        $allProductsQuery = $productsData['query'];

        if ($params->last() == 'discount') {
            $allProductsQuery->where('discount', true);
            $params->forget($params->keys()->last());
        }

        $productsQuery = $allProductsQuery;

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

        $availableCategoryFilters = Functions::collectFilters($productsData['productsId']);

        $availableFilters = self::availableFilters($availableCategoryFilters, $filteredProductsId, $params->toArray(), $productsQuery);

        return view('category', [
            'products' => $filteredProducts->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::filterDescription($params),
            'filters' => $availableFilters
        ]);
    }


    public function availableFilters($categoryFilters, $filteredId, $params, $allProductsQuery)
    {
        $paramArr = [];
        foreach ($params as $param) {
            $param = $param = explode('_', $param);
            $key = $param[0]; unset($param[0]);
            $paramArr[$key] = $param;
        }



        $availableFilters = Functions::collectFilters($filteredId);



        dump($paramArr);
        dump($availableFilters);

        return $availableFilters;
    }
}
