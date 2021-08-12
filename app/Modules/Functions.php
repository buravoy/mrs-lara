<?php

namespace App\Modules;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Support\Arr;

class Functions
{
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
