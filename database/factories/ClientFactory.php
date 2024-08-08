<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Squire\Models\Region;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        $countryCode = 'ca';

        return [
            Client::NAME => $this->faker->name,
            Client::ADDRESS => $this->faker->streetAddress,
            Client::CITY => $this->faker->city,
            Client::STATE => Region::where('country_id', $countryCode)->inRandomOrder()->first()->id,
            Client::POSTAL_CODE => $this->faker->postcode,
            Client::COUNTRY => $countryCode,
        ];
    }
}
