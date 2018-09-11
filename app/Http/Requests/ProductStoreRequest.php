<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (filter_var(request('photo'), FILTER_VALIDATE_URL)) {
            $photoRules = 'required|string';
        } else {
            $photoRules = 'required|file|mimes:jpg,jpeg,png|max:1024*4';
        }

        return [
            'title' => 'required|string|min:8|max:50|unique:products',
            'description' => 'required|min:50|max:8000|:regex:/^[a-zA-Z0-9_- ]*$/',
            'stock' => 'required|regex:/^[0-9]*$/',
            'price' => 'required|regex:/^[0-9]*$/',
            'photo' => $photoRules,
        ];
    }

    public function messages()
    {
        return [
            'photo.max' => 'The photo must be less than 4 megabytes'
        ];
    }
}