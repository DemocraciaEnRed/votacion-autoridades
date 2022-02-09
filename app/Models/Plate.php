<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plate extends Model
{
    use HasFactory, SoftDeletes;

    /** RELATIONS */

    public function blocks () {
        return $this->hasMany(BlockPlate::class, 'plate_id');
    }

    public function candidates () {
        return $this->hasMany(Candidate::class, 'plate_id');
    }

    public function votes () {
        return $this->hasMany(VoteResult::class, 'plate_id');
    }

    /** END RELATIONS */
}
