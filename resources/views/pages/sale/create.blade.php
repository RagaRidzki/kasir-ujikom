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

    <form action="{{ route('sale.session') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-6 bg-white border border-gray-200 p-6 rounded-xl">
            <div class="grid grid-cols  -1 md:grid-cols-3 gap-6 p-6">
                @foreach ($products as $product)
                <div class="bg-white p-6 rounded-lg border border-gray-200 text-center">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-40 h-40 mx-auto mb-4">
                    <h1 class="text-lg font-semibold">{{ $product->name }}</h1>
                    <p class="text-gray-500 text-sm" data-stock="{{ $product->id }}">Stok {{ $product->stock }}</p>
                    <p class="text-md font-medium mt-2">{{ 'Rp' . number_format($product->price, 0,',', '.') }}</p>

                    <div class="flex items-center justify-center mt-4 space-x-4 text-gray-500">
                        <button type="button" class="text-lg btn-minus" data-id="{{ $product->id }}">-</button>
                        <span class="text-lg quantity" id="quantity-{{ $product->id }}">0</span>
                        <button type="button" class="text-lg btn-plus" data-id="{{ $product->id }}">+</button>
                    </div>

                    <p class="mt-4 text-gray-600">Sub Total <span id="subtotal-{{ $product->id }}" class="font-bold">Rp0</span></p>

                    <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                    <input type="hidden" name="products[{{ $product->id }}][name]" value="{{ $product->name }}">
                    <input type="hidden" name="products[{{ $product->id }}][price]" value="{{ $product->price }}">
                    <input type="hidden" name="products[{{ $product->id }}][quantity]" class="quantity-input" id="input-quantity-{{ $product->id }}" value="0">
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
