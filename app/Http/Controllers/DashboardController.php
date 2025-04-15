<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $products = Product::count();
        $users = User::count();
        $sales = Sale::count();

        return view('pages.dashboard.index', compact('products', 'users', 'sales'));
    }
}
