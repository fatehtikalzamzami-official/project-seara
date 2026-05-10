<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerChatController extends Controller
{
    // ── Daftar semua room chat milik seller yang login
    public function index()
    {
        $userId = Auth::id();

        $rooms = ChatRoom::with([
            'buyer',
            'seller',
            'harvest.product',
            'lastMessage'
        ])
            ->where('seller_id', $userId)
            ->orderByDesc('last_message_at')
            ->get();

        $totalUnread = $rooms->sum(fn($r) => $r->unreadCount($userId));

        if ($rooms->isNotEmpty()) {
            $activeRoom = $rooms->first();
            return $this->loadRoom($activeRoom, $userId, $rooms, $totalUnread);
        }

        return view('seller.chat', compact('rooms', 'totalUnread'));
    }

    // ── Buka room chat tertentu
    public function show(ChatRoom $chatRoom)
    {
        $userId = Auth::id();

        // Pastikan seller ini memang bagian dari room
        abort_unless($chatRoom->seller_id === $userId, 403);

        $rooms = ChatRoom::with(['buyer', 'seller', 'harvest.product', 'lastMessage'])
            ->where('seller_id', $userId)
            ->orderByDesc('last_message_at')
            ->get();

        $totalUnread = $rooms->sum(fn($r) => $r->unreadCount($userId));

        return $this->loadRoom($chatRoom, $userId, $rooms, $totalUnread);
    }

    // ── Helper: render view seller dengan room aktif
    private function loadRoom(ChatRoom $chatRoom, int $userId, $rooms, int $totalUnread)
    {
        // Tandai pesan masuk sebagai dibaca (seller_id = always the seller in this room)
        $sellerId = $chatRoom->seller_id;
        ChatMessage::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', $sellerId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $activeMessages = $chatRoom->messages()->with('sender')->get();
        $activeOther = $chatRoom->otherUser($userId);
        $activeRoom = $chatRoom;

        return view('seller.chat', compact(
            'rooms',
            'totalUnread',
            'activeRoom',
            'activeMessages',
            'activeOther'
        ));
    }

    // ── Kirim pesan (AJAX)
    public function send(Request $request, ChatRoom $chatRoom)
    {
        // Seller controller: sender is always the seller of the room, regardless of session
        $senderId = $chatRoom->seller_id;

        $request->validate(['body' => 'required|string|max:2000']);

        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id'    => $senderId,
            'body'         => $request->body,
        ]);

        $chatRoom->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            $messages = $chatRoom->messages()->with('sender')
                ->orderBy('created_at')->get()
                ->map(fn($m) => [
                    'id'        => $m->id,
                    'body'      => $m->body,
                    'sender_id' => $m->sender_id,
                    'is_mine'   => $m->sender_id === $senderId,
                    'time'      => $m->created_at->format('H:i'),
                    'sender'    => $m->sender->nama_lengkap ?? $m->sender->name,
                ]);

            return response()->json(['messages' => $messages]);
        }

        return redirect()->route('seller.chat.show', $chatRoom->id);
    }

    // ── Polling AJAX: ambil pesan baru sejak ID tertentu
    public function poll(Request $request, ChatRoom $chatRoom)
    {
        $userId = Auth::id();

        abort_unless($chatRoom->seller_id === $userId, 403);

        $since = $request->input('since', 0);

        ChatMessage::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $chatRoom->messages()
            ->with('sender')
            ->where('id', '>', $since)
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'body' => $m->body,
                'is_mine' => $m->sender_id === $userId,
                'time' => $m->created_at->format('H:i'),
                'sender' => $m->sender->nama_lengkap ?? $m->sender->name,
            ]);

        return response()->json(['messages' => $messages]);
    }
}