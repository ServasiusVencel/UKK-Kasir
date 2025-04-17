<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\User;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email', 
            'Role',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    public function map($user): array
    {
        static $i = 1;
        return [
            $i++,
            $user->name,
            $user->email,
            $user->role,
            $user->created_at->format('d-m-Y H:i:s'),
            $user->updated_at->format('d-m-Y H:i:s')
        ];
    }
}