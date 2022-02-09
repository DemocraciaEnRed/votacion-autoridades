<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordAPIRequest;
use App\Models\Roll;
use App\Models\User;
use App\Models\UserPhoto;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function logged (Request $request) {

        $user = User::with([
            'photos',
        ])
            ->where('id', $request->user()->id)
            ->first();

        $user->photos = $user->photos->map(function($userPhoto) {

            $userPhoto->filename = ($userPhoto->filename != '') ? asset('uploads/'.$userPhoto->filename) : '';

            return $userPhoto;
        });

        return Response::json($user);
    }

    public function changePassword(ChangePasswordAPIRequest $request) {

        $user = $request->user();

        if(!Hash::check($request->input('actual_password'), $user->password)) {
            return Response::json([
                'message' => 'La contraseña actual no coincide',
                'errors' => [
                    'actual_password' => [
                        'La contraseña actual no es correcta',
                    ],
                ],
            ], 422);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return Response::json([
            'message' => 'Contraseña cambiada',
        ]);
    }
}
