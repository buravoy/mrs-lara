<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Products;
use App\Modules\Functions;
use App\Modules\Generator;

class FilterController extends Controller
{
    public function query($params = null)
    {
        $discount = false;
        $params = collect(explode('/', $params));

        if(count($params) == 1) return redirect(route('category',['category' => $params[0]]));

        if ($params->last() == 'discount') {
            $params->forget($params->keys()->last());
            $discount = true;
        }

        $productsData = Functions::productsData($params->first(), $discount);
        $params->forget($params->keys()->first());

        $filteredProductsQuery = $productsData['query'];

        foreach ($params as $param) $filteredProductsQuery = self::createFilterQuery($param, $filteredProductsQuery);

        if ($discount) $filteredProductsQuery->where('discount','<>', null);

        $availableFilters = self::availableFilters($params->toArray(), $productsData, $filteredProductsQuery, $discount);

        return view('category', [
            'products' => $filteredProductsQuery->orderBy('price', 'asc')->paginate(10),
            'discountAvailable' => $filteredProductsQuery->where('discount','<>' , null)->first(),
            'category' => $productsData['category'],
            'meta' => Generator::filterMeta($params, $productsData),
            'filters' => $availableFilters,
            'discountSet' => $discount,
            'page' => 'filter'
        ]);
    }


    public function availableFilters($params, $productsData, $filteredProductsQuery, $discount): array
    {
        $availableFilters = [];
        $currentFilters = Functions::collectFilters($filteredProductsQuery->pluck('id')->toArray(), $discount);

        if ($discount && empty($params)) return $currentFilters;

        if (count($params) == 1) {
            $categoryFilters = Functions::collectFilters($productsData['productsId'], $discount);
            $singleParam = explode('_', $params[1])[0];

            $currentFilters[$singleParam] = $categoryFilters[$singleParam];
            return $currentFilters;
        }

        foreach ($params as $param) {
            $groupSlug = explode('_', $param)[0];
            $productsQuery = Products::whereIn('id', $productsData['productsId']);
            $query = self::createFilterQuery($param, $productsQuery);
            $filteredProductsId = Functions::collectId($query->get('id'));
            $availableFilters[$groupSlug] = Functions::collectFilters($filteredProductsId, $discount);
        }

        $merged = array_map(function (){ return []; }, $currentFilters);

        foreach ($availableFilters as $availableFilter)
            foreach ($availableFilter as $group => $attribute)
                if(array_key_exists($group, $merged))
                    $merged[$group] = array_merge_recursive($merged[$group], $attribute );

        foreach ($merged as $key => $group) {
            $merged[$key] = [
                'id' => $group['id'][0],
                'name' => $group['name'][0],
                'slug' => $group['slug'][0],
                'sort' => $group['sort'][0],
                'attributes' => array_map(function($item){ return unserialize($item); },
                    array_unique(array_map(function($item){ return serialize($item); }, $group['attributes'])))
            ];
        }

        foreach ($merged as $key => $filter)
            if (!array_key_exists($key, $availableFilters))
                $merged[$key] = $currentFilters[$key];

        return $merged;
    }

    public function createFilterQuery($param, $productsQuery)
    {
        $param = explode('_', $param);
        $groupSlug = $param[0];
        unset($param[0]);

        $seekId = Attributes::whereIn('slug', $param)->pluck('id');

        return $productsQuery->where(function($query) use($seekId, $groupSlug) {
            foreach($seekId as $id)
                $query->orWhereJsonContains('attributes->' . $groupSlug , $id);
        });
    }
}
