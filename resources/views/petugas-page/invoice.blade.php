<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $saleData['sale_id'] }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 12px; 
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            color: #3498db;
            margin-bottom: 10px;
        }
        .report-info {
            font-size: 11px;
            color: #7f8c8d;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #3498db; 
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .date-printed {
            text-align: center;
            margin-bottom: 10px;
            font-style: italic;
            font-size: 11px;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .summary p {
            margin: 5px 0;
        }
        .member-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .member-info h3 {
            margin-top: 0;
            color: #3498db;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Warung AGS</div>
        <div class="report-title">INVOICE #{{ $saleData['sale_id'] }}</div>
        <div class="report-info">Jl. Asia-Afrika No. 123 </div>
    </div>
    
    <div class="date-printed">
        Tanggal Transaksi: {{ $saleData['date'] }} | Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
    
    @if($saleData['member_name'])
    <div class="member-info">
        <h3>Informasi Member</h3>
        <p><strong>Nama:</strong> {{ $saleData['member_name'] }}</p>
        <p><strong>Telepon:</strong> {{ $saleData['member_phone'] }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="50%">Produk</th>
                <th width="15%" class="text-right">Qty</th>
                <th width="20%" class="text-right">Harga</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saleData['products'] as $product)
            <tr>
                <td>{{ $product['product_name'] }}</td>
                <td class="text-right">{{ $product['qty'] }}</td>
                <td class="text-right">Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($product['qty'] * $product['price'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary text-right">
        <p><strong>Subtotal:</strong> Rp {{ number_format($saleData['sub_total'], 0, ',', '.') }}</p>
        @if($saleData['point_used'] > 0)
        <p><strong>Poin Digunakan:</strong> - Rp {{ number_format($saleData['point_used'], 0, ',', '.') }}</p>
        @endif
        <p><strong>Total:</strong> Rp {{ number_format($saleData['total'], 0, ',', '.') }}</p>
        <p><strong>Dibayar:</strong> Rp {{ number_format($saleData['amount_paid'], 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($saleData['change'], 0, ',', '.') }}</p>
    </div>
    
    
    <div class="footer">
        <p>Terima kasih atas pembelian Anda!</p>
        <p>Laporan ini dibuat secara otomatis oleh sistem.</p>
    </div>
</body>
</html>