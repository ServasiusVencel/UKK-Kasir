@extends('layouts.navbar-petugas')

@section('content')
<div class="container mx-auto p-6">
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('petugas.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a> > Produk
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-14 h-14 object-cover rounded" style="max-width: 200px; max-height: 200px;"">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-xs text-gray-500">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->nama_produk }}</td>
                        <td class="px-6 py-4">{{ $product->stok }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection