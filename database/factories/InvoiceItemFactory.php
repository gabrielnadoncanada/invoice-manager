<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition()
    {
        return [
            InvoiceItem::INVOICE_ID => Invoice::factory(),
            InvoiceItem::PRODUCT_ID => Product::factory(),
            InvoiceItem::QUANTITY => $this->faker->numberBetween(1, 100),
            InvoiceItem::UNIT_PRICE => $this->faker->randomFloat(2, 10, 500),
            InvoiceItem::AMOUNT => $this->faker->randomFloat(2, 10, 5000),
        ];
    }
}
