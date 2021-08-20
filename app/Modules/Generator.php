<?php

namespace App\Modules;

use App\Models\MetaGenerators;
use App\Models\Products;

class Generator
{
    public static function categoryMeta($productsData)
    {

        $productsId = $productsData['productsId']->toArray();
        $templates = MetaGenerators::where('type', 'category')
                        ->select(
                            'template_meta_title',
                            'template_meta_description',
                            'template_title',
                            'template_description1',
                            'template_description2'
                        )->first();
        $data = [
            'categoryId' => $productsData['category']->id,
            'name' => $productsData['category']->name,
            'count' => $productsData['category']->count,
            'discount' => [
                'min' => Products::whereIn('id', $productsId)->whereNotNull('discount')->select('discount')
                    ->orderBy('discount', 'asc')
                    ->first()->toArray()['discount'],

                'max' => Products::whereIn('id', $productsId)->whereNotNull('discount')->select('discount')
                    ->orderBy('discount', 'desc')
                    ->first()->toArray()['discount'],
            ],
            'price' => [
                'min' => Products::whereIn('id', $productsId)->whereNotNull('price')->select('price')
                    ->orderBy('price', 'asc')
                    ->first()->toArray()['price'],

                'max' => Products::whereIn('id', $productsId)->whereNotNull('price')->select('price')
                    ->orderBy('price', 'desc')
                    ->first()->toArray()['price'],
            ]
        ];

        $templateMetaTitle = $templates->template_meta_title;
        $templateMetaDescription = $templates->template_meta_description;
        $templateTitle = $templates->template_title;
        $templateDescription1 = $templates->template_description1;
        $templateDescription2 = $templates->template_description2;


        return [
            'meta_title' => self::parseCategory($templateMetaTitle, $data),
            'meta_description' => self::parseCategory($templateMetaDescription, $data),
            'title' => self::parseCategory($templateTitle, $data),
            'description1' => self::parseCategory($templateDescription1, $data),
            'description2' => self::parseCategory($templateDescription2, $data),
        ];
    }

    public static function filterDescription($params)
    {

        $paramString = '';

        foreach ($params as $param) {
            $paramString = $paramString . ' ' . $param;
        }

        return 'Купить ' . $paramString . ' FILTER GENERATOR';
    }


    static function parseCategory($template, $data)
    {
        if(!$template) return null;

        $template = str_replace('$name$', $data['name'], $template);
        $template = str_replace('$count$', $data['count'], $template);
        $template = str_replace('$discountMax$', $data['discount']['max'], $template);
        $template = str_replace('$discountMin$', $data['discount']['min'], $template);
        $template = str_replace('$priceMax$', $data['price']['max'], $template);
        $template = str_replace('$priceMin$', $data['price']['min'], $template);
        $titleRun = strrev($data['categoryId']);
        $titleLoop = 0;
        while (strpos($template, '[')) {
            $from = strpos($template, '[');
            $to = strpos($template, ']');
            $part = substr($template, $from, ($to - $from + 1));
            $word = explode('/', mb_substr(mb_substr($part, 1), 0, -1));
            $wordPos = ($titleRun[$titleLoop++] + 99) % count($word);
            $template = str_replace($part, $word[$wordPos], $template);
        }

        return $template;
    }
}
