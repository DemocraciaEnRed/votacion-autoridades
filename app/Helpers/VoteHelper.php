<?php

namespace App\Helpers;

use App\Models\Block;
use App\Models\User;

class VoteHelper {

    public static function totalVotes () {

        $totalVotes = 0;

        $block = Block::first();
        $voteResults = $block->votes;
        $voteBlanks = $block->votes_blank;

        foreach($voteResults as $voteResult) {
            $totalVotes += $voteResult->votes;
        }

        $totalVotes += $voteBlanks->votes;

        return $totalVotes;
    }

    public static function usersVote () {
        $users = User::where('vote', 1)
            ->get();

        return count($users);
    }

    public static function totalBlockVotes () {
        $totalBlockVotes = 0;

        $blocks = Block::all();

        foreach($blocks as $block) {

            foreach($block->votes as $voteResult) {
                $totalBlockVotes += $voteResult->votes;
            }

            $totalBlockVotes += $block->votes_blank->votes;
        }

        return $totalBlockVotes;
    }

}