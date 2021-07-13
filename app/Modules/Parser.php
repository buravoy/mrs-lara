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
        $countLimit = $request->count;

        foreach ($offers as $offer) {
            $offerXML = $offer->asXML();

            foreach ($offer->param as $param) $offer->addChild('params', $param->attributes());
            if ($countIteration++ > $countLimit) break;

            $selectedOffers[] = $offer;
            $selectedOffersXML[] = $offerXML;
        }

        $selectedOffers = json_decode(json_encode($selectedOffers), true);

        $selectedOffers = array_map(function ($offer) {
            $offer['attributes'] = $offer['@attributes'];
            $offer['param'] = array_combine($offer['params'], $offer['param']);
            unset($offer['@attributes'], $offer['params']);

            return $offer;
        }, $selectedOffers);

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

            $offerName = $functions['name']($offer);
            $slug = SlugService::createSlug(Products::class, 'slug', $offerName);
            $uniqId = $functions['uniq_id']($offer);

            $product = [
                'name' => $offerName,
                'slug' => $slug,
                'uniq_id' => $uniqId,
                'description_1' => $functions['desc_1']($offer),
                'description_2' => $functions['desc_2']($offer),
                'price' => $functions['price']($offer),
                'old_price' => $functions['old_price']($offer),
                'image' => $functions['image']($offer),
                'href' => $functions['href']($offer),
            ];

//            if (Products::where('uniq_id', $uniqId)->exists()) {
//                Products::where('uniq_id', $uniqId)->update($product);
//            } else {
//                Products::insert($product);
//            }

            $productList[] = $product;
            if ($count++ > 20) break;
        }


        return $productList;
    }


//    public function parseXml(Request $request)
//    {
//        $slug = $request->name;
//        $filename = $slug.'.xml';
//        $xml = simplexml_load_file( base_path('uploads/xml/feeds/').$filename );
//        $offers = $xml->shop->offers->offer;
//
//        $parserFields = Feeds::where('slug', $slug)->select('parser')->first();
//
//        $fields = json_decode($parserFields->parser);
//
//        $uniq = explode(';', $fields->offer_uniq);
//
//
//        return $productList;
//    }

    public function saveFunction(Request $request)
    {
        $content = $request->value;
        $filenamePHP = $request->filename;
        file_put_contents(base_path('uploads/functions/') . $filenamePHP, $content);
    }
}
