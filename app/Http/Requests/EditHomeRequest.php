<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditHomeRequest extends FormRequest
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
            'extra_information' => 'nullable|string',
            'filename' => 'nullable|string',
            'file' => 'nullable|file',
        ];
    }
}
