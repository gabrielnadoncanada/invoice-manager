<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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
        ];
    }
}
