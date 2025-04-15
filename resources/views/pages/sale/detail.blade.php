@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Penjualan" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Penjualan', 'url' => ''],
            ['name' => 'Tambah Data Penjualan', 'url' => '']
        ]" />

    <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Invoice - #1</h1>
                <p class="text-gray-500">[Tanggal Penjualan]</p>
                
                {{-- Customer only --}}
                <p class="text-gray-500 font-semibold">[No Hp 08123456789]</p>
                <p class="text-gray-500">MEMBER SEJAK: [Tanggal Member]</p>
                <p class="text-gray-500">MEMBER POIN: [Member Poin]</p>
                
            </div>
            <div class="space-x-2">
                <button class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Unduh</button>
                <button class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md">Kembali</button>
            </div>
        </div>

        <table class="w-full border-t border-gray-300 mt-4 text-gray-700">
            <thead>
                <tr class="text-left bg-gray-100">
                    <th class="py-3 px-4">Produk</th>
                    <th class="py-3 px-4">Harga</th>
                    <th class="py-3 px-4">Quantity</th>
                    <th class="py-3 px-4">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-200">
                    <td class="py-3 px-4">[Nama Produk]</td>
                    <td class="py-3 px-4">Rp[Harga Produk]</td>
                    <td class="py-3 px-4">[Quantity Produk (500)]</td>
                    <td class="py-3 px-4">Rp[Sub Total]</td>
                </tr>
            </tbody>
        </table>

        <div class="bg-gray-50 p-6 mt-6 rounded-md shadow">
            <div class="grid grid-cols-3 gap-6 text-gray-700">
                <div>
                    <p class="font-semibold text-gray-600">POIN DIGUNAKAN</p>
                    <p class="text-lg">[Point Digunakan]</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">KASIR</p>
                    <p class="text-lg">[Nama Kasir]</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">KEMBALIAN</p>
                    <p class="text-xl font-bold text-green-600">Rp[Kembalian]
                    </p>
                </div>
            </div>
        </div>

            <div class="bg-gray-900 text-white p-6 mt-6 rounded-md flex justify-between items-center shadow-lg">
                <span class="text-lg font-semibold">TOTAL</span>
                <div class="flex flex-col">
                    {{-- Harga yang belum di diskon (contoh) --}}
                    <span class="text-2xl font-bold line-through">Rp[Harga sebelum diskon]</span>
                    {{-- Harga yang sudah didiskon --}}
                    <span class="text-2xl font-bold">Rp[Harga sesudah diskon]</span>
                </div>

            </div>
    </div>
</div>
@endsection