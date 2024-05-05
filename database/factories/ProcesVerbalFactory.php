<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProcesVerbal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcesVerbalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProcesVerbal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'libel' => $this->faker->text(255),
            'photo' => $this->faker->text(255),
            'bureau_vote_id' => \App\Models\BureauVote::factory(),
        ];
    }
}
