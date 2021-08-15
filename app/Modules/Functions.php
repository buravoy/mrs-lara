<?php

namespace App\Modules;

use App\Models\Categories;
use App\Models\CategoryProduct;
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
        $catIdWithChild = Categories::where('slug', $category)->first();
        $idArray = Arr::flatten(Functions::collectId(collect([$catIdWithChild])));
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->get('product_id');

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
            if (!empty($item->allChild)) $arr[] = self::collectId($item->allChild);
        }
        return $arr;
    }
}
