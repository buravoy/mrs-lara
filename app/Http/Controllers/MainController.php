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

        $categories = Categories::where('show', true)
            ->orderBy('sort', 'asc')
            ->get();

        return view('home', [
            'categories' => $categories
        ]);
    }
}
