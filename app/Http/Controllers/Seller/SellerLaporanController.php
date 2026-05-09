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
    /**
     * Tampilkan halaman laporan penjualan penjual.
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        // ── Periode Filter ──────────────────────────────────────────────────
        $periode = $request->input('periode', 'bulan_ini');
        [$startDate, $endDate] = $this->resolvePeriode($periode, $request);

        // ── Status Filter ───────────────────────────────────────────────────
        $filterStatus = $request->input('status', '');

        // ── Base query: order_items milik seller ini ─────────────────────────
        $baseQuery = OrderItem::with(['order', 'harvest.product.category'])
            ->where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate, $filterStatus) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
                if ($filterStatus) {
                    $q->where('status', $filterStatus);
                }
                // Hanya order yang sudah bayar / selesai untuk kalkulasi pendapatan
                $q->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            });

        // ── Ringkasan Statistik (dari semua periode filter, semua status valid) ─
        $statsQuery = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            });

        $totalPendapatan = (clone $statsQuery)->sum('subtotal');
        $totalOrder = (clone $statsQuery)->distinct('order_id')->count('order_id');
        $totalItemTerjual = (clone $statsQuery)->sum('quantity');

        // Rata-rata nilai per order
        $rataRataOrder = $totalOrder > 0 ? $totalPendapatan / $totalOrder : 0;

        // ── Produk terlaris (top 5) ─────────────────────────────────────────
        $produkTerlaris = (clone $statsQuery)
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ── Pendapatan per bulan (12 bulan terakhir, untuk grafik) ───────────
        $grafikBulanan = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) {
                $q->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(order_items.subtotal) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        // Isi bulan yang kosong agar grafik lengkap
        $grafikData = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $label = now()->subMonths($i)->isoFormat('MMM YY');
            $grafikData[] = [
                'bulan' => $label,
                'total' => $grafikBulanan->get($key)?->total ?? 0,
            ];
        }

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

        // ── Perbandingan periode sebelumnya ──────────────────────────────────
        $diffDays = $startDate->diffInDays($endDate) + 1;
        $prevStart = $startDate->copy()->subDays($diffDays);
        $prevEnd = $startDate->copy()->subDay();
        $prevPendapatan = OrderItem::where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($prevStart, $prevEnd) {
                $q->whereBetween('created_at', [$prevStart, $prevEnd])
                    ->whereNotIn('status', ['cancelled', 'refunded', 'pending_payment']);
            })->sum('subtotal');

        $growthPersen = $prevPendapatan > 0
            ? round((($totalPendapatan - $prevPendapatan) / $prevPendapatan) * 100, 1)
            : ($totalPendapatan > 0 ? 100 : 0);

        return view('seller.laporan', compact(
            'totalPendapatan',
            'totalOrder',
            'totalItemTerjual',
            'rataRataOrder',
            'produkTerlaris',
            'grafikData',
            'riwayat',
            'periode',
            'filterStatus',
            'startDate',
            'endDate',
            'growthPersen',
            'prevPendapatan',
        ));
    }

    /**
     * Export CSV laporan penjualan.
     */
    public function export(Request $request)
    {
        $sellerId = Auth::id();
        $periode = $request->input('periode', 'bulan_ini');
        [$startDate, $endDate] = $this->resolvePeriode($periode, $request);
        $filterStatus = $request->input('status', '');

        $items = OrderItem::with(['order', 'harvest.product'])
            ->where('seller_user_id', $sellerId)
            ->whereHas('order', function ($q) use ($startDate, $endDate, $filterStatus) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
                if ($filterStatus) {
                    $q->where('status', $filterStatus);
                }
            })
            ->orderByDesc('created_at')
            ->get();

        $filename = 'laporan_penjualan_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            // BOM untuk Excel agar bisa baca UTF-8
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No. Order',
                'Tanggal',
                'Produk',
                'Satuan',
                'Qty',
                'Harga Satuan',
                'Subtotal',
                'Status Order',
                'Harga Penawaran',
            ]);

            foreach ($items as $item) {
                fputcsv($file, [
                    $item->order->order_number ?? '-',
                    optional($item->order->created_at)->format('d/m/Y H:i'),
                    $item->product_name,
                    $item->product_unit,
                    $item->quantity,
                    $item->price_per_unit,
                    $item->subtotal,
                    $this->labelStatus($item->order->status ?? ''),
                    $item->is_offer_price ? 'Ya' : 'Tidak',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Kembalikan [Carbon $start, Carbon $end] berdasarkan pilihan periode.
     */
    private function resolvePeriode(string $periode, Request $request): array
    {
        return match ($periode) {
            'hari_ini' => [now()->startOfDay(), now()->endOfDay()],
            'minggu_ini' => [now()->startOfWeek(), now()->endOfWeek()],
            'bulan_ini' => [now()->startOfMonth(), now()->endOfMonth()],
            'bulan_lalu' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'tahun_ini' => [now()->startOfYear(), now()->endOfYear()],
            'custom' => [
                Carbon::parse($request->input('start_date', now()->startOfMonth()))->startOfDay(),
                Carbon::parse($request->input('end_date', now()->endOfMonth()))->endOfDay(),
            ],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }

    /**
     * Label bahasa Indonesia untuk status order.
     */
    private function labelStatus(string $status): string
    {
        return match ($status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Dikembalikan',
            default => ucfirst($status),
        };
    }
}