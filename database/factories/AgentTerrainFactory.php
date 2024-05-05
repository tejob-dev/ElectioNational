<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AgentTerrain;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentTerrainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentTerrain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'code' => $this->faker->unique->text(255),
            'telephone' => $this->faker->unique->text(255),
            'lieu_vote_id' => \App\Models\LieuVote::factory(),
        ];
    }
}
