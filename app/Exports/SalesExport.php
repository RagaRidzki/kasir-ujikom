<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::select('id', 'sale_date', 'total_price', 'total_pay', 'total_return', 'point', 'total_point', 'customer_id', 'user_id', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Sale Date',
            'Total Price',
            'Total Pay',
            'Total Return',
            'Point',
            'Total Point',
            'Customer ID',
            'User ID',
            'Created At'
        ];
    }
}

