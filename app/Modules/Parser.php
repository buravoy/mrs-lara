<?php

namespace App\Modules;

use App\Models\Attributes;
use App\Models\Categories;
use App\Models\Feeds;
use App\Models\Groups;
use App\Models\Products;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Parser
{
    public function handleOffers(Request $request)
    {
        $filename = $request->name;
        $xml = simplexml_load_file(base_path('uploads/xml/feeds/') . $filename);
        $offers = $xml->shop->offers->offer;

        $countIteration = 1;
        $countFrom = $request->count_from;
        $countTo = $request->count_to;

        foreach ($offers as $offer) {
            $offerXML = $offer->asXML();

            $countIteration++;
            if ($countIteration < $countFrom) continue;
            if ($countIteration >= $countTo) break;

            $selectedOffers[] = self::offerToObject($offer);
            $selectedOffersXML[] = $offerXML;
        }

        return [
            'json' => $selectedOffers,
            'xml' => $selectedOffersXML
        ];
    }

    public function parseXml(Request $request)
    {
        $countIteration = 1;
        $countFrom = $request->count_from;
        $countTo = $request->count_to;
        $mode = $request->mode;


        $slug = $request->name;
        $xml = simplexml_load_file(base_path('uploads/xml/feeds/') . $slug . '.xml');
        $offers = $xml->shop->offers->offer;

        $parserFields = Feeds::where('slug', $slug)->select('parser')->first();
        $attributesGroups = Groups::all();

        $fields = json_decode($parserFields->parser);

        $functions = [
            'name' => $fields->offer_name,
            'desc_1' => $fields->offer_desc_1,
            'desc_2' => $fields->offer_desc_2,
            'price' => $fields->offer_price,
            'old_price' => $fields->offer_old,
            'image' => $fields->offer_img,
            'href' => $fields->offer_href,
            'uniq_id' => $fields->offer_uniq,
            'category' => $fields->offer_category
        ];

        $functionsAttributes = [];

        foreach ($attributesGroups as $group) {
            $groupSlug = $group->slug;
            $groupFunction = 'offer_'.$group->slug;
            $functionsAttributes[$groupFunction] = [
                'slug' => $groupSlug,
                'function' => $fields->$groupFunction
            ];
        }

        require_once base_path('uploads/functions/') . $slug . '.php';

        foreach ($offers as $offer) {
            $offerObj = self::offerToObject($offer);

            $offerName = $functions['name']($offerObj);
            $uniqId = $functions['uniq_id']($offerObj);
            $offerImg = $functions['image']($offerObj);
            $offerPrice = $functions['price']($offerObj);
            $offerOldPrice = $functions['old_price']($offerObj);
            $offerDiscount = $offerOldPrice ? ceil(($offerOldPrice - $offerPrice) / $offerOldPrice * 100) : null;
            $productCatsArr = $functions['category']($offerObj);
            $productAttributes = [];

            if (is_string($offerImg)) {
                $imagesArr[] = $offerImg;
                $offerImg = $imagesArr;
                unset($imagesArr);
            }

            foreach ($functionsAttributes as $function) {
                $attributeReturnedArray = $function['function']($offerObj);
                $groupId = Groups::where('slug', $function['slug'])->first()->id;



                if (!is_array($attributeReturnedArray)) $attributeReturnedArray = [$attributeReturnedArray];


                foreach ($attributeReturnedArray as $attributeReturnedValue) {
                    $attributeInBase = Attributes::where('group_id', $groupId)
                        ->where('name', $attributeReturnedValue)
                        ->pluck('id')->first();

                    if (empty($attributeInBase) && $attributeReturnedValue != null) {
                        $attributeInBase = Attributes::insertGetId(['group_id' => $groupId,
                            'name' => $attributeReturnedValue,
                            'slug' => SlugService::createSlug(Attributes::class, 'slug', $attributeReturnedValue),
                        ]);
                    }

                    $productAttributes[$function['slug']][] = $attributeInBase;
                }
            }

            $product = [
                'name' => $offerName,
                'uniq_id' => $uniqId,
                'description_1' => $functions['desc_1']($offerObj),
                'description_2' => $functions['desc_2']($offerObj),
                'price' => $offerPrice,
                'old_price' => $offerOldPrice,
                'image' => $offerImg,
                'href' => $functions['href']($offerObj),
                'parser_slug' => $slug,
                'rating' => rand(40, 50) / 10,
                'discount' => $offerDiscount
            ];

            if (Products::where('uniq_id', $uniqId)->exists()) {
                $productExistAttributes = json_decode(Products::where('uniq_id', $uniqId)->pluck('attributes')->first());
                $productMergedAttributes = array_merge_recursive((array)$productExistAttributes, (array)$productAttributes);
                $productMergedAttributes = array_map('array_unique', $productMergedAttributes);
                $product['attributes'] = json_encode($productMergedAttributes);
                $updatedProduct = Products::where('uniq_id', $uniqId)->first();
                $updatedProduct->update($product);
            } else {
                $product['slug'] = SlugService::createSlug(Products::class, 'slug', $offerName);
                $product['attributes'] = json_encode($productAttributes);
                $createdProduct = Products::create($product);

                foreach ($productCatsArr as $productCatEntry)
                {
                    $catId = Categories::where('name', $productCatEntry)->first()->id;
                    DB::table('category_product')->insert([
                        'category_id' => $catId,
                        'product_id' => $createdProduct->id,
                    ]);
                }
            }


            if ($mode) {
                $countIteration++;
                if ($countIteration < $countFrom) continue;
                if ($countIteration >= $countTo) break;
            }
        }
    }

    public function saveFunction(Request $request)
    {
        $content = $request->value;
        $filenamePHP = $request->filename;
        file_put_contents(base_path('uploads/functions/') . $filenamePHP, $content);
    }

    public function deleteAllGoods(Request $request)
    {
        $slug = $request->slug;
        Products::where('parser_slug', $slug)->forceDelete();
    }

    function offerToObject($offer){
        foreach ($offer->param as $param) $offer->addChild('params', $param->attributes());
        $offerObj = json_decode(json_encode($offer), true);
        $offerObj['attributes'] = $offerObj['@attributes'];
        $offerObj['param'] = array_combine($offerObj['params'], $offerObj['param']);
        unset($offerObj['@attributes'], $offerObj['params']);

        return $offerObj;
    }
}
