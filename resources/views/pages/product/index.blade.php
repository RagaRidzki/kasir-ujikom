@extends('layouts.main')

@section('content')
    <div class="p-6">
        <x-breadcrumb title="Data Produk" :paths="[['name' => 'Home', 'url' => ''], ['name' => 'Data Produk', 'url' => '']]" />

        <div class="w-full flex justify-between items-center mb-6">
            <div class="relative w-96">
                <input type="text" placeholder="Cari produk..."
                    class="w-full border border-gray-300 rounded-md py-2 px-4 pl-10 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <i class="ri-search-line absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
            </div>

            <div class="flex items-center space-x-4">
                {{-- <div class="flex items-center space-x-2">
                    <span class="text-gray-600 text-sm">Showing</span>
                    <select
                        class="border border-gray-300 bg-white text-gray-700 rounded-md px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <button
                    class="flex items-center space-x-1 border border-gray-300 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 text-sm">
                    <i class="ri-filter-line"></i>
                    <span>Filter</span>
                </button> --}}

                <!-- Tombol Tambah Produk -->
                <x-link-button href="/product/create" color="blue" shadow="blue">
                    <i class="ri-add-line"></i> Tambah Produk Baru
                </x-link-button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px] border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">No</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Gambar</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Nama Produk</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Harga</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Stok</th>
                            <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-5 border-b border-gray-300">{{ $loop->iteration }}</td>
                                <td class="py-3 px-5 border-b border-gray-300">
                                    <img src="{{ 'storage/' . $product->image }}" alt="gambar" class="w-16 h-16">
                                </td>
                                <td class="py-3 px-5 border-b border-gray-300">{{ $product->name }}</td>
                                <td class="py-3 px-5 border-b border-gray-300 text-green-700 font-semibold">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-5 border-b border-gray-300">{{ $product->stock }}</td>
                                <td class="py-3 px-5 border-b border-gray-300">
                                    <ul class="flex items-center space-x-3">
                                        <li>
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="ri-edit-line text-lg"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <button data-modal-target="updateStock-{{ $product->id }}"
                                                data-modal-toggle="updateStock-{{ $product->id }}"
                                                class="text-gray-500 hover:text-gray-700">
                                                <i class="ri-loop-left-line text-lg"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('product.delete', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $product->id }})"
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

        @foreach ($products as $product)
            <div id="updateStock-{{ $product->id }}" tabindex="-1" aria-hidden="true"
                class="backdrop-blur-xs hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-300 rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Update Stok Produk
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="updateStock-{{ $product->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form action="{{ route('product.update.stock', $product->id) }}" class="p-4 md:p-5" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                        Produk</label>
                                    <input readonly type="text" name="name" id="name"
                                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 block w-full p-2.5"
                                        value="{{ $product->name }}">
                                </div>
                                <div class="col-span-2">
                                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                                    <input type="number" name="stock" id="stock"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        value="{{ $product->stock }}">
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            function confirmDelete(productID) {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data product ini akan dihapus secara permanen!',
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
                        document.getElementById('delete-form-' + productID).submit();
                    } else {
                        Swal.fire({
                            title: 'Dibatalkan',
                            text: 'Data product aman tersimpan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        </script>
    @endsection
