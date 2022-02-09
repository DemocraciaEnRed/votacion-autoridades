<?php

namespace App\Http\Controllers\Backend;

use App\Exports\RollExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRollRequest;
use App\Http\Requests\EditRollRequest;
use App\Http\Requests\ExportRollsRequest;
use App\Http\Requests\ImportRollsRequest;
use App\Imports\RollImport;
use App\Models\Roll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RollController extends Controller
{

    public function __construct () {
        $this->middleware('permission:listar padrones,backend', ['only' => ['index']]);
        $this->middleware('permission:crear padron,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar padron,backend', ['only' => ['store']]);
        $this->middleware('permission:ver padron,backend', ['only' => ['show']]);
        $this->middleware('permission:ver padron,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar padron,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar padron,backend', ['only' => ['destroy']]);

        $this->middleware('permission:ver importar padrones,backend', ['only' => ['import']]);
        $this->middleware('permission:importar padrones,backend', ['only' => ['importPost']]);
        $this->middleware('permission:ver exportar padrones,backend', ['only' => ['export']]);
        $this->middleware('permission:exportar padrones,backend', ['only' => ['exportPost']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = Roll::latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Roll $roll) {
                    return $roll->name;
                })
                ->editColumn('email', function(Roll $roll) {
                    return $roll->last_name;
                })
                ->editColumn('is_active', function(Roll $roll) {
                    return $roll->dni;
                })
                ->addColumn('action', function(Roll $roll) {
                    $editBtn =
                        '<a href="'. action('\App\Http\Controllers\Backend\RollController@edit', $roll) .'" class="edit btn btn-success btn-sm mr-1">'.
                            'Editar'.
                        '</a>';

                    $messageBtnDelete = 'Está seguro que desea eliminar este padrón?';
                    $userInRoll = User::where('dni', $roll->dni)
                        ->first();
                    if($userInRoll) {
                        $messageBtnDelete = 'Estás eliminando a alguien que ya tiene un usuario activo. Recomendamos que lo borres o lo inactives para restringir su participación';
                    }

                    $deleteBtn =
                        '<form method="POST" action="'.action('\App\Http\Controllers\Backend\RollController@destroy', $roll).'">'.
                            csrf_field().
                            '<input type="hidden" name="_method" value="DELETE">'.
                            '<button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\''.$messageBtnDelete.'\')">'.
                                'Borrar'.
                            '</button>'.
                        '</form>';
                    $action =
                        '<div class="d-flex">'.
                            $editBtn.
                            $deleteBtn.
                        '</div>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.rolls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.rolls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRollRequest $request)
    {
        $roll = new Roll();
        $roll->name = $request->input('name');
        $roll->last_name = $request->input('last_name');
        $roll->dni = $request->input('dni');

        if ($roll->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Padrón creado',
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
     * @param  \App\Models\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function show(Roll $roll)
    {
        return $this->edit($roll);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function edit(Roll $roll)
    {
        return view('backend.rolls.edit')->with([
            'element' => $roll,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function update(EditRollRequest $request, Roll $roll)
    {
        $roll->name = $request->input('name');
        $roll->last_name = $request->input('last_name');
        $roll->dni = $request->input('dni');

        if ($roll->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Padrón actualizado',
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
     * @param  \App\Models\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roll $roll)
    {
        if ($roll->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Padron eliminado',
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

    public function import () {
        return view('backend.rolls.import');
    }

    public function importPost(ImportRollsRequest $request) {

        Excel::import(new RollImport(), $request->file('file'));

        return Redirect::action('\App\Http\Controllers\Backend\RollController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Padrón importado',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);

    }

    public function export () {

        $rolls = Roll::all();

        return Excel::download(new RollExport($rolls), 'Padron.xlsx');

        // return view('backend.rolls.export');
    }

    public function exportPost(ExportRollsRequest $request) {

    }
}
