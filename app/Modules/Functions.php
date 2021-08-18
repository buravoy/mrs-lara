<?php

namespace App\Modules;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Functions
{
    static function getFilterUrl($group, $attribute, $url): array
    {
        $urlArr = explode('/', $url);
        $category = $urlArr[1];
        unset($urlArr[0], $urlArr[1]);
        $isActive = false;
        $isThisGroup = false;

        foreach ($urlArr as $item) {
            $seek = explode('_', $item);
            if (array_search($attribute, $seek) !== false) {
                $isActive = true;
            }
        }


        if (!count($urlArr)) {
            return [
                'link' => 'filter/' . $category . '/' . $group . '_' . $attribute,
                'isActive' => $isActive
            ];
        }

        $urlArr = array_map(function ($item) use ($group, $attribute) {

//            dump($item);

            if (strpos($item, $group) !== false && strpos($item, $attribute) == true) {
                return str_replace('_' . $attribute, null, $item);
            }

            if (strpos($item, $group) !== false && strpos($item, $attribute) != true) {
                return $item . '_' . $attribute;
            }

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
        return [
            'link' => 'filter/' . $category . '/' . implode('/', $cleanUrlArr),
            'isActive' => $isActive
        ];
    }

    static function productsData($category): Collection
    {
        $catIdWithChild = Categories::where('slug', $category)->select('id', 'parent_id', 'slug', 'name', 'count')->first();
        $idArray = Arr::flatten(Functions::collectId(collect([$catIdWithChild])));
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->pluck('product_id')->unique();

//        dump($catIdWithChild);

        return collect([
            'query' => Products::whereIn('id', $productsId),
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

    static function collectFilters($idArray) {
        $attributesGroups = Groups::with('attributes:group_id,id,name,slug,sort')
            ->select('id', 'name', 'slug', 'sort')
            ->orderBy('sort')
            ->get()->toArray();

        $productsAttributes = Products::whereIn('id', $idArray)->pluck('attributes')->toArray();

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
}
