<?php

namespace App\Filament\Resources;

use App\Filament\AbstractResource;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class InvoiceResource extends AbstractResource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns()
                    ->schema([
                        Select::make(Invoice::CLIENT_ID)
                            ->relationship('client', Client::NAME)
                            ->required(),
                        DatePicker::make(Invoice::DATE)->required(),
                        TextInput::make(Invoice::INVOICE_NUMBER)->required()->numeric(),
                        TextInput::make(Invoice::SUBTOTAL)->required()->numeric(),
                        TextInput::make(Invoice::GST)->required()->numeric(),
                        TextInput::make(Invoice::PST)->required()->numeric(),
                        TextInput::make(Invoice::TOTAL_AMOUNT)->required()->numeric(),
                        Select::make('service_id')
                            ->relationship('services', 'name')
                            ->multiple()
                            ->searchable()
                            ->columnSpanFull()
                            ->preload()
                            ->required(),
                        TableRepeater::make('products')
                            ->relationship('invoiceItems')
                            ->reorderable()
                            ->distinct()
                            ->headers([
                                Header::make('Produit'),
                                Header::make('Quantité'),
                            ])
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->options(function () {
                                        $products = Product::with('category')->get();

                                        $options = [];

                                        foreach ($products as $product) {
                                            $categoryName = $product->category->name ?? 'Uncategorized'; // Handle cases where category might be null
                                            $options[$categoryName][$product->id] = $product->name;
                                        }

                                        return $options;
                                    })
                                    ->required(),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric(),
                            ])->columnSpanFull()
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.' . Client::NAME)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Invoice::INVOICE_NUMBER)->sortable()->searchable(),
                Tables\Columns\TextColumn::make(Invoice::DATE)->date(),
                Tables\Columns\TextColumn::make(Invoice::TOTAL_AMOUNT)->sortable()->searchable()->money('CAD', true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('generatePDF')
                    ->label('Generate PDF')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->action(function ($record) {
                        $pdf = PDF::loadView('pdf.invoice', ['invoice' => $record]);
                        return response()->streamDownload(
                            fn() => print($pdf->stream()),
                            "invoice_{$record->invoice_number}.pdf"
                        );
                    }),

            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
