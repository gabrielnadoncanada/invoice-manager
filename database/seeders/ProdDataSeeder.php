<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->seedClients();
        $this->seedServices();
        $this->seedProducts();
        $this->seedInvoices();
    }

    private function seedUsers(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@invoicemanager.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function seedClients(): void
    {
        Client::factory()->create([
            Client::NAME => 'Chantal Gagnon',
            Client::ADDRESS => '12310 chemin riviere du nord',
            Client::CITY => 'Mirabel',
            Client::STATE => 'Québec',
        ]);
    }

    private function seedServices(): void
    {
        $services = [
            'Installation de toiles',
            'Réfection de toiture',
            'Ménage et nettoyage des gouttières',
            'Installation de membrane en partance',
            'Installation de la sous-couche',
            'Installation des paquets de bardeaux',
            'Installation de ventilateur',
            'Installation des chapeaux',
            'Grand ménage de finition'
        ];

        foreach ($services as $serviceDescription) {
            Service::factory()
                ->sequence(fn($sequence) => ['name' => $serviceDescription])
                ->create();
        }
    }

    private function seedProducts(): void
    {
        $categories = [
            'Bardeaux' => [
                ['name' => 'GAF Timberline HDZ', 'price' => 26.50],
                ['name' => 'GAF Seal A Ridge', 'price' => 42],
                ['name' => 'GAF Timbertex Hip & Ridge Rouge Patriot', 'price' => 51],
                ['name' => 'BP Mystique', 'price' => 27.15],
                ['name' => 'BP Dakota', 'price' => 25],
            ],
            'Sous-couche' => [
                ['name' => 'GAF Pro-Start - Starter Strip Shingle', 'price' => 37.25],
                ['name' => 'GAF DeckArmour', 'price' => 231.75],
                ['name' => 'GAF Stormguard Film-Surfaced', 'price' => 79.50],
                ['name' => 'GAF Weather Watch Mineral Surfaced', 'price' => 67],
                ['name' => 'Grace Ice and Water - 225 Sqft.', 'price' => 161.25],
                ['name' => 'Lexmat Ice & Water Shield (Sanded)', 'price' => 50.25],
                ['name' => 'Lexmat Synthetique', 'price' => 98.75],
            ],
            'Accessoires' => [
                ['name' => 'Vallée 9" x 9"', 'price' => 13.25],
                ['name' => 'Équerre 3" x 3"', 'price' => 7.50],
                ['name' => 'Solin Aluminium 1.5" x 10" (200pi.In)', 'price' => 75],
                ['name' => 'Ventilateur Lexmat R412', 'price' => 108.75],
                ['name' => 'Ventilateur Lexmat R112', 'price' => 66.75],
                ['name' => 'Ventilateur Lexmat R312', 'price' => 100],
                ['name' => 'Event Galvanisé', 'price' => 12],
                ['name' => 'Cap Plastique 5"-3"', 'price' => 6],
                ['name' => 'Cap Métal Couleur', 'price' => 6.50],
                ['name' => 'Manchon Métal Couleur', 'price' => 5],
            ],
            'Quincaillerie' => [
                ['name' => 'CT-4', 'price' => 45],
                ['name' => 'CT-6', 'price' => 47.50],
                ['name' => 'CT-10', 'price' => 50],
                ['name' => 'Ciment plastique 13,6 KG ÉTÉ', 'price' => 38.75],
                ['name' => 'Ciment plastique 13,6 KG HIVER', 'price' => 43.75],
                ['name' => 'Ciment plastique 20 KG ÉTÉ', 'price' => 50],
                ['name' => 'Ciment plastique 20 KG HIVER', 'price' => 56.25],
                ['name' => 'Clous à pistolett 1 1/4" Lexmat', 'price' => 31.75],
                ['name' => 'Vidange de bardeaux', 'price' => 400],
                ['name' => 'Feuille de contreplaqué 1/2', 'price' => 45],
            ],
            'Autres' => [
                ['name' => 'Sous-traitance', 'price' => 50],
            ],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::factory()
                ->sequence(fn($sequence) => ['name' => $categoryName])
                ->create();

            foreach ($products as $product) {
                Product::factory()
                    ->sequence(fn($sequence) => [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'category_id' => $category->id,
                    ])
                    ->create();
            }
        }
    }

    private function seedInvoices(): void
    {
        $client = Client::firstWhere(Client::NAME, 'Chantal Gagnon');

        $invoice = Invoice::factory()->create([
            Invoice::CLIENT_ID => $client->id,
            Invoice::DATE => '2021-09-26',
            Invoice::INVOICE_NUMBER => 156,
            Invoice::SUBTOTAL => 0,  // Will calculate below
            Invoice::GST => 0,
            Invoice::PST => 0,
            Invoice::TOTAL_AMOUNT => 0,  // Will calculate below
        ]);

        $products = $this->getInvoiceProducts();
        $subtotal = $this->createInvoiceItems($invoice, $products);

        $services = Service::all()->pluck('id')->toArray();
        $invoice->services()->attach($services);

        $this->updateInvoiceTotals($invoice, $subtotal);
    }

    private function createInvoiceItems(Invoice $invoice, array $products): float
    {
        $subtotal = 0;

        foreach ($products as $productData) {
            $product = Product::firstWhere('name', $productData['name']);

            if ($product) {
                InvoiceItem::factory()->create([
                    InvoiceItem::INVOICE_ID => $invoice->id,
                    InvoiceItem::PRODUCT_ID => $product->id,
                    InvoiceItem::QUANTITY => $productData['quantity'],
                    InvoiceItem::UNIT_PRICE => $product->price,
                    InvoiceItem::AMOUNT => $productData['quantity'] * $product->price
                ]);

                $subtotal += $productData['quantity'] * $product->price;
            }
        }

        return $subtotal;
    }

    private function updateInvoiceTotals(Invoice $invoice, float $subtotal): void
    {
        $gst = $subtotal * 0.05;  // Assuming 5% GST
        $pst = $subtotal * 0.09975;  // Assuming 9.975% PST
        $total = $subtotal + $gst + $pst;

        $invoice->update([
            Invoice::SUBTOTAL => $subtotal,
            Invoice::GST => $gst,
            Invoice::PST => $pst,
            Invoice::TOTAL_AMOUNT => $total,
        ]);
    }

    private function getInvoiceProducts(): array
    {
        return [
            ['name' => 'GAF Timberline HDZ', 'quantity' => 149],
            ['name' => 'GAF Pro-Start - Starter Strip Shingle', 'quantity' => 9],
            ['name' => 'Ventilateur Lexmat R412', 'quantity' => 2],
            ['name' => 'Clous à pistolet 1 1/4" Lexmat', 'quantity' => 4],
            ['name' => 'Lexmat Synthetique', 'quantity' => 5],
            ['name' => 'Event Galvanisé', 'quantity' => 1],
            ['name' => 'Ciment plastique 13,6 KG ÉTÉ', 'quantity' => 8],
            ['name' => 'Vallée 9\'\' x 9\'\'', 'quantity' => 11],
            ['name' => 'Lexmat Ice & Water Shield (Sanded)', 'quantity' => 11],
            ['name' => 'Équerre 3" x 3"', 'quantity' => 33],
            ['name' => 'GAF Seal A Ridge', 'quantity' => 28],
            ['name' => 'Vidange de bardeaux', 'quantity' => 3],
        ];
    }
}
