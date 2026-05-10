<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan masuk untuk seller yang login.
     * Pesanan difilter berdasarkan order_items.seller_user_id = auth user.
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        // Base query: ambil order yang punya item milik seller ini
        $query = Order::whereHas('items', function ($q) use ($sellerId) {
            $q->where('seller_user_id', $sellerId);
        })
            ->with([
                'items' => function ($q) use ($sellerId) {
                    // Eager load hanya item milik seller ini
                    $q->where('seller_user_id', $sellerId)
                        ->with('harvest.product.category');
                },
                'buyer',
            ]);

        // Filter status dari tab / query string
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter metode pembayaran
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search nomor pesanan / nama penerima
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->oldest(),
            'total_desc' => $query->orderByDesc('total_amount'),
            default => $query->latest(),
        };

        $orders = $query->paginate(10)->withQueryString();

        // Hitung jumlah per status untuk badge di tab & stat cards
        $counts = Order::whereHas('items', fn($q) => $q->where('seller_user_id', $sellerId))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('seller.pesananmasuk', compact('orders', 'counts'));
    }

    /**
     * Update status pesanan.
     * Seller hanya boleh mengubah status pesanan yang ada item miliknya,
     * dan hanya transisi status yang valid.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $sellerId = Auth::id();

        // Pastikan order ini punya item milik seller ini
        $hasItem = $order->items()->where('seller_user_id', $sellerId)->exists();
        if (!$hasItem) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $newStatus = $request->input('status');

        // Validasi transisi status yang diizinkan untuk seller
        $allowedTransitions = [
            'paid' => ['processing', 'cancelled'],
            'processing' => ['shipped'],
        ];

        $currentStatus = $order->status;

        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])
        ) {
            return back()->with('error', 'Perubahan status tidak valid dari "' . $currentStatus . '" ke "' . $newStatus . '".');
        }

        // Validasi input tambahan per status
        $request->validate($this->validationRules($newStatus));

        DB::beginTransaction();
        try {
            $updateData = ['status' => $newStatus];

            if ($newStatus === 'shipped') {
                $updateData['kurir'] = $request->kurir;
                $updateData['nomor_resi'] = $request->nomor_resi;
            }

            if ($newStatus === 'cancelled') {
                $updateData['cancel_reason'] = $request->cancel_reason;

                // Kembalikan stok produk untuk item milik seller ini
                $order->items()
                    ->where('seller_user_id', $sellerId)
                    ->with('harvest')
                    ->each(function ($item) {
                        if ($item->harvest) {
                            $item->harvest->increment('remaining_stock', $item->quantity);
                        }
                    });
            }

            $order->update($updateData);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        $statusMessages = [
            'processing' => 'Pesanan berhasil diproses.',
            'shipped' => 'Pesanan berhasil dikirim. Nomor resi tersimpan.',
            'cancelled' => 'Pesanan berhasil ditolak.',
        ];

        return back()->with('success', $statusMessages[$newStatus] ?? 'Status pesanan diperbarui.');
    }

    /**
     * Halaman cetak pesanan (print-friendly).
     */
    public function print(Order $order)
    {
        $sellerId = Auth::id();

        $hasItem = $order->items()->where('seller_user_id', $sellerId)->exists();
        if (!$hasItem) {
            abort(403);
        }

        $order->load([
            'items' => fn($q) => $q->where('seller_user_id', $sellerId)->with('harvest.product'),
            'buyer',
        ]);

        return view('seller.pesanan.print', compact('order'));
    }

    // ── Private Helpers ──────────────────────────────────────────────────────

    private function validationRules(string $status): array
    {
        return match ($status) {
            'shipped' => [
                'kurir' => ['required', 'string', 'max:100'],
                'nomor_resi' => ['required', 'string', 'max:100'],
            ],
            'cancelled' => [
                'cancel_reason' => ['required', 'string', 'max:500'],
            ],
            default => [],
        };
    }
}