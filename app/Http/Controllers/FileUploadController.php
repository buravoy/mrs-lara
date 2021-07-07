<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
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
        $filename = $request->name . '.xml';
        $link = $request->link;
        file_put_contents( base_path('uploads/xml/feeds/').$filename, fopen($link, 'r'));

        return response()->json([
            'message' => 'XML feed uploaded',
        ]);
    }

}