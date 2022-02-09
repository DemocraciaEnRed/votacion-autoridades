<?php

namespace App\Http\Controllers\Backend;

use App\Exports\VoteResultsExport;
use App\Helpers\VoteHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadVotesManuallyRequest;
use App\Models\Block;
use App\Models\Roll;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class VoteResultController extends Controller
{
    public function __construct () {
        $this->middleware('permission:ver resultados,backend', ['only' => ['index']]);
        $this->middleware('permission:exportar resultados,backend', ['only' => ['export']]);
        $this->middleware('permission:cargar resultados manuales,backend', ['only' => ['loadVotesManually', 'loadVotesManuallyPost']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allUsers = User::all();
        $usersAvailableForVote = User::where('active', 1)
            ->get();
        $usersDontAvailableForVote = User::where('active', 0)
            ->get();
        $usersVote = User::where('active', 1)
            ->where('vote', 1)
            ->get();
        $usersDontVote = User::where('active', 1)
            ->where('vote', 0)
            ->get();
        $allRolls = Roll::all();


        $blocks = Block::with([
                'votes' => function($query) {
                    $query->orderBy('votes', 'asc');
                },
                'votes_blank',
            ])
            ->orderBy('order', 'asc')
            ->get();

        $blocks = $blocks->map(function($block, $iBlock) {

            $block->votes = $block->votes->map(function ($voteResult, $iVoteResult) {

                $voteResult->percentage = (VoteHelper::usersVote() > 0) ? number_format(($voteResult->votes * 100) / VoteHelper::usersVote(), 2) : 0;

                return $voteResult;
            });

            $votesBlank = $block->votes_blank;
            $votesBlank->percentage = (VoteHelper::usersVote() > 0) ? number_format(($votesBlank->votes * 100) / VoteHelper::usersVote(), 2) : 0;
            $block->votes_blank = $votesBlank;

            return $block;
        });

        return view('backend.vote_results.index')->with([
            'blocks' => $blocks,
            'allUsers' => $allUsers,
            'usersAvailableForVote' => $usersAvailableForVote,
            'usersDontAvailableForVote' => $usersDontAvailableForVote,
            'usersVote' => $usersVote,
            'usersDontVote' => $usersDontVote,
            'allRolls' => $allRolls,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VoteResult  $voteResult
     * @return \Illuminate\Http\Response
     */
    public function show(VoteResult $voteResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VoteResult  $voteResult
     * @return \Illuminate\Http\Response
     */
    public function edit(VoteResult $voteResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VoteResult  $voteResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteResult $voteResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VoteResult  $voteResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteResult $voteResult)
    {
        //
    }

    public function loadVotesManually() {

        $blocks = Block::with([
            'plates' => function($query) {
                $query->whereHas('plate');
            },
            'plates.plate',
        ])
            ->orderBy('order', 'asc')
            ->get();

        return view('backend.vote_results.load_votes_manually')->with([
            'blocks' => $blocks,
        ]);
    }

    public function loadVotesManuallyPost(LoadVotesManuallyRequest $request) {

        $blocks = Block::with([
            'plates' => function($query) {
                $query->whereHas('plate');
            },
            'plates.plate',
        ])
            ->orderBy('order', 'asc')
            ->get();

        // VALIDATE VOTES IN EACH BLOCK
        $votesEachBlock = [];

        foreach($blocks as $block) {

            $votes = 0;

            foreach($block->plates as $blockPlate) {
                // NOT BLANK VOTE
                $votes += $request->input('vote_'.$block->id.'_'.$blockPlate->plate->id);
            }

            // BLANK VOTE
            $votes += $request->input('vote_'.$block->id.'_blank');

            $votesEachBlock[] = $votes;
        }

        if(count(array_unique($votesEachBlock)) > 1) {
            return Redirect::action('\App\Http\Controllers\Backend\VoteResultController@loadVotesManually')->withAlert([
                'title' => 'Error',
                'text' => 'Tiene que ingresar la misma cantidad de votos en cada bloque',
                'icon' => 'error',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        // LOAD VOTES
        foreach($blocks as $block) {

            foreach($block->plates as $blockPlate) {

                // NOT BLANK VOTE
                $votes = $request->input('vote_'.$block->id.'_'.$blockPlate->plate->id);

                $voteResult = VoteResult::where('block_id', $block->id)
                    ->where('plate_id', $blockPlate->plate->id)
                    ->first();

                if(!empty($voteResult)) {
                    $voteResult->votes += $votes;
                    $voteResult->manuals += $votes;
                    $voteResult->save();
                }
            }

            // BLANK VOTE
            $votes = $request->input('vote_'.$block->id.'_blank');

            $voteResult = VoteResult::where('block_id', $block->id)
                ->whereNull('plate_id')
                ->first();

            if(!empty($voteResult)) {
                $voteResult->votes += $votes;
                $voteResult->manuals += $votes;
                $voteResult->save();
            }
        }

        return Redirect::action('\App\Http\Controllers\Backend\VoteResultController@loadVotesManually')->withAlert([
            'title' => 'Éxito',
            'text' => 'Votos manuales cargados con éxito',
            'icon' => 'success',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    public function export () {

        $blocks = Block::with([
            'votes' => function($query) {
                $query->orderBy('votes', 'asc');
            },
            'votes_blank',
        ])
            ->orderBy('order', 'asc')
            ->get();

        $blocks = $blocks->map(function($block, $iBlock) {

            $block->votes = $block->votes->map(function ($voteResult, $iVoteResult) {

                $voteResult->percentage = (VoteHelper::usersVote() > 0) ? number_format(($voteResult->votes * 100) / VoteHelper::usersVote(), 2) : 0;

                return $voteResult;
            });

            $votesBlank = $block->votes_blank;
            $votesBlank->percentage = (VoteHelper::usersVote() > 0) ? number_format(($votesBlank->votes * 100) / VoteHelper::usersVote(), 2) : 0;
            $block->votes_blank = $votesBlank;

            return $block;
        });

        return Excel::download(new VoteResultsExport($blocks), 'Resultados de votación.xlsx');
    }
}
