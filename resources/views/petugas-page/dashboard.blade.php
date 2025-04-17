@extends('layouts.navbar-petugas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <br>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Selamat Datang, Petugas!</h2>
        
        <!-- Sales Card -->
        <div class="bg-blue-50 rounded-lg p-6 border border-blue-100">
            <h3 class="text-lg font-medium text-gray-700 mb-2">Total Penjualan Hari ini</h3>
            
            <div class="flex items-baseline space-x-2">
                <span class="text-4xl font-bold text-blue-600">{{ $todaySalesCount }}</span>
            </div>
            
            <p class="text-gray-600 mt-3 text-sm">
                Jumlah total penjualan yang terjadi hari ini.
            </p>
            
            <div class="mt-4 text-xs text-gray-500">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection