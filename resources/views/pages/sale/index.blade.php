@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Data Penjualan"
        :paths="[['name' => 'Home', 'url' => ''], ['name' => 'Data Penjualan', 'url' => '']]" />

    <div class="w-full flex justify-between items-center mb-6">
        <div class="relative w-70">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari penjualan..." value="{{ request('search') }}"
                    class="bg-white border border-gray-200 rounded-lg px-4 py-2 pl-10 w-full focus:outline-none focus:ring-3 focus:ring-third transition">
                <i class="ri-search-line absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
            </form>
        </div>

        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <form method="GET" class="flex items-center gap-2">
                    <select name="filter_by" id="filter_by"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                        onchange="this.form.submit()">
                        <option value="">Semua Data</option>
                        <option value="day" {{ request('filter_by')=='day' ? 'selected' : '' }}>Harian</option>
                        <option value="month" {{ request('filter_by')=='month' ? 'selected' : '' }}>Bulanan</option>
                        <option value="year" {{ request('filter_by')=='year' ? 'selected' : '' }}>Tahunan</option>
                    </select>

                    @if(request('filter_by') == 'day')
                    <input type="date" name="filter_value" value="{{ request('filter_value') }}"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                        required>
                    @elseif(request('filter_by') == 'month')
                    <input type="month" name="filter_value" value="{{ request('filter_value') }}"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                        required>
                    @elseif(request('filter_by') == 'year')
                    <input type="year" name="filter_value" min="2000" max="{{ now()->year }}"
                        value="{{ request('filter_value') }}"
                        class="bg-white border border-gray-200 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-3 focus:ring-third transition"
                        placeholder="Contoh: 2025" required>
                    @endif
                    <button type="submit"
                        class="flex items-center space-x-1  bg-white border border-gray-200 rounded-lg text-gray-700 px-4 py-2 text-sm focus:outline-none focus:ring-3 focus:ring-third transition">
                        <i class="ri-filter-line"></i>
                        <span>Filter</span>
                    </button>
                </form>
            </div>

            <x-link-button
                href="{{ route('sales.exportExcel') }}?filter_by={{ request('filter_by') }}&filter_value={{ request('filter_value') }}"
                color="green" shadow="green">
                <i class="ri-export-line"></i> Export Penjualan(.xlsx)
            </x-link-button>

            @if (auth()->user()->role === 'Employee')
            <x-link-button href="/sale/create" color="blue" shadow="blue">
                <i class="ri-add-line"></i> Tambah
                Penjualan
            </x-link-button>
            @endif
        </div>
    </div>

    <div class="bg-white border border-gray-200 p-6 rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">No</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">Nama Pelanggan</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">Tanggal Penjualan</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">Total Harga</th>
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">Dibuat Oleh</th>
                        @if (auth()->user()->role === 'Employee')
                        <th class="text-md font-semibold py-3 px-5 border-b border-gray-200">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-5 border-b border-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-3 px-5 border-b border-gray-200">{{ $sale->customer->name ?? 'NON-MEMBER' }}
                        </td>
                        <td class="py-3 px-5 border-b border-gray-200">{{ $sale->created_at->format('d F Y') }}</td>
                        <td class="py-3 px-5 border-b border-gray-200">
                            Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                        <td class="py-3 px-5 border-b border-gray-200">{{ $sale->user->name }}</td>
                        @if (auth()->user()->role === 'Employee')
                        <td class="py-3 px-5 border-b border-gray-200">
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

<!-- Modal Detail Sale -->
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
                    <li>Member Status: <span class="font-medium">{{ $sale->customer_id ? 'Member' : 'Non Member'
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
                <div class="text-right font-semibold">
                    Total Pay <span class="text-lg text-black">Rp{{ number_format($sale->total_pay, 0, ',', '.')
                        }}</span>
                </div>
                <div class="text-right font-semibold">
                    Total Return <span class="text-lg text-black">Rp{{ number_format($sale->total_return, 0, ',', '.')
                        }}</span>
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