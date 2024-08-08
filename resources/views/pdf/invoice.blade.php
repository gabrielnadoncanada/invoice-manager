<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Invoice</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>

    <table border="1" >
        <tr>
            <td colspan="4">
                <h2>{{ setting('company_name') }}</h2>
                <p>{{ setting('address') }}<br>
                    {{ setting('city') }}, {{ setting('state') }} {{ setting('postal_code') }}, {{ setting('country') }}
                </p>
                <p>RBQ: {{ setting('rbq') }}</p>
                <p>N° d'entreprise: {{ setting('business_number') }}</p>
            </td>
            <td colspan="4" valign="top" align="right">
                <h2>FACTURE</h2>
                <p>N° facture: {{ $invoice->invoice_number }}<br>
                    Date: {{ $invoice->date->format('d-m-Y') }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="4">Vendu à:</td>
            <td colspan="4">Expédié à:</td>
        </tr>
        <tr>
            <td colspan="4">
                {{ $invoice->client->name }}<br>
                {{ $invoice->client->address }}<br>
                {{ $invoice->client->city }}, {{ $invoice->client->state }}
            </td>
            <td colspan="4">
                {{ $invoice->client->name }}<br>
                {{ $invoice->client->address }}<br>
                {{ $invoice->client->city }}, {{ $invoice->client->state }}
            </td>
        </tr>
        <tr>
            <td colspan="4">Description</td>
            <td colspan="1">Quantité</td>
            <td colspan="1">Prix unit.</td>
            <td colspan="1">Montant</td>
        </tr>
        @foreach ($invoice->invoiceItems as $item)
            <tr>
                <td colspan="5">{{ $item->product->name }}</td>
                <td colspan="1">{{ $item->quantity }}</td>
                <td colspan="1">{{ $item->unit_price }}</td>
                <td colspan="1">{{ $item->amount }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8">
                <strong>Services:</strong><br>
                @foreach ($invoice->services as $service)
                    {{ $service->name }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <strong>Autres:</strong><br>
                {{ setting('remarks') }}
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="4">Sous-total:</td>
            <td colspan="2">{{ $invoice->subtotal }}</td>
        </tr>
        <tr>
            <td colspan="2">GQ - TPS 5%, TVQ 9.975%</td>
            <td colspan="4">TPS/TVH</td>
            <td colspan="2">{{ $invoice->gst }}</td>
        </tr>
        <tr>
            <td colspan="2">TPS/TVH: {{ setting('gst_hst') }}</td>
            <td colspan="4">TVQ</td>
            <td colspan="2">{{ $invoice->pst }}</td>
        </tr>
        <tr>
            <td colspan="2">TVQ: {{ setting('pst') }}</td>
            <td colspan="4"><strong>Montant total</strong></td>
            <td colspan="2"><strong>{{ $invoice->total_amount }}</strong></td>
        </tr>
        <tr>
            <td colspan="8">Remarques: {{ setting('remarks') }}</td>
        </tr>
    </table>
</body>
</html>
