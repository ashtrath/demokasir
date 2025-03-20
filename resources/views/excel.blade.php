<table>
    <thead>
        <tr>
            <td style="font-weight: 600;" colspan="7" align="center">{{ auth()->user()->store_name }}</td>
        </tr>
        <tr>
            <td style="font-weight: 600;" colspan="7" align="center">Laporan Penjualan</td>
        </tr>
        <tr>
            <td style="font-weight: 600;" colspan="7" align="center">Periode {{ $dates[0] }} @if($dates[0] != $dates[1]) - {{ $dates[1] }} @endif {{ $dates[2] }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: 600; border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">No</td>
            <td style="font-weight: 600; border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">Tanggal</td>
            <td style="font-weight: 600; border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">Total</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
        <tr>
            <td></td>
            <td></td>
            <td style="border: 1px solid black;">
                {{ $loop->iteration }}
            </td>
            <td style="border: 1px solid black;">
                {{ $sale->created_at }}
            </td>
            <td style="border: 1px solid black;">
                {{ $sale->total }}
            </td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td style="border: 1px solid black; font-weight: 600;" align="center" valign="center" colspan="2">
                Total
            </td>
            <td style="border: 1px solid black; font-weight: 600;">
                {{ $total }}
            </td>
        </tr>
    </tbody>
</table>