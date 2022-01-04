<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
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
            'created_at' =>  $this->faker->dateTimeBetween('-10 years'),
        ];
    }
}
