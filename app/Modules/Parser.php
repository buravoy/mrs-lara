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

        $selectedOffers = [];
        $countIteration = 0;

        foreach ($offers as $key => $offer) {
            foreach ($offer->param as $param) {
                $offer->addChild('params', $param->attributes());
            }
            if ($countIteration++ > 100) break;

            $selectedOffers[] = $offer;
        }




        return $selectedOffers;
    }

    public function parseHtml()
    {

    }

    public function parseXml()
    {

    }

}
