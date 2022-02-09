<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backend.auth.profile');
    }

    public function update(UpdateProfileRequest $request)
    {

        $user = Auth::guard('backend')->user();

        $user->name = $request->input('name');
        if ($request->input('password') != '') {
            $user->password = bcrypt($request->input('password'));
        }

        if ($user->save()) {
            return Redirect::action('\App\Http\Controllers\Backend\Auth\ProfileController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'La información ha sido actualizada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\Auth\ProfileController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Ocurrió un error. Volvé a intentarlo',
            'icon' => 'error',
            'confirm_button_text' => 'Close'
        ]);
    }
}
