<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRoll extends Model
{
    use HasFactory;

    protected $fillable = ['roll_id', 'administrator_id', 'action', 'previous_name', 'previous_last_name', 'previous_dni', 'name', 'last_name', 'dni'];

    /** RELATIONS */

    public function roll () {
        return $this->belongsTo(Roll::class, 'roll_id');
    }

    public function administrator () {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    /** END RELATIONS */
}
