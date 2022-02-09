<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCandidateRequest extends FormRequest
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
            'position_id' => 'required|integer|exists:positions,id',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'photo' => 'nullable|image',
            'link' => 'nullable|url',
            'order' => 'nullable|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->order == '') {
            $this->merge(['order' => 0]);
        }
    }
}
