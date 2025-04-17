<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class SalesExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $filter;

    /**
     * Constructor to set filter parameter
     *
     * @param string|null $filter
     */
    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * Get the collection of items to export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DB::table('sales as s')
            ->join('sale_details as d', 's.id', '=', 'd.sale_id')
            ->join('products as p', 'p.id', '=', 'd.product_id')
            ->leftJoin('members as m', 'm.id', '=', 's.member_id')
            ->select(
                's.id as sale_id',
                's.date as purchase_date',
                'm.name as member_name',
                'm.no_telp as member_phone',
                'm.poin as member_points',
                'm.date as member_join_date',
                's.total as total_amount',
                's.amount_paid as cash_paid',
                's.point_used',
                's.change as change_amount',
                DB::raw('SUM(d.product_price * d.product_qty) as subtotal')
            )
            ->groupBy(
                's.id',
                's.date',
                'm.name',
                'm.no_telp',
                'm.poin',
                'm.date',
                's.total',
                's.amount_paid',
                's.point_used',
                's.change'
            );

        if ($this->filter === 'daily') {
            $query->whereDate('s.date', Carbon::today());
        } elseif ($this->filter === 'weekly') {
            $query->whereBetween('s.date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($this->filter === 'monthly') {
            $query->whereMonth('s.date', Carbon::now()->month)
                  ->whereYear('s.date', Carbon::now()->year);
        }

        return $query->orderBy('s.date', 'desc')->get();
    }

    /**
     * Map the data to be exported
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Get product details for this sale
        $productDetails = DB::table('sale_details as d')
            ->join('products as p', 'p.id', '=', 'd.product_id')
            ->where('d.sale_id', $row->sale_id)
            ->select(
                'p.nama_produk as product_name',
                'd.product_qty as quantity',
                'd.product_price as price'
            )
            ->get();

        $productDetailsFormatted = $productDetails->map(function($item) {
            return "{$item->product_name} ({$item->quantity} pcs : Rp. {$item->price})";
        })->implode(' , ');

        return [
            $row->purchase_date ? Carbon::parse($row->purchase_date)->format('d/m/Y') : '',
            $row->member_name ?? 'Non-Member',
            $row->member_phone ?? '-',
            $row->member_points ?? 0,
            $row->member_join_date ? Carbon::parse($row->member_join_date)->format('d/m/Y') : '-',
            $productDetailsFormatted,
            $row->total_amount,
            $row->cash_paid,
            $row->point_used,
            $row->change_amount,
            $row->subtotal, // Profit/subtotal
        ];
    }

    /**
     * Set the headings for the exported file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tanggal Pembelian',
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Tanggal Bergabung',
            'Detail Produk',
            'Total Pembayaran',
            'Pembayaran Tunai',
            'Poin Digunakan',
            'Kembalian',
            'Profit'
        ];
    }

    /**
     * Set the title of the worksheet
     *
     * @return string
     */
    public function title(): string
    {
        $title = 'Sales Report';
        
        if ($this->filter === 'daily') {
            $title .= ' - Daily (' . Carbon::today()->format('d/m/Y') . ')';
        } elseif ($this->filter === 'weekly') {
            $title .= ' - Weekly (' . 
                Carbon::now()->startOfWeek()->format('d/m/Y') . ' to ' . 
                Carbon::now()->endOfWeek()->format('d/m/Y') . ')';
        } elseif ($this->filter === 'monthly') {
            $title .= ' - Monthly (' . Carbon::now()->format('F Y') . ')';
        }
        
        return $title;
    }
}