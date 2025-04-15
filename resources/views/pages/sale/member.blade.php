@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Penjualan" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Penjualan', 'url' => ''],
            ['name' => 'Member', 'url' => ''],
        ]" />

    <div class="flex gap-20 bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
        <!-- Bagian Kiri: Tabel Produk -->
        <div class="w-1/2">
            <div class="overflow-x-auto">
                {{-- @if (!empty($cart)) --}}
                <table class="w-full border-collapse bg-white border border-gray-200 shadow-sm rounded-lg">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3 text-left text-md font-semibold">Nama Produk</th>
                            <th class="p-3 text-center text-md font-semibold">QTY</th>
                            <th class="p-3 text-right text-md font-semibold">Harga</th>
                            <th class="p-3 text-right text-md font-semibold">Sub Total</th>
                        </tr>
                    </thead>
                    {{-- Tampilkan data produk --}}
                    
                    <tbody>
                        <tr class="border-t border-b">
                            <td class="p-3">[Nama Produk]</td>
                            <td class="p-3 text-center">[Quantity Produk]</td>
                            <td class="p-3 text-right">Rp[Harga Produk]</td>
                            <td class="p-3 text-right">Rp[Sub Total]</td>
                        </tr>
                    </tbody>
                    
                </table>
                <div class="mt-6 space-y-3">
                    <div class="flex justify-between text-md font-semibold text-gray-800">
                        <span>Total Harga</span>
                        <span>Rp[Total harga keseluruhan produk yang dibeli]</span>
                    </div>
                    <div class="flex justify-between text-xl font-semibold text-gray-800">
                        <span>Total Bayar</span>
                        <span>Rp[Total bayar]</span>
                    </div>
                </div>
                {{-- @endif --}}
            </div>


        </div>

        <!-- Bagian Kanan: Form Member -->
        <div class="w-1/2">
            <form action="/sale member save, id" method="POST" class="space-y-4">
                <!-- Nama Member -->
                <div class="flex flex-col space-y-1">
                    <label class="text-sm text-gray-600" for="memberName">Nama Member (Identitas)</label>
                    <input type="text" id="memberName" name="name"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:outline-none focus:ring-gray-400"
                        value="" required>
                </div>

                <!-- Poin -->
                <div class="flex flex-col space-y-1">
                    <label class="text-sm text-gray-600" for="poin">Poin</label>
                    <input type="text" id="poin"
                        class="w-full border border-gray-300 bg-gray-200 text-gray-500 rounded-md p-2"
                        value="" readonly disabled>
                </div>

                <!-- Gunakan Poin -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="use_point" value="1" id="usePoints" class="rounded-sm">
                    <label for="usePoints" class="text-sm text-gray-600">Gunakan poin</label>
                </div>

                <!-- Tombol Selanjutnya -->
                <x-button type="submit">
                    Selanjutnya
                </x-button>
            </form>
        </div>
    </div>
</div>
@endsection