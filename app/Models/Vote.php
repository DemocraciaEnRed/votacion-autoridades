<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'day_start', 'day_finish'];

    /** RELATIONS */

    public function state () {
        return $this->belongsTo(VoteState::class, 'state_id');
    }

    /** END RELATIONS */
}
