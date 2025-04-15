@extends('layouts.main')

@section('content')
<div class="p-6">
    <x-breadcrumb title="Penjualan" :paths="[
            ['name' => 'Home', 'url' => ''],
            ['name' => 'Data Penjualan', 'url' => ''],
            ['name' => 'Tambah Data Penjualan', 'url' => '']
        ]" />

    <form action="sale/session" method="POST">
        <div class="mb-6 bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 text-center">
                    <img src="" alt="" class="w-40 h-40 mx-auto mb-4">
                    <h1 class="text-lg font-semibold"></h1>
                    <p class="text-gray-500 text-sm" data-stock="produkId">Stok </p>
                    <p class="text-md font-medium mt-2"></p>

                    <div class="flex items-center justify-center mt-4 space-x-4 text-gray-500">
                        <button type="button" class="text-lg btn-minus" data-id="produkId">-</button>
                        <span class="text-lg quantity" id="quantity-produkId">0</span>
                        <button type="button" class="text-lg btn-plus" data-id="produkId">+</button>
                    </div>

                    <p class="mt-4 text-gray-600">Sub Total <span id="subtotal-produkId" class="font-bold">Rp0</span>
                    </p>

                    <input type="hidden" name="products[produkId][id]" value="produkId">
                    <input type="hidden" name="products[produkId][name]" value="">
                    <input type="hidden" name="products[produkId][price]" value="}">
                    <input type="hidden" name="products[produkId][quantity]" class="quantity-input"
                        id="input-quantity-id" value="0">
                </div>
                @endforeach
            </div>

            <div class="flex justify-center items-center text-center">
                <x-button type="submit" color="blue" shadow="blue">
                    Selanjutnya
                </x-button>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.btn-plus').forEach(button => {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let quantityElement = document.getElementById('quantity-' + productId);
            let inputElement = document.getElementById('input-quantity-' + productId);
            let price = parseInt(document.querySelector(`input[name="products[${productId}][price]"]`).value);
            let stock = parseInt(document.querySelector(`p[data-stock="${productId}"]`).textContent.replace(/\D/g, ''));
            let subtotalElement = document.getElementById('subtotal-' + productId);

            let quantity = parseInt(quantityElement.textContent);

            if (quantity < stock) {
                quantity += 1;
                quantityElement.textContent = quantity;
                inputElement.value = quantity;
                subtotalElement.textContent = 'Rp' + (quantity * price).toLocaleString('id-ID');
            }
        });
    });

    document.querySelectorAll('.btn-minus').forEach(button => {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let quantityElement = document.getElementById('quantity-' + productId);
            let inputElement = document.getElementById('input-quantity-' + productId);
            let price = parseInt(document.querySelector(`input[name="products[${productId}][price]"]`).value);
            let subtotalElement = document.getElementById('subtotal-' + productId);

            let quantity = Math.max(0, parseInt(quantityElement.textContent) - 1);
            quantityElement.textContent = quantity;
            inputElement.value = quantity;
            subtotalElement.textContent = 'Rp' + (quantity * price).toLocaleString('id-ID');
        });
    });
</script>



@endsection