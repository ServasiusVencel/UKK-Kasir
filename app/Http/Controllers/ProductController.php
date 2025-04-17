<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all(); // Atau bisa pake paginate() jika data banyak
        return view('admin-page.product', compact('products'));
    }

    // Menampilkan form untuk menambah produk
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|unique:products',
            'stok' => 'required|integer',
            'harga_produk' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan file gambar
        $imagePath = $request->file('image')->store('images', 'public');

        // Menyimpan data produk ke database
        Product::create([
            'nama_produk' => $request->nama_produk,
            'stok' => $request->stok,
            'harga_produk' => $request->harga_produk,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|unique:products,nama_produk,' . $id,
            'stok' => 'required|integer',
            'harga_produk' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Jika ada gambar baru, simpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        // Update produk di database
        $product->update([
            'nama_produk' => $request->nama_produk,
            'stok' => $request->stok,
            'harga_produk' => $request->harga_produk,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }
}
