<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakeCreatedDate = $this->faker->dateTimeBetween('-10 years');
        return [
            'seller_id' => Seller::inRandomOrder()->first()->id,
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'invoice_date' => $fakeCreatedDate->format('Y-m-d'),
            'created_at' =>  $fakeCreatedDate,
            'updated_at' =>  $this->faker->dateTimeBetween($fakeCreatedDate, Carbon::now())
        ];
    }
}
