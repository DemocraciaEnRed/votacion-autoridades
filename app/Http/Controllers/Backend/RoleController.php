<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\EditRolePermissionsRequest;
use App\Http\Requests\EditRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getPermissions() {
        $return = [];
        $permissions = Permission::all();

        return $permissions;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:listar roles,backend', ['only' => ['index']]);
        $this->middleware('permission:crear rol,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar rol,backend', ['only' => ['store']]);
        $this->middleware('permission:ver rol,backend', ['only' => ['show']]);
        $this->middleware('permission:ver rol,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar rol,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar rol,backend', ['only' => ['destroy']]);

        $this->middleware('permission:ver permisos rol,backend', ['only' => ['permissions']]);
        $this->middleware('permission:editar permisos rol,backend', ['only' => ['editPermissions']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = Role::latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Role $role) {
                    return $role->name;
                })
                ->addColumn('action', function(Role $role) {

                    $editPermissions = '<a href="'. action('\App\Http\Controllers\Backend\RoleController@permissions', $role) .'" class="edit btn btn-primary btn-sm">Ver permisos</a>';
                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\RoleController@edit', $role) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\RoleController@destroy',
                            $role).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este rol?\')">Borrar</button></form>';
                    $action = $editBtn. ' '.$editPermissions;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = 'backend';

        if ($role->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\RoleController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Rol creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
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
    public function show(Role $role)
    {
        return $this->edit($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('backend.roles.edit')->with([
            'element' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');

        if ($role->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\RoleController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Rol creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
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
    public function destroy(Role $role)
    {
        //
    }

    public function permissions(Role $role) {
        return view('backend.roles.permissions')->with([
            'permissions' => $this->getPermissions(),
            'element' => $role,
        ]);
    }

    public function editPermissions(EditRolePermissionsRequest $request, Role $role) {

        $permissions = [];
        foreach($request->input('permissions') as $permission) {
            $permissions[] = Permission::find($permission);
        }

        $role->syncPermissions($permissions);

        return Redirect::action('\App\Http\Controllers\Backend\RoleController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Permisos sincronizados',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
