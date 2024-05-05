<?php

namespace Database\Seeders;

use App\Models\Candidat;
use Illuminate\Database\Seeder;

class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidat::factory()
            ->count(5)
            ->create();
    }
}
