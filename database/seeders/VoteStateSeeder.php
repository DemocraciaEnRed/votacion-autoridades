<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vote_states')->insert([
            ['name' => 'Pre-votación',],
            ['name' => 'Votación',],
            ['name' => 'Pre-resultados',],
            ['name' => 'Resultados',],
        ]);
    }
}
