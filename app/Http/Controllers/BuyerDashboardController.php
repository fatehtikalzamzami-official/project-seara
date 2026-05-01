<?php

namespace App\Http\Controllers;

use App\Models\Harvest;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $harvests = Harvest::with(['product', 'seller.user'])
            ->whereDate('harvest_date', now())
            ->latest()
            ->take(6)
            ->get();

        return view('pembeli.dashboard', compact('harvests'));
    }
}
