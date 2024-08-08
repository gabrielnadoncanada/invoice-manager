<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected static string $layout = 'components.layouts.print';

    protected static string $view = 'filament.resources.work-order-resource.pages.print-work-order';

    protected function getActions(): array
    {
        return [];
    }
}
