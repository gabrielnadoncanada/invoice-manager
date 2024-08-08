<?php

namespace App\Services;

use App\Contracts\PdfBrokerInterface;
use Illuminate\Database\Eloquent\Model;

class PdfService
{
    public function __construct(
        protected PdfBrokerInterface $broker
    ) {
    }

    public function download(Model $record, string $documentName, $reportName = null, $viewName = null)
    {
        return $this->broker->download($record, $documentName, $reportName, $viewName);

    }
}
