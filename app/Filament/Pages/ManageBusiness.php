<?php

namespace App\Filament\Pages;

use App\Settings\BusinessSettings;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageBusiness extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = BusinessSettings::class;

    protected static ?string $title = 'Paramètres de l\'entreprise';
    protected static ?string $navigationGroup = 'Site';

    protected static ?int $navigationSort = 5;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns()
                    ->schema([
                        TextInput::make('company_name')
                            ->required(),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('city')
                            ->required(),
                        TextInput::make('state')
                            ->required(),
                        TextInput::make('postal_code')
                            ->required(),
                        TextInput::make('country')
                            ->required(),
                        TextInput::make('rbq')
                            ->required(),
                        TextInput::make('business_number')
                            ->required(),
                        TextInput::make('gst_hst')
                            ->required(),
                        TextInput::make('pst')
                            ->required(),
                        Textarea::make('remarks')
                        ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->image()
                    ])

            ]);
    }


}
