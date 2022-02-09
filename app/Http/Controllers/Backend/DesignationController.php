<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDesignationRequest;
use App\Models\Block;
use App\Models\Designation;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DesignationController extends Controller
{
    public function __construct () {
        $this->middleware('permission:ver designaciones,backend', ['only' => ['index']]);
        $this->middleware('permission:editar designaciones,backend', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blocks = Block::with([
//            'positions',
//            'positions.candidates',
//            'positions.candidates.plate',
        ])
            ->get()
            ->map(function($block, $iBlock) {

                unset($block->positions);

                $block->positions = $block->positions()->with([
                        'candidates' => function($query) {
                            $query->whereHas('plate');
                        },
                        'candidates.plate',
                    ])
                    ->whereHas('candidates', function (Builder $query) {
                        $query->whereHas('plate');
                    })
                    ->get()
                    ->map(function($position, $iPosition) use($block) {

                        $candidatesForSelect = [];
                        foreach($position->candidates as $candidate) {
                            $candidatesForSelect[$candidate->id] = $candidate->plate->name.' - '.$candidate->name;
                        }

                        $position->candidates_for_select = $candidatesForSelect;

                        $designation = Designation::where('block_id', $block->id)
                            ->where('position_id', $position->id)
                            ->first();

                        $position->candidate_selected = (!empty($designation)) ? $designation->candidate_id : null;

                        return $position;
                    });

                return $block;
            });

        return view('backend.designations.index')->with([
            'blocks' => $blocks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDesignationRequest $request)
    {
        $positions = Position::all();

        Designation::truncate();
        foreach($positions as $position) {

            if($request->has('position_'.$position->id)) {

                $candidate = $request->input('position_'.$position->id);

                if($candidate != '') {
                    Designation::create([
                        'block_id' => $position->block->id,
                        'position_id' => $position->id,
                        'candidate_id' => $candidate,
                    ]);
                }
            }
        }

        return Redirect::action('\App\Http\Controllers\Backend\DesignationController@index')->withAlert([
            'title' => 'Éxito',
            'text' => 'Designaciones creadas',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
