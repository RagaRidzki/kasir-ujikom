@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Tambah Data Produk" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Produk', 'url' => ''],
            ['name' => 'Tambah Data Produk', 'url' => '']
        ]" />


    <div class="mb-6 bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <form action="/product/store" method="POST" enctype="multipart/form-data" class="w-full">
            <div class="flex flex-col">
                <div class="w-full mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk <span
                            class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukan nama produk">

                    {{-- <p class="text-red-600 text-sm mt-1">  </p> --}}

                </div>
                <div class="w-full mb-4">
                    <label for="price" class="block text-gray-700 font-semibold mb-2">Harga <span
                            class="text-red-600">*</span></label>
                    <input type="number" id="price" name="price"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukkan harga produk (Rp)">

                    {{-- <p class="text-red-600 text-sm mt-1">  </p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok <span
                            class="text-red-600">*</span></label>
                    <input type="text" id="stock" name="stock"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400"
                        placeholder="Masukkan jumlah stok tersedia">
                    
                    {{-- <p class="text-red-600 text-sm mt-1">  </p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="image" class="block text-gray-700 font-semibold mb-2">Gambar <span
                            class="text-red-600">*</span></label>
                    <input type="file" id="image" name="image"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400">
                    
                    {{-- <p class="text-red-600 text-sm mt-1">  </p> --}}
                    
                </div>

            </div>
            <div class="flex justify-end gap-x-2">
                <x-button type="submit">
                    <i class="ri-add-line"></i> Tambah Product
                </x-button>
                <x-link-button href="/product">
                    <i class="ri-arrow-go-back-line"></i> Kembali
                </x-link-button>
            </div>
        </form>
    </div>
</div>
@endsection