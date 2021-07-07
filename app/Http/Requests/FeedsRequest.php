<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class FeedsRequest extends FormRequest
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
            'xml_url' => 'bail|required|string|max:max:65535',

            'parser' => 'bail|nullable|string|max:max:65535',
            'rules' => 'bail|nullable|string|max:max:65535',
            'schedule' => 'bail|nullable|string|max:max:65535',
            'last_update' => 'bail|nullable|string|max:max:65535',

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
