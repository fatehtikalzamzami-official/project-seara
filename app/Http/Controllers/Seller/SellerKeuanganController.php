<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HarvestSchedule;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SellerKeuanganController extends Controller
{
    /**
     * Tampilan utama halaman Keuangan Seller.
     */
    public function index(Request $request)
    {
        $sellerUserId = Auth::id();
        $sellerProfile = Auth::user()->sellerProfile;

        // ── Periode filter untuk tabel transaksi ─────────────────────────
        $period = $request->get('period', '');
        $status = $request->get('status', '');

        // ── Query orders yang mengandung item milik seller ini ─────────────
        $ordersQuery = Order::with([
            'buyer:id,nama_lengkap,email',
            'items' => fn($q) => $q->where('seller_user_id', $sellerUserId),
        ])
            ->whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId))
            ->latest('created_at');

        // Filter status
        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Filter periode
        match ($period) {
            'hari_ini' => $ordersQuery->whereDate('created_at', today()),
            '7_hari' => $ordersQuery->where('created_at', '>=', now()->subDays(7)),
            'bulan_ini' => $ordersQuery->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year),
            'bulan_lalu' => $ordersQuery->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year),
            default => null,
        };

        $orders = $ordersQuery->paginate(15)->withQueryString();

        // ── Statistik utama ────────────────────────────────────────────────
        // Total pendapatan dari pesanan selesai (delivered)
        $totalPendapatan = OrderItem::where('seller_user_id', $sellerUserId)
            ->whereHas('order', fn($q) => $q->where('status', 'delivered'))
            ->sum('subtotal');

        // Pendapatan bulan ini
        $pendapatanBulanIni = OrderItem::where('seller_user_id', $sellerUserId)
            ->whereHas(
                'order',
                fn($q) => $q
                    ->where('status', 'delivered')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
            )
            ->sum('subtotal');

        // Jumlah pesanan selesai bulan ini
        $pesananBulanIni = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId))
            ->where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Dana dapat dicairkan = delivered yang belum ditarik
        // (Simplified: semua delivered — bisa dikembangkan dengan tabel withdrawals)
        $danaDicairkan = OrderItem::where('seller_user_id', $sellerUserId)
            ->whereHas('order', fn($q) => $q->whereIn('status', ['delivered']))
            ->sum('subtotal');

        // Saldo tersedia untuk penarikan
        $saldoTersedia = $danaDicairkan;

        // Jumlah pesanan menunggu cair (processing + shipped)
        $pesananMenungguCair = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId))
            ->whereIn('status', ['processing', 'shipped', 'paid'])
            ->count();

        // Total pesanan selesai (semua waktu)
        $totalPesananSelesai = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId))
            ->where('status', 'delivered')
            ->count();

        // Rata-rata per order
        $rataRataOrder = $totalPesananSelesai > 0
            ? $totalPendapatan / $totalPesananSelesai
            : 0;

        // ── Ringkasan per status untuk periode yang dipilih ──────────────
        $summaryPeriod = $request->get('period', 'bulan_ini');

        $summaryBaseQuery = fn() => OrderItem::where('seller_user_id', $sellerUserId)
            ->whereHas('order', function ($q) use ($summaryPeriod) {
                match ($summaryPeriod) {
                    'bulan_ini' => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                    'bulan_lalu' => $q->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year),
                    'tahun_ini' => $q->whereYear('created_at', now()->year),
                    default => null,
                };
            });

        $summaryDelivered = (clone $summaryBaseQuery())->whereHas('order', fn($q) => $q->where('status', 'delivered'))->sum('subtotal');
        $summaryShipped = (clone $summaryBaseQuery())->whereHas('order', fn($q) => $q->where('status', 'shipped'))->sum('subtotal');
        $summaryProcessing = (clone $summaryBaseQuery())->whereHas('order', fn($q) => $q->whereIn('status', ['processing', 'paid']))->sum('subtotal');
        $summaryCancelled = (clone $summaryBaseQuery())->whereHas('order', fn($q) => $q->whereIn('status', ['cancelled', 'refunded']))->sum('subtotal');

        // ── Chart data: 7 hari terakhir ───────────────────────────────────
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $income = OrderItem::where('seller_user_id', $sellerUserId)
                ->whereHas(
                    'order',
                    fn($q) => $q
                        ->where('status', 'delivered')
                        ->whereDate('created_at', $date)
                )
                ->sum('subtotal');

            $orderCount = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId))
                ->whereDate('created_at', $date)
                ->count();

            $chartData[] = [
                'label' => $date->isoFormat('ddd D/M'),
                'income' => (float) $income,
                'orders' => $orderCount,
            ];
        }

        // ── Jadwal panen mendatang (30 hari ke depan) ─────────────────────
        $jadwalMendatang = HarvestSchedule::forSeller($sellerUserId)
            ->whereNotIn('status', ['selesai', 'gagal'])
            ->where('estimasi_panen', '>=', now())
            ->where('estimasi_panen', '<=', now()->addDays(30))
            ->orderBy('estimasi_panen')
            ->get();

        // ── Riwayat penarikan dana terbaru ─────────────────────────────────
        $riwayatWithdrawal = Withdrawal::forSeller($sellerUserId)
            ->latest()
            ->limit(5)
            ->get();

        return view('seller.keuangan', compact(
            'orders',
            'sellerProfile',
            'totalPendapatan',
            'pendapatanBulanIni',
            'pesananBulanIni',
            'danaDicairkan',
            'saldoTersedia',
            'pesananMenungguCair',
            'totalPesananSelesai',
            'rataRataOrder',
            'summaryDelivered',
            'summaryShipped',
            'summaryProcessing',
            'summaryCancelled',
            'chartData',
            'jadwalMendatang',
            'riwayatWithdrawal',
        ));
    }

    /**
     * Export transaksi ke CSV.
     */
    public function export(Request $request)
    {
        $sellerUserId = Auth::id();
        $period = $request->get('period', '');
        $status = $request->get('status', '');

        $query = Order::with([
            'buyer:id,nama_lengkap,email',
            'items' => fn($q) => $q->where('seller_user_id', $sellerUserId),
        ])
            ->whereHas('items', fn($q) => $q->where('seller_user_id', $sellerUserId));

        if ($status)
            $query->where('status', $status);
        match ($period) {
            'hari_ini' => $query->whereDate('created_at', today()),
            '7_hari' => $query->where('created_at', '>=', now()->subDays(7)),
            'bulan_ini' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'bulan_lalu' => $query->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year),
            default => null,
        };

        $orders = $query->latest()->get();

        $filename = 'transaksi_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders, $sellerUserId) {
            $handle = fopen('php://output', 'w');
            // BOM untuk Excel agar UTF-8 terbaca
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No. Order',
                'Pembeli',
                'Produk',
                'Qty',
                'Subtotal (Rp)',
                'Status',
                'Metode Bayar',
                'Tanggal',
            ]);

            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    fputcsv($handle, [
                        $order->order_number,
                        $order->buyer->nama_lengkap ?? '-',
                        $item->product_name,
                        $item->quantity,
                        number_format($item->subtotal, 0, ',', '.'),
                        $order->status,
                        $order->payment_method ?? '-',
                        $order->created_at?->format('d/m/Y H:i'),
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Proses pengajuan penarikan dana.
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'jumlah' => ['required', 'numeric', 'min:50000'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        // TODO: Simpan ke tabel withdrawals (buat migration terpisah jika diperlukan)
        // Withdrawal::create([
        //     'seller_user_id' => Auth::id(),
        //     'jumlah'         => $request->jumlah,
        //     'biaya_admin'    => 2500,
        //     'diterima'       => $request->jumlah - 2500,
        //     'catatan'        => $request->catatan,
        //     'status'         => 'pending',
        // ]);

        return redirect()->route('seller.keuangan.index')
            ->with('success', 'Pengajuan penarikan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan dan sedang diproses.');
    }

    /**
     * Riwayat penarikan dana.
     */
    public function riwayat()
    {
        // TODO: Query tabel withdrawals
        // $withdrawals = Withdrawal::where('seller_user_id', Auth::id())->latest()->paginate(20);
        return view('seller.keuangan_riwayat');
    }

    /**
     * Cetak invoice order.
     */
    public function invoice(Order $order)
    {
        $this->authorize('view', $order); // pastikan policy sudah dibuat
        return view('seller.invoice', compact('order'));
    }
}