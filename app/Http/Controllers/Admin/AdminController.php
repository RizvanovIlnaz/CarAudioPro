<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'products_count' => Product::count(),
            'users_count' => User::where('role', 'user')->count(),
            'orders_count' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}