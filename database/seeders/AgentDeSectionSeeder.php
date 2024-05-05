<?php

namespace Database\Seeders;

use App\Models\AgentDeSection;
use Illuminate\Database\Seeder;

class AgentDeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgentDeSection::factory()
            ->count(5)
            ->create();
    }
}
