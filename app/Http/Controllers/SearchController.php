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

        $separateString = explode(' ', $string);
        $resultsCategories = collect();
        $resultsAttributes = collect();

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
                        'text' => ucfirst($group->name) . ' '. ucfirst($attribute->name) . ' ' . $category->name,
                        'link' => 'filter/'.$category->slug . '/' . $group->slug . '_' . $attribute->slug
                    ];
                }
            }
        } else {
            foreach ($resultsCategories as $category) {
                $results[] = [
                    'text' => $category->name,
                    'link' => 'category/' . $category->slug
                ];
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
                'results' => self::query($query)
            ])->render()
        );
    }

    public function search()
    {



        return view('sections.search-ajax', [
            'results' => self::query($query),
            'query' => 'asdasd'

        ]);

    }
}
