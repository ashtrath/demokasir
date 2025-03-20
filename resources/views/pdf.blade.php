<div style="width: 100%; display: flex; flex-direction: column; gap: 1rem; justify-items: center; font-family: Arial">
    <div style="font-weight: 600; text-align: center">
        <p>{{ auth()->user()->store_name }}</p>
        <p>Laporan Penjualan</p>
        <p>Periode {{ $dates[0] }} @if($dates[0] != $dates[1]) - {{ $dates[1] }} @endif {{ $dates[2] }} </p>
    </div>
    <table border=1 style="width: 500px; text-align: center; border-collapse: collapse; margin: 0 auto 0 auto;">
        <thead>
            <tr style="background-color: #CFE3F4; font-weight: 600;">
                <td style="padding: .5rem">No</td>
                <td style="padding: .5rem">Tanggal</td>
                <td style="padding: .5rem">Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $sale->created_at }}
                </td>
                <td style="text-align: right;">
                    @currency($sale->total)
                </td>
            </tr>
            @endforeach
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th style="text-align: right;">@currency($total)</th>
                </tr>
            </tfoot>
        </tbody>
    </table>
</div>