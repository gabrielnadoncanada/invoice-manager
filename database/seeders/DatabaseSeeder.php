<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories first
        $categories = Category::factory()->count(5)->create();

        // Create products and associate them with random categories
        $categories->each(function ($category) {
            Product::factory()->count(4)->create(['category_id' => $category->id]);
        });

        // Create clients
        Client::factory()->count(10)->create();

        // Create invoices and invoice items
        Invoice::factory()->count(5)->create()->each(function ($invoice) {
            InvoiceItem::factory()->count(3)->create(['invoice_id' => $invoice->id]);
        });

        // Create services
        Service::factory()->count(5)->create();
    }
}
