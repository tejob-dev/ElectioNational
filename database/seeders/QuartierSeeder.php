<?php

namespace Database\Seeders;

use App\Models\Quartier;
use Illuminate\Database\Seeder;

class QuartierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quartier::factory()
            ->count(5)
            ->create();
    }
}
