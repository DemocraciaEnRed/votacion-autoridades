<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserVoteAPIRequest extends FormRequest
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
            'votes' => 'required|array|min:1',
            'votes.*.block_id' => 'required|integer|exists:blocks,id',
            'votes.*.plate_id' => 'nullable|integer|exists:plates,id',
        ];
    }
}
