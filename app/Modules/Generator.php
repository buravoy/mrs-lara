<?php

namespace App\Modules;

class Generator
{
    public static function categoryDescription($category) {

        return 'Купить ' . $category->name . ' CATEGORY GENERATOR';
    }

    public static function filterDescription($params) {

        $paramString = '';

        foreach ($params as $param) {
            $paramString = $paramString . ' ' . $param;
        }

        return 'Купить ' . $paramString . ' FILTER GENERATOR';
    }
}
