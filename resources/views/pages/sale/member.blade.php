@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Penjualan" :paths="[
            ['name' => 'Home', 'url' => '/dashboard'],
            ['name' => 'Data Penjualan', 'url' => route('sale.index')],
            ['name' => 'Member', 'url' => ''],
        ]" />

    <div class="flex gap-20 bg-white border border-gray-200 p-6 rounded-xl">
        <!-- Bagian Kiri: Tabel Produk -->
        <div class="w-1/2">
            <div class="overflow-x-auto">
                {{-- @if (!empty($cart)) --}}
                <table class="w-full border-collapse bg-white border border-gray-200 p-6 rounded-xl">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3 border-b border-gray-200 text-left text-md font-semibold">Nama Produk</th>
                            <th class="p-3 border-b border-gray-200 text-center text-md font-semibold">QTY</th>
                            <th class="p-3 border-b border-gray-200 text-right text-md font-semibold">Harga</th>
                            <th class="p-3 border-b border-gray-200 text-right text-md font-semibold">Sub Total</th>
                        </tr>
                    </thead>
                    {{-- Tampilkan data produk --}}
                    @foreach ($details as $detail)
                    <tbody>
                        <tr class="border-t border-b">
                            <td class="p-3 border-b border-gray-200">{{ $detail->product->name }}</td>
                            <td class="p-3 border-b border-gray-200 text-center">{{ $detail->quantity }}</td>
                            <td class="p-3 border-b border-gray-200 text-right">Rp{{ number_format($detail->product->price,0,',','.') }}</td>
                            <td class="p-3 border-b border-gray-200 text-right">Rp{{ number_format($detail->product->price *
                                $detail->quantity,0,',','.') }}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <div class="mt-6 space-y-3">
                    @php
                    $totalHarga = collect($details)->sum(function($item) {
                    return $item->product->price * $item->quantity;
                    });
                    @endphp
                    <div class="flex justify-between text-md font-semibold text-gray-800">
                        <span>Total Harga</span>
                        <span>Rp{{ number_format($totalHarga, 0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-semibold text-gray-800">
                        <span>Total Bayar</span>
                        <span>Rp{{ number_format($sales->total_pay, 0,',','.') }}</span>
                    </div>
                </div>
                {{-- @endif --}}
            </div>


        </div>

        <!-- Bagian Kanan: Form Member -->
        <div class="w-1/2">
            <form action="{{ route('sale.member.save', ['id' => $sales->id]) }}" method="POST" class="space-y-4">
                @csrf
                @method('POST')
                <!-- Nama Member -->
                <div class="flex flex-col space-y-1">
                    <label class="text-sm text-gray-600" for="memberName">Nama Member (Identitas)</label>
                    <input type="text" id="memberName" name="name"
                        class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400"
                        value="{{ $customers->name ?? '' }}" required>
                </div>

                <!-- Poin -->
                <div class="flex flex-col space-y-1">
                    <label class="text-sm text-gray-600" for="poin">Poin</label>
                    <input type="text" id="poin"
                        class="block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition placeholder-gray-400 bg-gray-200 text-gray-500 "
                        value="{{ $customers->point ?? 0 }}" readonly disabled>
                </div>

                <!-- Gunakan Poin -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="use_point" value="1" id="usePoints" class="rounded-sm" {{
                        $isFirstTransaction ? 'disabled' : '' }}>
                    <label for="usePoints" class="text-sm text-gray-600">Gunakan poin</label>
                </div>
                @if($isFirstTransaction)
                <p class="text-xs text-red-500">Poin tidak bisa dipakai di transaksi pertama</p>
                @endif

                <!-- Tombol Selanjutnya -->
                <x-button type="submit">
                    Selanjutnya
                </x-button>
            </form>
        </div>
    </div>
</div>
@endsection