<?php

namespace App\Modules;

use App\Models\Feeds;
use App\Models\Products;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class Parser
{
    public function handleOffers(Request $request){
        $filename = $request->name;
        $xml = simplexml_load_file( base_path('uploads/xml/feeds/').$filename );
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

        $selectedOffers = array_map(function($offer) {
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
//        $filename = $slug.'.xml';
        $parserConfig = Feeds::where('slug', $slug)->select('parser')->first();
//
////        $xml = simplexml_load_file( base_path('uploads/xml/feeds/').$filename );
////        $offers = $xml->shop->offers->offer;
//

        $fields = json_decode($parserConfig->parser);



        return $parserConfig;
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
//        $count = 0;
//
//        $productList = [];
//
//        foreach ($offers as $offer) {
//            $uniqId = [];
//
//            foreach ($uniq as $param) {
//                if (strpos($param, '@')) {
//                    $offerTag = substr($param, 0, strpos($param, '@'));
//                    $tagAttr = substr($param, strpos($param, '@') + 1);
//
//                    if ($offerTag == 'offer') {
//                        $uniqId[] = (string)$offer->attributes()->{$tagAttr};
//                        continue;
//                    }
//
//                    $uniqId[] = (string)$offer->{$offerTag}->attributes()->{$tagAttr};
//                    continue;
//                }
//
//                $uniqId[] = (string)$offer->{$param};
//            }
//
//            $uniqId = implode('_', $uniqId);
//            $offerName = (string)$offer->{$fields->offer_name};
//            $offerDesc = (string)$offer->{$fields->offer_desc};
//            $offerPrice = (double)$offer->{$fields->offer_price};
//            $offerOldPrice = $offer->{$fields->offer_old} ? (double)$offer->{$fields->offer_old} : null;
//            $offerImages = json_encode((array)$offer->{$fields->offer_img});
//            $offerUrl = (string)$offer->{$fields->offer_href};
//            $slug = SlugService::createSlug(Products::class, 'slug', $offerName);
//
//            $product = [
//                'name' => $offerName,
//                'description' => $offerDesc,
//                'price' => $offerPrice,
//                'old_price' => $offerOldPrice,
//                'image' => $offerImages,
//                'href' => $offerUrl,
//                'slug' => $slug,
//                'uniq_id' => $uniqId
//            ];
//
//            if (Products::where('uniq_id', $uniqId)->exists()) {
//                Products::where('uniq_id', $uniqId)->update($product);
//            } else {
//                Products::insert($product);
//            }
//
//            $productList[] = $product;
//            if ($count++ > 20) break;
//        }
//
//        return $productList;
//    }

    public function saveFunction (Request $request) {
        $content = $request->value;
        $filenamePHP = $request->filename;
        file_put_contents( base_path('uploads/functions/').$filenamePHP, $content);
    }
}
