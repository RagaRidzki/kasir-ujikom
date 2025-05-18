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
    public function index(Request $request)
    {
        $totalSale = Sale::count();
        $totalSaleDay = Sale::whereDate('created_at', Carbon::today())->count();
        $totalSaleYesterday = Sale::whereDate('created_at', Carbon::yesterday())->count();
        $totalTurnDay = Sale::whereDate('created_at', Carbon::today())->sum('total_price');
        $totalProduct = Product::count();
        $totalUser = User::count();

        if ($totalSaleYesterday > 0) {
            $percentageChange = (($totalSaleDay - $totalSaleYesterday) / $totalSaleYesterday) * 100;
        } else {
            $percentageChange = $totalSaleDay > 0 ? 100 : 0;
        }

        // Ambil data penjualan per hari
        $sales = DB::table('sales')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        $labels = $sales->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->translatedFormat('j F'); // hasil: "1 Jan 2025"
        });
        $dataChart = $sales->pluck('total');

        $productStock = Product::select('name', 'stock')->get();
        $productNames = $productStock->pluck('name');
        $productQuantities = $productStock->pluck('stock');

        $salesLatest = Sale::latest()->take(3)->get();

        $filterBy = $request->input('filter_by', 'day'); // default 'day'
        $filterValue = $request->input('filter_value', now()->format('Y-m-d'));

        $query = Sale::query();

        // Filter berdasarkan pilihan
        switch ($filterBy) {
            case 'day':
                $date = Carbon::parse($filterValue);
                $query->whereDate('created_at', $date);
                break;

            case 'month':
                $date = Carbon::parse($filterValue);
                $query->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year);
                break;

            case 'year':
                $query->whereYear('created_at', $filterValue);
                break;
        }

        $omzet = $query->sum('total_price');


        return view('pages.dashboard.index', compact(
            'totalSale',
            'totalSaleDay',
            'totalSaleYesterday',
            'totalTurnDay',
            'percentageChange',
            'totalProduct',
            'totalUser',
            'labels',
            'dataChart',
            'productStock',
            'productNames',
            'productQuantities',
            'salesLatest',
            'omzet'
        ));
    }
}
