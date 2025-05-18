@extends('layouts.main')

@section('content')
    <div class="p-6">
        <x-breadcrumb title="Data User" :paths="[['name' => 'Home', 'url' => ''], ['name' => 'Data User', 'url' => '']]" />

            <div class="w-full flex justify-between items-center mb-6">
                <form method="GET" action="" class="relative w-96">
                    <input type="search" name="search" placeholder="Cari user..."
                        value="{{ request('search') }}"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 pl-10 w-full focus:outline-none focus:ring-3 focus:ring-third transition">
                    <i class="ri-search-line absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
                </form>
    
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 text-sm">Showing</span>
                        <select
                            class="bg-white border border-gray-200 rounded-lg text-gray-700 px-2 py-1 text-sm w-full focus:outline-none focus:ring-3 focus:ring-third transition">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
    
                    <!-- Filter Button -->
                    <button
                        class="flex items-center space-x-1 bg-white border border-gray-200 rounded-lg text-gray-700 px-3 py-2 text-sm focus:outline-none focus:ring-3 focus:ring-third transition">
                        <i class="ri-filter-line"></i>
                        <span>Filter</span>
                    </button>
    
    
                    @if (auth()->user()->role === 'Admin')
                        <x-link-button href="/user/create" color="blue" shadow="blue">
                            <i class="ri-add-line"></i> Tambah User Baru
                        </x-link-button>
                    @endif
                </div>
            </div>

        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px] border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">No</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Nama</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Email</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Role</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-5 border-b border-gray-300">{{ $loop->iteration }}</td>
                                <td class="py-3 px-5 border-b border-gray-300">{{ $user->name }}</td>
                                <td class="py-3 px-5 border-b border-gray-300">
                                    {{ $user->email }}
                                </td>
                                <td class="py-3 px-5 border-b border-gray-300">{{ $user->role }}</td>
                                <td class="py-3 px-5 border-b border-gray-300">
                                    <ul class="flex items-center space-x-3">
                                        <li>
                                            <a href="{{ route('user.edit', $user->id) }}" class="text-gray-500 hover:text-gray-700">
                                                <i class="ri-edit-line text-lg"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('user.delete', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                    class="text-gray-500 hover:text-gray-700">
                                                    <i class="ri-delete-bin-line text-lg"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(userID) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data user ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus data ini',
                cancelButtonText: 'Batal, data tetap disimpan',
                reverseButtons: false, // Pastikan tombol merah tetap di kiri
                customClass: {
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded mr-2 order-1',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black font-semibold px-4 py-2 rounded order-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userID).submit();
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Data user aman tersimpan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
@endsection
