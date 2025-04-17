<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Product;

class PetugasController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Atau bisa pake paginate() jika data banyak
        return view('petugas-page.product', compact('products'));
    }
}
