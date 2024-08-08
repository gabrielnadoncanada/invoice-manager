<?php

namespace App\Filament\Resources;

use App\Filament\AbstractResource;
use App\Filament\Fields\AddressForm;
use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Squire\Models\Country;
use Squire\Models\Region;

class ClientResource extends AbstractResource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make(Client::NAME)->required(),

                    ]),
                Section::make('Address')
                    ->columns()
                    ->schema([
                        Select::make(Client::COUNTRY)
                            ->searchable()
                            ->optionsLimit(250)
                            ->required()
                            ->live(onBlur: true)
                            ->default('ca')
                            ->options(Country::whereIn('id', ['ca'])->pluck('name', 'id')),
                        Select::make(Client::STATE)
                            ->options(fn(Get $get) => Region::where('country_id', $get('country'))->orderBy('name')->pluck('name', 'id'))
                            ->hidden(fn(Select $component) => count($component->getOptions()) === 0)
                            ->required()
                            ->default('ca-qc')
                            ->key('dynamicStateOptions'),
                        TextInput::make(Client::ADDRESS)->required(),
                        TextInput::make(Client::CITY)->required(),
                        TextInput::make(Client::POSTAL_CODE)->required()
                            ->regex('/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(Client::NAME)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Client::ADDRESS)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Client::CITY)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Client::STATE)->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),

        ];
    }
}
