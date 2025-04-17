    @extends('layouts.navbar-petugas')

    @section('content')
        <!-- breadcrumbs -->
        <div class="breadcrumbs text-sm">
            <ul>
                <li class="font-bold text-gray-400">New Sale</li>
            </ul>
        </div>

        <h1 class="text-4xl font-bold mt-2">Select Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($data as $product)
            <div class="card bg-white shadow-xl rounded-xl overflow-hidden w-[100px]">

    
                <figure class="px-4 pt-4">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}"
                    class=" object-cover rounded" style="max-width:  200px; max-height: 200px;">
                </figure>
                <div class="card-body p-4">
                    <h2 class="card-title text-lg font-semibold">{{ $product->nama_produk }}</h2>
                    <p class="text-sm text-gray-600">Stock: {{ $product->stok }}</p>
                    <p class="text-sm text-gray-600">Price: Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</p>
        
                    <div class="flex items-center justify-between mt-4 gap-2">
                        <button onclick="updateQuantity({{ $product->id }}, -1, {{ $product->stok }})"
                            class="bg-red-500 hover:bg-red-600  font-bold py-1 px-3 rounded-lg shadow transition duration-150">
                            –
                        </button>
        
                        <input type="number" id="qty-{{ $product->id }}" value="0" readonly
                            class="w-16 text-center border border-gray-300 rounded-lg py-1 text-lg font-medium bg-gray-100" />
        
                        <button onclick="updateQuantity({{ $product->id }}, 1, {{ $product->stok }})"
                            class="bg-green-500 hover:bg-green-600  font-bold py-1 px-3 rounded-lg shadow transition duration-150">
                            +
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        

        <form action="{{ route('sales.checkout') }}" id="checkout-form" method="POST" class="mt-8">
            @csrf
            <input type="hidden" name="cart_checkout" id="cart_checkout">
            <button type="submit" class="btn btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                Proceed to Checkout
            </button>
        </form>

        <script>
            let cart_checkout = [];

            function updateQuantity(id, change, maxStock) {
                const qtyInput = document.getElementById('qty-' + id);
                let qty = parseInt(qtyInput.value) || 0;
                let newQty = qty + change;

                // Validasi batasan jumlah
                if (newQty < 0) newQty = 0;
                if (newQty > maxStock) newQty = maxStock;

                qtyInput.value = newQty;

                const index = cart_checkout.findIndex(item => item.id === id);

                if (newQty === 0 && index !== -1) {
                    cart_checkout.splice(index, 1);
                } else if (newQty > 0) {
                    if (index !== -1) {
                        cart_checkout[index].qty = newQty;
                    } else {
                        cart_checkout.push({ id: id, qty: newQty });
                    }
                }
            }

            document.getElementById('checkout-form').addEventListener('submit', function() {
                document.getElementById('cart_checkout').value = JSON.stringify(cart_checkout);
            });
        </script>
    @endsection
