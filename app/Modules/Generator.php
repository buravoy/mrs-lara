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

    public static function filterMeta($params, $productsData, $filteredId, $discount): array
    {
        $data = self::getData($productsData, $filteredId, $discount);
        $params = array_map(function ($item) { return explode('_', $item); }, $params->toArray());

        foreach ($params as $param)
            foreach ($param as $key => $value) {
                if ($key == 0) {
                    $name = Groups::where('slug', $value)->select('name', 'show', 'description_name')->first();
                    $data['attributes'][$param[0]][] = $name->show ? $name->description_name ?? $name->name : null;
                }
                if ($key > 0) {
                    $value = Attributes::where('slug', $value)->select('name', 'form')->first();

                    switch ($productsData['category']->form) {
                        case 'жен': {
                            $data['attributes'][$param[0]][] = json_decode($value->form)->form_female ?? $value->name;
                            break;
                        }
                        case 'муж': {
                            $data['attributes'][$param[0]][] = json_decode($value->form)->form_male ?? $value->name;
                            break;
                        }
                        case 'сред': {
                            $data['attributes'][$param[0]][] = json_decode($value->form)->form_neutral ?? $value->name;
                            break;
                        }
                        case 'множ': {
                            $data['attributes'][$param[0]][] = json_decode($value->form)->form_many ?? $value->name;
                            break;
                        }
                        default: {
                            $data['attributes'][$param[0]][] = $value->name;
                        }
                    }
                }
            }

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
        if (isset($data['discount']['isset']))
            $template = str_replace('$discount$', '', $template);
        if (isset($data['discount']['max']))
            $template = str_replace('$discountMax$', $data['discount']['max'], $template);
        if (isset($data['discount']['min']))
            $template = str_replace('$discountMin$', $data['discount']['min'], $template);
        if (isset($data['price']['max']))
            $template = str_replace('$priceMax$', $data['price']['max'], $template);
        if (isset($data['price']['min']))
            $template = str_replace('$priceMin$', $data['price']['min'], $template);
        if (isset($data['price']['min']))
            $template = str_replace('$vinpad$', $data['vinpad'], $template);

        $groups = [];
        if (isset($data['attributes'])) {
            foreach ($data['attributes'] as $key => $attribute) {
                if ($groups[] = substr($template, strpos($template, '$' . $key), (strlen($key) + 2))) {
                    $name = $attribute[0];
                    unset ($attribute[0]);
                    if (strpos($template, '$' . $key))
                        unset ($data['attributes'][$key]);
                    $merged = $name . ' ' . implode(', ', $attribute);
                    $template = str_replace('$' . $key . '$', $merged, $template);
                }
            }

            $attributes = array_map(function ($item) {
                $name = $item[0];
                unset($item[0]);
                return $name. ' ' . implode(', ', $item);
            }, $data['attributes']);

            $template = str_replace('$attributes$', implode(' ', $attributes), $template);
        }

        foreach ($data['groups'] as $group => $count)
            $template = str_replace('$count'.$group.'$', $count, $template);

        while (strpos($template, '{')) {
            $fromS = strpos($template, '{');
            $toS = strpos($template, '}');

            $section = substr($template, $fromS, ($toS - $fromS + 1));

            if(strpos($section, '$')) $template = str_replace($section, '', $template);
            else $template = str_replace($section, substr($section, 1, -1), $template);
        }

        $templateRun = strrev($data['categoryId']);
        $templateLoop = 0;

        while (strpos($template, '[')) {
            $from = strpos($template, '[');
            $to = strpos($template, ']');
            $part = substr($template, $from, ($to - $from + 1));
            $word = explode('|', mb_substr(mb_substr($part, 1), 0, -1));
            $wordPos = ($templateRun[$templateLoop++] + 99) % count($word);
            if ($templateLoop >= count($word))
                $templateLoop = 0;
            $template = str_replace($part, $word[$wordPos], $template);
        }

        $template = mb_strtolower(preg_replace('/\$.*?\$/is', '', $template));

        return preg_replace_callback('#((?:[.!?]|^)\s*)(\w)#us', function($matches) {
            return $matches[1] . mb_strtoupper($matches[2]);
        }, $template);
    }

    static function getData($productsData, $filteredId = null, $isDiscount = false): array
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

        $discount = [
            'isset' => $isDiscount,
            'min' => $discountMin ? $discountMin->toArray()['discount'] : null,
            'max' => $discountMax ? $discountMax->toArray()['discount'] : null,
        ];

        if ($isDiscount == false) unset($discount['isset']);

        $groups = Groups::with('attributes:group_id')->get();

        $groupsCount = [];
        foreach ($groups as $group)
            $groupsCount[ucfirst($group->slug)] = $group->attributes->count();

        $countProducts = $filteredId ? Products::whereIn('id', $productsId)->count() : $productsData['category']->count;

        return [
            'categoryId' => $productsData['category']->id,
            'vinpad' => $productsData['category']->vinpad,
            'name' => $productsData['category']->name,
            'count' => $countProducts . ' ' .Functions::plural($countProducts, ['товар', 'товара', 'товаров']),
            'discount' => $discount,
            'groups' => $groupsCount,
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
