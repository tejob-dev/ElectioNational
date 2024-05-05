<?php

namespace Database\Seeders;

use App\Models\AgentTerrain;
use Illuminate\Database\Seeder;

class AgentTerrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgentTerrain::factory()
            ->count(5)
            ->create();
    }
}
