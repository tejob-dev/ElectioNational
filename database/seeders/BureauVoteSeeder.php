<?php

namespace Database\Seeders;

use App\Models\BureauVote;
use Illuminate\Database\Seeder;

class BureauVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BureauVote::factory()
            ->count(5)
            ->create();
    }
}
