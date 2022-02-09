<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePositionRequest;
use App\Http\Requests\EditPositionRequest;
use App\Models\Block;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function __construct () {
        $this->middleware('permission:listar posiciones,backend', ['only' => ['index']]);
        $this->middleware('permission:crear posicion,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar posicion,backend', ['only' => ['store']]);
        $this->middleware('permission:ver posicion,backend', ['only' => ['show']]);
        $this->middleware('permission:ver posicion,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar posicion,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar posicion,backend', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Block $block)
    {
        if ($request->ajax()) {
            $elements = Position::where('block_id', $block->id)
                ->latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Position $position) {
                    return $position->name;
                })
                ->addColumn('action', function(Position $position) use($block) {

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\PositionController@edit', [$block, $position]) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\PositionController@destroy',
                            [$block, $position]).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar esta posición?\')">Borrar</button></form>';
                    $action = $editBtn . ' ' . $deleteBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.positions.index')->with([
            'block' => $block,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Block $block)
    {
        return view('backend.positions.create')->with([
            'block' => $block,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePositionRequest $request, Block $block)
    {
        $position = new Position();
        $position->block_id = $block->id;
        $position->name = $request->input('name');
        $position->order = $request->input('order');

        if ($position->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
                'title' => 'Éxito',
                'text' => 'Posición creada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block, Position $position)
    {
        return $this->edit($block, $position);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block, Position $position)
    {
        return view('backend.positions.edit')->with([
            'block' => $block,
            'element' => $position,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(EditPositionRequest $request, Block $block, Position $position)
    {
        $position->name = $request->input('name');
        $position->order = $request->input('order');

        if ($position->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
                'title' => 'Éxito',
                'text' => 'Posición creada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block, Position $position)
    {
        if ($position->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
                'title' => 'Éxito',
                'text' => 'Posición creada',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\PositionController@index', [$block])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
