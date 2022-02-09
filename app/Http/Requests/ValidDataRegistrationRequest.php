<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidDataRegistrationRequest extends FormRequest
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
            'name' => 'required|string',
            'last_name' => 'required|string',
            'dni' => 'required|string',
            'email' => 'required|confirmed|email|unique:users,email,NULL,id,deleted_at,NULL',
            'email_confirmation' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|confirmed',
        ];
    }
}
