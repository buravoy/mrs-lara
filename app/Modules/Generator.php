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
        dump($productsData);
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

    public static function filterMeta($params, $productsData): array
    {
        dump($productsData);
        $data = self::getData($productsData);

        $params = array_map(function($item) { return explode('_',$item); }, $params->toArray());

        foreach ($params as $param)
            foreach ($param as $key => $value) {
                if ($key == 0) {
//                    $data[$param[0]][] = Groups::where('slug', $value)->pluck('name')->first();
                    $data['attributes'][$param[0]][] = Groups::where('slug', $value)->pluck('name')->first();
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
                if($group = substr($template, strpos($template, '$'.$key), (strlen($key)+2) )) {
                    if(strpos($group,'#')) {
                        unset($attribute[0]);
                        $merged = implode(', ', $attribute);
                        if(strpos($template, '$'.$key))
                            unset ($data['attributes'][$key]);
                        $template = str_replace('$'.$key.'#$', $merged, $template);
                        continue;
                    }
                    $name = $attribute[0];
                    unset ($attribute[0]);
                    if(strpos($template, '$'.$key))
                        unset ($data['attributes'][$key]);
                    $merged = $name. ': '. implode(', ', $attribute);
                    $template = str_replace('$'.$key.'$', $merged, $template);
                }
            }

            $attributes = array_map(function($item) {
                $name = $item[0];
                unset($item[0]);
                return $name.': '.implode(', ', $item);
            }, $data['attributes']);
            $template = str_replace('$attributes$', implode('. ',$attributes), $template);

            $template = preg_replace('/\$.*?\$/is', '', $template);
//            $template = str_replace('$%%$', implode(', ',$attributes), $template);
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

        return $template;
    }

    static function getData($productsData): array
    {

        $productsId = $productsData['productsId']->toArray();

        return [
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
