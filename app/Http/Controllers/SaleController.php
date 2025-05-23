<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\DetailSale;
use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $details = DetailSale::all();

        $filterBy = $request->input('filter_by');
        $filterValue = $request->input('filter_value');
        $search = $request->input('search');

        $transactions = Sale::with('user', 'customer')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('customer', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('total_price', 'like', "%{$search}%");

                    if (preg_match('/^non|n\b/i', $search)) {
                        $q->orWhereNull('customer_id');
                    }
                });
            })
            ->when($filterBy === 'day' && $filterValue, function ($query) use ($filterValue) {
                return $query->whereDate('created_at', Carbon::parse($filterValue));
            })
            ->when($filterBy === 'month' && $filterValue, function ($query) use ($filterValue) {
                return $query->whereMonth('created_at', Carbon::parse($filterValue)->month)
                    ->whereYear('created_at', Carbon::parse($filterValue)->year);
            })
            ->when($filterBy === 'year' && $filterValue, function ($query) use ($filterValue) {
                return $query->whereYear('created_at', $filterValue);
            });

        $sales = $transactions->latest()->get(); // bisa juga ->paginate(10);

        return view('pages.sale.index', compact('sales', 'details'));
    }

    public function detail(Request $request, $id)
    {
        $details = DetailSale::where('sale_id', $id)->get();
        $sales = Sale::findOrFail($id);

        $pointUsed = $sales->point;
        $totalBeforeDiscount = $details->sum('subtotal');
        $totalAfterDiscount = $sales['total_price'];
        $pointUsed = $totalBeforeDiscount - $totalAfterDiscount;

        return view('pages.sale.detail', compact('details', 'sales', 'totalBeforeDiscount', 'totalAfterDiscount', 'pointUsed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return view('pages.sale.create', compact('products'));
    }

    public function post()
    {
        $cart = session('cart', []);

        return view('pages.sale.post', compact('cart'));
    }

    public function member(Request $request, $id)
    {
        $details = DetailSale::where('sale_id', $id)->get();
        $sales = Sale::findOrFail($id);
        $customers = $sales->customer_id ? Customer::find($sales->customer_id) : null;

        $isFirstTransaction = Sale::where('customer_id', $customers->id)
            ->where('id', '<>', $sales->id)
            ->count() === 0;

        return view('pages.sale.member', compact('details', 'sales', 'customers', 'isFirstTransaction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function session(Request $request)
    {
        session(['cart' => array_filter($request->products, fn($p) => $p['quantity'] > 0)]);

        return redirect()->route('sale.post');
    }

    // Saya ingin memasukan juga point nya ke tabel sales column 'point' dan 'total_point'

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_date' => 'required',
            'total_price' => 'required',
            'total_pay' => 'required',
            'used_point' => 'nullable',
            'total_point' => 'nullable',
            'customer_id' => 'nullable',
            'user_id' => 'required'
        ]);

        $total_return = $request->input('total_pay') - $request->input('total_price');
        $validated['total_return'] = $total_return;

        $customer_id = null;

        if (!empty($request->no_hp)) {
            $customer = Customer::where('no_hp', $request->no_hp)->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => 'customer' . $request->no_hp,
                    'no_hp' => $request->no_hp,
                    'point' => 0
                ]);
            }
            $customer_id = $customer->id;
        }

        $validated['customer_id'] = $customer_id;
        $sales['customer_id'] = $customer_id;

        $point = 0;
        $used_point = 0;
        $total_point = 0;

        $is_member = $request->member_status === 'member';

        if ($is_member && $customer_id) {
            $point = floor($request->input('total_price') / 100);

            $currentCustomer = Customer::find($customer_id);
            $previousPoint = $currentCustomer->point;

            // Update total point = sisa setelah dikurangi + point baru
            $total_point = $previousPoint + $point;

            // Simpan ke validated
            $validated['used_point'] = $used_point;
            $validated['total_point'] = $total_point;

            // Update point di tabel customer
            Customer::where('id', $customer_id)->update([
                'point' => $total_point
            ]);
        } else {
            $validated['used_point'] = 0;
            $validated['total_point'] = 0;
        }

        $sale = Sale::create($validated);

        foreach ($request->products as $product) {
            DetailSale::create([
                'sale_id' => $sale->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'subtotal' => $product['price'] * $product['quantity']
            ]);

            Product::where('id', $product['id'])->decrement('stock', $product['quantity']);
        }

        if ($is_member) {
            return redirect()->route('sale.member', $sale->id);
        }

        return redirect()->route('sale.detail', $sale->id);
    }

    public function saveMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $sale = Sale::findOrFail($id);
        $customer = Customer::findOrFail($sale->customer_id);
        $usePoint = $request->has('use_point');

        $point = $customer->point;
        $originalTotal = $sale->total_price;
        $pay = $sale->total_pay;

        $customer->name = $request->name;

        if ($usePoint) {
            if ($point >= $originalTotal) {
                $sale->total_price = 0;
                $sale->used_point = $originalTotal;
                $customer->point = $point - $originalTotal;
                $sale->total_return = $pay; // full return karena tidak bayar
            } else {
                $discountedTotal = $originalTotal - $point;
                $sale->total_price = $discountedTotal;
                $sale->used_point = $point;
                $customer->point = 0;
                $sale->total_return = $pay - $discountedTotal;
            }
        } else {
            $sale->used_point = 0;
            $sale->total_return = $pay - $sale->total_price;
        }

        // Simpan poin akhir customer ke total_point di tabel sales
        // $sale->total_point = $customer->point;

        $customer->save();
        $sale->save();

        return redirect()->route('sale.detail', $sale->id);
    }




    public function generatePdf(Request $request, $id)
    {
        $details = DetailSale::where('sale_id', $id)->get();
        $sales = Sale::findOrFail($id);

        $pointUsed = $sales->point;
        $totalBeforeDiscount = $details->sum('subtotal');
        $totalAfterDiscount = $sales->total_price;
        $pointUsed = $totalBeforeDiscount - $totalAfterDiscount;

        // Tampilkan data untuk view
        $data = compact('details', 'sales', 'totalBeforeDiscount', 'totalAfterDiscount', 'pointUsed');

        // Generate PDF
        $pdf = PDF::loadView('pages.sale.invoice', $data);

        // Return the PDF file as download
        return $pdf->download('invoice_' . $sales->sale_id . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filterBy = $request->input('filter_by');
        $filterValue = $request->input('filter_value');

        return Excel::download(new SalesExport($filterBy, $filterValue), 'sales.xlsx');
    }


    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
