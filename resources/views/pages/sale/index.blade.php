@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Data Penjualan" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Penjualan', 'url' => '']
        ]" />


    <div class="w-full flex justify-between items-center mb-6">
        <div class="relative w-96">
            <input type="text" placeholder="Cari penjualan..."
                class="w-full border border-gray-300 rounded-md py-2 px-4 pl-10 focus:ring-2 focus:ring-blue-600 focus:outline-none">
            <i class="ri-search-line absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
        </div>

        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
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
            </button>
            <x-link-button href="#" color="green" shadow="green">
                <i class="ri-export-line"></i> Export
                Penjualan(.xlsx)
            </x-link-button>
            <x-link-button href="/sale/create" color="blue" shadow="blue">
                <i class="ri-add-line"></i> Tambah
                Penjualan
            </x-link-button>
        </div>
    </div>

    <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">No</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Nama Pelanggan</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Tanggal Penjualan</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Total Harga</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Dibuat Oleh</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-5 border-b border-gray-300">1</td>
                        <td class="py-3 px-5 border-b border-gray-300">[Nama Pelanggan]
                        </td>
                        <td class="py-3 px-5 border-b border-gray-300">[Tanggal Penjualan]</td>
                        <td class="py-3 px-5 border-b border-gray-300">Rp[Total Harga]</td>
                        <td class="py-3 px-5 border-b border-gray-300">[Dibuat Oleh]</td>

                        <td class="py-3 px-5 border-b border-gray-300">
                            <ul class="flex items-center gap-x-2">
                                <li class="text-gray-500 hover:text-gray-700 cursor-pointer">
                                    <button data-modal-target="saleModal-1"
                                        data-modal-toggle="saleModal-1">
                                        <i class="ri-eye-line text-lg"></i>
                                    </button>
                                </li>
                                <li class="text-gray-500 hover:text-gray-700 cursor-pointer"><i
                                        class="ri-download-line text-lg"></i>
                                </li>
                            </ul>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div id="saleModal-1" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Detail Penjualan
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4 text-sm text-gray-700">
                <!-- Info Member -->
                <ul class="space-y-1 text-sm text-gray-700 list-disc list-inside">
                    <li>Member Status: <span class="font-medium">Bukan Member</span></li>
                    <li>Bergabung Sejak: 2021-01-01</li>
                    <li>No. HP: 08123456789</li>
                    <li>Poin Member: 0</li>
                </ul>

                <!-- Table Produk -->
                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left text-gray-700">
                        <thead class="text-sm border-b">
                            <tr>
                                <th class="py-2">Nama Produk</th>
                                <th class="py-2">Qty</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-2">Produk A</td>
                                <td class="py-2">2</td>
                                <td class="py-2">Rp100,000</td>
                                <td class="py-2">Rp200,000</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-2">Produk B</td>
                                <td class="py-2">1</td>
                                <td class="py-2">Rp50,000</td>
                                <td class="py-2">Rp50,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="text-right font-semibold mt-2">
                    Total <span class="text-lg text-black">Rp250,000</span>
                </div>

                <!-- Info Pembuat -->
                <div class="text-xs text-gray-500 mt-4">
                    Dibuat pada : 2021-01-01 <br>
                    Oleh : John Doe
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end px-6 pb-4">
                <button type="button"
                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    data-modal-hide="saleModal-1">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection