@extends('layouts.app')

@section('title', 'Chat dengan ' . ($other->nama_lengkap ?? $other->name ?? 'Penjual') . ' — SEARA')

@push('styles')
<style>
/* ── Layout Chat Room ── */
.chatroom-page { max-width: 800px; margin: 0 auto; padding: 20px 20px 40px; display: flex; flex-direction: column; height: calc(100vh - 130px); }

/* ── Header ── */
.chatroom-head {
    background: white; border: 1.5px solid var(--border);
    border-radius: 16px 16px 0 0; padding: 14px 18px;
    display: flex; align-items: center; gap: 14px;
    border-bottom: none;
}
.chatroom-back { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid var(--border); background: white; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; text-decoration: none; color: var(--text-dark); transition: all .2s; flex-shrink: 0; }
.chatroom-back:hover { border-color: var(--green-main); background: var(--green-pale); }
.chatroom-ava { width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, var(--green-main), var(--green-dark)); color: white; font-size: 18px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.chatroom-info { flex: 1; min-width: 0; }
.chatroom-name { font-size: 16px; font-weight: 800; color: var(--text-dark); }
.chatroom-status { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; margin-top: 2px; }
.chatroom-status .dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; }
.chatroom-product { background: var(--green-pale); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: 700; color: var(--green-dark); }

/* ── Pesan area ── */
.chatroom-messages {
    flex: 1; overflow-y: auto;
    background: white; border: 1.5px solid var(--border);
    border-left: 1.5px solid var(--border); border-right: 1.5px solid var(--border);
    padding: 16px; display: flex; flex-direction: column; gap: 12px;
    scroll-behavior: smooth;
}
.chatroom-messages::-webkit-scrollbar { width: 4px; }
.chatroom-messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

/* ── Date separator ── */
.date-sep { text-align: center; margin: 8px 0; }
.date-sep span { font-size: 11px; color: var(--text-muted); background: var(--green-pale); padding: 3px 12px; border-radius: 20px; font-weight: 600; }

/* ── Bubble ── */
.msg-row { display: flex; align-items: flex-end; gap: 8px; }
.msg-row.mine { flex-direction: row-reverse; }
.msg-avatar { width: 28px; height: 28px; border-radius: 50%; background: var(--green-pale); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; color: var(--green-dark); flex-shrink: 0; }
.msg-avatar.mine-ava { background: var(--green-main); color: white; }
.msg-group { display: flex; flex-direction: column; gap: 2px; max-width: 70%; }
.msg-row.mine .msg-group { align-items: flex-end; }
.bubble {
    padding: 10px 14px; border-radius: 16px;
    font-size: 14px; line-height: 1.6; word-break: break-word;
    position: relative;
}
.bubble.other { background: white; color: var(--text-dark); border: 1.5px solid var(--border); border-bottom-left-radius: 4px; }
.bubble.mine  { background: var(--green-main); color: white; border-bottom-right-radius: 4px; }
.bubble-time  { font-size: 10px; color: var(--text-muted); padding: 0 4px; }
.msg-row.mine .bubble-time { text-align: right; }
.bubble-read  { font-size: 10px; color: var(--green-main); }

/* ── Produk konteks (bubble pertama) ── */
.context-card { background: var(--green-pale); border: 1.5px solid var(--border); border-radius: 12px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
.context-emoji { font-size: 28px; }
.context-info .c-name { font-size: 13px; font-weight: 800; color: var(--text-dark); }
.context-info .c-price { font-size: 12px; color: var(--green-main); font-weight: 700; }

/* ── Typing indicator ── */
.typing-row { display: flex; align-items: center; gap: 8px; }
.typing-bubble { background: white; border: 1.5px solid var(--border); border-radius: 16px; border-bottom-left-radius: 4px; padding: 10px 16px; display: flex; gap: 5px; align-items: center; }
.typing-bubble span { width: 7px; height: 7px; background: #bbb; border-radius: 50%; animation: tbounce .9s infinite; }
.typing-bubble span:nth-child(2) { animation-delay: .15s; }
.typing-bubble span:nth-child(3) { animation-delay: .3s; }
@keyframes tbounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-6px)} }

