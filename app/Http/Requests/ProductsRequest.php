<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

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
            'category_id' => 'bail|nullable|integer|max:255',
            'description' => 'bail|nullable|string|max:65535',
            'price' => 'bail|nullable|integer|max:999999999',
            'old_price' => 'bail|nullable|integer|max:999999999',
            'discount' => 'bail|nullable|integer|max:100',
            'attributes' => 'bail|nullable|string|max:65535',
            'image' => 'bail|nullable|string|max:65535',

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
