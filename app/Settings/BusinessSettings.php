<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BusinessSettings extends Settings
{
    public ?string $company_name;
    public ?string $address;
    public ?string $city;
    public ?string $logo;
    public ?string $state;
    public ?string $postal_code;
    public ?string $country;
    public ?string $rbq;
    public ?string $business_number;
    public ?string $gst_hst;
    public ?string $pst;
    public ?string $remarks;

    public static function group(): string
    {
        return 'business';
    }
}
