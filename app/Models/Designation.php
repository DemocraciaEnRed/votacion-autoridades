<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['block_id', 'position_id', 'candidate_id'];

    /** RELATIONS */

    public function position () {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function candidate () {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /** END RELATIONS */
}
