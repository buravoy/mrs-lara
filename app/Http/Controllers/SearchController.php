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
        $results = ['categories'=>[], 'products'=>[]];

        foreach ($separateString as $part) {
            $seekCategories = Categories::where('name', 'LIKE', '%' . $part . '%')->where('count', '>', 0 )->orderBy('count')->get();
            $seekAttributes = Attributes::with('group')->where('name', 'LIKE', '%' . $part . '%')->get();

            if ($seekCategories->isNotEmpty())
                foreach ($seekCategories as $seekCategory)
                    $resultsCategories->push($seekCategory);

            if ($seekAttributes->isNotEmpty())
                foreach ($seekAttributes as $seekAttribute)
                    $resultsAttributes->push($seekAttribute);
        }
        $resultsCategories = $resultsCategories->unique();
        $resultsAttributes = $resultsAttributes->unique();

        if($resultsAttributes->isNotEmpty() && $resultsCategories->isNotEmpty()) {
            foreach ($resultsCategories as $category) {
                foreach ($resultsAttributes as $attribute) {
                    $group = Groups::where('id', $attribute->group_id)->first();
                    $results['categories'][] = [
                        'text' => mb_strtolower($group->name) . ' '. mb_strtolower($attribute->name) . ' ' . mb_strtolower($category->name),
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
            $allCategories = Categories::where('count', '>', 0 )->get();


            foreach ($resultsAttributes as $attribute) {
                $group = Groups::where('id', $attribute->group_id)->first();

                $products = Products::with('category')->where(function($query) use($attribute, $group) {
                    $query->whereJsonContains('attributes->' . $group->slug , $attribute->id);
                })->get();

                dd($products);
                foreach ($products as $product) {

//                    if($category->products->attributes)

                    $results['categories'][] = [
                        'text' => mb_strtolower($group->name) . ' '. mb_strtolower($attribute->name) . ' ' . mb_strtolower($category->name),
                        'link' => 'filter/'.$category->slug . '/' . $group->slug . '_' . $attribute->slug
                    ];
                }
            }

        }

        foreach ($results['categories'] as $key => $result) {
            foreach ($separateString as $word) {
                if (strpos($result['text'], $word)) {
                    $results['categories'][$key]['text'] = str_replace($word, '<span>'.$word.'</span>', $results['categories'][$key]['text']);
                }
            }
        }

//        $sort  = array_column($results['categories'], 'text');
//        array_multisort($sort, SORT_ASC, $results['categories']);

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
