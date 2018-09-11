<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequestForm extends FormRequest
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
        return [
            'first_name'        => 'nullable|string',
            'last_name'         => 'nullable|string',
            'bio' 				=> 'nullable|string',
            'about'             => 'nullable|string',
            'country' 			=> 'nullable|string',
            'phone' 			=> 'nullable|regex:/^[0-9]*$/',
            'city' 				=> 'nullable|string',
            'street'    		=> 'nullable|string',
        ];
    }
}
