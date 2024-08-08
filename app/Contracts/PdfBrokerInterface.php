<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface PdfBrokerInterface
{
    public function download(Model $record, string $documentName, $reportName = null, $viewName = null);
}
