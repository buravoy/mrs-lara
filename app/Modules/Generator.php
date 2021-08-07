<?php

namespace App\Modules;

class Generator
{
    public static function categoryDescription($category) {

//        dd($category);

        return 'Купить ' . $category->name . ' AUTO GENERATOR';
    }
}
