<?php

namespace App\Http\Controllers\Admin;

use App\Models\MetaGenerators;
use Illuminate\Http\Request;

class MetaGeneratorController
{
    public function index()
    {

        $generators = MetaGenerators::all()->sortBy('name');


        return view('vendor.backpack.base.generators', ['generators' => $generators]);
    }


    public function save(Request $request)
    {
        $type = $request->type;
        $templateMetaTitle = $request->template_meta_title;
        $templateMetaDescription = $request->template_meta_description;
        $templateTitle = $request->template_title;
        $templateDescription1 = $request->template_description1;
        $templateDescription2 = $request->template_description2;

        MetaGenerators::where('type', $type)->update([
            'template_meta_title' => $templateMetaTitle,
            'template_meta_description' => $templateMetaDescription,
            'template_title' => $templateTitle,
            'template_description1' => $templateDescription1,
            'template_description2' => $templateDescription2
        ]);

        return json_encode(ucfirst($type) . ' сохранено');
    }
}
