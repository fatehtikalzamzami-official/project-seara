<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Harvest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ── Daftar semua room chat milik user yang login
    public function index()
    {
        $userId = Auth::id();

        $rooms = ChatRoom::with([
                'buyer', 'seller', 'harvest.product', 'lastMessage'
            ])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->orderByDesc('last_message_at')
            ->get();

        $totalUnread = $rooms->sum(fn($r) => $r->unreadCount($userId));

        // Buka room pertama otomatis kalau ada
        if ($rooms->isNotEmpty()) {
            $activeRoom = $rooms->first();
            return $this->loadRoom($activeRoom, $userId, $rooms, $totalUnread);
        }

        return view('chat.index', compact('rooms', 'totalUnread'));
    }

    // ── Buka / buat room chat dengan seller terkait produk tertentu
    public function openOrCreate(Request $request)
    {
        $request->validate([
            'seller_user_id' => 'required|exists:users,id',
            'harvest_id'     => 'nullable|exists:harvests,id',
        ]);

        $buyerId   = Auth::id();
        $sellerId  = (int) $request->seller_user_id;

        // Jangan chat dengan diri sendiri
        abort_if($buyerId === $sellerId, 403, 'Tidak bisa chat dengan diri sendiri.');

        // Satu room per pasangan buyer–seller, harvest_id diabaikan untuk lookup
        $room = ChatRoom::firstOrCreate(
            [
                'buyer_id'  => $buyerId,
                'seller_id' => $sellerId,
            ],
            ['last_message_at' => now()]
        );

        // Kalau AJAX (dari offer form), return JSON room id
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['room_id' => $room->id]);
        }

        return redirect()->route('chat.show', $room->id);
    }

    // ── Halaman ruang chat (panel kanan)
    public function show(ChatRoom $chatRoom)
    {
        $userId = Auth::id();

        abort_unless(
            $chatRoom->buyer_id === $userId || $chatRoom->seller_id === $userId,
            403
        );

        $rooms = ChatRoom::with(['buyer', 'seller', 'harvest.product', 'lastMessage'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->orderByDesc('last_message_at')
            ->get();

        $totalUnread = $rooms->sum(fn($r) => $r->unreadCount($userId));

        return $this->loadRoom($chatRoom, $userId, $rooms, $totalUnread);
    }

    // ── Helper: render view gabungan dengan room aktif
    private function loadRoom(ChatRoom $chatRoom, int $userId, $rooms, int $totalUnread)
    {
        // Tandai pesan masuk sebagai dibaca
        ChatMessage::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $activeMessages = $chatRoom->messages()->with('sender')->get();
        $activeOther    = $chatRoom->otherUser($userId);
        $activeRoom     = $chatRoom;

        return view('chat.index', compact(
            'rooms', 'totalUnread',
            'activeRoom', 'activeMessages', 'activeOther'
        ));
    }

    // ── Kirim pesan (form POST biasa — no websocket needed)
    public function send(Request $request, ChatRoom $chatRoom)
    {
        $userId = Auth::id();

        abort_unless(
            $chatRoom->buyer_id === $userId || $chatRoom->seller_id === $userId,
            403
        );

        $request->validate(['body' => 'required|string|max:2000']);

        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id'    => $userId,
            'body'         => $request->body,
        ]);

        $chatRoom->update(['last_message_at' => now()]);

        // Kalau request JSON (AJAX polling), kembalikan pesan terbaru
        if ($request->expectsJson()) {
            $messages = $chatRoom->messages()->with('sender')
                ->orderBy('created_at')->get()
                ->map(fn($m) => [
                    'id'        => $m->id,
                    'body'      => $m->body,
                    'sender_id' => $m->sender_id,
                    'is_mine'   => $m->sender_id === $userId,
                    'time'      => $m->created_at->format('H:i'),
                    'sender'    => $m->sender->nama_lengkap ?? $m->sender->name,
                ]);

            return response()->json(['messages' => $messages]);
        }

        return redirect()->route('chat.show', $chatRoom->id);
    }

    // ── Polling AJAX: ambil pesan baru sejak ID tertentu
    public function poll(Request $request, ChatRoom $chatRoom)
    {
        $userId = Auth::id();
        abort_unless(
            $chatRoom->buyer_id === $userId || $chatRoom->seller_id === $userId,
            403
        );

        $since = $request->input('since', 0);

        // Tandai pesan masuk sebagai dibaca
        ChatMessage::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $chatRoom->messages()
            ->with('sender')
            ->where('id', '>', $since)
            ->get()
            ->map(fn($m) => [
                'id'      => $m->id,
                'body'    => $m->body,
                'is_mine' => $m->sender_id === $userId,
                'time'    => $m->created_at->format('H:i'),
                'sender'  => $m->sender->nama_lengkap ?? $m->sender->name,
            ]);

        return response()->json(['messages' => $messages]);
    }


    // ── Online status user (untuk polling di chat)
    public function onlineStatus(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $user = \App\Models\User::find($request->user_id);
        return response()->json([
            'is_online' => $user->isOnline(),
            'label'     => $user->onlineLabel(),
        ]);
    }

    // ── Hitung unread untuk badge di topbar (AJAX)
    public function unreadCount()
    {
        $userId = Auth::id();
        $count  = ChatMessage::whereHas('room', fn($q) =>
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId)
            )
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }
}