<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh: ambil statistik dari DB nanti
        // $stats = [
        //     'total_sales'   => Order::sum('total_price'),
        //     'active_orders' => Order::where('status', 'active')->count(),
        //     'total_farmers' => Farmer::count(),
        //     'products'      => Product::where('stock', '>', 0)->count(),
        // ];
        // $latestOrders = Order::with(['product', 'buyer'])->latest()->take(5)->get();
        // $activities   = Activity::latest()->take(5)->get();

        return view('dashboard', [
            // 'stats'        => $stats,
            // 'latestOrders' => $latestOrders,
            // 'activities'   => $activities,
        ]);
    }
}
