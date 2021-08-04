<?php

namespace App\Http\Controllers;

use App\Models\Categories;

class MainController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
