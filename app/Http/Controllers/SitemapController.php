<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Livewire\Response;

class SitemapController extends Controller
{
    public function index()
    {


        $content =  view('sitemap', [
            'type' => 'sitemap',
            'links' => ['categories', 'products'],
        ]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function categories()
    {
        $categories = Categories::all()->pluck('slug');
        $content =  view('sitemap', [
            'type' => 'categories',
            'links' => $categories
        ]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function products($count = null)
    {
        $products = Products::all()->pluck('slug');
        $content =  view('sitemap', [
            'type' => 'product',
            'links' => $products
        ]);



        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
}
