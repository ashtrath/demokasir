<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html, body {
            height: auto !important;
        }

        body {
            font-size: 10pt;
            padding: 15px;
            text-align: center;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }
    </style>
</head>
<body>
<!-- Store Info -->
<h2 class="text-center">{{ $store_name }}</h2>
<p class="text-center">{{ $store_address }}</p>
<p class="text-center">No. Telp: {{ $store_phone }}</p>

<div class="divider"></div>

<!-- Transaction Info -->
<table>
    <tr>
        <td>{{ date('Y-m-d', strtotime($sale->created_at)) }}</td>
        <td class="text-right">{{ $cashier_name }}</td>
    </tr>
    <tr>
        <td>{{ date('H:i:s', strtotime($sale->created_at)) }}</td>
        <td class="text-right">No. {{ $sale->id }}</td>
    </tr>
</table>

<div class="divider"></div>

<!-- Items List -->
<table>
    <tbody>
    @foreach ($sale->detailSale as $key => $item)
        <tr>
            <td colspan="2" class="font-bold">{{ $key + 1 }}. {{ $item->item->name }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty }} x {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="divider"></div>

<!-- Totals -->
<p class="text-left" style="margin-bottom: 8px">Total QTY: {{ $sale->detailSale->sum("qty") }}</p>

<table>
    <tr class="font-bold">
        <td>Total</td>
        <td class="text-right">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Bayar (Cash)</td>
        <td class="text-right">Rp {{ number_format($sale->cash_tendered, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Kembali</td>
        <td class="text-right">Rp {{ number_format($sale->cash_tendered - $sale->total, 0, ',', '.') }}</td>
    </tr>
</table>

<div class="divider"></div>

<!-- Footer -->
<p class="text-center">Terimakasih Telah Berbelanja!</p>
</body>
</html>
