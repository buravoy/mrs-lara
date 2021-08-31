<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Products;
use App\Modules\Functions;
use App\Modules\Generator;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function query($params = null)
    {
        $discount = false;
        $params = collect(explode('/', $params));
        $sorting = Functions::sorting();

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

        $queryForGenerator = $filteredProductsQuery;
        $filteredId = $queryForGenerator->pluck('id')->toArray();

        $availableFilters = self::availableFilters($params->toArray(), $productsData, $filteredProductsQuery, $discount);

        return view('category', [
            'products' => $filteredProductsQuery->orderBy($sorting['column'], $sorting['direction'])
                ->orderBy('price', 'asc')
                ->paginate($_COOKIE['pagination'] ?? 20),
            'discountAvailable' => $filteredProductsQuery->where('discount','<>' , null)->first(),
            'category' => $productsData['category'],
            'meta' => Generator::filterMeta($params, $productsData, $filteredId, $discount),
            'filters' => $availableFilters,
            'discountSet' => $discount,
            'page' => 'filter'
        ]);
    }

    public function availableFilters($params, $productsData, $filteredProductsQuery, $discount): array
    {
        $currentFilters = Functions::collectFilters($filteredProductsQuery->pluck('id')->toArray(), $discount);
        if ($discount && empty($params)) return $currentFilters;

        if (count($params) == 1) {
            $categoryFilters = Functions::collectFilters($productsData['productsId'], $discount);
            $singleParam = explode('_', $params[1])[0];

            $currentFilters[$singleParam] = $categoryFilters[$singleParam] ?? null;

            return $currentFilters;
        }
        $productsQuery = Products::whereIn('id', $productsData['productsId']);

        $availableFilters = [];

        foreach ($currentFilters as $group => $filter) {
            foreach ($params as $key => $param) {
                if (strpos($param, $group) !== false) {
                    $paramId = $key;
                    if (isset($paramId)) {
                        $croppedParams = $params;
                        unset($croppedParams[$paramId]);
                        $fProdQuery = $productsQuery;
                        foreach ($croppedParams as $croppedParam) $fProdQuery = self::createFilterQuery($croppedParam, $fProdQuery);
                        if ($discount) $fProdQuery->where('discount','<>', null);
                        $availableFilters[$group] = Functions::collectFilters($fProdQuery->pluck('id')->toArray(), $discount);
                    }
                }
            }
        }

        $merged = array_map(function() { return []; }, $currentFilters);

        foreach ($availableFilters as $availableFilter)
            foreach ($availableFilter as $group => $attribute)
                if(array_key_exists($group, $merged))
                    $merged[$group] = array_merge_recursive($merged[$group], $attribute);

        foreach ($merged as $key => $group) {
            $merged[$key] = [
                'id' => $group['id'][0],
                'name' => $group['name'][0],
                'slug' => $group['slug'][0],
                'sort' => $group['sort'][0],
                'active_attributes' => array_map(function($item){ return unserialize($item); },
                    array_unique(array_map(function($item){ return serialize($item); }, $group['active_attributes'])))
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

    public function ajaxQuery(Request $request)
    {
        $href = $request->href;

        $url =  explode('/', $request->href);
        unset($url[0]);
        $url = implode( '/', $url);
        $discount = false;
        $params = collect(explode('/', $url));

        if ($params->last() == 'discount') {
            $params->forget($params->keys()->last());
            $discount = true;
        }

        $productsData = Functions::productsData($params->first(), $discount);

        $params->forget($params->keys()->first());
        $filteredProductsQuery = $productsData['query'];

        foreach ($params as $param) $filteredProductsQuery = self::createFilterQuery($param, $filteredProductsQuery);
        if ($discount) $filteredProductsQuery->where('discount','<>', null);

        if(explode('/', $href)[0] == 'filter') {
            $availableFilters = self::availableFilters($params->toArray(), $productsData, $filteredProductsQuery, $discount);
        } else {
            $availableFilters = Functions::collectFilters($productsData['productsId']);
        }

        $filteredProductsCount = $filteredProductsQuery->count();

        if ($filteredProductsCount) {
            $filters =  view('sections.filter-ajax', [
                'products' => $filteredProductsQuery->count(),
                'discountAvailable' => $filteredProductsQuery->where('discount','<>' , null)->first(),
                'category' => $productsData['category'],
                'filters' => $availableFilters,
                'discountSet' => $discount,
                'path' => $href
            ])->render();

            $request->session()->put('filters', $filters);

            return json_encode([
                'view' => $filters
            ]);
        }

        $filters = $request->session()->get('filters');

        return json_encode([
            'view' => $filters,
            'message' => 'Нет товаров, выберите другие фильтры'
        ]);
    }
}
