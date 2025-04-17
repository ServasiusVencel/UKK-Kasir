@extends('layouts.navbar-admin')
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs text-sm">
      <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
    </div>
        </ul>
    </div>
    <h1 class="text-4xl font-bold mt-2">DASHBOARD</h1>

    <!-- main -->
    <div class="overflow-x-auto mt-8">
        @if (Auth::user()->role === 'admin')
            <p class="text-2xl">Selamat Datang, Administrator!</p>

            <div class="grid grid-cols-4 gap-4 mt-8">
                <div class="shadow-lg rounded-lg p-4 col-span-3 flex flex-col items-center">
                    <h2 class="text-lg font-semibold text-center">Grafik Penjualan Harian</h2>
                    <canvas id="salesChart" class="w-full h-[50px]"></canvas>
                </div>

                <div class="shadow-lg rounded-lg p-4 col-span-1 flex flex-col items-center">
                    <h2 class="text-lg font-semibold text-center">Penjualan Produk</h2>
                    <canvas id="productChart" class="w-full h-[50px]"></canvas>
                </div>

            </div>
            
            {{-- <a href="{{ route('dashboard.exportProfit') }}" class="btn btn-success text-white w-full">Export</a> --}}
        @else
            <p class="text-2xl">Selamat Datang, Petugas!</p>
            <div class="card shadow-xl p-2 w-full">
                <div class="mt-4 card bg-base-300 rounded-lg p-5 text-center">
                    <p>Total Penjualan Hari Ini</p>
                    <p class="text-2xl m-8">{{ $today_sale }}</p>
                    <p>Jumlah total penjualan yang terjadi hari ini.</p>
                </div>
                {{-- <a href="{{ route('dashboard.exportProfit') }}" class="btn btn-success text-white">Export</a> --}}
                <div class="grid grid-cols-2 gap-6 mt-8">
                    <div
                        class="card bg-base-300 rounded-lg p-5 text-center shadow-xl hover:shadow-2xl transition duration-300">
                        <div class="flex justify-center items-center mb-4">
                            <i class="fas fa-calendar-day text-xl text-blue-500"></i>
                        </div>
                        <p class="text-2xl font-semibold mb-2">Profit Hari ini</p>
                        <p class="text-lg text-gray-600">Rp. {{ number_format($profittoday, 0, ',', '.') }}</p>
                    </div>

                    <div
                        class="card bg-base-300 rounded-lg p-5 text-center shadow-xl hover:shadow-2xl transition duration-300">
                        <div class="flex justify-center items-center mb-4">
                            <i class="fas fa-calendar-week text-xl text-green-500"></i>
                        </div>
                        <p class="text-2xl font-semibold mb-2">Profit Minggu ini</p>
                        <p class="text-lg text-gray-600">Rp. {{ number_format($profitweek, 0, ',', '.') }}</p>
                    </div>
                </div>

            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: {!! json_encode($totals) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {!! json_encode($product_name) !!},
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: {!! json_encode($product_qty) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection