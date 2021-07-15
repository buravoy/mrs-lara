<?php

namespace App\Modules;

use App\Models\Feeds;
use App\Models\Products;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

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
        $slug = $request->name;
        $xml = simplexml_load_file(base_path('uploads/xml/feeds/') . $slug . '.xml');
        $offers = $xml->shop->offers->offer;

        $parserFields = Feeds::where('slug', $slug)->select('parser')->first();
        $fields = json_decode($parserFields->parser);

        require_once base_path('uploads/functions/') . $slug . '.php';

        $count = 0;

        $productList = [];

        foreach ($offers as $offer) {
            $offerObj = self::offerToObject($offer);

            $functions = [
                'name' => $fields->offer_name,
                'desc_1' => $fields->offer_desc_1,
                'desc_2' => $fields->offer_desc_2,
                'price' => $fields->offer_price,
                'old_price' => $fields->offer_old,
                'image' => $fields->offer_img,
                'href' => $fields->offer_href,
                'uniq_id' => $fields->offer_uniq
            ];

            $offerName = $functions['name']($offerObj);
            $uniqId = $functions['uniq_id']($offerObj);


            $product = [
                'name' => $offerName,
                'uniq_id' => $uniqId,
                'description_1' => $functions['desc_1']($offerObj),
                'description_2' => $functions['desc_2']($offerObj),
                'price' => $functions['price']($offerObj),
                'old_price' => $functions['old_price']($offerObj),
                'image' => $functions['image']($offerObj),
                'href' => $functions['href']($offerObj),
            ];

            if (Products::where('uniq_id', $uniqId)->exists()) {
                Products::where('uniq_id', $uniqId)->update($product);
            } else {
                $product['slug'] = SlugService::createSlug(Products::class, 'slug', $offerName);
                Products::insert($product);
            }

            $productList[] = $product;
            if ($count++ > 20) break;
        }

        return $productList;
    }

    function offerToObject($offer){
        foreach ($offer->param as $param) $offer->addChild('params', $param->attributes());
        $offerObj = json_decode(json_encode($offer), true);
        $offerObj['attributes'] = $offerObj['@attributes'];
        $offerObj['param'] = array_combine($offerObj['params'], $offerObj['param']);
        unset($offerObj['@attributes'], $offerObj['params']);

        return $offerObj;
    }

    public function saveFunction(Request $request)
    {
        $content = $request->value;
        $filenamePHP = $request->filename;
        file_put_contents(base_path('uploads/functions/') . $filenamePHP, $content);
    }
}
