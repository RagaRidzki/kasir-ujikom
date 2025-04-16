@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="mb-10">
        <h1 class="text-2xl font-semibold text-textColor">Penjualan</h1>
        <ul class="flex items-center text-sm">
            <li class="mr-2">
                <a href="" class="text-gray-400 hover:text-gray-600 font-medium">Home</a>
            </li>
            <li class="mr-2 text-gray-400 hover:text-gray-600 font-medium">/</li>
            <li class="mr-2">
                <a href="" class="text-gray-400 hover:text-gray-600 font-medium">Data Penjualan</a>
            </li>
            <li class="mr-2 text-gray-400 hover:text-gray-600 font-medium">/</li>
            <li class="mr-2">
                <a href="" class="text-gray-600 font-medium">Tambah Data Penjualan</a>
            </li>
        </ul>
    </div>

    <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Invoice - #{{ $details->first()->sale_id }}</h1>
                <p class="text-gray-500">{{ $sales->created_at }}</p>
                @if ($sales->customer)
                <p class="text-gray-500 font-semibold">{{ $sales->customer->no_hp }}</p>
                <p class="text-gray-500">MEMBER SEJAK: {{ $sales->customer->created_at->format('d M Y') }}</p>
                <p class="text-gray-500">MEMBER POIN: {{ $sales->customer->point }}</p>
                @endif
            </div>
            <div class="space-x-2">
                <a href ="{{ route('sales.generatePdf', $sales->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Unduh</a>
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
                @foreach ($details as $detail)
                <tr class="border-b border-gray-200">
                    <td class="py-3 px-4">{{ $detail->product->name }}</td>
                    <td class="py-3 px-4">Rp{{ number_format($detail->product->price, 0,',','.') }}</td>
                    <td class="py-3 px-4">{{ $detail->quantity }}</td>
                    <td class="py-3 px-4">Rp{{ number_format($detail->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bg-gray-50 p-6 mt-6 rounded-md shadow">
            <div class="grid grid-cols-3 gap-6 text-gray-700">
                <div>
                    <p class="font-semibold text-gray-600">POIN DIGUNAKAN</p>
                    <p class="text-lg">{{ $pointUsed }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">KASIR</p>
                    <p class="text-lg">{{ $sales->user->name }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-600">KEMBALIAN</p>
                    <p class="text-xl font-bold text-green-600">Rp{{ number_format($sales->total_return, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

            <div class="bg-gray-900 text-white p-6 mt-6 rounded-md flex justify-between items-center shadow-lg">
                <span class="text-lg font-semibold">TOTAL</span>
                <div class="flex flex-col">
                    {{-- Harga yang belum di diskon (contoh) --}}
                    {{-- <span class="text-2xl font-bold line-through">Rp{{ number_format($totalBeforeDiscount, 0, ',', '.') }}</span> --}}
                    {{-- Harga yang sudah didiskon --}}
                    <span class="text-2xl font-bold">Rp{{ number_format($totalAfterDiscount, 0, ',', '.') }}</span>
                </div>

            </div>
    </div>
</div>
@endsection
