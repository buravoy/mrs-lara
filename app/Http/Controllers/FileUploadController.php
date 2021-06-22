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
}