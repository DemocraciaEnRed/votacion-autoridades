<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCandidateRequest;
use App\Http\Requests\EditCandidateRequest;
use App\Models\Candidate;
use App\Models\Plate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class CandidateController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getPositionsSelect(Plate $plate) {

        $return = [];

        $blockPlates = $plate->blocks;
        foreach($blockPlates as $blockPlate) {

            $block = $blockPlate->block;
            $positions = $block->positions;

            foreach($positions as $position) {
                $return[$position->id] = $block->name.' - '.$position->name;
            }
        }

        return $return;
    }

    /** END HELPER FUNCTIONS */

    public function __construct () {
        $this->middleware('permission:listar candidatos,backend', ['only' => ['index']]);
        $this->middleware('permission:crear candidato,backend', ['only' => ['create']]);
        $this->middleware('permission:guardar candidato,backend', ['only' => ['store']]);
        $this->middleware('permission:ver candidato,backend', ['only' => ['show']]);
        $this->middleware('permission:ver candidato,backend', ['only' => ['edit']]);
        $this->middleware('permission:editar candidato,backend', ['only' => ['update']]);
        $this->middleware('permission:eliminar candidato,backend', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Plate $plate)
    {
        if ($request->ajax()) {
            $elements = Candidate::where('plate_id', $plate->id)
                ->latest()->get();

            return Datatables::of($elements)
                ->editColumn('name', function(Candidate $candidate) {
                    return $candidate->name;
                })
                ->editColumn('last_name', function(Candidate $candidate) {
                    return $candidate->last_name;
                })
                ->editColumn('position', function(Candidate $candidate) {
                    return $candidate->position->block->name.' - '.$candidate->position->name;
                })
                ->addColumn('action', function(Candidate $candidate) use ($plate) {

                    $editBtn = '<a href="'. action('\App\Http\Controllers\Backend\CandidateController@edit', [$plate, $candidate]) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\CandidateController@destroy',
                            [$plate, $candidate]).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este candidato?\')">Borrar</button></form>';

                    $action = $editBtn . ' ' . $deleteBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.candidates.index')->with([
            'plate' => $plate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Plate $plate)
    {
        return view('backend.candidates.create')->with([
            'plate' => $plate,
            'positions' => $this->getPositionsSelect($plate),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCandidateRequest $request, Plate $plate)
    {
        $candidate = new Candidate();
        $candidate->plate_id = $plate->id;
        $candidate->position_id = $request->input('position_id');
        $candidate->name = $request->input('name');
        $candidate->last_name = $request->input('last_name');
        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('img/candidates', 'public_uploads');
            $candidate->photo = $path;
        }
        $candidate->link = $request->input('link');
        $candidate->order = $request->input('order');

        if ($candidate->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
                'title' => 'Éxito',
                'text' => 'Candidato creado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Plate $plate, Candidate $candidate)
    {
        return $this->edit($plate, $candidate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Plate $plate, Candidate $candidate)
    {
        return view('backend.candidates.edit')->with([
            'plate' => $plate,
            'positions' => $this->getPositionsSelect($plate),
            'element' => $candidate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(EditCandidateRequest $request, Plate $plate, Candidate $candidate)
    {
        $candidate->position_id = $request->input('position_id');
        $candidate->name = $request->input('name');
        $candidate->last_name = $request->input('last_name');
        if($request->hasFile('photo')) {
            $path = $request->file('photo')->store('img/candidates', 'public_uploads');
            $candidate->photo = $path;
        }
        $candidate->link = $request->input('link');
        $candidate->order = $request->input('order');

        if ($candidate->save()) {

            return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
                'title' => 'Éxito',
                'text' => 'Candidato actualizado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plate $plate, Candidate $candidate)
    {
        if ($candidate->delete()) {

            return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
                'title' => 'Éxito',
                'text' => 'Candidato eliminado',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::action('\App\Http\Controllers\Backend\CandidateController@index', [$plate])->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }
}
