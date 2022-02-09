<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlateRequest;
use App\Http\Requests\EditPlateRequest;
use App\Models\Block;
use App\Models\BlockPlate;
use App\Models\Plate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PlateController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getBlocks() {
        $blocks = Block::orderBy('order', 'asc')
            ->get();

        return $blocks;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:listar planchas,backend', ['only' => ['index']]);
        $this->middleware('permission:crear plancha,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar plancha,backend', ['only' => ['store']]);
        $this->middleware('permission:ver plancha,backend', ['only' => ['show']]);
        $this->middleware('permission:ver plancha,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar plancha,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar plancha,backend', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = Plate::latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Plate $plate) {
                    return $plate->name;
                })
                ->addColumn('action', function(Plate $plate) {

                    $candidatesBtn = '
                        <a href="'. action('\App\Http\Controllers\Backend\CandidateController@create', $plate) .'" class="edit btn btn-primary btn-sm">Crear candidato</a>
                        <a href="'. action('\App\Http\Controllers\Backend\CandidateController@index', $plate) .'" class="edit btn btn-primary btn-sm">Editar candidatos</a>
                    ';

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\PlateController@edit', $plate) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\PlateController@destroy',
                            $plate).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar esta plancha?\')">Borrar</button></form>';
                    $action = $editBtn . ' ' . $deleteBtn. ' '.$candidatesBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.plates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.plates.create')->with([
            'blocks' => $this->getBlocks(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePlateRequest $request)
    {
        $plate = new Plate();
        $plate->name = $request->input('name');
        $plate->description = $request->input('description');
        if($request->hasFile('logo')) {
            $path = $request->file('logo')->store('img/plates', 'public_uploads');
            $plate->logo = $path;
        }
        $plate->link = $request->input('link');
        $plate->order = $request->input('order');

        if ($plate->save()) {

            foreach($request->input('blocks') as $block) {
                BlockPlate::create([
                    'plate_id' => $plate->id,
                    'block_id' => $block,
                ]);
            }

            return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Plancha creada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function show(Plate $plate)
    {
        return $this->edit($plate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function edit(Plate $plate)
    {
        return view('backend.plates.edit')->with([
            'blocks' => $this->getBlocks(),
            'element' => $plate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function update(EditPlateRequest $request, Plate $plate)
    {
        $plate->name = $request->input('name');
        $plate->description = $request->input('description');
        if($request->hasFile('logo')) {
            $path = $request->file('logo')->store('img/plates', 'public_uploads');
            $plate->logo = $path;
        }
        $plate->link = $request->input('link');
        $plate->order = $request->input('order');

        if ($plate->save()) {

            BlockPlate::where('plate_id', $plate->id)
                ->delete();
            foreach($request->input('blocks') as $block) {
                BlockPlate::create([
                    'plate_id' => $plate->id,
                    'block_id' => $block,
                ]);
            }

            return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Plancha actualizada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plate $plate)
    {
        if ($plate->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Plancha eliminada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PlateController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
