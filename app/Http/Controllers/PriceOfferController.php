<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Harvest;
use App\Models\PriceOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceOfferController extends Controller
{
    // ── Buyer: kirim tawaran baru
    public function store(Request $request)
    {
        $request->validate([
            'harvest_id'   => 'required|exists:harvests,id',
            'offer_price'  => 'required|numeric|min:1',
            'quantity'     => 'required|integer|min:1',
            'buyer_note'   => 'nullable|string|max:500',
            'chat_room_id' => 'nullable|exists:chat_rooms,id',
        ]);

        $harvest = Harvest::with(['seller.user', 'product'])->findOrFail($request->harvest_id);
        $buyer   = Auth::user();

        // Seller user id dari relasi SellerProfile → User
        $sellerUserId = $harvest->seller->user_id;

        abort_if($buyer->id === $sellerUserId, 403, 'Tidak bisa menawar produk sendiri.');

        // Batalkan tawaran pending sebelumnya untuk harvest yang sama
        PriceOffer::where('harvest_id', $harvest->id)
            ->where('buyer_id', $buyer->id)
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        $offer = PriceOffer::create([
            'harvest_id'     => $harvest->id,
            'buyer_id'       => $buyer->id,
            'seller_user_id' => $sellerUserId,
            'chat_room_id'   => $request->chat_room_id,
            'original_price' => $harvest->price_per_unit,
            'offer_price'    => $request->offer_price,
            'quantity'       => $request->quantity,
            'buyer_note'     => $request->buyer_note,
            'expires_at'     => now()->addHours(24),
        ]);

        // Kirim notifikasi otomatis ke chat room jika ada
        if ($request->chat_room_id) {
            $this->postOfferMessage($offer, $request->chat_room_id);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'offer'   => $this->offerPayload($offer),
                'message' => 'Tawaran berhasil dikirim!',
            ]);
        }

        return back()->with('success', 'Tawaran berhasil dikirim!');
    }

    // ── Seller: terima tawaran
    public function accept(PriceOffer $priceOffer)
    {
        $this->authorizeSeller($priceOffer);
        abort_unless($priceOffer->isPending() || $priceOffer->isCountered(), 422, 'Tawaran tidak bisa diubah.');

        $priceOffer->update(['status' => 'accepted']);

        if ($priceOffer->chat_room_id) {
            $finalPrice = $priceOffer->counter_price ?? $priceOffer->offer_price;
            $this->postSystemMessage(
                $priceOffer->chat_room_id,
                Auth::id(),
                "✅ Tawaran diterima! Harga final: Rp " . number_format($finalPrice, 0, ',', '.') . " × {$priceOffer->quantity} unit."
            );
        }

        return response()->json(['success' => true, 'offer' => $this->offerPayload($priceOffer->fresh())]);
    }

    // ── Seller: tolak tawaran
    public function reject(Request $request, PriceOffer $priceOffer)
    {
        $this->authorizeSeller($priceOffer);
        abort_unless($priceOffer->isPending() || $priceOffer->isCountered(), 422);

        $priceOffer->update([
            'status'      => 'rejected',
            'seller_note' => $request->seller_note,
        ]);

        if ($priceOffer->chat_room_id) {
            $this->postSystemMessage(
                $priceOffer->chat_room_id,
                Auth::id(),
                "❌ Tawaran ditolak." . ($request->seller_note ? " Alasan: {$request->seller_note}" : '')
            );
        }

        return response()->json(['success' => true, 'offer' => $this->offerPayload($priceOffer->fresh())]);
    }

    // ── Seller: tawar balik (counter offer)
    public function counter(Request $request, PriceOffer $priceOffer)
    {
        $this->authorizeSeller($priceOffer);
        abort_unless($priceOffer->isPending(), 422);

        $request->validate([
            'counter_price' => 'required|numeric|min:1',
            'seller_note'   => 'nullable|string|max:500',
        ]);

        $priceOffer->update([
            'status'        => 'countered',
            'counter_price' => $request->counter_price,
            'seller_note'   => $request->seller_note,
        ]);

        if ($priceOffer->chat_room_id) {
            $this->postSystemMessage(
                $priceOffer->chat_room_id,
                Auth::id(),
                "🔄 Penjual menawar balik: Rp " . number_format($request->counter_price, 0, ',', '.') .
                ($request->seller_note ? " — \"{$request->seller_note}\"" : '')
            );
        }

        return response()->json(['success' => true, 'offer' => $this->offerPayload($priceOffer->fresh())]);
    }

    // ── Buyer: batalkan tawaran
    public function cancel(PriceOffer $priceOffer)
    {
        abort_unless($priceOffer->buyer_id === Auth::id(), 403);
        abort_unless($priceOffer->isPending() || $priceOffer->isCountered(), 422);

        $priceOffer->update(['status' => 'cancelled']);

        return response()->json(['success' => true, 'offer' => $this->offerPayload($priceOffer->fresh())]);
    }

    // ── Cek status tawaran aktif (polling AJAX)
    public function status(Request $request)
    {
        $request->validate(['harvest_id' => 'required|exists:harvests,id']);

        $offer = PriceOffer::where('harvest_id', $request->harvest_id)
            ->where('buyer_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted', 'countered'])
            ->latest()
            ->first();

        return response()->json(['offer' => $offer ? $this->offerPayload($offer) : null]);
    }

    // ── Online status user (AJAX)
    public function onlineStatus(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $user = \App\Models\User::find($request->user_id);

        return response()->json([
            'is_online' => $user->isOnline(),
            'label'     => $user->onlineLabel(),
        ]);
    }

    // ── Helpers ──────────────────────────────────

    private function authorizeSeller(PriceOffer $offer): void
    {
        abort_unless($offer->seller_user_id === Auth::id(), 403);
    }

    private function offerPayload(PriceOffer $offer): array
    {
        return [
            'id'             => $offer->id,
            'status'         => $offer->status,
            'status_label'   => $offer->statusLabel(),
            'original_price' => (float) $offer->original_price,
            'offer_price'    => (float) $offer->offer_price,
            'counter_price'  => $offer->counter_price ? (float) $offer->counter_price : null,
            'quantity'       => $offer->quantity,
            'discount_pct'   => $offer->discountPct(),
            'buyer_note'     => $offer->buyer_note,
            'seller_note'    => $offer->seller_note,
            'expires_at'     => $offer->expires_at?->toISOString(),
        ];
    }

    private function postOfferMessage(PriceOffer $offer, int $roomId): void
    {
        $harvest   = $offer->harvest;
        $formatted = number_format($offer->offer_price, 0, ',', '.');
        $orig      = number_format($offer->original_price, 0, ',', '.');
        $disc      = $offer->discountPct();

        $body = "💰 *Penawaran Harga*\n" .
                "Produk: {$harvest->product->name}\n" .
                "Harga asli: Rp {$orig}/{$harvest->product->unit}\n" .
                "Harga tawar: Rp {$formatted}/{$harvest->product->unit} (-{$disc}%)\n" .
                "Jumlah: {$offer->quantity} {$harvest->product->unit}" .
                ($offer->buyer_note ? "\nCatatan: {$offer->buyer_note}" : '') .
                "\n[offer:{$offer->id}]";

        $this->postSystemMessage($roomId, $offer->buyer_id, $body);
    }

    private function postSystemMessage(int $roomId, int $senderId, string $body): void
    {
        ChatMessage::create([
            'chat_room_id' => $roomId,
            'sender_id'    => $senderId,
            'body'         => $body,
        ]);
        ChatRoom::where('id', $roomId)->update(['last_message_at' => now()]);
    }
}
