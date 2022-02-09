<?php

namespace App\Observers;

use App\Models\Block;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteResult;

class VoteObserver
{
    /**
     * Handle the Vote "created" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function created(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "updated" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function updated(Vote $vote)
    {
        if($vote->isDirty('state_id')) {

            $previousState = $vote->getOriginal('state_id');
            $newState = $vote->state_id;

            // IF PASS FROM PRE-VOTACION TO VOTACIÓN
            if($previousState == 1 && $newState == 2) {

                $vote->mail_results_sended = 0;
                $vote->saveQuietly();

                // SET ALL USERS TO NOT VOTED
                User::where('vote', 1)
                    ->update([
                        'vote' => 0,
                        'vote_date' => null,
                    ]);

                // CREATE ALL DE BLOCKS-PLATES VOTES RESULTS RECORDS
                VoteResult::truncate();
                $blocks = Block::with([
                    'plates' => function($query) {
                        $query->whereHas('plate');
                    },
                    'plates.plate',
                ])
                    ->get();

                foreach($blocks as $block) {

                    // NOT BLANKS VOTE
                    foreach($block->plates as $blockPlate) {
                        VoteResult::create([
                            'block_id' => $block->id,
                            'plate_id' => $blockPlate->plate->id,
                        ]);
                    }

                    // BLANKS VOTE
                    VoteResult::create([
                        'block_id' => $block->id,
                    ]);
                }
            }
        }
    }

    /**
     * Handle the Vote "deleted" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function deleted(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "restored" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function restored(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "force deleted" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function forceDeleted(Vote $vote)
    {
        //
    }
}
