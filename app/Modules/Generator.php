<?php

namespace App\Modules;

use App\Models\Attributes;
use App\Models\Groups;
use App\Models\MetaGenerators;
use App\Models\Products;

class Generator
{
    public static function categoryMeta($productsData): array
    {
//        dump($productsData);
        $data = self::getData($productsData);
        $templates = self::getTemplates('category');

        return [
            'meta_title' => self::parseTemplate($templates['meta_title'], $data),
            'meta_description' => self::parseTemplate($templates['meta_description'], $data),
            'title' => self::parseTemplate($templates['title'], $data),
            'description1' => self::parseTemplate($templates['description1'], $data),
            'description2' => self::parseTemplate($templates['description2'], $data),
        ];
    }

    public static function filterMeta($params, $productsData, $filteredId): array
    {
//        dump($filteredId);

        $data = self::getData($productsData, $filteredId);

        $params = array_map(function ($item) {
            return explode('_', $item);
        }, $params->toArray());


        foreach ($params as $param)
            foreach ($param as $key => $value) {
                if ($key == 0) {
//                    $data[$param[0]][] = Groups::where('slug', $value)->pluck('name')->first();
                    $name = Groups::where('slug', $value)->select('name', 'show')->first();
                    $data['attributes'][$param[0]][] = $name->show ? $name->name : null;

                }
                if ($key > 0) {
//                    $data[$param[0]][] = Attributes::where('slug', $value)->pluck('name')->first();
                    $data['attributes'][$param[0]][] = Attributes::where('slug', $value)->pluck('name')->first();
                }
            }


//        dump($data);


        $templates = self::getTemplates('filter');


        return [
            'meta_title' => self::parseTemplate($templates['meta_title'], $data),
            'meta_description' => self::parseTemplate($templates['meta_description'], $data),
            'title' => self::parseTemplate($templates['title'], $data),
            'description1' => self::parseTemplate($templates['description1'], $data),
            'description2' => self::parseTemplate($templates['description2'], $data),
        ];
    }

    static function parseTemplate($template, $data)
    {
        if (!$template) return null;

        if (isset($data['name']))
            $template = str_replace('$name$', $data['name'], $template);
        if (isset($data['count']))
            $template = str_replace('$count$', $data['count'], $template);
        if (isset($data['discount']['max']))
            $template = str_replace('$discountMax$', $data['discount']['max'], $template);
        if (isset($data['discount']['min']))
            $template = str_replace('$discountMin$', $data['discount']['min'], $template);
        if (isset($data['price']['max']))
            $template = str_replace('$priceMax$', $data['price']['max'], $template);
        if (isset($data['price']['min']))
            $template = str_replace('$priceMin$', $data['price']['min'], $template);

        if (isset($data['attributes'])) {
            foreach ($data['attributes'] as $key => $attribute) {
                if (substr($template, strpos($template, '$' . $key), (strlen($key) + 2))) {
                    $name = $attribute[0] ? $attribute[0] . ': ' : $attribute[0];
                    unset ($attribute[0]);
                    if (strpos($template, '$' . $key)) unset ($data['attributes'][$key]);
                    $merged = $name . implode(', ', $attribute);
                    $template = str_replace('$' . $key . '$', $merged, $template);
                }
            }

            $attributes = array_map(function ($item) {
                $name = $item[0];
                unset($item[0]);
                return $name . ': ' . implode(', ', $item);
            }, $data['attributes']);

            $template = str_replace('$attributes$', implode('. ', $attributes), $template);

//

        }

        while (strpos($template, '{')) {
            $fromS = strpos($template, '{');
            $toS = strpos($template, '}');

            $section = substr($template, $fromS, ($toS - $fromS + 1));

            if(strpos($section, '$')) $template = str_replace($section, '', $template);

            else $template = str_replace($section, substr($section, 1, -1), $template);
//
//            dump($section);


        }

        $templateRun = strrev($data['categoryId']);
        $templateLoop = 0;

        while (strpos($template, '[')) {
            $from = strpos($template, '[');
            $to = strpos($template, ']');
            $part = substr($template, $from, ($to - $from + 1));
            $word = explode('/', mb_substr(mb_substr($part, 1), 0, -1));
            $wordPos = ($templateRun[$templateLoop++] + 99) % count($word);
            $template = str_replace($part, $word[$wordPos], $template);
        }

        $template = preg_replace('/\$.*?\$/is', '', $template);

//        while(preg_match('/\$.*?\$/is', $template, $matches)){
//        preg_match('/\$.*?\$/is', $template, $matches) ;
//
//            dump(preg_match('/\$.*?\$/is', $template));

//            if ($matches) {
//
//            }

//        }



        return $template;
    }

    static function getData($productsData, $filteredId = null): array
    {

        $productsId = $filteredId ?? $productsData['productsId']->toArray();

        $discountMin = Products::whereIn('id', $productsId)->whereNotNull('discount')->select('discount')
            ->orderBy('discount', 'asc')
            ->first();

        $discountMax = Products::whereIn('id', $productsId)->whereNotNull('discount')->select('discount')
            ->orderBy('discount', 'desc')
            ->first();

        $priceMin = Products::whereIn('id', $productsId)->whereNotNull('price')->select('price')
            ->orderBy('price', 'asc')
            ->first();

        $priceMax = Products::whereIn('id', $productsId)->whereNotNull('price')->select('price')
            ->orderBy('price', 'desc')
            ->first();

        return [
            'categoryId' => $productsData['category']->id,
            'name' => $productsData['category']->name,
            'count' => $filteredId ? Products::whereIn('id', $productsId)->count() : $productsData['category']->count,
            'discount' => [
                'min' => $discountMin ? $discountMin->toArray()['discount'] : null,
                'max' => $discountMax ? $discountMax->toArray()['discount'] : null,
            ],
            'price' => [
                'min' => $priceMin ? $priceMin->toArray()['price'] : null,
                'max' => $priceMax ? $priceMax->toArray()['price'] : null,
            ]
        ];
    }

    static function getTemplates($type): array
    {
        $templates = MetaGenerators::where('type', $type)
            ->select(
                'template_meta_title',
                'template_meta_description',
                'template_title',
                'template_description1',
                'template_description2'
            )->first();

        return [
            'meta_title' => $templates->template_meta_title,
            'meta_description' => $templates->template_meta_description,
            'title' => $templates->template_title,
            'description1' => $templates->template_description1,
            'description2' => $templates->template_description2,
        ];
    }
}