/* ── Input area ── */
.chatroom-input-wrap {
    background: white; border: 1.5px solid var(--border);
    border-radius: 0 0 16px 16px; border-top: none;
    padding: 12px 14px; display: flex; align-items: flex-end; gap: 10px;
}
.chatroom-input {
    flex: 1; border: 1.5px solid var(--border); border-radius: 12px;
    padding: 10px 14px; font-family: 'Nunito', sans-serif; font-size: 14px;
    outline: none; resize: none; max-height: 120px; overflow-y: auto;
    transition: border-color .2s; line-height: 1.5;
}
.chatroom-input:focus { border-color: var(--green-main); }
.chatroom-send {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--green-main); border: none; color: white;
    font-size: 20px; cursor: pointer; display: flex; align-items: center;
    justify-content: center; flex-shrink: 0; transition: all .2s;
}
.chatroom-send:hover { background: var(--green-dark); transform: scale(1.05); }
.chatroom-send:disabled { background: #ccc; cursor: not-allowed; transform: none; }
.chatroom-send:active { transform: scale(0.95); }

/* ── Quick replies ── */
.quick-replies { background: white; border-left: 1.5px solid var(--border); border-right: 1.5px solid var(--border); padding: 8px 14px; display: flex; gap: 6px; flex-wrap: wrap; border-top: 1px solid var(--border); }
.qr-btn { font-size: 12px; font-weight: 700; color: var(--green-dark); background: var(--green-pale); border: 1px solid var(--border); padding: 5px 12px; border-radius: 20px; cursor: pointer; transition: all .2s; white-space: nowrap; font-family: 'Nunito', sans-serif; }
.qr-btn:hover { background: #c8e6c9; border-color: var(--green-main); }

@keyframes msgIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
.msg-row { animation: msgIn .25s ease both; }
</style>
@endpush

@section('content')
<div class="chatroom-page">

    {{-- Header --}}
    <div class="chatroom-head">
        <a href="{{ route('chat.index') }}" class="chatroom-back">←</a>
        <div class="chatroom-ava">
            {{ strtoupper(substr($other->nama_lengkap ?? $other->name ?? 'U', 0, 2)) }}
        </div>
        <div class="chatroom-info">
            <div class="chatroom-name">{{ $other->nama_lengkap ?? $other->name ?? 'Pengguna' }}</div>
            <div class="chatroom-status">
                <span class="dot"></span> Online sekarang
            </div>
        </div>
        @if($chatRoom->harvest)
            <div class="chatroom-product">🌾 {{ $chatRoom->harvest->product->name ?? 'Produk' }}</div>
        @endif
    </div>

    {{-- Pesan --}}
    <div class="chatroom-messages" id="chatMessages">

        {{-- Konteks produk --}}
        @if($chatRoom->harvest)
        <div class="context-card">
            <div class="context-emoji">🌾</div>
            <div class="context-info">
                <div class="c-name">{{ $chatRoom->harvest->product->name ?? 'Produk' }}</div>
                <div class="c-price">Rp {{ number_format($chatRoom->harvest->price_per_unit, 0, ',', '.') }} / {{ $chatRoom->harvest->product->unit ?? 'kg' }}</div>
            </div>
        </div>
        @endif

        {{-- Pesan dari DB --}}
        @php $lastDate = null; $myId = Auth::id(); @endphp
        @foreach($messages as $msg)
            @php
                $msgDate = $msg->created_at->format('Y-m-d');
                $isMine  = $msg->sender_id === $myId;
                $initials = strtoupper(substr($msg->sender->nama_lengkap ?? $msg->sender->name ?? 'U', 0, 2));
            @endphp

            @if($msgDate !== $lastDate)
                <div class="date-sep">
                    <span>{{ $msg->created_at->isToday() ? 'Hari ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->format('d M Y')) }}</span>
                </div>
                @php $lastDate = $msgDate; @endphp
            @endif

            <div class="msg-row {{ $isMine ? 'mine' : '' }}" data-id="{{ $msg->id }}">
                <div class="msg-avatar {{ $isMine ? 'mine-ava' : '' }}">{{ $initials }}</div>
                <div class="msg-group">
                    <div class="bubble {{ $isMine ? 'mine' : 'other' }}">{{ $msg->body }}</div>
                    <div class="bubble-time">
                        {{ $msg->created_at->format('H:i') }}
                        @if($isMine && $msg->read_at)
                            <span class="bubble-read">✓✓</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- Quick Replies --}}
    <div class="quick-replies" id="quickReplies">
        <button class="qr-btn" onclick="useQuick(this)">Apakah stok masih ada?</button>
        <button class="qr-btn" onclick="useQuick(this)">Berapa minimum order?</button>
        <button class="qr-btn" onclick="useQuick(this)">Bisa kirim ke luar kota?</button>
        <button class="qr-btn" onclick="useQuick(this)">Kapan panen berikutnya?</button>
    </div>

    {{-- Input --}}
    <div class="chatroom-input-wrap">
        <textarea class="chatroom-input" id="msgInput"
            placeholder="Tulis pesan..."
            rows="1"
            onkeydown="handleKey(event)"
            oninput="autoResize(this)"></textarea>
        <button class="chatroom-send" id="sendBtn" onclick="sendMessage()">➤</button>
    </div>

</div>
@endsection

@push('scripts')
<script>
const ROOM_ID   = {{ $chatRoom->id }};
const MY_ID     = {{ Auth::id() }};
const MY_INIT   = '{{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? "U", 0, 2)) }}';
const POLL_MS   = 3000; // polling setiap 3 detik
let   lastId    = {{ $messages->last()?->id ?? 0 }};
let   polling   = null;

// ── Auto scroll ke bawah
function scrollBottom(smooth = true) {
    const el = document.getElementById('chatMessages');
    el.scrollTo({ top: el.scrollHeight, behavior: smooth ? 'smooth' : 'instant' });
}
scrollBottom(false);

// ── Auto resize textarea
function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

// ── Enter kirim, Shift+Enter newline
function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
}

// ── Quick reply
function useQuick(btn) {
    document.getElementById('msgInput').value = btn.textContent.trim();
    document.getElementById('msgInput').focus();
    document.getElementById('quickReplies').style.display = 'none';
}

// ── Render satu bubble
function renderBubble(msg) {
    const isMine = msg.is_mine;
    const init   = isMine ? MY_INIT : '{{ strtoupper(substr($other->nama_lengkap ?? $other->name ?? "U", 0, 2)) }}';
    const div    = document.createElement('div');
    div.className = 'msg-row ' + (isMine ? 'mine' : '');
    div.dataset.id = msg.id;
    div.innerHTML = `
        <div class="msg-avatar ${isMine ? 'mine-ava' : ''}">${init}</div>
        <div class="msg-group">
            <div class="bubble ${isMine ? 'mine' : 'other'}">${escHtml(msg.body)}</div>
            <div class="bubble-time">${msg.time}</div>
        </div>`;
    return div;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── Kirim pesan
async function sendMessage() {
    const input = document.getElementById('msgInput');
    const body  = input.value.trim();
    if (!body) return;

    const btn = document.getElementById('sendBtn');
    btn.disabled = true;
    input.value  = '';
    input.style.height = 'auto';
    document.getElementById('quickReplies').style.display = 'none';

    try {
        const res = await fetch('{{ route("chat.send", $chatRoom->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ body })
        });

        const data = await res.json();
        // Render semua pesan baru
        const container = document.getElementById('chatMessages');
        data.messages.forEach(msg => {
            if (msg.id > lastId) {
                container.appendChild(renderBubble(msg));
                lastId = msg.id;
            }
        });
        scrollBottom();
    } catch(err) {
        console.error(err);
    } finally {
        btn.disabled = false;
        input.focus();
    }
}

// ── Polling pesan baru dari pihak lain
async function pollMessages() {
    try {
        const res  = await fetch(`{{ route("chat.poll", $chatRoom->id) }}?since=${lastId}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const data = await res.json();
        if (data.messages && data.messages.length) {
            const container = document.getElementById('chatMessages');
            data.messages.forEach(msg => {
                if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                    container.appendChild(renderBubble(msg));
                    lastId = Math.max(lastId, msg.id);
                }
            });
            scrollBottom();
        }
    } catch(e) { /* silent */ }
}

// Mulai polling
polling = setInterval(pollMessages, POLL_MS);

// Stop polling saat halaman ditinggal
document.addEventListener('visibilitychange', () => {
    if (document.hidden) { clearInterval(polling); }
    else { polling = setInterval(pollMessages, POLL_MS); }
});
</script>
@endpush
