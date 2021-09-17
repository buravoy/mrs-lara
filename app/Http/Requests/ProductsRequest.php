<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Products;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|string|max:255',
            'special_name' => 'bail|nullable|string|max:255',
            'description_1' => 'bail|nullable|string|max:65535',
            'description_2' => 'bail|nullable|string|max:65535',
            'price' => 'bail|nullable|integer|max:999999999',
            'old_price' => 'bail|nullable|integer|max:999999999',
            'discount' => 'bail|nullable|integer|max:100',
            'attributes' => 'bail|nullable|string|max:65535',
            'image' => 'bail|nullable|string|max:65535',
            'rating' => 'bail|nullable|numeric|max:5',

            'slug' => 'bail|nullable|string|max:255|unique:products,slug,'.request()->id,
            'meta_title' => 'bail|nullable|string|max:255',
            'meta_description' => 'bail|nullable|string|max:65535',
            'sort' => 'bail|integer|max:99999',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
