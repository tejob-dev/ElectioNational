<?php

namespace Database\Factories;

use App\Models\LieuVote;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LieuVoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LieuVote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique->text(255),
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'quartier_id' => \App\Models\Quartier::factory(),
        ];
    }
}
