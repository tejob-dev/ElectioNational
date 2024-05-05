<?php

namespace Database\Seeders;

use App\Models\ProcesVerbal;
use Illuminate\Database\Seeder;

class ProcesVerbalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcesVerbal::factory()
            ->count(5)
            ->create();
    }
}
