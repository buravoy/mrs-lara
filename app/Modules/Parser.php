<?php

namespace App\Modules;

use App\Http\Controllers\CategoriesController;
use App\Models\Attributes;
use App\Models\Categories;
use App\Models\CategoryProduct;
use App\Models\Feeds;
use App\Models\Groups;
use App\Models\Products;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class Parser
{
    public function handleOffers(Request $request): array
    {
        $filename = $request->name;
        $xml = simplexml_load_file(base_path('uploads/xml/feeds/') . $filename);
        $offers = $xml->shop->offers->offer;

        $countIteration = 1;
        $countFrom = $request->count_from;
        $countTo = $request->count_to;

        foreach ($offers as $offer) {
            $offerXML = $offer->asXML();

            $countIteration++;
            if ($countIteration < $countFrom) continue;
            if ($countIteration >= $countTo) break;

            $selectedOffers[] = self::offerToObject($offer);
            $selectedOffersXML[] = $offerXML;
        }



        return [
            'json' => $selectedOffers,
            'xml' => $selectedOffersXML
        ];
    }

    public static function parse($slug, $mode, $countFrom, $countTo, $requestType = null)
    {
        $countIteration = 0;
        $filenameXML = $slug . '.xml';
        $oldXml = simplexml_load_file(base_path('uploads/xml/feeds/') . $slug . '.xml');
        $oldDate = Carbon::parse((string)$oldXml->attributes()->date)->format('Y-m-d H:i:s');

        $parserFields = Feeds::where('slug', $slug)->first();
        $link = $parserFields->xml_url;
        file_put_contents( base_path('uploads/xml/feeds/') . $filenameXML, fopen($link, 'r'));
        $xml = simplexml_load_file(base_path('uploads/xml/feeds/') . $slug . '.xml');

        $newDate = Carbon::parse((string)$xml->attributes()->date)->format('Y-m-d H:i:s');

        if ($newDate == $oldDate && $requestType == 'update') return true;

        $offers = $xml->shop->offers->offer;
        $attributesGroups = Groups::all();
        $fields = (array)json_decode($parserFields->parser);

        $functions = [
            'name' => $fields['offer_name'],
            'desc_1' => $fields['offer_desc_1'],
            'desc_2' => $fields['offer_desc_2'],
            'price' => $fields['offer_price'],
            'old_price' => $fields['offer_old'],
            'image' => $fields['offer_img'],
            'href' => $fields['offer_href'],
            'uniq_id' => $fields['offer_uniq'],
            'category' => $fields['offer_category']
        ];

        if(isset($fields['offer_available'])) $functions['available'] = $fields['offer_available'];

        $functionsAttributes = [];

        foreach ($attributesGroups as $attributeGroup) {
            if(isset( $fields['offer_'.$attributeGroup->slug] )) {
                $functionsAttributes['offer_'.$attributeGroup->slug] = [
                    'slug' => $attributeGroup->slug,
                    'function' => $fields['offer_'.$attributeGroup->slug]
                ];
            }
        }

        require_once base_path('uploads/functions/') . $slug . '.php';

        foreach ($offers as $offer) {
            $offerObj = self::offerToObject($offer);

            $offerName = $functions['name']($offerObj);
            $uniqId = $functions['uniq_id']($offerObj);
            $offerImg = $functions['image']($offerObj);
            $offerPrice = $functions['price']($offerObj);
            $offerOldPrice = $functions['old_price']($offerObj);
            $offerDiscount = $offerOldPrice ? ceil(($offerOldPrice - $offerPrice) / $offerOldPrice * 100) : null;
            $productCatsArr = $functions['category']($offerObj);

            if(isset($fields['offer_available'])) {
                $functions['available'] = $fields['offer_available'];
                $productAvailable = $functions['available']($offerObj);
            }


            $productAttributes = [];

            if (is_string($offerImg)) {
                $imagesArr[] = $offerImg;
                $offerImg = $imagesArr;
                unset($imagesArr);
            }

            foreach ($functionsAttributes as $function) {
                $attributeReturnedArray = $function['function']($offerObj);
                $groupId = Groups::where('slug', $function['slug'])->first()->id;

                if (!is_array($attributeReturnedArray)) $attributeReturnedArray = [$attributeReturnedArray];

                foreach ($attributeReturnedArray as $attributeReturnedValue) {

                    $attributeInBase = Attributes::where('group_id', $groupId)
                        ->where('name', $attributeReturnedValue)
                        ->pluck('id')->first();

                    if (empty($attributeInBase) && $attributeReturnedValue != null) {
                        $attributeInBase = Attributes::insertGetId([
                            'group_id' => $groupId,
                            'name' => $attributeReturnedValue,
                            'creator' => $parserFields->name,
                            'slug' => SlugService::createSlug(Attributes::class, 'slug', $attributeReturnedValue),
                        ]);
                    }

                    if ($attributeInBase != null) {
                        $productAttributes[$function['slug']][] = $attributeInBase;
                    }
                }
            }

            $product = [
                'name' => $offerName,
                'uniq_id' => $uniqId,
                'description_1' => $functions['desc_1']($offerObj),
                'description_2' => $functions['desc_2']($offerObj),
                'price' => $offerPrice,
                'old_price' => $offerOldPrice,
                'image' => $offerImg,
                'href' => $functions['href']($offerObj),
                'parser_slug' => $slug,
                'rating' => rand(40, 50) / 10,
                'discount' => $offerDiscount,
                'deleted_at' => null
            ];

            if(isset($productAvailable) && !$productAvailable) $product['deleted_at'] = now();

            if (Products::where('uniq_id', $uniqId)->exists()) {
                $productExistAttributes = json_decode(Products::where('uniq_id', $uniqId)->pluck('attributes')->first());
                $productMergedAttributes = array_merge_recursive((array)$productExistAttributes, (array)$productAttributes);
                $productMergedAttributes = array_map('array_unique', $productMergedAttributes);
                $product['attributes'] = json_encode($productMergedAttributes);
                $updatedProduct = Products::where('uniq_id', $uniqId)->first();

                $updatedProduct->update($product);

                self::insertProductCategory($productCatsArr, $updatedProduct);

            } else {
                $product['slug'] = SlugService::createSlug(Products::class, 'slug', $offerName);
                $product['attributes'] = json_encode($productAttributes);
                $createdProduct = Products::create($product);

                self::insertProductCategory($productCatsArr, $createdProduct);
            }


            if ($mode == 'true') {
                $countIteration++;
                if ($countIteration <= $countFrom) continue;
                if ($countIteration > $countTo) break;
            }
        }

        $date = new \DateTime();
        $date->modify('-120 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        Products::where('parser_slug', $slug)
            ->where('updated_at','<=', $formatted_date)
            ->update(['deleted_at' => now()]);

        if($requestType == 'update') CategoriesController::countAllProductsInCategories();

        Feeds::where('slug', $slug)->update(['last_update' => now()]);
        return true;
    }

    public function parseXml(Request $request): bool
    {
        $countFrom = $request->count_from ?? 0;
        $countTo = $request->count_to ?? 100;
        $mode = $request->mode;

        $slug = $request->name;

        self::parse($slug, $mode, $countFrom, $countTo);

        return true;
    }

    public function saveFunction(Request $request)
    {
        $content = $request->value;
        $filenamePHP = $request->filename;
        file_put_contents(base_path('uploads/functions/') . $filenamePHP, $content);
    }

    public function deleteAllGoods(Request $request)
    {
        $slug = $request->slug;
        Products::where('parser_slug', $slug)->forceDelete();
    }

    static function offerToObject($offer){
        $offerArr = json_decode(json_encode($offer), true);
        $offerArr['attributes'] = $offerArr['@attributes'];
        unset($offerArr['@attributes'], $offerArr['param']);

        $paramsObj = [];

        foreach ($offer->param as $singleParam) {
            $singleParam = json_decode(json_encode($singleParam), true);
            $paramsObj[$singleParam['@attributes']['name']] = $singleParam['@attributes'];
            $paramsObj[$singleParam['@attributes']['name']]['val_'] = $singleParam[0];
            $offerArr['params'] = $paramsObj;
        }

        return $offerArr;
    }

    static function insertProductCategory($productCatsArr, $product) {

        CategoryProduct::where('product_id', $product->id)->forceDelete();

        foreach ($productCatsArr as $productCatEntry)
        {
            $catId = Categories::where('name', $productCatEntry)->first()->id ?? false;

            if($catId) {
                CategoryProduct::insert([
                    'category_id' => $catId,
                    'product_id' => $product->id,
                ]);
            } else {
                $newCatId = Categories::insertGetId([
                    'name' => $productCatEntry,
                    'slug' => SlugService::createSlug(Categories::class, 'slug', $productCatEntry),
                ]);

                CategoryProduct::insert([
                    'category_id' => $newCatId,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
