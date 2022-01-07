<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vat_nr' => $this->faker->numerify('##########'),
            'name' => $this->faker->word(),
            'created_at' =>  $this->faker->dateTimeBetween('-10 years'),
        ];
    }
}
