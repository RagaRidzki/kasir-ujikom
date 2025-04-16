<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSale = Sale::count();
        $totalSaleDay = Sale::whereDate('created_at', Carbon::today())->count();
        $totalProduct = Product::count();
        $totalUser = User::count();

        // Ambil data penjualan per hari
        $sales = DB::table('sales')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();


        // Siapkan data untuk chart
        $labels = $sales->pluck('date');
        $dataChart = $sales->pluck('total');

        return view('pages.dashboard.index', compact(
            'totalSale',
            'totalSaleDay',
            'totalProduct',
            'totalUser',
            'labels',
            'dataChart'
        ));
    }
}
