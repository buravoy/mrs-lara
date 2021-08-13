<?php

namespace App\Modules;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Support\Arr;

class Functions
{
    static function getFilterUrl($group, $attribute, $url)
    {

        return null;

        $urlArr = collect(explode('/', $url));

        $filterPage = $urlArr->first();
        $urlArr->forget($urlArr->keys()->first());
        $filterCategory = $urlArr->first();
        $urlArr->forget($urlArr->keys()->first());
        if ($urlArr->last() == 'discount') {
            $filterDiscount = $urlArr->last();
            $urlArr->forget($urlArr->keys()->last());
        }

        $filterString = '/';

        foreach ($urlArr as $filterGroup) {
           $groupArr = explode('_', $filterGroup);
           $groupName = $groupArr[0];
           unset($groupArr[0]);
            $filterString = $filterString.$group;
           foreach ($groupArr as $attr) {
               $filterString = $filterString.'_'.$attr.'_'.$attribute;
           }
        }
        dump($filterString);


//        return $filterPage. '/' . $filterCategory . '/';
    }

    static function productsData($category){
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

    static function collectId($collection){
        $arr = [];
        foreach ($collection as $item) {
            if(isset($item->id)) $arr[] = $item->id;
            if(!empty($item->allChild)) $arr[] = self::collectId($item->allChild);
        }
        return $arr;
    }
}
