<?php

namespace App\Modules;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    public function handleOffers(Request $request){
        $filename = $request->name;
        $xml = simplexml_load_file( base_path('uploads/xml/feeds/').$filename );
        $offers = $xml->shop->offers->offer;
        $countIteration = 0;

        foreach ($offers as $key => $offer) {
            foreach ($offer->param as $param) $offer->addChild('params', $param->attributes());
            if ($countIteration++ > 99) break;
            $selectedOffers[] = $offer;
        }

        $selectedOffers = json_decode(json_encode($selectedOffers), true);

        $selectedOffers = array_map(function($offer) {
            $offer['attributes'] = $offer['@attributes'];
            $offer['param'] = array_combine($offer['params'], $offer['param']);
            unset($offer['@attributes'], $offer['params']);

            return $offer;
        }, $selectedOffers);

        return $selectedOffers;
    }


    public function parseXml(Request $request)
    {
        $filename = $request->name;
        $xml = simplexml_load_file( base_path('uploads/xml/feeds/').$filename );
        $offers = $xml->shop->offers->offer;

        foreach ($offers as $key => $offer) {

        }

        return $filename;
    }

}
