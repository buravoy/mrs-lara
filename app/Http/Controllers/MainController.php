<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $categoriesController = new CategoriesController();

        $categories = Categories::where('parent_id', null)->get();



        return view('home', [
            'categories' => $categories
        ]);
    }
}
