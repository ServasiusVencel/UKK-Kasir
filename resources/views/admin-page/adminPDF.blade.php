<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Produk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Produk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item['nama_barang'] }}</td>
                <td>Rp {{ number_format($item['harga_barang'], 0, ',', '.') }}</td>
                <td>{{ $item['stok_barang'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
