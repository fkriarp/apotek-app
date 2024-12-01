<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembelian</title>
    <style>
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;  
            flex-direction: column;
        }
        .card {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .button-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .btn-back {
            padding: 8px 12px;
            border-radius: 6px;
            color: #d1d5db;
            background-color: #4b5563;
            text-decoration: none;
        }
        .header, .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .header h1 {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .header a {
            color: #4b5563;
            text-decoration: none;
        }
        .info p {
            margin: 0.25rem 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 0.5rem;
            text-align: left;
        }
        th {
            background-color: #e5e7eb;
        }
        .total-row {
            background-color: #e5e7eb;
            font-weight: bold;
        }
        .footer p {
            font-size: 0.875rem;
        }
        .footer p.bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
        <div class="button-container">
            <a href="{{ route('kasir.order.index') }}" class="btn-back">Kembali</a>
        </div>
        <div class="card">
            <div class="header">
                <h1>Apotek Jaya Abadi</h1>
                <a href="{{ route('kasir.order.download', $order['id']) }}">Cetak (.pdf)</a>
            </div>
            <div class="info">
                <p>Alamat : sepanjang jalan kenangan</p>
                <p>Email : apotekjayaabadi@gmail.com</p>
                <p>Phone : 000-111-2222</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th>Total</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order['medicines'] as $medicine)
                    <tr>
                        <td>
                            <p>{{ $medicine['name_medicine'] }}</p>
                        </td>
                        <td>
                            <p>{{ $medicine['qty'] }}</p>
                        </td>
                        <td>
                            <p>Rp. {{ number_format($medicine['sub_price'],0,',','.') }}</p>
                        </td>
                    </tr>
                    @endforeach
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <tr class="total-row">
                        <td colspan="2">PPN (10%)</td>
                        <td>Rp. {{ number_format($ppn,0,',','.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="2">Total Harga</td>
                        <td>Rp. {{ number_format($order['total_price'] + $ppn,0,',','.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="footer">
                <p class="bold">Terima kasih atas pembelian Anda!</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores natus et numquam ducimus dolorum tenetur.</p>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
