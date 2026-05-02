@extends('layouts.app')

@section('title', 'Pesan — SEARA')

@push('styles')
<style>
/* ══════════════════════════════════
   LAYOUT UTAMA — 2 panel sebelahan
   ══════════════════════════════════ */
.chat-shell {
    max-width: 1200px; margin: 0 auto;
    padding: 20px 20px 20px;
    height: calc(100vh - 110px);
    display: flex; flex-direction: column;
}
.chat-header-bar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px;
}
.chat-header-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700; color: var(--text-dark);
    display: flex; align-items: center; gap: 10px;
}
.chat-unread-pill {
    font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800;
    background: var(--accent); color: white;
    padding: 2px 10px; border-radius: 20px;
}
.chat-back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 700; color: var(--text-muted);
    padding: 7px 14px; border-radius: 10px;
    border: 1.5px solid var(--border); background: white;
    transition: all .2s; text-decoration: none;
}
.chat-back-btn:hover { border-color: var(--green-main); color: var(--green-main); background: var(--green-pale); }

.chat-body {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 0;
    flex: 1;
    min-height: 0;
    border-radius: 18px;
    overflow: hidden;
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow-md);
}

/* ══════════════════════════════════
   PANEL KIRI — Daftar Room
   ══════════════════════════════════ */
.rooms-panel {
    background: white;
    border-right: 1.5px solid var(--border);
    display: flex; flex-direction: column;
    min-height: 0;
}
.rooms-panel-head {
    padding: 16px 16px 12px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.rooms-panel-head h2 { font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 10px; }
.rooms-search-wrap { position: relative; }
.rooms-search {
    width: 100%; padding: 8px 14px 8px 36px;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-size: 13px;
    outline: none; background: var(--green-bg); transition: border-color .2s;
}
.rooms-search:focus { border-color: var(--green-main); background: white; }
.rooms-search-ico { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); font-size: 14px; pointer-events: none; }
.rooms-list { flex: 1; overflow-y: auto; }
.rooms-list::-webkit-scrollbar { width: 3px; }
.rooms-list::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

.room-item {
    display: flex; align-items: center; gap: 11px;
    padding: 12px 16px; cursor: pointer;
    border-bottom: 1px solid var(--border);
    transition: background .15s; text-decoration: none; color: inherit;
    position: relative;
}
.room-item:hover { background: var(--green-bg); }
.room-item.active { background: var(--green-pale); border-right: 3px solid var(--green-main); }
.room-item.has-unread .room-last-msg { font-weight: 800; color: var(--text-dark); }
.room-ava {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--green-light), var(--green-dark));
    color: white; font-size: 16px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}
