<?php

namespace App\Filament\Resources;

use App\Filament\AbstractResource;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class ProductResource extends AbstractResource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(Product::NAME)->required(),
                Select::make(Product::CATEGORY_ID)
                    ->relationship('category', Category::NAME)
                    ->required(),
                TextInput::make(Product::PRICE)->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(Product::NAME)->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.' . Category::NAME)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Product::PRICE)->sortable()->searchable()->money('USD', true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->filters([
                //
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
            'index' => Pages\ListProducts::route('/'),
        ];
    }
}
