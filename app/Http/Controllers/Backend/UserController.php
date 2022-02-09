<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\ValidateUserRequest;
use App\Models\User;
use App\Models\UserPhoto;
use App\Notifications\EmailVerification;
use App\Notifications\UserNotValidated;
use App\Notifications\UserValidated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use PharIo\Manifest\Email;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /** HELPER FUNCTIONS */

    public function existUserForValidate () {
        $users = User::with([
            'photos'
        ])
            ->where('active', 0)
            ->get();

        return count($users) > 0;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:listar usuarios,backend', ['only' => ['index']]);
        $this->middleware('permission:crear usuario,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar usuario,backend', ['only' => ['store']]);
        $this->middleware('permission:ver usuario,backend', ['only' => ['show']]);
        $this->middleware('permission:ver usuario,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar usuario,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar usuario,backend', ['only' => ['destroy']]);

        $this->middleware('permission:ver validar usuario,backend', ['only' => ['validateUsers']]);
        $this->middleware('permission:validar usuario,backend', ['only' => ['validateUser']]);
        $this->middleware('permission:validar todos los usuarios,backend', ['only' => ['validateAllUsers']]);
        $this->middleware('permission:exportar usuarios,backend', ['only' => ['export']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = User::latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(User $user) {
                    return $user->name;
                })
                ->editColumn('email', function(User $user) {
                    return $user->email;
                })
                ->editColumn('is_active', function(User $user) {
                    return $user->active ? 'SÍ' : 'NO';
                })
                ->addColumn('action', function(User $user) {

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\UserController@edit', $user) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\UserController@destroy',
                            $user).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este usuario?\')">Borrar</button></form>';
                    $action = $editBtn . ' ' . $deleteBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->dni = $request->input('dni');
        $user->email = $request->input('email');
        $user->password = Hash::make($user->password);
        $user->active = $request->input('active');

        if ($user->save()) {

            // IMAGES
            foreach($request->input('upload_photos') as $iuploadPhoto => $uploadPhoto) {

                $userPhoto = UserPhoto::create([
                    'user_id' => $user->id,
                    'filename' => $uploadPhoto,
                    'order' => $iuploadPhoto,
                ]);
            }

            $user->notify(new EmailVerification($user));

            return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Usuario creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->edit($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('backend.users.edit')->with([
            'element' => $user,
        ]);
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
        $request = app(EditUserRequest::class, ['user' => $user]);

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->dni = $request->input('dni');
        $user->email = $request->input('email');
        if($request->input('password') != '') {
            $user->password = Hash::make($user->password);
        }
        $user->active = $request->input('active');

        if ($user->save()) {

            // IMAGES
            if($request->input('upload_photos') != '') {
                foreach($request->input('upload_photos') as $iuploadPhoto => $uploadPhoto) {

                    $productPhotoExist = UserPhoto::where('filename', $uploadPhoto)
                        ->where('user_id', $user->id)
                        ->first();

                    if(empty($productPhotoExist)) {
                        $productPhoto = UserPhoto::create([
                            'user_id' => $user->id,
                            'filename' => $uploadPhoto,
                            'order' => $iuploadPhoto,
                        ]);
                    } else {
                        $productPhotoExist->order = $iuploadPhoto;
                        $productPhotoExist->save();
                    }
                }
            }

            return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Usuario actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Usuario eliminado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    public function validateUsers($index = 0) {

        $users = User::with([
                'photos'
        ])
            ->where('active', 0)
            ->whereNotNull('email_verified_at')
            ->get();

        if(count($users) <= 0) {
            return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
                'title' => 'Error',
                'text' => 'No hay usuarios para validar',
                'icon' => 'error',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        if(!isset($users[$index])) {

            while($index > 0 && !isset($users[$index])) {
                $index = count($users) - 1;
            }
        }

        return view('backend.users.validate')->with([
            'index' => $index,
            'user' => $users[$index],
        ]);
    }

    public function validateUser(ValidateUserRequest $request, $index, User $user) {

        if($user->active) {
            return Redirect::action('\App\Http\Controllers\Backend\UserController@validateUsers', [$index])->withAlert([
                'title' => 'Error',
                'text' => 'Este usuario ya está activo',
                'icon' => 'error',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        $validate = $request->input('validate');

        if($validate) {
            $user->active = 1;
            $user->save();

            $user->notify(new UserValidated($user));
        } else {
            $user->notify(new UserNotValidated($user));
        }

        if($this->existUserForValidate()) {

            $index++;

            return Redirect::action('\App\Http\Controllers\Backend\UserController@validateUsers', [$index])->withAlert([
                'title' => 'Éxito',
                'text' => 'Usuario actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Usuario actualizado',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);

    }

    public function validateAllUsers () {
        $users = User::with([
            'photos'
        ])
            ->where('active', 0)
            ->whereNotNull('email_verified_at')
            ->get();

        foreach($users as $user) {
            $user->active = 1;
            $user->save();

            $user->notify(new UserValidated($user));
        }

        return Redirect::action('\App\Http\Controllers\Backend\UserController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Usuarios validados',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    public function export () {

        $users = User::where('active', 1)
            ->get();

        return Excel::download(new UserExport($users), 'Usuarios.xlsx');
    }
}
