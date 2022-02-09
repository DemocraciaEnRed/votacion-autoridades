<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlateRequest extends FormRequest
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
            'description' => 'nullable|string',
            'logo' => 'nullable|image',
            'link' => 'nullable|url',
            'order' => 'nullable|numeric',
            'blocks' => 'nullable|array',
            'blocks.*' => 'required|integer|exists:blocks,id',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->order == '') {
            $this->merge(['order' => 0]);
        }
    }
}
