<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(AgentDeSectionSeeder::class);
        $this->call(AgentDuBureauVoteSeeder::class);
        $this->call(AgentTerrainSeeder::class);
        $this->call(BureauVoteSeeder::class);
        $this->call(CandidatSeeder::class);
        $this->call(CommuneSeeder::class);
        $this->call(DepartementSeeder::class);
        $this->call(LieuVoteSeeder::class);
        $this->call(ParrainSeeder::class);
        $this->call(ProcesVerbalSeeder::class);
        $this->call(QuartierSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(SupLieuDeVoteSeeder::class);
        $this->call(UserSeeder::class);
    }
}
