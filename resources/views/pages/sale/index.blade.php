@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Data Penjualan"
        :paths="[['name' => 'Home', 'url' => ''], ['name' => 'Data Penjualan', 'url' => '']]" />


    <div class="w-full flex justify-between items-center mb-6">
        <div class="relative w-96">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
                    class="mb-4 px-4 py-2 border rounded ">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
            </form>
        </div>

        <div class="flex items-center space-x-4">
            {{-- <form method="GET" action="" class="flex items-center gap-2">
                <label for="tanggal" class="text-sm font-medium text-gray-700">Filter Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                    Filter Date
                </button>
            </form> --}}


            <div class="flex items-center">
                <form method="GET">
                    <select name="filter_by" id="filter_by" class="px-4 py-2 border rounded">
                        <option value="">-- Semua Data --</option>
                        <option value="day" {{ request('filter_by')=='day' ? 'selected' : '' }}>Harian</option>
                        <option value="week" {{ request('filter_by')=='week' ? 'selected' : '' }}>Mingguan</option>
                        <option value="month" {{ request('filter_by')=='month' ? 'selected' : '' }}>Bulanan</option>
                        <option value="year" {{ request('filter_by')=='year' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
                </form>
            </div>


            {{-- <button
                class="flex items-center space-x-1 border border-gray-300 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 text-sm">
                <i class="ri-filter-line"></i>
                <span>Filter</span>
            </button> --}}
            <x-link-button href="{{ route('sales.exportExcel', ['filter_by' => request('filter_by')]) }}" color="green"
                shadow="green">
                <i class="ri-export-line"></i> Export
                Penjualan(.xlsx)
            </x-link-button>
            @if (auth()->user()->role === 'Employee')
            <x-link-button href="/sale/create" color="blue" shadow="blue">
                <i class="ri-add-line"></i> Tambah
                Penjualan
            </x-link-button>
            @endif
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
                        @if (auth()->user()->role === 'Employee')
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-300">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-5 border-b border-gray-300">{{ $loop->iteration }}</td>
                        <td class="py-3 px-5 border-b border-gray-300">{{ $sale->customer->name ?? 'NON-MEMBER' }}
                        </td>
                        <td class="py-3 px-5 border-b border-gray-300">{{ $sale->created_at }}</td>
                        <td class="py-3 px-5 border-b border-gray-300">
                            Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-5 border-b border-gray-300">{{ $sale->user->name }}</td>
                        @if (auth()->user()->role === 'Employee')
                        <td class="py-3 px-5 border-b border-gray-300">
                            <ul class="flex items-center gap-x-2">
                                <li class="text-gray-500 hover:text-gray-700 cursor-pointer">
                                    <button data-modal-target="saleModal-{{ $sale->id }}"
                                        data-modal-toggle="saleModal-{{ $sale->id }}">
                                        <i class="ri-eye-line text-lg"></i>
                                    </button>
                                </li>
                                <li class="text-gray-500 hover:text-gray-700 cursor-pointer">
                                    <a href="{{ route('sales.generatePdf', $sale->id) }}">
                                        <i class="ri-download-line text-lg"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
@foreach ($sales as $sale)
<div id="saleModal-{{ $sale->id }}" tabindex="-1" aria-hidden="true"
    class="backdrop-blur-xs hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                    <li>Member Status: <span class="font-medium">{{ $sale->customer_id ? 'Member' : 'Bukan Member'
                            }}</span></li>
                    @if ($sale->customer)
                    <li>Bergabung Sejak: {{ $sale->customer->created_at ?? '' }}</li>
                    <li>No. HP: {{ $sale->customer->no_hp ?? '' }}</li>
                    <li>Poin Member: {{ $sale->customer->point ?? '' }}</li>
                    @endif
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
                            @foreach ($details->where('sale_id', $sale->id) as $detail)
                            <tr class="border-b">
                                <td class="py-2">{{ $detail->product->name }}</td>
                                <td class="py-2">{{ $detail->quantity }}</td>
                                <td class="py-2">Rp{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                <td class="py-2">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="text-right font-semibold mt-2">
                    Total <span class="text-lg text-black">Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span>
                </div>

                <!-- Info Pembuat -->
                <div class="text-xs text-gray-500 mt-4">
                    Dibuat pada : {{ $sale->created_at }} <br>
                    Oleh : {{ $sale->user->name }}
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
@endforeach
@endsection