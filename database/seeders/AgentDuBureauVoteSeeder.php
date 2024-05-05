<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgentDuBureauVote;

class AgentDuBureauVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgentDuBureauVote::factory()
            ->count(5)
            ->create();
    }
}
