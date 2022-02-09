<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /** RELATIONS */

    public function block () {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function candidates () {
        return $this->hasMany(Candidate::class, 'position_id');
    }

    /** END RELATIONS */
}
