<?php

namespace App\Http\Requests;

use App\Models\Block;
use Illuminate\Foundation\Http\FormRequest;

class LoadVotesManuallyRequest extends FormRequest
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
        $rules = [];

        $blocks = Block::with([
            'plates' => function($query) {
                $query->whereHas('plate');
            },
            'plates.plate',
        ])
            ->orderBy('order', 'asc')
            ->get();

        foreach($blocks as $block) {

            foreach($block->plates as $blockPlate) {
                $rules['vote_'.$block->id.'_'.$blockPlate->plate->id] = 'required|integer';
            }
        }

        return $rules;
    }
}
