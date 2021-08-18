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

        $filteredProductsQuery = $productsData['query'];

        if ($params->last() == 'discount') {
            $filteredProductsQuery->where('discount', true);
            $params->forget($params->keys()->last());
        }

        foreach ($params as $param) $filteredProductsQuery = self::createFilterQuery($param, $filteredProductsQuery);

        $availableFilters = self::availableFilters($params->toArray(), $productsData, $filteredProductsQuery);

        return view('category', [
            'products' => $filteredProductsQuery->orderBy('price', 'asc')->paginate(10),
            'category' => $productsData['category'],
            'description' => Generator::filterDescription($params),
            'filters' => $availableFilters
        ]);
    }


    public function availableFilters($params, $productsData, $filteredProductsQuery)
    {
        $availableFilters = [];

        $currentFilters = Functions::collectFilters($filteredProductsQuery->pluck('id')->toArray());

        if (count($params) == 1) {
            $categoryFilters = Functions::collectFilters($productsData['productsId']);
            $singleParam = explode('_', $params[1])[0];
        }

        foreach ($params as $param) {
            $groupSlug = explode('_', $param)[0];
            $productsQuery = Products::whereIn('id', $productsData['productsId']);
            $query = self::createFilterQuery($param, $productsQuery);
            $filteredProductsId = Functions::collectId($query->get('id'));
            $availableFilters[$groupSlug] = Functions::collectFilters($filteredProductsId);
        }

        $existFilters = [];

        foreach ($availableFilters as $filters) foreach ($filters as $filter) $existFilters[$filter['slug']][] = $filter;

        $existFilters = array_map(function($item) {
                return array_map(function($i) { return unserialize($i); }, $item);
            }, array_map(function($item) {
            return array_unique(array_map(function($a) {
                return serialize($a);
            }, array_merge(...$item)));
        }, $existFilters));

        foreach ($existFilters as $key => $existFilter) if (!array_key_exists($key, $currentFilters)) unset($existFilters[$key]);

        if (count($params) == 1) $existFilters[$singleParam] = $categoryFilters[$singleParam];

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
