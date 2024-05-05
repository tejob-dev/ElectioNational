<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AgentDeSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentDeSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentDeSection::class;

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
            'telephone' => $this->faker->text(255),
            'section_id' => \App\Models\Section::factory(),
        ];
    }
}
