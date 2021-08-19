<?php

namespace App\Http\Controllers;

use App\Models\MetaGenerators;
use Illuminate\Http\Request;

class MetaGeneratorController
{
    public function index()
    {

        $generators = MetaGenerators::all();


        return view('vendor.backpack.base.generators', ['generators' => $generators]);
    }


    public function save(Request $request)
    {

        \Alert::add('result', $request);

        return json_encode($request);
    }
}
