<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory, SoftDeletes;

    /** RELATIONS */

    public function positions () {
        return $this->hasMany(Position::class, 'block_id');
    }

    public function plates () {
        return $this->hasMany(BlockPlate::class, 'block_id');
    }

    public function votes () {
        return $this->hasMany(VoteResult::class, 'block_id')->whereHas('plate');
    }

    public function votes_blank () {
        return $this->hasOne(VoteResult::class, 'block_id')->whereDoesntHave('plate');
    }

    public function designations () {
        return $this->hasMany(Designation::class, 'block_id');
    }

    /** END RELATIONS */
}
