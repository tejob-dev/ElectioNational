<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AgentDuBureauVote;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentDuBureauVoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentDuBureauVote::class;

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
            'telphone' => $this->faker->text(255),
            'bureau_vote_id' => \App\Models\BureauVote::factory(),
        ];
    }
}
