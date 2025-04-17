<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ProductExport implements FromCollection
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                'Nama Produk' => $item['nama_barang'],
                'Harga' => $item['harga_barang'],
                'Stok' => $item['stok_barang'],
            ];
        });
    }
}
