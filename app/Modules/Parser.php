<?php

namespace App\Modules;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{

    public function getSize(Request $request)
    {
        $filename = $request->name . '.xml';

        return response()->json([
            'localSize' => number_format( (filesize(base_path('uploads/xml/feeds/').$filename)/1024/1024), 2, ',', ' ')
        ]);
    }

    public function downloadXml(Request $request)
    {
        $filename = $request->name . '.xml';
        $link = $request->link;
        file_put_contents( base_path('uploads/xml/feeds/').$filename, fopen($link, 'r'));

        return response()->json([
            'message' => 'XML feed uploaded',
        ]);
    }

    public function parseHtml()
    {

    }

    public function parseXml()
    {

    }

}
