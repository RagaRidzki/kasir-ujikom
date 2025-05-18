@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-6">
        <div class="flex flex-col">
            <h1 class="text-xl lg:text-2xl font-semibold text-text-primary">Selamat datang, {{ auth()->user()->name }}
            </h1>
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
        <div id="clock" class="flex justify-center items-center text-xs lg:text-sm text-gray-600 font-mono"></div>
    </div>
    {{-- If admin --}}
    @if (auth()->user()->role === 'Admin')
    <div class="mb-6 gap-6 grid grid-cols-1 md:grid-cols-3">
        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2 text-text-primary">Produk: </h1>
                <h4 class="text-2xl font-semibold text-text-primary">{{ $totalProduct }}</h4>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold mr-2 text-text-primary">User:</h1>
                <h4 class="text-2xl font-semibold text-text-primary">{{ $totalUser }}</h4>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="flex flex-col space-y-2">
                <h1 class="text-xl font-semibold text-text-primary">Total Penjualan:</h1>
                <h4 class="text-2xl font-semibold text-text-primary">{{ $totalSale }}</h4>
            </div>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2">

        <!-- Card #1 -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="overflow-x-auto">
                <div class="min-w-[300px] sm:min-w-[400px] md:min-w-[500px]">
                    <canvas id="barChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Card #2 -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl">
            <div class="overflow-x-auto">
                <div class="min-w-[300px] sm:min-w-[400px] md:min-w-[500px]">
                    <canvas id="bar2Chart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let labels = @json($labels);
        let data = @json($dataChart);
    
        // Ambil 7 data terakhir
        const last7Labels = labels.slice(-7);
        const last7Data = data.slice(-7);
    
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: last7Labels,
                datasets: [{
                    // label: 'Total Penjualan 7 Hari Terakhir',
                    data: last7Data,
                    backgroundColor: 'rgba(95,116,253,255)',
                    borderRadius: 10,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                },
                title: {
                    display: true,
                    text: 'Penjualan 7 Hari Terakhir',
                    align: 'start',
                    color: '#1D2939',
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    padding: {
                        bottom: 20 // margin antara title dan chart
                    }
                }
            },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const ctx = document.getElementById('bar2Chart').getContext('2d');
    
        const productNames = {!! json_encode($productNames) !!};
        const productQuantities = {!! json_encode($productQuantities) !!};
    
        const backgroundColors = productQuantities.map(qty =>
            qty < 10 ? 'rgba(253,95,116,255)' : 'rgba(95,116,253,255)'
        );
    
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    // label: 'Stok Produk',
                    data: productQuantities,
                    backgroundColor: backgroundColors,
                    borderRadius: 10,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    },
                    title: {
                    display: true,
                    text: 'Stok Produk',
                    align: 'start',
                    color: '#1D2939',
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    padding: {
                        bottom: 20 // margin antara title dan chart
                    }
                }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                }
            }
        });
    </script>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col justify-between">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
                <h1 class="text-xl font-semibold flex items-center gap-2 text-gray-800">
                    Total Penjualan Hari Ini
                </h1>
            </div>

            <!-- Total Nominal -->
            <div class="text-3xl font-bold text-gray-900 mb-2">
                Rp{{ number_format($totalTurnDay, 0, ',', '.') }}
            </div>

            <!-- Jumlah Transaksi -->
            <p class="text-sm text-gray-500 mb-4">
                {{ $totalSaleDay }} Transaksi
            </p>

            <!-- Persentase Perubahan -->
            <div class="flex items-center gap-2 text-sm mb-4">
                @if ($percentageChange >= 0)
                <span class="text-green-600 font-medium">+{{ number_format($percentageChange, 0) }}%</span>
                @else
                <span class="text-red-600 font-medium">{{ number_format($percentageChange, 0) }}%</span>
                @endif
                <span class="text-gray-500">dibanding kemarin</span>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                <div class="bg-secondary h-2 rounded-full" style="width: {{ intval($percentageChange) }}%"></div>
            </div>

            <!-- Footer -->
            <div class="text-xs text-gray-400 text-left">
                Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
                <h1 class="text-xl font-semibold flex items-center gap-2 text-text-primary">
                    Omzet Penjualan
                </h1>
            </div>

            <form method="GET" class="flex flex-col gap-4 flex-1">
                <!-- Filter Type -->
                <div>
                    <label for="filter_by" class="block mb-2 text-sm font-medium text-text-secondary">
                        Tampilkan berdasarkan:
                    </label>
                    <select name="filter_by" id="filter_by"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                        onchange="this.form.submit()">
                        <option value="day" {{ request('filter_by')=='day' ? 'selected' : '' }}>Per Hari</option>
                        <option value="month" {{ request('filter_by')=='month' ? 'selected' : '' }}>Per Bulan</option>
                        <option value="year" {{ request('filter_by')=='year' ? 'selected' : '' }}>Per Tahun</option>
                    </select>
                </div>

                <!-- Dynamic Date Input -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-text-secondary">Pilih Tanggal:</label>
                    @if(request('filter_by') == 'day')
                    <input type="date" name="filter_value" value="{{ request('filter_value') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                        required>
                    @elseif(request('filter_by') == 'month')
                    <input type="month" name="filter_value" value="{{ request('filter_value') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                        required>
                    @elseif(request('filter_by') == 'year')
                    <input type="number" name="filter_value" min="2000" max="{{ now()->year }}"
                        value="{{ request('filter_value') }}" placeholder="Contoh: 2025"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                        required>
                    @endif
                </div>

                <!-- Omzet & Button -->
                <div class="flex flex-row items-center justify-between mt-auto">
                    <div id="omzetDisplay" class="text-xl font-bold text-text-pr mb-3 sm:mb-0">
                        Rp{{ number_format($omzet, 0, ',', '.') }}
                    </div>
                    <button type="submit"
                        class="flex items-center space-x-1 bg-white border border-gray-200 rounded-lg text-gray-700 px-3 py-2 text-sm focus:outline-none focus:ring-3 focus:ring-third transition">
                        <i class="ri-filter-line"></i>
                        <span>Filter</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 3 -->
        <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col">
            <h1 class="mb-4 text-xl font-semibold text-text-primary">Data Penjualan Terbaru</h1>
            <div class="flex flex-col divide-y divide-gray-100">
                @foreach ($salesLatest as $sale)
                <div class="py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div>
                        <h4 class="text-md font-semibold text-text-primary">
                            {{ $sale->customer->name ?? 'NON-MEMBER' }}
                        </h4>
                        <p class="text-text-secondary text-sm">
                            {{ $sale->created_at->format('j M Y, H:i') }}
                        </p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-500 rounded-full">
                            Rp{{ number_format($sale->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('sale.index') }}"
                    class="font-semibold text-sm hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i class="ri-arrow-right-long-line"></i>
                </a>
            </div>
        </div>
    </div>

</div>


{{-- else if employee --}}
@elseif (auth()->user()->role === 'Employee')
<div class="mb-6 text-center bg-white border border-gray-200 p-6 rounded-xl">
    <div class="bg-gray-100 p-4 rounded-lg">
        <h1 class="text-xl font-semibold mr-2 ">Total Penjualan Hari Ini</h1>
    </div>
    <div class="mt-8">
        <p class="text-2xl font-semibold">{{ $totalSaleDay }}</p>
        <p class="text-gray-500">Jumlah total penjualan yang terjadi hari ini.</p>
    </div>
    <div class="bg-gray-100 mt-8 p-4 rounded-lg">
        <h1 class="text-text-secondary">Terakhir diperbarui: {{ now() }}</h1>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    <!-- Card 1 -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col justify-between">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
            <h1 class="text-xl font-semibold flex items-center gap-2 text-gray-800">
                Total Penjualan Hari Ini
            </h1>
        </div>

        <!-- Total Nominal -->
        <div class="text-3xl font-bold text-gray-900 mb-2">
            Rp{{ number_format($totalTurnDay, 0, ',', '.') }}
        </div>

        <!-- Jumlah Transaksi -->
        <p class="text-sm text-gray-500 mb-4">
            {{ $totalSaleDay }} Transaksi
        </p>

        <!-- Persentase Perubahan -->
        <div class="flex items-center gap-2 text-sm mb-4">
            @if ($percentageChange >= 0)
            <span class="text-green-600 font-medium">+{{ number_format($percentageChange, 0) }}%</span>
            @else
            <span class="text-red-600 font-medium">{{ number_format($percentageChange, 0) }}%</span>
            @endif
            <span class="text-gray-500">dibanding kemarin</span>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
            <div class="bg-secondary h-2 rounded-full" style="width: {{ intval($percentageChange) }}%"></div>
        </div>

        <!-- Footer -->
        <div class="text-xs text-gray-400 text-left">
            Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
            <h1 class="text-xl font-semibold flex items-center gap-2 text-text-primary">
                Omzet Penjualan
            </h1>
        </div>

        <form method="GET" class="flex flex-col gap-4 flex-1">
            <!-- Filter Type -->
            <div>
                <label for="filter_by" class="block mb-2 text-sm font-medium text-text-secondary">
                    Tampilkan berdasarkan:
                </label>
                <select name="filter_by" id="filter_by"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                    onchange="this.form.submit()">
                    <option value="day" {{ request('filter_by')=='day' ? 'selected' : '' }}>Per Hari</option>
                    <option value="month" {{ request('filter_by')=='month' ? 'selected' : '' }}>Per Bulan</option>
                    <option value="year" {{ request('filter_by')=='year' ? 'selected' : '' }}>Per Tahun</option>
                </select>
            </div>

            <!-- Dynamic Date Input -->
            <div>
                <label class="block mb-2 text-sm font-medium text-text-secondary">Pilih Tanggal:</label>
                @if(request('filter_by') == 'day')
                <input type="date" name="filter_value" value="{{ request('filter_value') }}"
                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                    required>
                @elseif(request('filter_by') == 'month')
                <input type="month" name="filter_value" value="{{ request('filter_value') }}"
                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                    required>
                @elseif(request('filter_by') == 'year')
                <input type="number" name="filter_value" min="2000" max="{{ now()->year }}"
                    value="{{ request('filter_value') }}" placeholder="Contoh: 2025"
                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-3 focus:ring-third transition"
                    required>
                @endif
            </div>

            <!-- Omzet & Button -->
            <div class="flex flex-row items-center justify-between mt-auto">
                <div id="omzetDisplay" class="text-xl font-bold text-text-pr mb-3 sm:mb-0">
                    Rp{{ number_format($omzet, 0, ',', '.') }}
                </div>
                <button type="submit"
                    class="flex items-center space-x-1 bg-white border border-gray-200 rounded-lg text-gray-700 px-3 py-2 text-sm focus:outline-none focus:ring-3 focus:ring-third transition">
                    <i class="ri-filter-line"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Card 3 -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl flex flex-col">
        <h1 class="mb-4 text-xl font-semibold text-text-primary">Data Penjualan Terbaru</h1>
        <div class="flex flex-col divide-y divide-gray-100">
            @foreach ($salesLatest as $sale)
            <div class="py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                <div>
                    <h4 class="text-md font-semibold text-text-primary">
                        {{ $sale->customer->name ?? 'NON-MEMBER' }}
                    </h4>
                    <p class="text-text-secondary text-sm">
                        {{ $sale->created_at->format('j M Y, H:i') }}
                    </p>
                </div>
                <div class="mt-2 sm:mt-0">
                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-500 rounded-full">
                        Rp{{ number_format($sale->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('sale.index') }}"
                class="font-semibold text-sm hover:underline inline-flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="ri-arrow-right-long-line"></i>
            </a>
        </div>
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

<script>
    function updateClock() {
      const now = new Date();
      const time = now.toLocaleTimeString('id-ID');
      const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      document.getElementById('clock').textContent = `${time} | ${date}`;
    }
  
    setInterval(updateClock, 1000);
    updateClock(); // panggil langsung saat load
</script>
@endsection