<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- Ini WAJIB ada
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'vncl',
            'email' => 'adminn@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'admin'
        ]);
    }
}