@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-textColor">Selamat datang, [Auth User]</h1>
        <ul class="flex items-center text-sm">
            <li class="mr-2">
                <a href="" class="text-gray-400 hover:text-gray-600 font-medium">Home</a>
            </li>
            <li class="mr-2 text-gray-600 font-medium">/</li>
            <li class="mr-2 ">
                <a href="" class="text-gray-600 font-medium">Dashboard</a>
            </li>
        </ul>
    </div>
    {{-- If admin --}}
    <div class="mb-6 gap-6 grid grid-cols-1 md:grid-cols-3">
        <div class="bg-white border-gray-100 shadow-black/5 p-6 rounded-md shadow-md">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2">Produk: </h1>
                <h4 class="text-2xl font-semibold text-textColor">100</h4>
            </div>
        </div>
        <div class="bg-white border-gray-100 shadow-black/5 p-6 rounded-md shadow-md">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2">User:</h1>
                <h4 class="text-2xl font-semibold text-textColor">5</h4>
            </div>
        </div>
        <div class="bg-white border-gray-100 shadow-black/5 p-6 rounded-md shadow-md">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold">Penjualan:</h1>
                <h4 class="text-2xl font-semibold text-textColor">5000</h4>
            </div>
        </div>
    </div>

    {{-- else if employee --}}
    <div class="text-center bg-white border-gray-100 shadow-black/5 p-6 rounded-xl shadow-md">
        <div class="bg-gray-100 p-4 rounded-lg">
            <h1 class="text-xl font-semibold mr-2">Total Penjualan Hari Ini</h1>
        </div>
        <div class="mt-8">
            <p class="text-2xl font-semibold">100</p>
            <p class="text-gray-500">Jumlah total penjualan yang terjadi hari ini.</p>
        </div>
        <div class="bg-gray-100 mt-8 p-4 rounded-lg">
            <h1 class=" text-gray-500">Terakhir diperbarui: 24 Feb 2025 05:37</h1>
        </div>
    </div>

    {{-- else --}}
    <div class="p-6 bg-white shadow-md rounded-md text-center">
        <h1 class="text-xl font-semibold text-red-500">Role tidak ditemukan</h1>
        <p>Silakan hubungi administrator.</p>
    </div>
</div>
@endsection