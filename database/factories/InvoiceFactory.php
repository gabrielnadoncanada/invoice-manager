<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            Invoice::CLIENT_ID => Client::factory(),
            Invoice::DATE => $this->faker->date,
            Invoice::INVOICE_NUMBER => $this->faker->unique()->numberBetween(1000, 9999),
            Invoice::SUBTOTAL => $this->faker->randomFloat(2, 100, 5000),
            Invoice::GST => $this->faker->randomFloat(2, 5, 500),
            Invoice::PST => $this->faker->randomFloat(2, 5, 500),
            Invoice::TOTAL_AMOUNT => $this->faker->randomFloat(2, 110, 5500),
        ];
    }
}