.room-info { flex: 1; min-width: 0; }
.room-name { font-size: 13px; font-weight: 800; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.room-product-tag { font-size: 11px; color: var(--green-main); font-weight: 700; margin: 1px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.room-last-msg { font-size: 12px; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.room-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.room-time { font-size: 10px; color: var(--text-muted); }
.room-badge {
    background: var(--green-main); color: white;
    font-size: 10px; font-weight: 800;
    min-width: 18px; height: 18px; border-radius: 20px;
    display: flex; align-items: center; justify-content: center; padding: 0 4px;
}

.rooms-empty { padding: 40px 20px; text-align: center; color: var(--text-muted); }
.rooms-empty .ico { font-size: 40px; margin-bottom: 10px; }
.rooms-empty p { font-size: 13px; }

/* ══════════════════════════════════
   PANEL KANAN — Ruang Chat
   ══════════════════════════════════ */
.msg-panel {
    display: flex; flex-direction: column;
    background: var(--green-bg); min-height: 0;
}

/* Placeholder saat belum pilih room */
.msg-placeholder {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 12px;
    color: var(--text-muted);
}
.msg-placeholder .big-icon { font-size: 64px; }
.msg-placeholder h3 { font-size: 18px; font-weight: 800; color: var(--text-mid); }
.msg-placeholder p { font-size: 13px; }

/* Header room aktif */
.msg-head {
    background: white; border-bottom: 1.5px solid var(--border);
    padding: 12px 18px; display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
}
.msg-head-ava {
    width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--green-main), var(--green-dark));
    color: white; font-size: 16px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}
.msg-head-info { flex: 1; }
.msg-head-name { font-size: 15px; font-weight: 800; color: var(--text-dark); }
.msg-head-status { font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-top: 2px; }
.msg-head-status .dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.msg-head-product { font-size: 11px; font-weight: 700; background: var(--green-pale); color: var(--green-dark); padding: 4px 10px; border-radius: 8px; }

/* Area pesan */
.msg-area {
    flex: 1; overflow-y: auto; padding: 16px;
    display: flex; flex-direction: column; gap: 10px;
    scroll-behavior: smooth;
}
.msg-area::-webkit-scrollbar { width: 4px; }
.msg-area::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

.date-sep { text-align: center; margin: 4px 0; }
.date-sep span { font-size: 11px; color: var(--text-muted); background: rgba(255,255,255,.8); padding: 3px 12px; border-radius: 20px; font-weight: 600; border: 1px solid var(--border); }

.msg-row { display: flex; align-items: flex-end; gap: 7px; }
.msg-row.mine { flex-direction: row-reverse; }
.msg-ava { width: 26px; height: 26px; border-radius: 50%; background: var(--green-pale); color: var(--green-dark); font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.msg-ava.mine { background: var(--green-main); color: white; }
.msg-grp { display: flex; flex-direction: column; gap: 2px; max-width: 65%; }
.msg-row.mine .msg-grp { align-items: flex-end; }
.bubble { padding: 9px 13px; border-radius: 14px; font-size: 13px; line-height: 1.6; word-break: break-word; }
.bubble.other { background: white; color: var(--text-dark); border: 1px solid var(--border); border-bottom-left-radius: 3px; }
.bubble.mine  { background: var(--green-main); color: white; border-bottom-right-radius: 3px; }
.btime { font-size: 10px; color: var(--text-muted); padding: 0 2px; }
.msg-row.mine .btime { text-align: right; }
.bread { font-size: 10px; color: var(--green-main); }

/* Konteks produk */
.ctx-card { background: white; border: 1.5px solid var(--border); border-radius: 12px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 4px; flex-shrink: 0; }
.ctx-emoji { font-size: 26px; }
.ctx-name { font-size: 13px; font-weight: 800; color: var(--text-dark); }
.ctx-price { font-size: 12px; color: var(--green-main); font-weight: 700; }

/* Typing */
.typing-row { display: flex; align-items: center; gap: 7px; }
.typing-bub { background: white; border: 1.5px solid var(--border); border-radius: 14px; border-bottom-left-radius: 3px; padding: 9px 14px; display: flex; gap: 4px; }
.typing-bub span { width: 6px; height: 6px; background: #bbb; border-radius: 50%; animation: tb .9s infinite; }
.typing-bub span:nth-child(2) { animation-delay: .15s; }
.typing-bub span:nth-child(3) { animation-delay: .3s; }
@keyframes tb { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }

/* Quick replies */
.quick-row { padding: 8px 14px; background: white; border-top: 1px solid var(--border); display: flex; gap: 6px; flex-wrap: wrap; flex-shrink: 0; }
.qr-btn { font-size: 11px; font-weight: 700; color: var(--green-dark); background: var(--green-pale); border: 1px solid var(--border); padding: 4px 10px; border-radius: 20px; cursor: pointer; font-family: 'Nunito', sans-serif; transition: all .15s; white-space: nowrap; }
.qr-btn:hover { background: #c8e6c9; border-color: var(--green-main); }

/* Input */
.msg-input-wrap { background: white; border-top: 1.5px solid var(--border); padding: 10px 14px; display: flex; align-items: flex-end; gap: 10px; flex-shrink: 0; }
.msg-input { flex: 1; border: 1.5px solid var(--border); border-radius: 12px; padding: 9px 14px; font-family: 'Nunito', sans-serif; font-size: 13px; outline: none; resize: none; max-height: 100px; overflow-y: auto; transition: border-color .2s; line-height: 1.5; }
.msg-input:focus { border-color: var(--green-main); }
.msg-send { width: 40px; height: 40px; border-radius: 11px; background: var(--green-main); border: none; color: white; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .2s; flex-shrink: 0; }
.msg-send:hover { background: var(--green-dark); transform: scale(1.05); }
.msg-send:active { transform: scale(.95); }
.msg-send:disabled { background: #ccc; cursor: not-allowed; transform: none; }

@keyframes msgIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
.msg-row { animation: msgIn .2s ease both; }

/* ── Online status ── */
.online-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.online-dot.online  { background: #22c55e; box-shadow: 0 0 0 2px rgba(34,197,94,.25); }
.online-dot.offline { background: #9ca3af; }
.status-text { font-size: 11px; }
.status-text.online  { color: #16a34a; font-weight: 700; }
.status-text.offline { color: var(--text-muted); }

/* ── Offer Card dalam chat ── */
.offer-card {
    background: white; border: 2px solid var(--green-main);
    border-radius: 14px; padding: 14px 16px;
    max-width: 320px; width: 100%;
}
.offer-card.mine-card { align-self: flex-end; border-color: var(--green-light); }
.offer-card-head { font-size: 12px; font-weight: 800; color: var(--green-dark); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
.offer-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 6px; }
.offer-price-new { font-size: 22px; font-weight: 900; color: var(--accent); }
.offer-price-old { font-size: 13px; color: var(--text-muted); text-decoration: line-through; }
.offer-disc { font-size: 11px; font-weight: 800; background: #fff3ee; color: var(--accent); padding: 2px 7px; border-radius: 5px; }
.offer-qty { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; }
.offer-note { font-size: 12px; color: var(--text-mid); font-style: italic; margin-bottom: 10px; padding: 6px 10px; background: var(--green-pale); border-radius: 8px; }
.offer-status { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 6px; margin-bottom: 10px; }
.offer-status.pending   { background: #fef9c3; color: #854d0e; }
.offer-status.accepted  { background: #dcfce7; color: #166534; }
.offer-status.rejected  { background: #fee2e2; color: #991b1b; }
.offer-status.countered { background: #e0f2fe; color: #075985; }
.offer-status.cancelled { background: #f3f4f6; color: #6b7280; }
.offer-actions { display: flex; gap: 7px; flex-wrap: wrap; }
.offer-btn { padding: 7px 14px; border-radius: 8px; font-family: 'Nunito',sans-serif; font-size: 12px; font-weight: 800; border: none; cursor: pointer; transition: all .2s; }
.offer-btn.accept  { background: var(--green-main); color: white; }
.offer-btn.accept:hover { background: var(--green-dark); }
.offer-btn.reject  { background: #fee2e2; color: #dc2626; }
.offer-btn.reject:hover { background: #fecaca; }
.offer-btn.counter { background: #e0f2fe; color: #0369a1; }
.offer-btn.counter:hover { background: #bae6fd; }

/* ── Modal Tawar Harga ── */
.offer-modal-bg {
    display: none; position: fixed; inset: 0; z-index: 9500;
    background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
    align-items: center; justify-content: center; padding: 20px;
}
.offer-modal-bg.open { display: flex; }
.offer-modal {
    background: white; border-radius: 20px; width: 100%; max-width: 440px;
    box-shadow: 0 24px 60px rgba(0,0,0,.2);
    animation: modalIn .28s cubic-bezier(.22,1,.36,1);
}
@keyframes modalIn { from{opacity:0;transform:scale(.95) translateY(12px)} to{opacity:1;transform:scale(1) translateY(0)} }
.offer-modal-head { padding: 20px 22px 0; display: flex; align-items: center; justify-content: space-between; }
.offer-modal-head h3 { font-size: 18px; font-weight: 800; color: var(--text-dark); }
.offer-modal-close { width: 32px; height: 32px; border-radius: 50%; border: none; background: var(--green-pale); color: var(--text-mid); font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.offer-modal-body { padding: 16px 22px 22px; }
.offer-product-info { background: var(--green-pale); border-radius: 12px; padding: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
.offer-product-emoji { font-size: 28px; }
.offer-product-name { font-size: 14px; font-weight: 800; color: var(--text-dark); }
.offer-product-orig { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.offer-form-group { margin-bottom: 14px; }
.offer-form-label { font-size: 12px; font-weight: 800; color: var(--text-mid); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 6px; display: block; }
.offer-form-input {
    width: 100%; padding: 10px 14px; border: 1.5px solid var(--border);
    border-radius: 10px; font-family: 'Nunito',sans-serif; font-size: 15px;
    font-weight: 800; outline: none; transition: border-color .2s; color: var(--text-dark);
}
.offer-form-input:focus { border-color: var(--green-main); }
.offer-savings { background: #fff3ee; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
.offer-savings-label { font-size: 12px; color: var(--text-muted); }
.offer-savings-val { font-size: 15px; font-weight: 900; color: var(--accent); }
.offer-submit-btn { width: 100%; padding: 13px; background: var(--green-main); color: white; border: none; border-radius: 12px; font-family: 'Nunito',sans-serif; font-size: 15px; font-weight: 800; cursor: pointer; transition: background .2s; }
.offer-submit-btn:hover { background: var(--green-dark); }
.offer-submit-btn:disabled { background: #ccc; cursor: not-allowed; }

/* ── Counter Modal ── */
.counter-modal-bg {
    display: none; position: fixed; inset: 0; z-index: 9600;
    background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
    align-items: center; justify-content: center; padding: 20px;
}
.counter-modal-bg.open { display: flex; }
</style>
@endpush

@section('content')
<div class="chat-shell">

    {{-- Top bar --}}
    <div class="chat-header-bar">
        <div class="chat-header-title">
            💬 Pesan Saya
            @if($totalUnread > 0)
                <span class="chat-unread-pill">{{ $totalUnread }} baru</span>
            @endif
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="chat-back-btn">← Dashboard</a>
    </div>

    <div class="chat-body">

        {{-- ── PANEL KIRI: List room ── --}}
        <div class="rooms-panel">
            <div class="rooms-panel-head">
                <h2>Percakapan</h2>
                <div class="rooms-search-wrap">
                    <span class="rooms-search-ico">🔍</span>
                    <input class="rooms-search" type="text" placeholder="Cari nama..." oninput="filterRooms(this.value)">
                </div>
            </div>

            <div class="rooms-list" id="roomsList">
                @forelse($rooms as $room)
                    @php
                        $uid     = Auth::id();
                        $other   = $room->otherUser($uid);
                        $unread  = $room->unreadCount($uid);
                        $lastMsg = $room->lastMessage;
                        $initials = strtoupper(substr($other->nama_lengkap ?? $other->name ?? 'U', 0, 2));
                    @endphp
                    <a href="{{ route('chat.show', $room->id) }}"
                       class="room-item {{ isset($activeRoom) && $activeRoom->id === $room->id ? 'active' : '' }} {{ $unread > 0 ? 'has-unread' : '' }}"
                       data-room="{{ $room->id }}"
                       data-name="{{ strtolower($other->nama_lengkap ?? $other->name ?? '') }}"
                       onclick="loadRoom(event, {{ $room->id }})">
                        <div class="room-ava">{{ $initials }}</div>
                        <div class="room-info">
                            <div class="room-name">{{ $other->nama_lengkap ?? $other->name ?? 'Pengguna' }}</div>
                            @if($room->harvest)
                                <div class="room-product-tag">🌾 {{ $room->harvest->product->name ?? '' }}</div>
                            @endif
                            <div class="room-last-msg">
                                @if($lastMsg)
                                    {{ $lastMsg->sender_id === $uid ? 'Kamu: ' : '' }}{{ Str::limit($lastMsg->body, 40) }}
                                @else
                                    Mulai percakapan...
                                @endif
                            </div>
                        </div>
                        <div class="room-meta">
                            <span class="room-time">{{ $room->last_message_at?->diffForHumans(null, true) ?? '' }}</span>
                            @if($unread > 0)
                                <span class="room-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="rooms-empty">
                        <div class="ico">💬</div>
                        <p>Belum ada percakapan.<br>Mulai dari halaman detail produk.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ── PANEL KANAN: Ruang chat ── --}}
        <div class="msg-panel" id="msgPanel">

            @if(isset($activeRoom))
                {{-- Header --}}
                <div class="msg-head">
                    <div class="msg-head-ava" id="headAva">
                        {{ strtoupper(substr($activeOther->nama_lengkap ?? $activeOther->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="msg-head-info">
                        <div class="msg-head-name" id="headName">{{ $activeOther->nama_lengkap ?? $activeOther->name ?? 'Pengguna' }}</div>
                        <div class="msg-head-status" id="onlineStatusRow">
                            <span class="online-dot {{ $activeOther->isOnline() ? 'online' : 'offline' }}" id="onlineDot"></span>
                            <span class="status-text {{ $activeOther->isOnline() ? 'online' : 'offline' }}" id="onlineText">
                                {{ $activeOther->onlineLabel() }}
                            </span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        @if($activeRoom->harvest)
                            <div class="msg-head-product">🌾 {{ $activeRoom->harvest->product->name ?? '' }}</div>
                            @if(Auth::id() !== ($activeRoom->harvest->seller->user_id ?? -1))
                            <button onclick="openOfferModal()" style="padding:6px 12px;background:var(--accent);color:white;border:none;border-radius:8px;font-family:'Nunito',sans-serif;font-size:12px;font-weight:800;cursor:pointer;white-space:nowrap;transition:background .2s;" onmouseover="this.style.background='#e55a2b'" onmouseout="this.style.background='var(--accent)'">
                                💰 Tawar Harga
                            </button>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Pesan --}}
                <div class="msg-area" id="msgArea">
                    @if($activeRoom->harvest)
                    <div class="ctx-card">
                        <div class="ctx-emoji">🌾</div>
                        <div>
                            <div class="ctx-name">{{ $activeRoom->harvest->product->name ?? '' }}</div>
                            <div class="ctx-price">Rp {{ number_format($activeRoom->harvest->price_per_unit, 0, ',', '.') }} / {{ $activeRoom->harvest->product->unit ?? 'kg' }}</div>
                        </div>
                    </div>
                    @endif

                    @php $lastDate = null; $myId = Auth::id(); @endphp
                    @foreach($activeMessages as $msg)
                        @php
                            $msgDate = $msg->created_at->format('Y-m-d');
                            $isMine  = $msg->sender_id === $myId;
                            $ini     = strtoupper(substr($msg->sender->nama_lengkap ?? $msg->sender->name ?? 'U', 0, 2));
                        @endphp
                        @if($msgDate !== $lastDate)
                            <div class="date-sep">
                                <span>{{ $msg->created_at->isToday() ? 'Hari ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->format('d M Y')) }}</span>
                            </div>
                            @php $lastDate = $msgDate; @endphp
                        @endif
                        @php
                            $isOfferMsg = preg_match('/\[offer:(\d+)\]/', $msg->body, $offerMatch);
                            $offerObj   = $isOfferMsg ? \App\Models\PriceOffer::find($offerMatch[1]) : null;
                            $cleanBody  = $isOfferMsg ? preg_replace('/\[offer:\d+\]/', '', $msg->body) : $msg->body;
                        @endphp
                        <div class="msg-row {{ $isMine ? 'mine' : '' }}" data-id="{{ $msg->id }}">
                            <div class="msg-ava {{ $isMine ? 'mine' : '' }}">{{ $ini }}</div>
                            <div class="msg-grp" style="max-width:70%;">
                                @if($offerObj)
                                    {{-- Render offer card --}}
                                    <div class="offer-card {{ $isMine ? 'mine-card' : '' }}" data-offer-id="{{ $offerObj->id }}">
                                        <div class="offer-card-head">💰 Penawaran Harga</div>
                                        <div class="offer-price-row">
                                            <span class="offer-price-new">Rp {{ number_format($offerObj->counter_price ?? $offerObj->offer_price, 0, ',', '.') }}</span>
                                            <span class="offer-price-old">Rp {{ number_format($offerObj->original_price, 0, ',', '.') }}</span>
                                            <span class="offer-disc">-{{ $offerObj->discountPct() }}%</span>
                                        </div>
                                        <div class="offer-qty">Jumlah: {{ $offerObj->quantity }} {{ $activeRoom->harvest->product->unit ?? 'unit' }}</div>
                                        @if($offerObj->buyer_note)<div class="offer-note">"{{ $offerObj->buyer_note }}"</div>@endif
                                        @if($offerObj->seller_note && $offerObj->status !== 'pending')<div class="offer-note" style="background:#e0f2fe;">Penjual: "{{ $offerObj->seller_note }}"</div>@endif
                                        @if($offerObj->counter_price && $offerObj->status === 'countered')
                                            <div style="font-size:12px;color:#0369a1;font-weight:700;margin-bottom:8px;">🔄 Tawar balik: Rp {{ number_format($offerObj->counter_price, 0, ',', '.') }}</div>
                                        @endif
                                        <div class="offer-status {{ $offerObj->status }}">{{ $offerObj->statusLabel() }}</div>
                                        @if($offerObj->isPending() && !$isMine && Auth::id() === ($activeRoom->harvest->seller->user_id ?? -1))
                                            <div class="offer-actions">
                                                <button class="offer-btn accept" onclick="acceptOffer({{ $offerObj->id }})">✅ Terima</button>
                                                <button class="offer-btn counter" onclick="openCounterModal({{ $offerObj->id }}, {{ $offerObj->offer_price }})">🔄 Tawar Balik</button>
                                                <button class="offer-btn reject" onclick="rejectOffer({{ $offerObj->id }})">❌ Tolak</button>
                                            </div>
                                        @elseif($offerObj->isCountered() && $isMine)
                                            <div class="offer-actions">
                                                <button class="offer-btn accept" onclick="acceptOffer({{ $offerObj->id }})">✅ Terima Tawar Balik</button>
                                                <button class="offer-btn reject" onclick="cancelOffer({{ $offerObj->id }})">🚫 Batalkan</button>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bubble {{ $isMine ? 'mine' : 'other' }}" style="white-space:pre-line;">{{ $cleanBody }}</div>
                                @endif
                                <div class="btime">{{ $msg->created_at->format('H:i') }}@if($isMine && $msg->read_at) <span class="bread">✓✓</span>@endif</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Quick replies --}}
                <div class="quick-row" id="quickRow">
                    <button class="qr-btn" onclick="useQuick(this)">Stok masih ada?</button>
                    <button class="qr-btn" onclick="useQuick(this)">Min. order berapa?</button>
                    <button class="qr-btn" onclick="useQuick(this)">Bisa kirim luar kota?</button>
                    <button class="qr-btn" onclick="useQuick(this)">Kapan panen lagi?</button>
                </div>

                {{-- Input --}}
                <div class="msg-input-wrap">
                    <textarea class="msg-input" id="msgInput" rows="1"
                        placeholder="Tulis pesan..."
                        onkeydown="handleKey(event)"
                        oninput="autoResize(this)"></textarea>
                    <button class="msg-send" id="sendBtn" onclick="sendMessage()">➤</button>
                </div>

            @else
                {{-- Placeholder --}}
                <div class="msg-placeholder">
                    <div class="big-icon">💬</div>
                    <h3>Pilih percakapan</h3>
                    <p>Klik nama di sebelah kiri untuk membuka chat</p>
                </div>
            @endif
        </div>

    </div>
</div>

@if(isset($activeRoom) && $activeRoom->harvest)
{{-- ── MODAL TAWAR HARGA ── --}}
<div class="offer-modal-bg" id="offerModalBg" onclick="closeOfferModal(event)">
    <div class="offer-modal">
        <div class="offer-modal-head">
            <h3>💰 Tawar Harga</h3>
            <button class="offer-modal-close" onclick="closeOfferModal()">✕</button>
        </div>
        <div class="offer-modal-body">
            <div class="offer-product-info">
                <div class="offer-product-emoji">🌾</div>
                <div>
                    <div class="offer-product-name">{{ $activeRoom->harvest->product->name ?? 'Produk' }}</div>
                    <div class="offer-product-orig">Harga asli: <strong>Rp {{ number_format($activeRoom->harvest->price_per_unit, 0, ',', '.') }}</strong> / {{ $activeRoom->harvest->product->unit ?? 'kg' }}</div>
                </div>
            </div>

            <div class="offer-form-group">
                <label class="offer-form-label">Harga Tawarmu (per {{ $activeRoom->harvest->product->unit ?? 'kg' }})</label>
                <input type="number" class="offer-form-input" id="offerPriceInput"
                    placeholder="Contoh: {{ round($activeRoom->harvest->price_per_unit * 0.85) }}"
                    min="1" max="{{ $activeRoom->harvest->price_per_unit }}"
                    oninput="updateSavings(this.value)"
                    value="{{ round($activeRoom->harvest->price_per_unit * 0.9) }}">
            </div>

            <div class="offer-form-group">
                <label class="offer-form-label">Jumlah ({{ $activeRoom->harvest->product->unit ?? 'kg' }})</label>
                <input type="number" class="offer-form-input" id="offerQtyInput" min="1"
                    max="{{ $activeRoom->harvest->remaining_stock }}" value="1"
                    oninput="updateSavings(document.getElementById('offerPriceInput').value)">
            </div>

            <div class="offer-form-group">
                <label class="offer-form-label">Catatan (opsional)</label>
                <input type="text" class="offer-form-input" id="offerNoteInput"
                    placeholder="Misal: saya beli rutin tiap minggu..." style="font-weight:500;font-size:13px;">
            </div>

            <div class="offer-savings" id="offerSavingsBox">
                <span class="offer-savings-label">Hemat per unit</span>
                <span class="offer-savings-val" id="offerSavingsVal">Rp 0</span>
            </div>

            <button class="offer-submit-btn" id="offerSubmitBtn" onclick="submitOffer()">
                Kirim Penawaran
            </button>
        </div>
    </div>
</div>

{{-- ── MODAL COUNTER OFFER ── --}}
<div class="counter-modal-bg" id="counterModalBg" onclick="closeCounterModal(event)">
    <div class="offer-modal">
        <div class="offer-modal-head">
            <h3>🔄 Tawar Balik</h3>
            <button class="offer-modal-close" onclick="closeCounterModal()">✕</button>
        </div>
        <div class="offer-modal-body">
            <input type="hidden" id="counterOfferId">
            <div class="offer-form-group">
                <label class="offer-form-label">Harga Tawar Balikmu</label>
                <input type="number" class="offer-form-input" id="counterPriceInput" min="1" placeholder="Masukkan harga...">
            </div>
            <div class="offer-form-group">
                <label class="offer-form-label">Catatan</label>
                <input type="text" class="offer-form-input" id="counterNoteInput"
                    placeholder="Misal: ini harga terendah saya..." style="font-weight:500;font-size:13px;">
            </div>
            <button class="offer-submit-btn" onclick="submitCounter()">Kirim Tawar Balik</button>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
@if(isset($activeRoom))
const ROOM_ID = {{ $activeRoom->id }};
const MY_ID   = {{ Auth::id() }};
const MY_INIT = '{{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? "U", 0, 2)) }}';
const OTHER_INIT = '{{ strtoupper(substr($activeOther->nama_lengkap ?? $activeOther->name ?? "U", 0, 2)) }}';
let lastId  = {{ $activeMessages->last()?->id ?? 0 }};
let polling = null;

function scrollBottom(smooth = true) {
    const el = document.getElementById('msgArea');
    if (el) el.scrollTo({ top: el.scrollHeight, behavior: smooth ? 'smooth' : 'instant' });
}
scrollBottom(false);

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 100) + 'px';
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
}

function useQuick(btn) {
    document.getElementById('msgInput').value = btn.textContent.trim();
    document.getElementById('msgInput').focus();
    document.getElementById('quickRow').style.display = 'none';
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function renderBubble(msg) {
    const isMine = msg.is_mine;
    const init   = isMine ? MY_INIT : OTHER_INIT;
    const div    = document.createElement('div');
    div.className = 'msg-row ' + (isMine ? 'mine' : '');
    div.dataset.id = msg.id;

    // Cek apakah pesan ini adalah offer card
    const offerMatch = msg.body.match(/\[offer:(\d+)\]/);
    if (offerMatch && msg.offer_card) {
        // Offer card sudah dirender server-side via reload — tampilkan bubble biasa dulu
        const cleanBody = msg.body.replace(/\[offer:\d+\]/, '').trim();
        div.innerHTML = `
            <div class="msg-ava ${isMine ? 'mine' : ''}">${init}</div>
            <div class="msg-grp" style="max-width:70%">
                <div class="bubble ${isMine ? 'mine' : 'other'}" style="white-space:pre-line">${escHtml(cleanBody)}</div>
                <div class="btime">${msg.time}</div>
            </div>`;
    } else {
        const cleanBody = msg.body.replace(/\[offer:\d+\]/, '').trim();
        div.innerHTML = `
            <div class="msg-ava ${isMine ? 'mine' : ''}">${init}</div>
            <div class="msg-grp">
                <div class="bubble ${isMine ? 'mine' : 'other'}" style="white-space:pre-line">${escHtml(cleanBody)}</div>
                <div class="btime">${msg.time}</div>
            </div>`;
    }
    return div;
}

async function sendMessage() {
    const input = document.getElementById('msgInput');
    const body  = input.value.trim();
    if (!body) return;
    const btn = document.getElementById('sendBtn');
    btn.disabled = true;
    input.value = '';
    input.style.height = 'auto';
    document.getElementById('quickRow').style.display = 'none';

    try {
        const res  = await fetch(`/chat/${ROOM_ID}/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: JSON.stringify({ body })
        });
        const data = await res.json();
        const area = document.getElementById('msgArea');
        data.messages.forEach(msg => {
            if (msg.id > lastId) { area.appendChild(renderBubble(msg)); lastId = msg.id; }
        });
        scrollBottom();
        updateRoomPreview(ROOM_ID, body);
    } catch(e) { console.error(e); }
    finally { btn.disabled = false; input.focus(); }
}

async function pollMessages() {
    try {
        const res  = await fetch(`/chat/${ROOM_ID}/poll?since=${lastId}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        if (data.messages?.length) {
            const area = document.getElementById('msgArea');
            data.messages.forEach(msg => {
                if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                    area.appendChild(renderBubble(msg));
                    lastId = Math.max(lastId, msg.id);
                    updateRoomPreview(ROOM_ID, msg.body);
                }
            });
            scrollBottom();
        }
    } catch(e) {}
}

polling = setInterval(pollMessages, 3000);
document.addEventListener('visibilitychange', () => {
    if (document.hidden) clearInterval(polling);
    else polling = setInterval(pollMessages, 3000);
});
@endif

// ── Filter room list
function filterRooms(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#roomsList .room-item').forEach(el => {
        el.style.display = (el.dataset.name || '').includes(q) ? '' : 'none';
    });
}

// ── Update preview teks di room list kiri setelah kirim pesan
function updateRoomPreview(roomId, text) {
    const item = document.querySelector(`[data-room="${roomId}"] .room-last-msg`);
    if (item) item.textContent = 'Kamu: ' + text.substring(0, 40);
}

function loadRoom(e, roomId) { /* biarkan link berjalan normal */ }

// ══════════════════════════════════
// ONLINE STATUS POLLING
// ══════════════════════════════════
@if(isset($activeOther))
const OTHER_USER_ID = {{ $activeOther->id }};

async function pollOnlineStatus() {
    try {
        const res  = await fetch(`/chat/online-status?user_id=${OTHER_USER_ID}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        const dot  = document.getElementById('onlineDot');
        const txt  = document.getElementById('onlineText');
        if (!dot || !txt) return;

        dot.className = 'online-dot ' + (data.is_online ? 'online' : 'offline');
        txt.className = 'status-text ' + (data.is_online ? 'online' : 'offline');
        txt.textContent = data.label;
    } catch(e) {}
}
setInterval(pollOnlineStatus, 15000); // cek tiap 15 detik
@endif

// ══════════════════════════════════
// TAWAR HARGA
// ══════════════════════════════════
@if(isset($activeRoom) && $activeRoom->harvest)
const HARVEST_ID      = {{ $activeRoom->harvest->id }};
const ORIG_PRICE      = {{ $activeRoom->harvest->price_per_unit }};
const ROOM_ID_OFFER   = {{ $activeRoom->id }};
const SELLER_USER_ID  = {{ $activeRoom->harvest->seller->user_id ?? 0 }};

function openOfferModal() {
    document.getElementById('offerModalBg').classList.add('open');
    updateSavings(document.getElementById('offerPriceInput').value);
    document.getElementById('offerPriceInput').focus();
}

function closeOfferModal(e) {
    if (!e || e.target === document.getElementById('offerModalBg'))
        document.getElementById('offerModalBg').classList.remove('open');
}

function updateSavings(priceVal) {
    const price   = parseFloat(priceVal) || 0;
    const qty     = parseInt(document.getElementById('offerQtyInput').value) || 1;
    const saving  = Math.max(0, ORIG_PRICE - price);
    const total   = saving * qty;
    const pct     = ORIG_PRICE > 0 ? Math.round((saving / ORIG_PRICE) * 100) : 0;
    const box     = document.getElementById('offerSavingsBox');
    const val     = document.getElementById('offerSavingsVal');
    val.textContent = 'Rp ' + total.toLocaleString('id-ID') + (pct > 0 ? ` (-${pct}%)` : '');
    box.style.display = saving > 0 ? 'flex' : 'none';
}

async function submitOffer() {
    const price = parseFloat(document.getElementById('offerPriceInput').value);
    const qty   = parseInt(document.getElementById('offerQtyInput').value) || 1;
    const note  = document.getElementById('offerNoteInput').value.trim();

    if (!price || price <= 0) { alert('Masukkan harga tawar yang valid.'); return; }
    if (price >= ORIG_PRICE)  { alert('Harga tawar harus lebih rendah dari harga asli.'); return; }

    const btn = document.getElementById('offerSubmitBtn');
    btn.disabled = true; btn.textContent = 'Mengirim...';

    try {
        const res  = await fetch('/offers', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: JSON.stringify({ harvest_id: HARVEST_ID, offer_price: price, quantity: qty, buyer_note: note, chat_room_id: ROOM_ID_OFFER })
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('offerModalBg').classList.remove('open');
            showChatToast('💰 Penawaran berhasil dikirim!');
            setTimeout(() => location.reload(), 800);
        }
    } catch(e) { alert('Gagal mengirim tawaran.'); }
    finally { btn.disabled = false; btn.textContent = 'Kirim Penawaran'; }
}

async function acceptOffer(offerId) {
    if (!confirm('Terima tawaran ini?')) return;
    try {
        const res  = await fetch(`/offers/${offerId}/accept`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) { showChatToast('✅ Tawaran diterima!'); setTimeout(() => location.reload(), 800); }
    } catch(e) {}
}

async function rejectOffer(offerId) {
    const note = prompt('Alasan penolakan (opsional):') ?? '';
    try {
        const res  = await fetch(`/offers/${offerId}/reject`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: JSON.stringify({ seller_note: note })
        });
        const data = await res.json();
        if (data.success) { showChatToast('❌ Tawaran ditolak.'); setTimeout(() => location.reload(), 800); }
    } catch(e) {}
}

async function cancelOffer(offerId) {
    if (!confirm('Batalkan tawaran ini?')) return;
    try {
        const res  = await fetch(`/offers/${offerId}/cancel`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) { showChatToast('🚫 Tawaran dibatalkan.'); setTimeout(() => location.reload(), 800); }
    } catch(e) {}
}

function openCounterModal(offerId, offerPrice) {
    document.getElementById('counterOfferId').value = offerId;
    document.getElementById('counterPriceInput').value = Math.round(offerPrice * 1.05);
    document.getElementById('counterModalBg').classList.add('open');
    document.getElementById('counterPriceInput').focus();
}
function closeCounterModal(e) {
    if (!e || e.target === document.getElementById('counterModalBg'))
        document.getElementById('counterModalBg').classList.remove('open');
}
async function submitCounter() {
    const id    = document.getElementById('counterOfferId').value;
    const price = parseFloat(document.getElementById('counterPriceInput').value);
    const note  = document.getElementById('counterNoteInput').value.trim();
    if (!price || price <= 0) { alert('Masukkan harga yang valid.'); return; }
    try {
        const res  = await fetch(`/offers/${id}/counter`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: JSON.stringify({ counter_price: price, seller_note: note })
        });
        const data = await res.json();
        if (data.success) { closeCounterModal(); showChatToast('🔄 Tawar balik terkirim!'); setTimeout(() => location.reload(), 800); }
    } catch(e) {}
}
@endif

function showChatToast(msg) {
    let t = document.getElementById('chatToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'chatToast';
        t.style.cssText = 'position:fixed;bottom:32px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--green-dark);color:white;padding:11px 22px;border-radius:50px;font-size:14px;font-weight:700;opacity:0;transition:all .35s cubic-bezier(.22,1,.36,1);z-index:9999;pointer-events:none;box-shadow:0 8px 24px rgba(0,0,0,.2);white-space:nowrap;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1'; t.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(-50%) translateY(20px)'; }, 2800);
}
</script>
@endpush