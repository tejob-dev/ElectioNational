<?php

namespace Database\Factories;

use App\Models\Quartier;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuartierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quartier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'section_id' => \App\Models\Section::factory(),
        ];
    }
}
