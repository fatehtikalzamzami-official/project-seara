<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;

class HomeController extends Controller
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
