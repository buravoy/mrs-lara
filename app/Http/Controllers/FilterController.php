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
            $productsQuery = self::createFilterQuery($param, $productsQuery);
        }


        $availableFilters = self::availableFilters($params->toArray(), $productsData);

        return view('category', [
            'products' => $productsQuery->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::filterDescription($params),
            'filters' => $availableFilters
        ]);
    }


    public function availableFilters($params, $productsData)
    {
        $availableFilters = [];

//        dump(count($params));

//        if (count($params) == 1) {
//
//            $categoryFilters = Functions::collectFilters($productsData['productsId']);
//
//            dump($categoryFilters);
//        }

        foreach ($params as $param) {
            $groupSlug = explode('_', $param)[0];
            $productsQuery = Products::whereIn('id', $productsData['productsId']);

            $query = self::createFilterQuery($param, $productsQuery);

            $filteredProductsId = Functions::collectId($query->get('id'));
            $availableFilters[$groupSlug] = Functions::collectFilters($filteredProductsId);
        }

        dump($availableFilters);

        $existFilters = [];
        foreach ($availableFilters as $filters) {
            $existFilters = array_merge($filters);
        }

        dump($existFilters);
        return $existFilters;
    }


    public function createFilterQuery($param, $productsQuery)
    {
        $param = explode('_', $param);
        $groupSlug = $param[0];
        unset($param[0]);

        $seekId = Attributes::whereIn('slug', $param)->pluck('id');

        $productsQuery = $productsQuery->where(function($query) use($seekId, $groupSlug) {
            foreach($seekId as $id) {
                $query->orWhereJsonContains('attributes->' . $groupSlug , $id);
            }
        });

        return $productsQuery;
    }
}
