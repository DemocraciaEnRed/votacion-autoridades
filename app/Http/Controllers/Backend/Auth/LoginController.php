<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(AuthenticateRequest $request)
    {

        if (Auth::guard('backend')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            if (Auth::guard('backend')->user()->is_active) {
                return Redirect::action('\App\Http\Controllers\Backend\AdminController@index');
            } else {
                Auth::guard('backend')->logout();
            }
        }

        return Redirect::action('\App\Http\Controllers\Backend\Auth\LoginController@login');
    }

    public function logout()
    {
        Auth::guard('backend')->logout();

        return Redirect::action('\App\Http\Controllers\Backend\Auth\LoginController@login');
    }

    public function verifyEmail(Request $request, User $user) {

        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $user->markEmailAsVerified();

         return Redirect::action('\App\Http\Controllers\Frontend\AppController@app', [
             'bienvenida' => 1,
             'any' => '/',
         ]);
    }
}
