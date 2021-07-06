<?php

namespace App\Modules;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{

    public function downloadXml(Request $request)
    {

//        file_put_contents("Tmpfile.zip", fopen("http://someurl/file.zip", 'r'));
//
//        $request->validate(['file' => 'required|mimes:xml']);
//        $fileName = time() . '.' . $request->file->extension();
//        $request->file->move(base_path('uploads/xml/categories'), $fileName);

        return response()->json([
            'message' => 'XML feed uploaded',
//            'request' => $request->name
//            'filename' => $fileName,
//            'original' => $request->file->getClientOriginalName()
        ]);
    }

    public function parseHtml()
    {

    }

    public function parseXml()
    {

    }

}