@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Edit Data Produk" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Produk', 'url' => ''],
            ['name' => 'Edit Data Produk', 'url' => '']
        ]" />

    <div class="mb-6 bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <form action="" method="POST" enctype="multipart/form-data" class="w-full">
            <div class="flex flex-col">
                <div class="w-full mb-4">
                    <label for="name" class="block text-gray-600 font-semibold mb-2">Nama Produk <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-700 py-2 px-4 rounded-md placeholder-gray-400"
                        value="">
                    
                    {{-- <p class="text-red-500 text-sm mt-1">  </p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="price" class="block text-gray-600 font-semibold mb-2">Harga <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="price" name="price"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400"
                        value="">
                    
                    {{-- <p class="text-red-500 text-sm mt-1">  </p> --}}
                    
                </div>
                <div class="w-full mb-4">
                    <label for="stock" class="block text-gray-600 font-semibold mb-2">Stok</label>
                    <input disabled type="text" id="stock" name="stock"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400"
                        value="">
                </div>
                <div class="w-full mb-4">
                    <label for="image" class="block text-gray-600 font-semibold mb-2">Gambar</label>
                    <input type="file" id="image" name="image"
                        class="block w-full border border-gray-300 focus:outline-none focus:border-gray-600 py-2 px-4 rounded-md placeholder-gray-400">
                </div>
                <div class="w-full mb-4">
                    <label class="block text-gray-600 font-semibold mb-2">Gambar Sebelumnya:</label>
                </div>
                
                <img src="" alt="product_image" class="w-52 h-52">
                
            </div>
            <div class="flex justify-end gap-x-2">
                <button type="submit" class="py-2 px-4 bg-blue-500 hover:bg-blue-700 text-white rounded-md"><i
                        class="ri-add-line"></i> Update Produk</button>
                <a href="/product" class="py-2 px-4 bg-gray-500 hover:bg-gray-700 text-white rounded-md">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection