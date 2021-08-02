<?php

namespace App\Http\Controllers;

use App\Models\Categories;

class MainController extends Controller
{
    public function index()
    {
        $categories = Categories::where('show', true)
            ->orderBy('sort', 'asc')
            ->get();



        return view('home', [
            'categories' => $categories
        ]);
    }
}
