<?php

namespace Database\Seeders;

use App\Models\SupLieuDeVote;
use Illuminate\Database\Seeder;

class SupLieuDeVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupLieuDeVote::factory()
            ->count(5)
            ->create();
    }
}
