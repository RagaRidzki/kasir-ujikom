<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromArray, WithHeadings
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }
    public function array(): array
    {
        $product = [];

        $saleQuery = Sale::with('user', 'customer');

        if ($this->filter == 'day') {
            $saleQuery->whereDate('created_at', Carbon::today());
        } elseif ($this->filter == 'week') {
            $saleQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->filter == 'month') {
            $saleQuery->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($this->filter == 'year') {
            $saleQuery->whereYear('created_at', Carbon::now()->year);
        }

        $sales = $saleQuery->get();

        foreach ($sales as $sale) {
            $product[] = [
                'Nama Pelanggan' => $sale->customer->name ?? 'NON-MEMBER',
                'Tanggal Penjualan' => $sale->created_at->format('d F Y'),
                'Total Harga' => 'Rp. ' . number_format($sale->total_price),
                'Total Bayar' => 'Rp. ' . number_format($sale->total_pay),
                'Total Kembalian' => 'Rp. ' . number_format($sale->total_return),
                'Dibuat Oleh' => $sale->user->name,
            ];
        }

        return $product;
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'Tanggal Penjualan',
            'Total Harga',
            'Total Bayar',
            'Total Kembalian',
            'Dibuat Oleh'
        ];
    }
}

