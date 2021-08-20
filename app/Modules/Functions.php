<?php

namespace App\Modules;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;

class Functions
{
    static function getDiscountUrl($url)
    {
        $url = explode('/', $url);
        $isActive = false;


        $generatedUrl = array_filter(array_map(function($item) use($url) {
            if ($item == 'category' && count($url) <= 3) return 'filter';
            if ($item == 'filter' && count($url) <= 3) return 'category';
            if ($item == 'discount') return null;
            return $item;
        }, $url));


        if(end($url) == 'discount') $isActive = true;
        if(end($url) != 'discount') $generatedUrl[] = 'discount';
//        if($url[0] == 'category') $generatedUrl[] = 'discount';



//        dump($generatedUrl);

        return [
            'link' => implode('/', $generatedUrl),
            'isActive' => $isActive
        ];
    }

    static function getFilterUrl($group, $attribute, $url): array
    {
        $urlArr = explode('/', $url);
        $category = $urlArr[1];
        unset($urlArr[0], $urlArr[1]);
        $isActive = false;
        $isThisGroup = false;

        foreach ($urlArr as $item) {
            $seek = explode('_', $item);
            if (array_search($attribute, $seek) !== false) $isActive = true;
        }

        if (!count($urlArr)) {
            return [
                'link' => 'filter/' . $category . '/' . $group . '_' . $attribute,
                'isActive' => $isActive
            ];
        }

        $urlArr = array_map(function ($item) use ($group, $attribute) {
            if (strpos($item, $group) !== false && strpos($item, $attribute) == true)
                return str_replace('_' . $attribute, null, $item);

            if (strpos($item, $group) !== false && strpos($item, $attribute) != true)
                return $item . '_' . $attribute;

            return $item;
        }, $urlArr);

        $cleanUrlArr = array_diff($urlArr, [$group, null]);

        foreach ($cleanUrlArr as $item) if (strpos($item, $group) !== false) $isThisGroup = true;

        if (!$isThisGroup && strpos($url, $attribute) == false) $cleanUrlArr[] = $group . '_' . $attribute;

        if (!count($cleanUrlArr)) {
            return [
                'link' => 'category/' . $category,
                'isActive' => $isActive
            ];
        }

        asort($cleanUrlArr);

        return [
            'link' => 'filter/' . $category . '/' . implode('/', $cleanUrlArr),
            'isActive' => $isActive
        ];
    }

    static function productsData($category, $discount = false): Collection
    {
        $catIdWithChild = Categories::where('slug', $category)->select('id', 'parent_id', 'slug', 'name', 'count')->first();
        $idArray = Arr::flatten(Functions::collectId(collect([$catIdWithChild])));
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->pluck('product_id')->unique();;
        $products = Products::whereIn('id', $productsId);

        if ($discount) $products->where('discount','<>', null);

        return collect([
            'query' => $products,
            'category' => $catIdWithChild,
            'categoriesId' => $idArray,
            'productsId' => $productsId
        ]);
    }

    static function collectId($collection): array
    {
        $arr = [];
        foreach ($collection as $item) {
            if (isset($item->id)) $arr[] = $item->id;
            $child = $item->allChild;
            if (!empty($child)) $arr[] = self::collectId($child);
        }
        return $arr;
    }

    static function collectFilters($idArray, $discount = false) {
        $attributesGroups = Groups::with('attributes:group_id,id,name,slug,sort')
            ->select('id', 'name', 'slug', 'sort')
            ->orderBy('sort')
            ->get()->toArray();

        $productsAttributesQery = Products::whereIn('id', $idArray);

        if ($discount) $productsAttributesQery->where('discount','<>', null);

        $productsAttributes = $productsAttributesQery->pluck('attributes')->toArray();

        $mergedAttributes = array_map('array_unique', array_merge_recursive(...array_map(function ($attribute) {
            return (array)json_decode($attribute);
        }, $productsAttributes)));

        foreach ($attributesGroups as $key => $group) {
            if ( !array_key_exists($group['slug'], $mergedAttributes ) ) {
                unset($attributesGroups[$key]);
                continue;
            }

            $attributesGroups[$key]['attributes'] = array_filter(
                array_map(
                    function ($item) use ($group, $mergedAttributes) {
                        return array_search($item['id'], $mergedAttributes[$group['slug']]) !== false ? $item : null;
                    }, $group['attributes']),
                );
        }

        foreach ($attributesGroups as $key => $group) {
            $attributesGroups[$group['slug']] = $group;
            unset($attributesGroups[$key]);
        }

        return $attributesGroups;
    }

    static function plural($n, $forms)
    {
        return $n % 10 == 1 && $n % 100 != 11 ?
            $forms[0]
            :
            ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20)
                ?
                $forms[1]
                :
                $forms[2]);
    }
}
