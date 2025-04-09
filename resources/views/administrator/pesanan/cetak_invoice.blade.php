<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .total { font-weight: bold; font-size: 18px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">

    <div class="invoice-box">
        <h2 class="text-center">Invoice</h2>
        <p><strong>No Invoice:</strong> {{ $pesanan->no_invoice }}</p>
        <p><strong>Tanggal:</strong> {{ date('d M Y', strtotime($pesanan->created_at)) }}</p>
        <p><strong>Customer:</strong> {{ $pesanan->customer->nama }}</p>
        <p><strong>Sales:</strong> {{ $pesanan->sales->nama }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($pesanan->produk as $index => $item)
                    @php
                        $subtotal = $item->pivot->jumlah * $item->harga;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right total">Total Harga</td>
                    <td class="total">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
