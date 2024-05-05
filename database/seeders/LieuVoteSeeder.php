<?php

namespace Database\Seeders;

use App\Models\LieuVote;
use Illuminate\Database\Seeder;

class LieuVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LieuVote::factory()
            ->count(5)
            ->create();
    }
}
