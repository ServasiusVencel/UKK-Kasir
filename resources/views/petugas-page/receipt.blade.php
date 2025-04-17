@extends('layouts.navbar-petugas')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Sales Receipt</h1>
            <p class="text-gray-600">Transaction #{{ $saleData['sale_id'] }}</p>
            <p class="text-gray-600">{{ $saleData['date'] }}</p>
        </div>

        @if($saleData['member_name'])
        <div class="mb-4">
            <h2 class="font-bold">Member Information</h2>
            <p>Name: {{ $saleData['member_name'] }}</p>
            <p>Phone: {{ $saleData['member_phone'] }}</p>
            <p>Points: {{ $saleData['member_point'] }}</p>
        </div>
        @endif

        <div class="border-t border-b py-4 my-4">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left">Item</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
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
        </div>

        <div class="mb-4">
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($saleData['sub_total'], 0, ',', '.') }}</span>
            </div>
            @if($saleData['point_used'] > 0)
            <div class="flex justify-between">
                <span>Points Used:</span>
                <span>- Rp {{ number_format($saleData['point_used'], 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between font-bold">
                <span>Total:</span>
                <span>Rp {{ number_format($saleData['total'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Amount Paid:</span>
                <span>Rp {{ number_format($saleData['amount_paid'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Change:</span>
                <span>Rp {{ number_format($saleData['change'], 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-gray-600">Thank you for your purchase!</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="{{ route('sales.invoice', $saleData['sale_id']) }}" class="btn btn-primary">Print Invoice</a>
                <a href="{{ route('sales.products') }}" class="btn btn-outline">New Sale</a>
            </div>
        </div>
    </div>
@endsection