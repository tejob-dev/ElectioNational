<?php

namespace Database\Factories;

use App\Models\BureauVote;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BureauVoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BureauVote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'libel' => $this->faker->text(255),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'lieu_vote_id' => \App\Models\LieuVote::factory(),
        ];
    }
}
