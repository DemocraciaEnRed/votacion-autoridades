<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    /** RELATIONS */

    public function position () {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function plate () {
        return $this->belongsTo(Plate::class, 'plate_id');
    }

    /** END RELATIONS */
}
