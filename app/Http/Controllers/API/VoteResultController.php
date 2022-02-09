<?php

namespace App\Http\Controllers\API;

use App\Exports\VoteResultsExport;
use App\Helpers\VoteHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserVoteAPIRequest;
use App\Models\Block;
use App\Models\Plate;
use App\Models\Position;
use App\Models\Roll;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteResult;
use App\Notifications\VoteReceived;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class VoteResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function userVote(UserVoteAPIRequest $request) {

        $user = $request->user();

        foreach($request->input('votes') as $vote) {

            if($vote['plate_id']) {
                $voteResult = VoteResult::where('block_id', $vote['block_id'])
                    ->where('plate_id', $vote['plate_id'])
                    ->first();
            } else {
                $voteResult = VoteResult::where('block_id', $vote['block_id'])
                    ->whereNull('plate_id')
                    ->first();
            }

            if (!empty($voteResult)) {
                $voteResult->votes++;
                $voteResult->no_manuals++;
                $voteResult->save();
            }
        }

        $user->vote = 1;
        $user->vote_date = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        $user->notify(new VoteReceived($user));

        return Response::json([
            'message' => 'El usuario voto con éxito',
        ]);
    }

    public function results () {

        $blocks = Block::orderBy('order', 'asc')
            ->get();
        $plates = Plate::orderBy('order', 'asc')
            ->get();
            
        $plateNames = [];
        foreach($plates as $plate) {
            $plateNames[] = $plate->name;
        }
        $plateNames[] = 'En Blanco';

        //# CHART BLOCKS

        $chartBlocks = [
            'categories' => [],
            'series' => [],
        ];

        foreach($blocks as $block) {
            $chartBlocks['categories'][] = $block->name;
        }

        foreach($plates as $plate) {

            $blockVotes = [];

            foreach($blocks as $block) {

                $voteResult = VoteResult::where('block_id', $block->id)
                    ->where('plate_id', $plate->id)
                    ->first();

                if(!empty($voteResult) && $voteResult->votes > 0) {
                    $blockVotes[] = $voteResult->votes;
                } else {
                    $blockVotes[] = null;
                }

            }

            $chartBlocks['series'][] = [
                'name' => $plate->name,
                'data' => $blockVotes,
            ];

        }

        // VOTES IN BLANK FOR CHARTS BLOCKS
        $blockBlankVotes = [];

        foreach($blocks as $block) {

            $voteResult = VoteResult::where('block_id', $block->id)
                ->whereNull('plate_id')
                ->first();

            if(!empty($voteResult) && $voteResult->votes > 0) {
                $blockBlankVotes[] = $voteResult->votes;
            } else {
                $blockBlankVotes[] = null;
            }

        }

        $chartBlocks['series'][] = [
            'name' => 'En Blanco',
            'data' => $blockBlankVotes,
        ];
        

        //# CHART PERCENTAGE

        $chartPercentage = [
            'labels' => $plateNames,
            'blocks' => [],
        ];

        foreach($blocks as $block) {

            $series = [];
            foreach($plates as $plate) {
                $voteResult = VoteResult::where('block_id', $block->id)
                    ->where('plate_id', $plate->id)
                    ->first();

                if(!empty($voteResult)) {
                    $series[] = $voteResult->votes;
                } else {
                    $series[] = 0;
                }
            }
            
            // BLANK VOTES
            $voteResult = VoteResult::where('block_id', $block->id)
                ->whereNull('plate_id')
                ->first();
            if(!empty($voteResult)) {
                $series[] = $voteResult->votes;
            } else {
                $series[] = 0;
            }

            $chartPercentage['blocks'][] = [
                'name' => $block->name,
                'series' => $series,
            ];
        }
        
        //# CHART PLATES
        
        $chartPlates = [
            'categories' => $plateNames,
            'data' => [],
        ];

        foreach($plates as $plate) {

            $totalVotes = 0;

            $voteResults = VoteResult::where('plate_id', $plate->id)
                ->get();
            foreach($voteResults as $voteResult) {
                $totalVotes += $voteResult->votes;
            }

            $chartPlates['data'][] = $totalVotes;
        }

        // TOTAL BLANK VOTES
        $totalVotes = 0;

        $voteResults = VoteResult::whereNull('plate_id')
            ->get();
        foreach($voteResults as $voteResult) {
            $totalVotes += $voteResult->votes;
        }

        $chartPlates['data'][] = $totalVotes;

        //# Response

        $usersCanVote = User::where('active', 1)
            ->get();
        $totalVotes = VoteHelper::totalVotes();
        $usersVote = VoteHelper::usersVote();
        $totalBlockVotes = VoteHelper::totalBlockVotes();
        $rolls = Roll::all();

        return Response::json([
            'chart_blocks' => $chartBlocks,
            'chart_percentage' => $chartPercentage,
            'chart_plates' => $chartPlates,

            'rolls' => $rolls,
            'total_votes' => $totalVotes,
            'total_block_votes' => $totalBlockVotes,
            'users_can_vote' => count($usersCanVote),
            'percentage_voted' => (count($usersCanVote) > 0) ? ( ($usersVote * 100) / count($usersCanVote) ) : 0,
        ]);
    }

    public function excelResults () {

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

        $randomString = Str::random(12);
        $filePath = 'excels_results/'.$randomString.'.xlsx';
        Excel::store(new VoteResultsExport($blocks), $filePath, 'public_uploads');

        return Response::json([
            'message' => 'Results generated',
            'file' => asset('uploads/'.$filePath),
        ]);
    }
}
