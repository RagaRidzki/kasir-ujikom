@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="mb-6">
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

    <div class="flex justify-between mb-6 bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <div class="w-1/2 pr-12">
            <h1 class="text-xl font-semibold mb-2">Produk yang dipilih</h1>

            {{-- start: looping produk dari session --}}
            @if (!empty($cart))
            @foreach ($cart as $product)
            <p>{{ $product['name'] }}</p>
            <div class="flex justify-between mb-6">
                <p class="text-gray-600">Rp{{ number_format($product['price'], 0, ',', '.') }} X {{ $product['quantity'] }}</p>
                <p class="font-semibold text-gray-700">Rp{{ number_format($product['price'] * $product['quantity'], 0,
                    ',', '.') }}</p>
            </div>
            @endforeach
            <div class="flex justify-between">
                <h1 class="text-xl font-semibold text-gray-800">Total</h1>
                <h1 id="totalAmount" class="text-xl font-semibold text-gray-800">Rp{{ number_format(array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $cart)), 0, ',', '.') }}
                </h1>
            </div>
            @else
            <p>Tidak ada produk yang dipilih.</p>
            @endif
            {{-- end: looping produk dari session --}}

        </div>

        <div class="w-1/2 pl-6">
            <form action="{{ route('sale.store') }}" method="POST">
                @csrf
                @method('POST')
                {{-- start: input data sale  --}}
                <input type="hidden" name="sale_date" value="{{ now() }}">
                <input type="hidden" name="total_price" id="total_price"
                    value="{{ array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $cart)) }}">
                <input type="hidden" name="total_return" id="totalReturn" value="">
                <input type="hidden" name="point" value="">
                <input type="hidden" name="total_point" value="">
                <input type="hidden" name="customer_id" value="{{ $customer_id ?? '' }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                {{-- end: input data sale  --}}

                {{-- start: input data detail product  --}}
                @foreach ($cart as $index => $product)
                <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product['id'] }}">
                <input type="hidden" name="products[{{ $index }}][name]" value="{{ $product['name'] }}">
                <input type="hidden" name="products[{{ $index }}][price]" value="{{ $product['price'] }}">
                <input type="hidden" name="products[{{ $index }}][quantity]" value="{{ $product['quantity'] }}">
                <input type="hidden" name="products[{{ $index }}][subtotal]" value="{{ $product['price'] * $product['quantity'] }}">
                @endforeach
                {{-- start: input data detail product --}}

                <div class="flex flex-col space-y-2 mb-4">
                    <label class="text-sm text-gray-500">Member status <span class="text-red-500">Dapat juga membuat
                            member</span></label>
                    <select name="member_status" id="memberStatus"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:outline-none focus:ring-gray-400">
                        <option value="non-member">Bukan member</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                <div class="flex flex-col space-y-2 mb-4" id="phoneField" style="display: none;">
                    <label class="text-sm text-gray-500">No Telepon <span class="text-red-500">(daftar/gunakan
                            member)</span></label>
                    <input type="number" name="no_hp"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:outline-none focus:ring-gray-400">
                </div>
                <div class="flex flex-col space-y-2 mb-4">
                    <label class="text-sm text-gray-500" for="totalPay">Total Bayar</label>
                    <input type="text" id="totalPayment"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring focus:outline-none focus:ring-gray-400"
                        inputmode="numeric" required>
                    <input type="hidden" id="totalPaymentRaw" name="total_pay">
                    <p id="alertText" class="text-red-500 text-sm hidden">Jumlah bayar kurang</p>
                </div>
                <button type="submit" id="submitButton"
                    class="px-4 py-2 rounded-md text-white bg-blue-500 hover:bg-blue-700">Pesan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const memberStatus = document.getElementById("memberStatus");
        const phoneField = document.getElementById("phoneField");
        const totalPaymentInput = document.getElementById("totalPayment");
        const totalPaymentRawInput = document.getElementById("totalPaymentRaw");
        const totalReturnInput = document.getElementById("totalReturn");
        const totalAmount = parseInt(document.getElementById("totalAmount").textContent.replace(/[^\d]/g, "")) || 0;
        const alertText = document.getElementById("alertText");
        const submitButton = document.getElementById("submitButton");

        // Menampilkan input nomor HP jika status member dipilih
        memberStatus.addEventListener("change", function() {
            phoneField.style.display = this.value === "member" ? "block" : "none";
        });

        // Fungsi untuk memformat angka ke Rupiah
        function formatRupiah(angka) {
            return "Rp" + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Event listener untuk format otomatis pada input pembayaran
        totalPaymentInput.addEventListener("input", function(e) {
            let value = e.target.value.replace(/[^\d]/g, ""); // Hanya angka

            // Biarkan kosong jika user menghapus semua angka
            if (value === "") {
            e.target.value = "";
            totalPaymentRawInput.value = "";
            return;
        }

            e.target.value = formatRupiah(value);
            totalPaymentRawInput.value = value;

            // Ambil angka asli tanpa format
            let numericValue = parseInt(value) || 0;

            let totalReturn = numericValue - totalAmount;
            totalReturnInput.value = totalReturn >= 0 ? totalReturn : 0;

            if (numericValue < totalAmount) {
                alertText.classList.remove("hidden");
                submitButton.disabled = true;
                submitButton.classList.add("bg-gray-400", "cursor-not-allowed");
                submitButton.classList.remove("bg-blue-500", "hover:bg-blue-700");
            } else {
                alertText.classList.add("hidden");
                submitButton.disabled = false;
                submitButton.classList.remove("bg-gray-400", "cursor-not-allowed");
                submitButton.classList.add("bg-blue-500", "hover:bg-blue-700");
            }
        });
    });
</script>


@endsection
