<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class SalesExport implements FromArray, WithHeadings
{
    protected $filterBy;
    protected $filterValue;

    public function __construct($filterBy, $filterValue)
    {
        $this->filterBy = $filterBy;
        $this->filterValue = $filterValue;
    }

    public function array(): array
    {
        $product = [];

        $saleQuery = Sale::with('user', 'customer');

        if ($this->filterBy === 'day' && $this->filterValue) {
            $saleQuery->whereDate('created_at', Carbon::parse($this->filterValue));
        } elseif ($this->filterBy === 'week') {
            $saleQuery->whereBetween('created_at', [
                Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()
            ]);
        } elseif ($this->filterBy === 'month' && $this->filterValue) {
            $saleQuery->whereMonth('created_at', Carbon::parse($this->filterValue)->month)
                ->whereYear('created_at', Carbon::parse($this->filterValue)->year);
        } elseif ($this->filterBy === 'year' && $this->filterValue) {
            $saleQuery->whereYear('created_at', $this->filterValue);
        }

        $sales = $saleQuery->orderBy('created_at', 'desc')->get();

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
