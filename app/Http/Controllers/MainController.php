<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Collection;

class MainController extends Controller
{
    public function index()
    {
        $collections = Collection::orderBy('sort')->get();

        return view('home', [
            'collections' => $collections,
        ]);
    }
}
