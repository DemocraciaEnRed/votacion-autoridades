<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordForgottenAPIRequest;
use App\Http\Requests\ForgotPasswordAPIRequest;
use App\Http\Requests\ChangePasswordAPIRequest;
use App\Http\Requests\LoginAPIRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\TakeCensusRequest;
use App\Http\Requests\ValidateTokenAPIRequest;
use App\Http\Requests\ValidDataRegistrationRequest;
use App\Http\Requests\ValidDNIRequest;
use App\Models\Roll;
use App\Models\User;
use App\Models\UserNotInRoll;
use App\Models\UserPhoto;
use App\Notifications\ChangePassword;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /** HELPER FUNCTIONS */

    public function validToken($token) {

        $validToken = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if(empty($validToken)) {
            return false;
        }

        return $validToken;
    }

    /** END HELPER FUNCTIONS */

    public function login(LoginAPIRequest $request) {

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            if (Auth::user()->active) {
                return Response::json([
                    'user' => Auth::user(),
                    'message' => 'User logged',
                ]);
            }

            Auth::logout();

            return Response::json([
                'message' => 'El usuario no está activo',
                'errors' => [
                    'email' => [
                        'El usuario no está activo',
                    ],
                ],
            ], 422);
        }

        return Response::json([
            'message' => 'El email o la contraseña son incorrectos',
            'errors' => [
                'email' => [
                    'El email o la contraseña son incorrectos',
                ],
            ],
        ], 422);
    }

    public function register (RegisterUserRequest $request) {

        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->dni = $request->input('dni');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        if ($user->save()) {

            // IMAGES
            if($request->hasFile('photos')) {
                foreach ($request->file('photos') as $iPhoto => $photo) {

                    $path = $photo->store('img/user_photos', 'public_uploads');

                    $userPhoto = UserPhoto::create([
                        'user_id' => $user->id,
                        'filename' => $path,
                        'order' => $iPhoto,
                    ]);
                }
            }

            $user->notify(new EmailVerification($user));

            return Response::json([
                'user' => $user,
                'message' => 'Registro exitoso',
            ]);
        }

        return Response::json([
            'message' => 'Error al guardar el usuario',
        ], 500);
    }

    public function validDataRegistration(ValidDataRegistrationRequest $request, User $user) {

        return Response::json([
            'message' => 'La información es correcta',
        ]);
    }

    public function validDNI(ValidDNIRequest $request) {

        $roll = Roll::where('dni', $request->input('dni'))
            ->first();

        if(empty($roll)) {
            return Response::json([
                'message' => 'El DNI no se encuentra en el padrón',
            ], 404);
        }

        $user = User::where('dni', $request->input('dni'))
            ->first();

        if(empty($user)) {
            return Response::json([
                'message' => 'El usuario existe en el padrón',
            ]);
        }

        return Response::json([
            'message' => 'Este DNI ya se encuentra registrado',
        ], 409);
    }

    public function takeCensus(TakeCensusRequest $request) {

        $userNotInRoll = UserNotInRoll::where('email', $request->input('email'))
            ->first();

        if(empty($userNotInRoll)) {
            $userNotInRoll = new UserNotInRoll();
            $userNotInRoll->email = $request->input('email');
            $userNotInRoll->save();
        }

        // TODO: SEND NOTIFICATION TO USER NOT IN ROLL

        return Response::json([
            'message' => 'Email guardado con éxito',
        ]);
    }

    public function logout(Request $request) {

        Auth::logout();

        return Response::json([
            'message' => 'Usuario deslogueado',
        ]);
    }

    public function forgotPassword(ForgotPasswordAPIRequest $request) {

        $user = User::where('email', $request->input('email'))
            ->first();
        $passwordReset = DB::table('password_resets')
            ->where('email', $user->email)
            ->first();

        if(!empty($passwordReset)) {
            $user->notify(new ChangePassword($user, $passwordReset->token));

            return Response::json([
                'errors' => [
                    'email' => 'Ya tenes un pedido de cambio de contraseña, por favor revisá tu email'
                ],
            ], 409);
        }

        $token = Str::random(16);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);
        $user->notify(new ChangePassword($user, $token));

        return Response::json([
            'message' => 'Email enviado para cambiar la contraseña',
        ]);
    }

    public function changePasswordForgotten(ChangePasswordForgottenAPIRequest $request) {

        $validToken = $this->validToken($request->input('token'));

        if(!$validToken) {
            return Response::json([
                'errors' => [
                    'token' => 'Token inválido'
                ],
            ], 401);
        }

        $user = User::where('email', $validToken->email)
            ->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->delete();

        return Response::json([
            'message' => 'Contraseña cambiada',
            'user' => $user,
        ]);
    }

    public function validateToken(ValidateTokenAPIRequest $request) {

        $validToken = $this->validToken($request->input('token'));

        if(!$validToken) {
            return Response::json([
                'errors' => [
                    'token' => 'Token inválido'
                ],
            ], 401);
        }

        $user = User::where('email', $validToken->email)
            ->first();

        return Response::json([
            'message' => 'Token válido',
            'user' => $user,
        ]);
    }
}
