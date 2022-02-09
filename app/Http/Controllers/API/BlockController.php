<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBlockAPIRequest;
use App\Http\Requests\GetBlocksWithPlatesAPIRequest;
use App\Models\Block;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetBlockAPIRequest $request)
    {
        $with = [
            'positions',
        ];

        if($request->input('order') != '') {

            $order = $request->input('order');
            $typeOfOrder = $request->input('type_of_order');

            $blocks = Block::with($with)
                ->orderBy($order, $typeOfOrder)
                ->get();
        } else {
            $blocks = Block::with($with)
                ->inRandomOrder()
                ->get();
        }

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
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }

    public function blocksWithPlates(GetBlocksWithPlatesAPIRequest $request) {

        $with = [
            'positions',
            'plates' => function($query) {
                $query->whereHas('plate');
            },
            'plates.plate',
            'plates.plate.candidates' => function($query) {
                $query->inRandomOrder();
            },
            'plates.plate.candidates.position',
        ];

        if($request->input('order') != '') {

            $order = $request->input('order');
            $typeOfOrder = $request->input('type_of_order');

            $blocks = Block::with($with)
                ->orderBy($order, $typeOfOrder)
                ->get();
        } else {
            $blocks = Block::with($with)
                ->inRandomOrder()
                ->get();
        }

        $blocks = $blocks->map(function($block, $iBlock) {

            unset($block->plates);

            $block->plates = $block->plates()
                ->whereHas('plate')
                ->get()->map(function($blockPlate, $iBlockPlate) use($block) {

                    unset($blockPlate->plate->candidates_of_block);

                    $blockPlate->plate->logo = ($blockPlate->plate->logo != '') ? asset('uploads/'.$blockPlate->plate->logo) : '';

                    $blockPlate->plate->candidates_of_block = $blockPlate->plate->candidates->filter(function($candidate, $iCandidate) use ($block) {
                        return ($candidate->position->block_id == $block->id);
                    })->shuffle();

                    $blockPlate->plate->candidates_of_block = $blockPlate->plate->candidates_of_block->map(function($candidate, $iCandidate) {

                        $candidate->photo = ($candidate->photo != '') ? asset('uploads/'.$candidate->photo) : '';

                        return $candidate;
                    });

                    return $blockPlate;
            });

            return $block;
        });

        return Response::json($blocks);
    }
}
