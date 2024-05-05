<?php

namespace Database\Factories;

use App\Models\Parrain;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParrainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parrain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_pren_par' => $this->faker->text(255),
            'telephone_par' => $this->faker->text(255),
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'cart_milit' => 'Oui',
            'list_elect' => $this->faker->text(255),
            'cart_elect' => $this->faker->text(255),
            'telephone' => $this->faker->text(255),
            'date_naiss' => $this->faker->date,
            'code_lv' => $this->faker->text(255),
            'residence' => $this->faker->text(255),
            'profession' => $this->faker->text(255),
            'observation' => $this->faker->sentence(15),
        ];
    }
}
