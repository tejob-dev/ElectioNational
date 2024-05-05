<?php

namespace Database\Factories;

use App\Models\Candidat;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidat::class;

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
            'code' => $this->faker->text(255),
            'photo' => $this->faker->text(255),
            'couleur' => $this->faker->text(255),
            'parti' => $this->faker->text(255),
        ];
    }
}
