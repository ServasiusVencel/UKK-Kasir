@extends('layouts.navbar-admin')

@section('content')
<div class="container mx-auto p-6">
    <link href="{{ asset('assets/css/tailwind.output.css') }}" rel="stylesheet">

    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a> > Produk
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Produk</h1>
        <button onclick="openAddModal()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Add Produk
        </button>
    </div>

    <!-- Tabel Produk -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Gambar Produk</th>
                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                    <th scope="col" class="px-6 py-3">Stok</th>
                    <th scope="col" class="px-6 py-3">Harga</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $index + 1 }}
                    </th>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}"  class="w-14 h-14 object-cover rounded" style="max-width: 200px; max-height: 200px;">
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->nama_produk }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->stok }}
                    </td>
                    <td class="px-6 py-4">
                        {{ number_format($product->harga_produk, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="openEditModal('{{ $product->id }}', '{{ $product->nama_produk }}', '{{ $product->stok }}', '{{ $product->harga_produk }}')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-6">Edit</button>
                        <button onclick="openDeleteModal('{{ $product->id }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="AddModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-2xl mx-auto transform scale-95 opacity-0 transition-all duration-300" id="addModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Tambah Produk</h3>
            <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Stok Barang</label>
                <input type="number" name="stok" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Harga Barang</label>
                <input type="number" name="harga_produk" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeAddModal()"
                    class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="EditModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-2xl mx-auto transform scale-95 opacity-0 transition-all duration-300" id="editModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Edit Produk</h3>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="editForm" action="{{ route('admin.products.update', ':id') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" id="edit_image"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" id="edit_nama_produk" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Stok Barang</label>
                <input type="number" name="stok" id="edit_stok" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Harga Barang</label>
                <input type="number" name="harga_produk" id="edit_harga_produk" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="DeleteModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-md mx-auto transform scale-95 opacity-0 transition-all duration-300" id="deleteModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Konfirmasi Hapus</h3>
            <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="mb-4">Apakah Anda yakin ingin menghapus produk ini?</p>
        <form id="deleteForm" action="{{ route('admin.products.destroy', ':id') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" id="delete_id" name="id">
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeDeleteModal()"
                    class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        let modal = document.getElementById('AddModal');
        let modalContent = document.getElementById('addModalContent');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeAddModal() {
        let modal = document.getElementById('AddModal');
        let modalContent = document.getElementById('addModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, nama_produk, stok, harga_produk) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama_produk').value = nama_produk;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_harga_produk').value = harga_produk;

        const form = document.getElementById('editForm');
        form.action = form.action.replace(':id', id);

        let modal = document.getElementById('EditModal');
        let modalContent = document.getElementById('editModalContent');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeEditModal() {
        let modal = document.getElementById('EditModal');
        let modalContent = document.getElementById('editModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);

        const form = document.getElementById('editForm');
        form.action = "{{ route('admin.products.update', ':id') }}";
    }

    function openDeleteModal(id) {
        document.getElementById('delete_id').value = id;
        const form = document.getElementById('deleteForm');
        form.action = form.action.replace(':id', id);

        let modal = document.getElementById('DeleteModal');
        let modalContent = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeDeleteModal() {
        let modal = document.getElementById('DeleteModal');
        let modalContent = document.getElementById('deleteModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);

        const form = document.getElementById('deleteForm');
        form.action = "{{ route('admin.products.destroy', ':id') }}";
    }
</script>
@endsection