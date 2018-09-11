<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Rules\EmailValidation;

class RegisterRequest extends FormRequest
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
            'username' => [
                'required', 'min:6', 'max:32', 'string', 'regex:/^[a-zA-Z0-9-_.]*$/', 'unique:users,username',
            ],
            'email'        => ['unique:users,email', new EmailValidation()],
            'password'     => 'required|string|confirmed|min:8|max:32',
        ];
    }
}
