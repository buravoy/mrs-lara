<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Modules\Functions;
use App\Modules\Generator;

class RssController extends Controller
{
    public function categories()
    {

        $content =  view('rss.index', [
            '$data' => null
        ]);

        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function products($category = null)
    {
        if(!$category || !Categories::where('slug', $category)->exists()) abort(404);



        $productsData = Functions::productsData($category);
        $productsQuery = $productsData['query'];
        $products = $productsQuery->orderBy('updated_at', 'desc')->take(1000)->get();

        $content =  view('rss.products', [
            'data' => $products
        ]);

        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
}
