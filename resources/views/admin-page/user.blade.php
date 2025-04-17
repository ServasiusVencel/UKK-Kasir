@extends('layouts.navbar-admin')

@section('content')
<div class="container mx-auto p-6">
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a> > Data User
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">User</h1>
        <button onclick="openCreateUserModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah User
        </button>
    </div>
    <a href="{{ route('admin.users.export') }}" 
       class="bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
        Export User (.xlsx)
    </a>

    <!-- Tabel User -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">No</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3 text-center">Role</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">{{ $user->role }}</td>
                    <td class="px-6 py-4 text-center">
                        @if (Auth::user()->email !== $user->email) <!-- Check if the logged-in user's email is not the same as the user's email -->
                <button onclick="openEditUser Modal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-6">Edit</button>
                <button onclick="openDeleteUser Modal('{{ $user->id }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
            @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create User Modal -->
<div id="openCreateUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-2xl mx-auto transform scale-95 opacity-0 transition-all duration-300" id="createUserModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Tambah User</h3>
            <button onclick="closeCreateUserModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300" placeholder="Enter user name">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300" placeholder="Enter user email">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300" placeholder="Enter password">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>
            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create User</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="openEditUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-2xl mx-auto transform scale-95 opacity-0 transition-all duration-300" id="editModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Edit User</h3>
            <button onclick="closeEditUserModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="editForm" action="{{ route('admin.users.update', ':id') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="edit_name" name="name" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="edit_email" name="email" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="edit_password" name="password" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="edit_password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select id="edit_role" name="role" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring focus:ring-blue-300">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeEditUserModal()" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete User -->
<div id="openDeleteUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/3 max-w-md mx-auto transform scale-95 opacity-0 transition-all duration-300" id="deleteModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Hapus User</h3>
            <button onclick="closeDeleteUserModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="deleteForm" action="{{ route('admin.users.destroy', ':id') }}" method="POST">
            @csrf
            @method('DELETE')
            <p>Apakah Anda yakin ingin menghapus user ini?</p>
            <input type="hidden" id="delete_id" name="id" value="">
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeDeleteUserModal()" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateUserModal() {
        const modal = document.getElementById('openCreateUserModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            document.getElementById('createUserModalContent').classList.remove('opacity-0', 'scale-95');
            document.getElementById('createUserModalContent').classList.add('opacity-100', 'scale-100');
        }, 50);
        document.body.classList.add('overflow-hidden');
    }

    function closeCreateUserModal() {
        const modal = document.getElementById('openCreateUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('createUserModalContent').classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditUserModal(id, name, email, role) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;

        const form = document.getElementById('editForm');
        form.action = form.action.replace(':id', id);

        const modal = document.getElementById('openEditUserModal');
        const modalContent = document.getElementById('editModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
        document.body.classList.add('overflow-hidden');
    }

    function closeEditUserModal() {
        const modal = document.getElementById('openEditUserModal');
        const modalContent = document.getElementById('editModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);

        const form = document.getElementById('editForm');
        form.action = "{{ route('admin.users.update', ':id') }}";
    }

    function openDeleteUserModal(id) {
        document.getElementById('delete_id').value = id;

        const form = document.getElementById('deleteForm');
        form.action = form.action.replace(':id', id);

        const modal = document.getElementById('openDeleteUserModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteUserModal() {
        const modal = document.getElementById('openDeleteUserModal');
        const modalContent = document.getElementById('deleteModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);

        const form = document.getElementById('deleteForm');
        form.action = "{{ route('admin.users.destroy', ':id') }}";
    }
</script>
@endsection