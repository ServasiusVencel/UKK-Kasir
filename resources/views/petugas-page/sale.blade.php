@extends('layouts.navbar-petugas')

@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs text-sm">
        <div class="mb-4 text-sm text-gray-500">
            <a href="{{ route('petugas.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a> > Laporan Penjualan
        </div>
    </div>
    <h1 class="text-4xl font-bold mt-2">Sales Transactions</h1>

    <div class="flex justify-between items-center mt-8">
        <div class="form-control">
            <form action="{{ route('sales.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="keyword" placeholder="Search by member name..." 
                           class="input input-bordered" value="{{ request('keyword') }}"/>
                    <button type="submit" class="btn btn-square">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('sales.products') }}" class="btn btn-primary">New Sale</a>
        </div>
    </div>

    <div class="overflow-x-auto mt-6">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction ID</th>
                    <th>Member</th>
                    <zth>Date</zth>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $sale)
                <tr>
                    <td>{{ $data->firstItem() + $key }}</td>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->member_name ?? 'Non-Member' }}</td>
                    <td>{{ $sale->date }}</td>
                    <td>Rp {{ number_format($sale->sub_total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('sales.receipt', $sale->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-sm btn-primary">Invoice</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $data->appends(['keyword' => request('keyword')])->links() }}
    </div>
@endsection