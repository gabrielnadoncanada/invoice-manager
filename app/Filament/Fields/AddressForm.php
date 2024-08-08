<?php

namespace App\Filament\Fields;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Squire\Models\Country;
use Squire\Models\Region;

class AddressForm extends Forms\Components\Field
{
    protected string $view = 'filament-forms::components.group';

    public function getChildComponents(): array
    {
        return [

        ];
    }
}
