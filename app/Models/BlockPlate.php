<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockPlate extends Model
{
    use HasFactory;

    protected $fillable = ['block_id', 'plate_id'];

    /** RELATIONS */

    public function block () {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function plate () {
        return $this->belongsTo(Plate::class, 'plate_id');
    }

    /** END RELATIONS */
}
