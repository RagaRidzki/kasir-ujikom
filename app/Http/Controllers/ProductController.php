<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return view('pages.product.index', compact('products', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048'
        ], [
            'price.min' => 'Harga tidak boleh kurang dari 1',
            'stock.min' => 'Stok tidak boleh kurang dari 1'
        ]);



        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $product = Product::findOrFail($id);

        return view('pages.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ], [
            'price.min' => 'Harga tidak boleh kurang dari 1',
            'stock.min' => 'Stok tidak boleh kurang dari 1'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);

        return redirect('/product')->with('success', 'Data produk berhasil diupdate');
    }

    public function updateStock(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'stock' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($id);

        $product->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return back()->with('success', 'Data Produk berhasil dihapus');
    }
}
