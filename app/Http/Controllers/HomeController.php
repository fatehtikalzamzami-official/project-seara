<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Contoh: ambil data dari DB nanti
        // $products  = Product::with('farmer')->latest()->paginate(10);
        // $flashSale = Product::where('is_flash_sale', true)->get();
        // $farmers   = Farmer::popular()->take(5)->get();

        return view('home', [
            // 'products'  => $products,
            // 'flashSale' => $flashSale,
            // 'farmers'   => $farmers,
        ]);
    }
}
