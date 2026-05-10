<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Harvest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerLaporanController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        $periode = $request->input('periode', 'bulan_ini');
        [$startDate, $endDate] = $this->resolvePeriode($periode, $request);
        $filterStatus = $request->input('status', '');
        $activeTab    = $request->input('tab', 'ringkasan');

        // ── Statistik Utama ──────────────────────────────────────────────────
        $statsQuery = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            });

        $totalPendapatan  = (clone $statsQuery)->sum('subtotal');
        $totalOrder       = (clone $statsQuery)->distinct('order_id')->count('order_id');
        $totalItemTerjual = (clone $statsQuery)->sum('quantity');
        $rataRataOrder    = $totalOrder > 0 ? $totalPendapatan / $totalOrder : 0;

        // ── Perbandingan periode sebelumnya ──────────────────────────────────
        $diffDays   = $startDate->diffInDays($endDate) + 1;
        $prevStart  = $startDate->copy()->subDays($diffDays);
        $prevEnd    = $startDate->copy()->subDay();
        $prevPendapatan = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($prevStart, $prevEnd) {
                $q->whereBetween('created_at', [$prevStart, $prevEnd])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })->sum('subtotal');

        $growthPersen = $prevPendapatan > 0
            ? round((($totalPendapatan - $prevPendapatan) / $prevPendapatan) * 100, 1)
            : ($totalPendapatan > 0 ? 100 : 0);

        // ── Produk terlaris (top 5) ─────────────────────────────────────────
        $produkTerlaris = (clone $statsQuery)
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as total_orders')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ── Grafik bulanan 12 bulan ──────────────────────────────────────────
        $grafikBulanan = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) {
                $q->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(order_items.subtotal) as total'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $grafikData = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $grafikData[] = [
                'bulan'        => now()->subMonths($i)->isoFormat('MMM YY'),
                'total'        => (float)($grafikBulanan->get($key)?->total ?? 0),
                'total_orders' => (int)($grafikBulanan->get($key)?->total_orders ?? 0),
            ];
        }

        // ── Grafik harian dalam periode ──────────────────────────────────────
        $grafikHarianRaw = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw("DATE(orders.created_at) as tanggal"),
                DB::raw('SUM(order_items.subtotal) as total'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $grafikHarianData = [];
        $currentDay = $startDate->copy();
        $maxDays = min($diffDays, 31); // Batasi 31 hari agar grafik tidak terlalu padat
        $step = $diffDays > 31 ? (int)ceil($diffDays / 31) : 1;
        $dayCount = 0;
        while ($currentDay->lte($endDate) && $dayCount < 60) {
            $key = $currentDay->format('Y-m-d');
            $grafikHarianData[] = [
                'tanggal'      => $currentDay->isoFormat('D MMM'),
                'total'        => (float)($grafikHarianRaw->get($key)?->total ?? 0),
                'total_orders' => (int)($grafikHarianRaw->get($key)?->total_orders ?? 0),
            ];
            $currentDay->addDays($step);
            $dayCount++;
        }

        // ── Distribusi status order ──────────────────────────────────────────
        $statusDistribusi = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerId))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // ── Pelanggan terbaik (top 5) ────────────────────────────────────────
        $pelangganTerbaik = OrderItem::where('order_items.seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.id as user_id',
                'users.nama_lengkap',
                DB::raw('SUM(order_items.subtotal) as total_belanja'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_items.quantity) as total_item')
            )
            ->groupBy('users.id', 'users.nama_lengkap')
            ->orderByDesc('total_belanja')
            ->limit(5)
            ->get();

        // ── Breakdown per kategori produk ────────────────────────────────────
        $kategoryBreakdown = OrderItem::where('order_items.seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })
            ->join('harvests', 'order_items.harvest_id', '=', 'harvests.id')
            ->join('products', 'harvests.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as kategori',
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->groupBy('categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        // ── Total dibatalkan/refund ──────────────────────────────────────────
        $totalDibatalkan = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['cancelled', 'refunded']);
            })->sum('subtotal');

        // ── Riwayat transaksi (paginasi) ────────────────────────────────────
        $riwayat = OrderItem::with(['order.buyer', 'harvest.product'])
            ->where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate, $filterStatus) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
                if ($filterStatus) {
                    $q->where('status', $filterStatus);
                }
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('seller.laporan', compact(
            'totalPendapatan', 'totalOrder', 'totalItemTerjual', 'rataRataOrder',
            'produkTerlaris', 'grafikData', 'grafikHarianData', 'riwayat',
            'periode', 'filterStatus', 'startDate', 'endDate',
            'growthPersen', 'prevPendapatan', 'statusDistribusi',
            'pelangganTerbaik', 'kategoryBreakdown', 'totalDibatalkan', 'activeTab',
        ));
    }

    public function export(Request $request)
    {
        $sellerId = Auth::id();
        $periode  = $request->input('periode', 'bulan_ini');
        [$startDate, $endDate] = $this->resolvePeriode($periode, $request);
        $filterStatus = $request->input('status', '');

        $items = OrderItem::with(['order.buyer', 'harvest.product'])
            ->where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate, $filterStatus) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
                if ($filterStatus) $q->where('status', $filterStatus);
            })
            ->orderByDesc('created_at')
            ->get();

        $filename = 'laporan_penjualan_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($items, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8 untuk Excel

            fputcsv($file, ['LAPORAN PENJUALAN - SEARA']);
            fputcsv($file, ['Periode', $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y')]);
            fputcsv($file, ['Diekspor pada', now()->format('d/m/Y H:i')]);
            fputcsv($file, []);
            fputcsv($file, [
                'No. Order', 'Tanggal Order', 'Nama Pembeli', 'Produk', 'Satuan',
                'Qty', 'Harga Satuan (Rp)', 'Subtotal (Rp)', 'Status Order',
                'Harga Penawaran', 'Metode Bayar', 'Tanggal Bayar',
            ]);

            foreach ($items as $item) {
                fputcsv($file, [
                    $item->order->order_number ?? '-',
                    optional($item->order->created_at)->format('d/m/Y H:i'),
                    $item->order->buyer->nama_lengkap ?? '-',
                    $item->product_name,
                    $item->product_unit,
                    $item->quantity,
                    number_format($item->price_per_unit, 2, '.', ''),
                    number_format($item->subtotal, 2, '.', ''),
                    $this->labelStatus($item->order->status ?? ''),
                    $item->is_offer_price ? 'Ya' : 'Tidak',
                    $item->order->payment_method ?? '-',
                    optional($item->order->paid_at)->format('d/m/Y H:i') ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function resolvePeriode(string $periode, Request $request): array
    {
        return match ($periode) {
            'hari_ini'   => [now()->startOfDay(), now()->endOfDay()],
            'minggu_ini' => [now()->startOfWeek(), now()->endOfWeek()],
            'bulan_ini'  => [now()->startOfMonth(), now()->endOfMonth()],
            'bulan_lalu' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'tahun_ini'  => [now()->startOfYear(), now()->endOfYear()],
            'custom'     => [
                Carbon::parse($request->input('start_date', now()->startOfMonth()))->startOfDay(),
                Carbon::parse($request->input('end_date', now()->endOfMonth()))->endOfDay(),
            ],
            default      => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }

    private function labelStatus(string $status): string
    {
        return match ($status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'paid'            => 'Sudah Dibayar',
            'processing'      => 'Diproses',
            'shipped'         => 'Dikirim',
            'delivered'       => 'Selesai',
            'cancelled'       => 'Dibatalkan',
            'refunded'        => 'Dikembalikan',
            default           => ucfirst($status),
        };
    }
}
