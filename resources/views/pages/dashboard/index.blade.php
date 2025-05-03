@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-textColor">Selamat datang, {{ auth()->user()->name }}</h1>
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
    @if (auth()->user()->role === 'Admin')
    <div class="mb-6 gap-6 grid grid-cols-1 md:grid-cols-3">
        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2">Produk: </h1>
                <h4 class="text-2xl font-semibold text-textColor">{{ $totalProduct }}</h4>
            </div>
        </div>
        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2">User:</h1>
                <h4 class="text-2xl font-semibold text-textColor">{{ $totalUser }}</h4>
            </div>
        </div>
        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold">Penjualan:</h1>
                <h4 class="text-2xl font-semibold text-textColor">{{ $totalSale }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <canvas id="barChart"></canvas>
        </div>
        <div class="bg-white border border-gray-200 shadow-sm p-6 rounded-lg">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($labels);
        const data = @json($dataChart);

        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan per Hari',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<script>
    const ctx = document.getElementById('pieChart').getContext('2d');

    const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productNames) !!},
            datasets: [{
                label: 'Stok Produk',
                data: {!! json_encode($productQuantities) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // biru muda
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Stok'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nama Produk'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Stok Produk per Item'
                }
            }
        }
    });
</script>

    {{-- else if employee --}}
    @elseif (auth()->user()->role === 'Employee')
    <div class="text-center bg-white border-gray-100 shadow-black/5 p-6 rounded-xl shadow-md">
        <div class="bg-gray-100 p-4 rounded-lg">
            <h1 class="text-xl font-semibold mr-2">Total Penjualan Hari Ini</h1>
        </div>
        <div class="mt-8">
            <p class="text-2xl font-semibold">{{ $totalSaleDay }}</p>
            <p class="text-gray-500">Jumlah total penjualan yang terjadi hari ini.</p>
        </div>
        <div class="bg-gray-100 mt-8 p-4 rounded-lg">
            <h1 class=" text-gray-500">Terakhir diperbarui: {{ now() }}</h1>
        </div>
    </div>

    {{-- else --}}
    @else
    <div class="p-6 bg-white shadow-md rounded-md text-center">
        <h1 class="text-xl font-semibold text-red-500">Role tidak ditemukan</h1>
        <p>Silakan hubungi administrator.</p>
    </div>
    @endif
</div>
@endsection