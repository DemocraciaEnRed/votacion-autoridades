<?php

namespace App\Http\Controllers\Backend;

use App\Models\Administrator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeStatusAdministratorRequest;
use App\Http\Requests\CreateAdministratorRequest;
use App\Http\Requests\EditAdministratorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdministratorController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getRolesSelect () {
        $return = [];
        $roles = Role::all();

        foreach($roles as $role) {
            $return[$role->id] = $role->name;
        }

        return $return;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:listar administradores,backend', ['only' => ['index']]);
        $this->middleware('permission:crear administrador,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar administrador,backend', ['only' => ['store']]);
        $this->middleware('permission:ver administrador,backend', ['only' => ['show']]);
        $this->middleware('permission:ver administrador,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar administrador,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar administrador,backend', ['only' => ['destroy']]);

        $this->middleware('permission:cambiar status administrador,backend', ['only' => ['changeStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $administrators = Administrator::latest()->get();

            return Datatables::of($administrators)
                ->editColumn('name', function(Administrator $administrator) {
                    return $administrator->name;
                })
                ->editColumn('email', function(Administrator $administrator) {
                    return $administrator->email;
                })
                ->editColumn('is_active', function(Administrator $administrator) {
                    return $administrator->is_active ? 'SÍ' : 'NO';
                })
                ->addColumn('action', function(Administrator $administrator) {

                    $statusBtn = '<a href="'. action('\App\Http\Controllers\Backend\AdministratorController@changeStatus', $administrator)
                        .'" class="active btn btn-info btn-sm">Cambiar estado</a>';
                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\AdministratorController@edit', $administrator) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\AdministratorController@destroy',
                            $administrator).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este usuario?\')">Borrar</button></form>';
                    $action = $statusBtn . ' ' . $editBtn . ' ' . $deleteBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.administrators.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.administrators.create')->with([
            'roles' => $this->getRolesSelect(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdministratorRequest $request)
    {

        $administrator = new Administrator;
        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');
        $administrator->password = Hash::make($administrator->password);
        $administrator->syncRoles($request->input('role'));

        if ($administrator->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Administrador creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        return $this->edit($administrator);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $administrator)
    {

        return view('backend.administrators.edit')->with([
            'roles' => $this->getRolesSelect(),
            'element' => $administrator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Administrator $administrator)
    {
        $request = app(EditAdministratorRequest::class, ['administrator' => $administrator]);

        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');
        if($request->input('password') != '') {
            $administrator->password = bcrypt($request->input('password'));
        }
        $administrator->syncRoles($request->input('role'));

        if ($administrator->save()) {
            return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Administrador actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        $administrator->delete();

        return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Administrador eliminado',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    public function changeStatus(ChangeStatusAdministratorRequest $request, Administrator $administrator)
    {
        $administrator->is_active = $administrator->is_active ? 0 : 1;

        if ($administrator->save()) {
            return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'El estado ha sido actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\AdministratorController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
