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
        $results = [];

        $separateString = explode(' ', mb_strtolower($string));
        $resultsCategories = collect();
        $resultsAttributes = collect();
        $results = [];

        foreach ($separateString as $part) {
            $seekCategories = Categories::where('name', 'LIKE', '%' . $part . '%')->where('count', '>', 0 )->get();
            $seekAttributes = Attributes::where('name', 'LIKE', '%' . $part . '%')->get();

            if ($seekCategories->isNotEmpty())
                foreach ($seekCategories as $seekCategory)
                    $resultsCategories->push($seekCategory);

            if ($seekAttributes->isNotEmpty())
                foreach ($seekAttributes as $seekAttribute)
                    $resultsAttributes->push($seekAttribute);
        }
        $resultsCategories = $resultsCategories->unique();
        $resultsAttributes = $resultsAttributes->unique();

        if($resultsAttributes->isNotEmpty()) {
            foreach ($resultsCategories as $category) {
                foreach ($resultsAttributes as $attribute) {
                    $group = Groups::where('id', $attribute->group_id)->first();
                    $results[] = [
                        'text' => mb_strtolower($group->name) . ' '. mb_strtolower($attribute->name) . ' ' . mb_strtolower($category->name),
                        'link' => 'filter/'.$category->slug . '/' . $group->slug . '_' . $attribute->slug
                    ];
                }
            }
        } else {
            foreach ($resultsCategories as $category) {
                $results[] = [
                    'text' => mb_strtolower($category->name),
                    'link' => 'category/' . mb_strtolower($category->slug)
                ];
            }
        }

        foreach ($results as $key => $result) {
            foreach ($separateString as $word) {
                if (strpos($result['text'], $word)) {
                    $results[$key]['text'] = str_replace($word, '<span>'.$word.'</span>', $results[$key]['text']);
                }
            }
        }

        $sort  = array_column($results, 'text');
        array_multisort($sort, SORT_ASC, $results);

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
