<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Self_;

class CategoriesController extends Controller
{
    public function index($slug = null)
    {
        $catIdWithChild = Categories::where('slug', $slug)->with('allChild')->get();
        $idArray = Arr::flatten(self::collectId($catIdWithChild));
        $productsId = CategoryProduct::whereIn('category_id', $idArray)->get('product_id');
        $products = Products::whereIn('id', $productsId)->get();

        return view('category', ['products' => $products]);
    }

    public function countProductsInCategory(Request $request)
    {
        $catId = $request->id;
        $categoriesWithChild = Categories::where('id', $catId)->with('allChild')->get();
        $idArray = Arr::flatten(self::collectId($categoriesWithChild));
        $productsCount = CategoryProduct::whereIn('category_id', $idArray)->count();
        Categories::where('id', $catId)->update([ 'count' => $productsCount ]);

        return response()->json($productsCount);
    }

    public static function countProductsInMenu() {
        $categoriesWithChild = Categories::where('show', true)->with('allChild')->get();

        foreach ($categoriesWithChild as $category_1) {

            if(!empty($category_1->allChild)) {
                foreach ($category_1->allChild as $category_2) {

                    if(!empty($category_2->allChild)) {
                        foreach ($category_2->allChild as $category_3) {
                            $idArray_3 = Arr::flatten(CategoriesController::collectId(collect([$category_3])));
                            $catId_3 = $category_3->id;
                            $catCount_3 = CategoryProduct::whereIn('category_id', $idArray_3)->count();
                            Categories::where('id', $catId_3)->update([ 'count' => $catCount_3 ]);
                        }
                    }

                    $idArray_2 = Arr::flatten(CategoriesController::collectId(collect([$category_2])));
                    $catId_2 = $category_2->id;
                    $catCount_2 = CategoryProduct::whereIn('category_id', $idArray_2)->count();
                    Categories::where('id', $catId_2)->update([ 'count' => $catCount_2 ]);
                }
            }
            $idArray_1 = Arr::flatten(CategoriesController::collectId(collect([$category_1])));
            $catId_1 = $category_1->id;
            $catCount_1 = CategoryProduct::whereIn('category_id', $idArray_1)->count();
            Categories::where('id', $catId_1)->update([ 'count' => $catCount_1 ]);
        }

        return true;
    }

    static function collectId($collection){
        $arr = [];
        foreach ($collection as $item) {
            if(isset($item->id)) $arr[] = $item->id;
            if(!empty($item->allChild)) $arr[] = self::collectId($item->allChild);
        }
        return $arr;
    }
}
