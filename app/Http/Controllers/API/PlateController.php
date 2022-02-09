<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetPlateAPIRequest;
use App\Models\Block;
use App\Models\Plate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PlateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetPlateAPIRequest $request)
    {

        $with = [
            'blocks',
            'blocks.block',
            'blocks.block.positions',
            'candidates',
            'candidates.position',
        ];

        $queryPlate = Plate::query();

        if($request->input('block_id') != '') {

            $block = Block::find($request->input('block_id'));

            $with['blocks'] = function($query) use($block) {
                $query->where('block_id', $block->id);
            };

            $with['candidates'] = function($queryCandidates) use($block) {
                $queryCandidates->whereHas('position', function($queryPosition) use($block) {
                    $queryPosition->where('block_id', $block->id);
                });
            };
        }

        $queryPlate->with($with);

        if($request->input('order') != '') {

            $order = $request->input('order');
            $typeOfOrder = $request->input('type_of_order');

            $queryPlate->orderBy($order, $typeOfOrder);

        } else {
            $queryPlate->inRandomOrder();
        }

        $plates = $queryPlate->get();

        // SET URL OF PHOTOS
        foreach($plates as $plate) {

            $plate->logo = ($plate->logo != '') ? asset('uploads/'.$plate->logo) : '';

            foreach($plate->candidates as $candidate) {
                $candidate->photo = ($candidate->photo != '') ? asset('uploads/'.$candidate->photo) : '';
            }
        }

        return Response::json($plates);
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
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function show(Plate $plate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function edit(Plate $plate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plate $plate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plate  $plate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plate $plate)
    {
        //
    }
}
