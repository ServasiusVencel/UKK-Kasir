@extends('layouts.navbar-admin')

@section('content')
<div class="container mx-auto p-6">
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a> > Penjualan
    </div>

    <form action="{{ route('admin.sale') }}" method="GET" class="flex space-x-4 w-full max-w-xl">
        <div class="relative w-1/2">
            <input type="text" name="keyword" value="{{ request('keyword') }}" 
                class="w-full p-2 pl-10 rounded border border-gray-300 focus:outline-none focus:border-blue-500" 
                placeholder="Cari nama pelanggan...">
            <span class="absolute left-0 top-0 mt-2 ml-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
        </div>
    
        <div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Cari
            </button>
        </div>
        <div class="dropdown dropdown-end">
            <button class="btn btn-success text-white">Export</button>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-2">
                <li><a href="{{ route('admin.exportInvoice', ['filter' => 'daily']) }}">Export Harian</a></li>
                <li><a href="{{ route('admin.exportInvoice', ['filter' => 'weekly']) }}">Export Mingguan</a></li>
                <li><a href="{{ route('admin.exportInvoice', ['filter' => 'monthly']) }}">Export Bulanan</a></li>
                <li><a href="{{ route('admin.exportInvoice') }}">Export Semua</a></li>
            </ul>
        </div>
    </form>
    

    </div>

    <!-- Tabel Penjualan -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nama Pelanggan</th>
                    <th scope="col" class="px-6 py-3">Tanggal Penjualan</th>
                    <th scope="col" class="px-6 py-3">Total Harga</th>
                    <th scope="col" class="px-6 py-3">Dibuat oleh</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $sale)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $index + $data->firstItem() }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $sale->member_name ?? 'Non-Member' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $sale->date }}
                    </td>
                    <td>Rp {{ number_format($sale->sub_total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        {{ $sale->created_by ?? 'Petugas' }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('sales.receipt', $sale->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-6">View</a>
                        <a href="{{ route('sales.invoice', $sale->id) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline">Invoice</a>
                    </td>
                </tr>
                @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="6" class="px-6 py-4 text-center">Tidak ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
@endsection