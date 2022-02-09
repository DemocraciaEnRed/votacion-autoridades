<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlockRequest;
use App\Http\Requests\EditBlockRequest;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class BlockController extends Controller
{
    public function __construct () {
        $this->middleware('permission:listar bloques,backend', ['only' => ['index']]);
        $this->middleware('permission:crear bloque,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar bloque,backend', ['only' => ['store']]);
        $this->middleware('permission:ver bloque,backend', ['only' => ['show']]);
        $this->middleware('permission:ver bloque,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar bloque,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar bloque,backend', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $elements = Block::latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Block $block) {
                    return $block->name;
                })
                ->addColumn('action', function(Block $block) {

                    $positionsBtn = '<a href="'. action('\App\Http\Controllers\Backend\PositionController@create', $block) .'" class="edit btn btn-primary btn-sm">Crear posición</a>
                                    <a href="'. action('\App\Http\Controllers\Backend\PositionController@index', $block) .'" class="edit btn btn-primary btn-sm">Editar posiciones</a>';

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\BlockController@edit', $block) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\BlockController@destroy',
                            $block).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este bloque?\')">Borrar</button></form>';
                    $action = $editBtn . ' ' . $deleteBtn. ' '.$positionsBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.blocks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBlockRequest $request)
    {
        $block = new Block();
        $block->name = $request->input('name');
        $block->order = $request->input('order');

        if ($block->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Bloque creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        return $this->edit($block);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        return view('backend.blocks.edit')->with([
            'element' => $block,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(EditBlockRequest $request, Block $block)
    {
        $block->name = $request->input('name');
        $block->order = $request->input('order');

        if ($block->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Bloque actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        if ($block->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
                'title' => 'Éxito',
                'text' => 'Bloque eliminado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\BlockController@index')->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
