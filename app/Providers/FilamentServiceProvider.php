<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

        Table::$defaultDateDisplayFormat = 'j M o';
        Table::$defaultDateTimeDisplayFormat = 'j M o H:i:s';
        Table::$defaultTimeDisplayFormat = 'H:i:s';
        Table::configureUsing(function (Table $table): void {
            $table
                ->defaultPaginationPageOption(10)
                ->paginationPageOptions([5, 10, 25, 50]);
        });

        TextInput::configureUsing(function (TextInput $input): void {
            $input->maxLength(255);
        });

        Field::configureUsing(function (Field $field): void {
            $field->label(function () use ($field): string {
                $fieldName = $field->getName();

                return __("filament.fields.$fieldName");
            });
        });

        Column::configureUsing(function (Column $column): void {
            $column->label(function () use ($column): string {
                $fieldName = $column->getName();

                return __("filament.fields.$fieldName");
            });
        });
    }
}
