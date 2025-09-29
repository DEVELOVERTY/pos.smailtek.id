<!-- Header Informasi -->
<div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;">
    <h2 style="margin: 0; text-align: center; color: #333;">LAPORAN PENJUALAN</h2>
    <p style="margin: 5px 0; text-align: center;">Tanggal Export: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    @if(request()->has('start_date') && request()->has('end_date') && request('start_date') && request('end_date'))
    <p style="margin: 5px 0; text-align: center;">Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}</p>
    @endif
    @if(request()->has('payment_method') && request('payment_method'))
    <p style="margin: 5px 0; text-align: center;">Filter Metode Pembayaran: {{ ucfirst(request('payment_method')) }}</p>
    @endif
</div>

<table border="1" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="13" style="background-color: #4CAF50; color: white; text-align: center; font-size: 16px; height: 35px; font-weight: bold; padding: 8px;">
                DATA TRANSAKSI PENJUALAN
            </th>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Tanggal</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 120px;">No. Referensi</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Toko</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 120px;">Pelanggan</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Status Bayar</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 80px;">Jml Produk</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 80px;">Qty Jual</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 120px;">Total Amount</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 120px;">Jumlah Bayar</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Metode Bayar</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 120px;">Sisa Hutang</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Profit</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; width: 100px;">Kasir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i') }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: left;">{{ $d->ref_no }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: left;">{{ $d->store->name ?? '-' }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: left;">{{ $d->customer->name ?? '-' }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ $status[$d->status] ?? '-' }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ ($d->sell ? $d->sell->count() : 0) }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ $d->qty_sell ?? 0 }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: right;">Rp {{ number_format(is_numeric($d->final_total) ? (float)$d->final_total : 0, 0, ',', '.') }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: right;">Rp {{ number_format(is_numeric($d->pay_total) ? (float)$d->pay_total : 0, 0, ',', '.') }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ $d->method ?? '-' }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: right;">Rp {{ number_format(is_numeric($d->due_total) ? (float)$d->due_total : 0, 0, ',', '.') }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: right;">Rp {{ number_format(is_numeric($d->calculated_profit) ? (float)$d->calculated_profit : 0, 0, ',', '.') }}</td>
            <td style="border: 1px solid #ddd; padding: 6px; text-align: left;">{{ $d->createdby->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #4CAF50; color: white; font-weight: bold;">
            <td colspan="7" style="border: 1px solid #ddd; padding: 10px; text-align: center; font-size: 14px; font-weight: bold;">
                <b>TOTAL KEUNTUNGAN: Rp {{ number_format(is_numeric($jumlahProfit) ? (float)$jumlahProfit : 0, 0, ',', '.') }}</b>
            </td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: right; font-weight: bold;">
                <b>Rp {{ number_format(is_numeric($jumlahTotal) ? (float)$jumlahTotal : 0, 0, ',', '.') }}</b>
            </td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: right; font-weight: bold;">
                <b>Rp {{ number_format(is_numeric($jumlahTerbayar) ? (float)$jumlahTerbayar : 0, 0, ',', '.') }}</b>
            </td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"></td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: right; font-weight: bold;">
                <b>Rp {{ number_format(is_numeric($jumlahHutang) ? (float)$jumlahHutang : 0, 0, ',', '.') }}</b>
            </td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: right; font-weight: bold;">
                <b>Rp {{ number_format(is_numeric($jumlahProfit) ? (float)$jumlahProfit : 0, 0, ',', '.') }}</b>
            </td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"></td>
        </tr>
    </tfoot>
</table>
