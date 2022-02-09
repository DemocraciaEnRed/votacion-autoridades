<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditVoteRequest extends FormRequest
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
            'state_id' => 'required|integer|exists:vote_states,id',
            'day_close_inscriptions' => 'required|date|before_or_equal:day_start',
            'day_start' => 'required|date|before:day_finish',
            'day_finish' => 'required|date|after:day_start',
        ];
    }
}
