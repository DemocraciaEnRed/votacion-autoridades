<?php

namespace App\Observers;

use App\Models\LogRoll;
use App\Models\Roll;
use Illuminate\Support\Facades\Auth;

class RollObserver
{
    /**
     * Handle the Roll "created" event.
     *
     * @param  \App\Models\Roll  $roll
     * @return void
     */
    public function created(Roll $roll)
    {
        LogRoll::create([
            'roll_id' => $roll->id,
            'administrator_id' => Auth::guard('backend')->id(),
            'action' => 'create',
            'name' => $roll->name,
            'last_name' => $roll->last_name,
            'dni' => $roll->dni,
        ]);
    }

    /**
     * Handle the Roll "updated" event.
     *
     * @param  \App\Models\Roll  $roll
     * @return void
     */
    public function updated(Roll $roll)
    {
        LogRoll::create([
            'roll_id' => $roll->id,
            'administrator_id' => Auth::guard('backend')->id(),
            'action' => 'update',
            'previous_name' => $roll->getOriginal('name'),
            'previous_last_name' => $roll->getOriginal('last_name'),
            'previous_dni' => $roll->getOriginal('dni'),
            'name' => $roll->name,
            'last_name' => $roll->last_name,
            'dni' => $roll->dni,
        ]);
    }

    /**
     * Handle the Roll "deleted" event.
     *
     * @param  \App\Models\Roll  $roll
     * @return void
     */
    public function deleted(Roll $roll)
    {
        LogRoll::create([
            'roll_id' => $roll->id,
            'administrator_id' => Auth::guard('backend')->id(),
            'action' => 'delete',
            'name' => $roll->name,
            'last_name' => $roll->last_name,
            'dni' => $roll->dni,
        ]);
    }

    /**
     * Handle the Roll "restored" event.
     *
     * @param  \App\Models\Roll  $roll
     * @return void
     */
    public function restored(Roll $roll)
    {
        //
    }

    /**
     * Handle the Roll "force deleted" event.
     *
     * @param  \App\Models\Roll  $roll
     * @return void
     */
    public function forceDeleted(Roll $roll)
    {
        //
    }
}
