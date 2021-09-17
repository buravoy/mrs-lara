<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;

class RssController extends Controller
{
    public function index() {
        $content =  view('rss.index', [
            'data' => Products::take(15)->orderBy('updated_at')->get()
        ]);

        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function categories()
    {

        $content =  view('rss.index', [
            '$data' => null
        ]);

        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function products()
    {
        $content =  view('rss.index', [
            '$data' => $categories
        ]);

        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
}
