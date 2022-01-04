<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(random_int(10,50))->create();
        Seller::factory()->count(random_int(10,50))->create();
        Product::factory()->count(random_int(10,50))->create();

        Invoice::factory()->count(random_int(10,20))->create()->each(function ($invoice) {
            $invoice->products()->attach(Product::inRandomOrder()->first()->id);
        });
    }
}
