<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserNotInRollAPIRequest;
use App\Models\UserNotInRoll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserNotInRollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserNotInRollAPIRequest $request)
    {
        $userNotInRoll = UserNotInRoll::where('email', $request->input('email'))
            ->first();

        if(empty($userNotInRoll)) {
            $userNotInRoll = new UserNotInRoll;
            $userNotInRoll->email = $request->input('email');
            $userNotInRoll->save();
        }

        // TODO: SEND NOTIFICATION USER NOT IN ROLL

        return Response::json([
            'message' => 'Usuario que no está en el padrón creado con éxito',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotInRoll $userNotInRoll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNotInRoll  $userNotInRoll
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotInRoll $userNotInRoll)
    {
        //
    }
}
