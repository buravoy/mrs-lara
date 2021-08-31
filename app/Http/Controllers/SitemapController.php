<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;

class SitemapController extends Controller
{
    public function index()
    {
        $categoriesCount = Categories::all()->count();
        $categoriesSitemapCount = ceil($categoriesCount / 10000);

        $productCount = Products::all()->count();
        $productSitemapCount = ceil($productCount / 10000);

        $content =  view('sitemap', [
            'type' => 'sitemap',
            'links' => [
                'categories' => $categoriesSitemapCount,
                'products' => $productSitemapCount
            ],
        ]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function categories($page = 1)
    {
        $skip = 10000 * ($page - 1);

        $categories = Categories::all()->pluck('slug')->skip($skip)->take(10000);
        $content =  view('sitemap', [
            'type' => 'category',
            'links' => $categories
        ]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function products($page = 1)
    {
        $skip = 10000 * ($page - 1);

        $products = Products::all()->pluck('slug')->skip($skip)->take(10000);
        $content =  view('sitemap', [
            'type' => 'product',
            'links' => $products
        ]);



        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
}
