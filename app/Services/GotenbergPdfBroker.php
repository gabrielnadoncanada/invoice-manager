<?php

namespace App\Services;

use App\Contracts\PdfBrokerInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GotenbergPdfBroker implements PdfBrokerInterface
{
    public function download(Model $record, string $documentName, $reportName = null, $viewName = null)
    {
        return response()->streamDownload(
            function () use ($record, $reportName, $viewName) {
                $viewName = $viewName ?? Str::kebab($record->getMorphClass());

                if (method_exists($record, 'loadRelationsForPrint')) {

                    $record->loadRelationsForPrint();
                }

                $response = Http::withOptions([
                    'curl' => [
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    ],
                    'debug' => true,
                ])
                    ->attach(
                        'files',
                        view('print.footer', ['reportName' => $reportName ?? $record->getMorphClass()])->render(),
                        'footer.html'
                    )
                    ->attach(
                        'files',
                        view('print.'.$viewName, compact('record'))->render(),
                        'index.html'
                    )
                    ->post('http://'.config('app.gotenberg_host').':3000/forms/chromium/convert/html', [
                        'failOnConsoleExceptions' => true,
                        'skipNetworkIdleEvent' => true,
                    ]);

                echo $response->body();
            },
            $documentName
        );

    }
}
