@extends('layouts.navbar-petugas')

@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs text-sm">
        <ul>
        </ul>
    </div>
    <h1 class="text-4xl font-bold mt-2">SALE</h1>

    <!-- main -->
    <div class="mx-auto p-5 rounded-xl shadow-md mt-8">

        <div class="grid grid-cols-2 gap-8">
            <!-- Product Table -->
            <div class="border p-4 shadow-md">
                <h2 class="text-2xl font-bold">
                    Produk yang dipilih
                </h2>
                <table class="table w-full mt-5">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left">Nama Produk</th>
                            <th class="text-left">Harga</th>
                            <th class="text-left"></th>
                            <th class="text-left">Jumlah</th>
                            <th class="text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($checkout as $item)
                            @php $subtotal = $item['qty'] * $item['price']; @endphp
                            <tr class="border-b">
                                <td>{{ $item['name'] }}</td>
                                <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>x</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rp.
                                    {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                            </tr>
                            @php $total += $subtotal; @endphp
                        @endforeach

                    </tbody>
                </table>

                <div class="mt-4 font-semibold text-lg text-right">
                    <p>Total Harga : Rp. {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Member Form -->
            <div>
                <label class="block font-semibold mt-4">Member Status</label>
                <select name="member_status" id="member_status" class="input input-bordered w-full mt-2">
                    <option value="non_member">Non-Member</option>
                    <option value="member">Member</option>
                </select>

                <div id="phone-container" class="hidden">
                    <label class="block font-semibold mt-4">No. Telepon</label>
                    <input type="number" name="phone_number" id="phone_number" class="input input-bordered w-full mt-2"
                        placeholder="Masukkan No. Telepon">
                </div>

                <label class="block font-semibold mt-4">Total Bayar</label>
                <input type="text" id="total_bayar" class="input input-bordered w-full mt-2"
                    placeholder="Masukkan Nominal Pembayaran" min="1" maxlength="11">

                <!-- payment -->
                <form id="checkout_form" action="{{ route('sales.payment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cart" id="cart-input">
                    <input type="hidden" name="amount_paid" id="amount-paid-input">
                    <input type="hidden" name="sub_total" id="sub-total-input">
                    <input type="hidden" name="is_member" id="is-member-input">
                    <input type="hidden" name="phone_number" id="no-telp-input">
                    <button type="submit" class="btn btn-primary w-full mt-4">Bayar</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Data dari server
        var cart = @json($checkout);
        var totalHarga = {{ $total }};

        // state member
        var memberStatus = document.getElementById('member_status');
        memberStatus.onchange = function() {
            var phoneContainer = document.getElementById('phone-container');
            var isMemberInput = document.getElementById('is-member-input');

            if (memberStatus.value == 'member') {
                phoneContainer.classList.remove('hidden');
                isMemberInput.value = 1;
            } else {
                phoneContainer.classList.add('hidden');
                isMemberInput.value = 0;
            }
        };

        // format RP
        var totalBayarInput = document.getElementById('total_bayar');
        totalBayarInput.oninput = function() {
            var value = totalBayarInput.value.replace(/[^0-9]/g, '');
            totalBayarInput.value = 'Rp. ' + (value ? new Intl.NumberFormat('id-ID').format(value) : '');
        };

        // paymnet
        var checkoutForm = document.getElementById('checkout_form');
        checkoutForm.onsubmit = function() {
            var totalBayar = parseInt(totalBayarInput.value.replace(/[^0-9]/g, '')) || 0;
            var noTelp = document.getElementById('phone_number').value;
            var isMember = (memberStatus.value == 'member');

            if (totalBayar < totalHarga) {
                alert('Uang kurang, harus sama atau lebih dari total belanja');
                return false;
            }

            if (isMember && noTelp.trim() == '') {
                alert('No telepon wajib diisi untuk member');
                return false;
            }

            var subTotal = 0;
            for (var i = 0; i < cart.length; i++) {
                subTotal = subTotal + (cart[i].qty * cart[i].price);
            }

            document.getElementById('cart-input').value = JSON.stringify(cart);
            document.getElementById('amount-paid-input').value = totalBayar;
            document.getElementById('sub-total-input').value = subTotal;
            document.getElementById('no-telp-input').value = isMember ? noTelp : '';

            return true;
        }
    </script>
@endsection