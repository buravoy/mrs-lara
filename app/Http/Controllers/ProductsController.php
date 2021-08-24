<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Groups;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index($slug = null)
    {
        if(!$slug) abort(404);

        $product = Products::where('slug', $slug)->first();
        $categoryId = CategoryProduct::where('product_id', $product->id)->first()->category_id;
        $category = Categories::where('id',$categoryId)->first();

        return view('product', [
            'product' => $product,
            'category' => $category
        ]);
    }

    public function away($slug = null)
    {
        if(!$slug) abort(404);

        $href = Products::where('slug', $slug)->value('href');

        return view('away', [
            'href' => $href
        ]);
    }


    public function getInfo(Request $request)
    {
        $productAttributes = json_decode($request->input('props'));
        $currentAttributes = [];

        foreach ($productAttributes as $key => $attribute) {
            $group = Groups::where('slug', $key)->first();

            $values = [];
            foreach ($attribute as $attr) if ($attr !== null)
                $values[] = Attributes::where('id', $attr)->value('name');

            if (!empty($values)) $currentAttributes[] = [
                'name' => $group->name,
                'value' => $values,
                'sort' => $group->sort
            ];
            unset($values);
        }
        return json_encode($currentAttributes);
    }
}
