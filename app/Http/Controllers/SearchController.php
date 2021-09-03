<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Categories;
use App\Models\Groups;
use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function query($string)
    {
        $separateString = explode(' ', mb_strtolower($string));
        $resultsCategories = collect();
        $resultsAttributes = collect();
        $resultsProducts = collect();
        $results = ['categories'=>[], 'products'=>[]];

        foreach ($separateString as $part) {
            if (mb_strlen($part) > 3) {
                $seekCategories = Categories::where('name', 'LIKE', '%' . $part . '%')->where('count', '>', 0)
                    ->orderBy('count')->orderBy('name')
                    ->get();

                $seekAttributes = Attributes::with(['group' => function ($query) {
                    $query->orderBy('sort');
                }])->where('name', 'LIKE', '%' . $part . '%')->get();

                $seekProducts = Products::where('name', 'LIKE', '%' . $part . '%')->take(10)->get();

                if ($seekProducts->isNotEmpty())
                    foreach ($seekProducts as $seekProduct)
                        $resultsProducts->push($seekProduct);


                if ($seekCategories->isNotEmpty())
                    foreach ($seekCategories as $seekCategory)
                        $resultsCategories->push($seekCategory);

                if ($seekAttributes->isNotEmpty())
                    foreach ($seekAttributes as $seekAttribute)
                        $resultsAttributes->push($seekAttribute);
            }
        }

        $resultsCategories = $resultsCategories->unique('id');
        $resultsAttributes = $resultsAttributes->unique('name');
        $resultsProducts = $resultsProducts->unique('id');

        if ($resultsProducts->isNotEmpty()) {
            foreach ($resultsProducts as $resultsProduct) {
                $results['products'][] = [
                    'text' => mb_strtolower($resultsProduct->name),
                    'link' => 'product/' . mb_strtolower($resultsProduct->slug)
                ];
            }
        }

        if($resultsAttributes->isNotEmpty() && $resultsCategories->isNotEmpty()) {
            foreach ($resultsCategories as $category) {
                foreach ($resultsAttributes as $attribute) {
                    $group = Groups::where('id', $attribute->group_id)->first();
                    $results['categories'][] = [
                        'text' => mb_strtolower($attribute->name) . ' ' . mb_strtolower($category->name),
                        'link' => 'filter/'.$category->slug . '/' . $group->slug . '_' . $attribute->slug
                    ];
                }
            }
        }

        if ($resultsAttributes->isEmpty() && $resultsCategories->isNotEmpty()) {
            foreach ($resultsCategories as $category) {
                $results['categories'][] = [
                    'text' => mb_strtolower($category->name),
                    'link' => 'category/' . mb_strtolower($category->slug)
                ];
            }
        }

        if ($resultsAttributes->isNotEmpty() && $resultsCategories->isEmpty()) {
            foreach ($resultsAttributes as $attribute) {
                $group = Groups::where('id', $attribute->group_id)->first();

                $allCategories = Categories::where('count', '>', 0 )->with(['products' => function($query) use($attribute, $group){
                    $query->whereJsonContains('attributes->' . $group->slug , $attribute->id);
                }])->orderBy('count', 'desc')->get();

                $allCategories = $allCategories->filter(function ($value) {
                    return $value->products->isNotEmpty();
                });
                foreach ($allCategories as $category) {
                    $results['categories'][] = [
                        'text' => mb_strtolower($attribute->name) . '&nbsp;' . mb_strtolower($category->name),
                        'link' => 'filter/'.$category->slug . '/' . $group->slug . '_' . $attribute->slug
                    ];
                }
            }

        }

        foreach ($results['categories'] as $key => $result) {
            foreach ($separateString as $word) {
                if (strpos($result['text'], $word) !== false) {
                    $results['categories'][$key]['text'] = str_replace($word, '<span>'.$word.'</span>', $results['categories'][$key]['text']);
                }
            }
        }

        foreach ($results['products'] as $key => $result) {
            foreach ($separateString as $word) {
                if (strpos($result['text'], $word) !== false) {
                    $results['products'][$key]['text'] = str_replace($word, '<span>'.$word.'</span>', $results['products'][$key]['text']);
                }
            }
        }

        return $results;
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->string;

        return json_encode(
            view('sections.search-ajax', [
                'results' => self::query($query),
            ])->render()
        );
    }

    public function search(Request $request)
    {
        $query = $request->search;

        return view('search', [
            'results' => self::query($query),
            'query' => $query
        ]);

    }
}
