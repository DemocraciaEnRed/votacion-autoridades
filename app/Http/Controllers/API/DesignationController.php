<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $blocks = Block::with([
//            'designations' => function($query) {
//                $query->whereHas('candidate');
//            },
            // 'designations.position',
//            'designations.candidate' => function($query) {
//                $query->whereHas('plate')
//                    ->whereHas('position');
//            },
//            'designations.candidate.plate',
//            'designations.candidate.position',
        ])
            ->get()
            ->map(function($block) {

                unset($block->designations);

                $block->designations = $block->designations()
                    ->with([
                        'candidate' => function($query) {
                            $query->whereHas('plate')
                                ->whereHas('position');
                        },
                         'candidate.plate',
                         'candidate.position',
                    ])
                    ->whereHas('candidate', function (Builder $query) {
                        $query->whereHas('plate')
                            ->whereHas('position');
                    })
                    ->get()
                    ->map(function($designation) {

                        unset($designation->candidate);
                        $designation->candidate->photo = ($designation->candidate->photo != '') ? asset('uploads/'.$designation->candidate->photo) : '';

                        unset($designation->candidate->plate);
                        $designation->candidate->plate->logo = ($designation->candidate->plate->logo != '') ? asset('uploads/'.$designation->candidate->plate->logo) : '';

                        $designation->candidate->position = $designation->candidate->position;

                        return $designation;
                    });

                return $block;
            });

        return Response::json($blocks);
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
    public function store(Request $request)
    {
        //
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
