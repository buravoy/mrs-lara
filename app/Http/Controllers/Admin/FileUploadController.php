<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class FileUploadController
{
    public function categoryXmlPostUpload(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xml']);
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(base_path('uploads/xml/categories'), $fileName);
        return response()->json([
            'message' => 'Categories XML file uploaded',
            'filename' => $fileName,
            'original' => $request->file->getClientOriginalName()
        ]);
    }

    public function getSize(Request $request)
    {
        $filename = $request->name . '.xml';

        return response()->json([
            'localSize' => number_format( (filesize(base_path('uploads/xml/feeds/').$filename)/1024/1024), 2, ',', ' ')
        ]);
    }

    public function downloadXml(Request $request)
    {
        $filenameXML = $request->name . '.xml';
        $filenamePHP = $request->name . '.php';
        $link = $request->link;

        file_put_contents( base_path('uploads/xml/feeds/').$filenameXML, fopen($link, 'r'));

        if (!file_exists(base_path('uploads/functions/').$filenamePHP)) {
            $base = file_get_contents(base_path('uploads/functions/sample.php'));
            file_put_contents( base_path('uploads/functions/').$filenamePHP, $base);
        }

        return true;
    }
}