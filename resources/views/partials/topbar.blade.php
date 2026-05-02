<style>
.topbar {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 60%, var(--green-mid) 100%);
    position: sticky; top: 0; z-index: 200;
    box-shadow: 0 2px 12px rgba(44,95,46,0.25);
}
.topbar-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 12px 24px;
    display: flex; align-items: center; gap: 20px;
}
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-right: 2%
}

.logo img {
    height: 80px; /* bisa lu adjust */
    width: auto;
    object-fit: contain;
}
.logo-badge {
    background: var(--white); color: var(--green-dark);
    font-weight: 900; font-size: 15px;
    padding: 5px 10px; border-radius: 8px;
    letter-spacing: 2px; line-height: 1;
}
.logo-sub { color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 600; letter-spacing: 1px; }
.search-bar {
    flex: 1; display: flex; align-items: center;
    background: var(--white); border-radius: 8px;
    overflow: hidden; height: 42px;
    border: 2px solid transparent; transition: border-color 0.2s;
}
.search-bar:focus-within { border-color: var(--green-light); }
.search-bar input {
    flex: 1; border: none; outline: none;
    padding: 0 16px; font-family: 'Nunito', sans-serif;
    font-size: 14px; color: var(--text-dark); background: transparent;
}
.search-bar input::placeholder { color: var(--text-muted); }
.search-btn {
    background: var(--green-light); border: none; height: 100%;
    padding: 0 18px; color: white;
    font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 13px;
    display: flex; align-items: center; gap: 6px; cursor: pointer;
    transition: background 0.2s;
}
.search-btn:hover { background: var(--green-mid); }
.topbar-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.topbar-icon-btn {
    display: flex; flex-direction: column; align-items: center; gap: 2px;
    padding: 6px 12px; border-radius: 8px;
    background: transparent; border: none; color: white;
    cursor: pointer; transition: background 0.2s; position: relative; text-decoration: none;
}
.topbar-icon-btn:hover { background: rgba(255,255,255,0.12); }
.topbar-icon-btn svg { width: 22px; height: 22px; }
.topbar-icon-btn span { font-size: 11px; font-weight: 600; }
.cart-badge {
    position: absolute; top: 2px; right: 6px;
    background: var(--accent); color: white;
    font-size: 10px; font-weight: 800;
    width: 17px; height: 17px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--green-dark);
}

/* ── USER BUTTON ── */
.topbar-user-wrap { position: relative; }

.topbar-user {
    display: flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px; padding: 6px 12px;
    cursor: pointer; color: white;
    transition: background 0.2s;
    font-family: 'Nunito', sans-serif;
}
.topbar-user:hover { background: rgba(255,255,255,0.22); }

.user-ava {
    width: 30px; height: 30px; background: var(--green-light);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800; flex-shrink: 0; color: white;
}
.user-txt { font-size: 12px; font-weight: 700; text-align: left; }
.user-hello { font-size: 10px; opacity: 0.7; font-weight: 500; }
.user-chevron { transition: transform 0.25s; opacity: 0.8; }
.user-chevron.open { transform: rotate(180deg); }

/* ── DROPDOWN ── */
.user-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 248px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.14), 0 2px 8px rgba(0,0,0,0.06);
    padding: 8px;
    z-index: 9999;
    opacity: 0;
    transform: translateY(-8px) scale(0.96);
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    transform-origin: top right;
}
.user-dropdown.open {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
}

/* Profile header */
.udrop-profile {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 10px 12px;
}
.udrop-ava {
    width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--green-main), var(--green-dark));
    color: white; font-weight: 800; font-size: 17px;
    display: flex; align-items: center; justify-content: center;
}
.udrop-name { font-size: 13px; font-weight: 800; color: var(--text-dark); line-height: 1.3; }
.udrop-email { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
.udrop-role {
    display: inline-block; margin-top: 4px;
    font-size: 10px; font-weight: 700; letter-spacing: 0.5px; text-transform: capitalize;
    background: var(--green-pale); color: var(--green-dark);
    padding: 2px 8px; border-radius: 20px;
}

.udrop-divider { height: 1px; background: var(--border); margin: 4px 0; }

/* Menu items */
.udrop-item {
    display: flex; align-items: center; gap: 11px;
    width: 100%; padding: 9px 10px; border-radius: 10px;
    font-size: 13px; font-weight: 700; color: var(--text-dark);
    text-decoration: none; background: none; border: none;
    cursor: pointer; font-family: 'Nunito', sans-serif;
    transition: background 0.15s, color 0.15s; text-align: left;
}
.udrop-item:hover { background: var(--green-pale); color: var(--green-dark); }
.udrop-icon {
    width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
    background: var(--green-pale); display: flex; align-items: center; justify-content: center;
    font-size: 15px; transition: background 0.15s;
}
.udrop-item:hover .udrop-icon { background: #c8e6c9; }

.udrop-logout { color: #dc2626; }
.udrop-logout:hover { background: #fef2f2; color: #b91c1c; }
.udrop-logout .udrop-icon { background: #fef2f2; }
.udrop-logout:hover .udrop-icon { background: #fecaca; }

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    height: 40px; /* bisa lu adjust */
    width: auto;
    object-fit: contain;
}
</style>

<header class="topbar">
    <div class="topbar-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo">
            <div>
                <div class="logo">
    <img src="{{ asset('assets/logo.png') }}" alt="SEARA Logo">
</div>
            </div>
        </a>

        {{-- Search --}}
        <form action="{{ route('home') }}" method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Cari sayuran, buah, beras, rempah..." value="{{ request('q') }}">
            <button type="submit" class="search-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                    <circle cx="11" cy="11" r="8"/>
                    <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                </svg>
                Cari
            </button>
        </form>

        {{-- Actions --}}
        <div class="topbar-actions">

            {{-- Wishlist --}}
            <a href="#" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>Wishlist</span>
            </a>

            {{-- Chat --}}
            @auth
            <a href="{{ route('chat.index') }}" class="topbar-icon-btn" id="chatTopbarBtn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Pesan</span>
                <div class="cart-badge" id="chatBadge" style="display:none;">0</div>
            </a>
            @endauth

            {{-- Keranjang --}}
           <a href="{{ route('cart.index') }}" class="topbar-icon-btn">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    <span>Keranjang</span>
    <div class="cart-badge" id="cartBadge" style="display:none">0</div>
</a>

            {{-- Pesanan --}}
            <a href="{{ route('orders.index') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Pesanan</span>
            </a>

            {{-- Dashboard --}}
            <a href="{{ route('buyer.dashboard') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- ── USER DROPDOWN ── --}}
            @auth
            <div class="topbar-user-wrap" id="userDropWrap">

                <button class="topbar-user" id="userAvatarBtn" onclick="toggleUserMenu()">
                    <div class="user-ava">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="user-hello">Selamat datang,</div>
                        <div class="user-txt">
                            {{ \Illuminate\Support\Str::limit(Auth::user()->nama_lengkap ?? 'Pengguna', 16) }}
                        </div>
                    </div>
                    <svg class="user-chevron" id="userChevron" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div class="user-dropdown" id="userDropdown">

                    {{-- Profile Info --}}
                    <div class="udrop-profile">
                        <div class="udrop-ava">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <div class="udrop-name">{{ Auth::user()->nama_lengkap ?? 'Pengguna' }}</div>
                            <div class="udrop-email">{{ Auth::user()->email }}</div>
                            <span class="udrop-role">{{ Auth::user()->role ?? 'buyer' }}</span>
                        </div>
                    </div>

                    <div class="udrop-divider"></div>

                    {{-- Menu --}}
                    <a href="{{ route('buyer.dashboard') }}" class="udrop-item">
                        <span class="udrop-icon">🏠</span> Dashboard
                    </a>
                    <a href="{{ route('orders.index') }}" class="udrop-item">
                        <span class="udrop-icon">📋</span> Pesanan Saya
                    </a>
                    <a href="{{ route('cart.index') }}" class="udrop-item">
                        <span class="udrop-icon">🛒</span> Keranjang Belanja
                    </a>
                    <a href="{{ route('chat.index') }}" class="udrop-item">
                        <span class="udrop-icon">💬</span> Chat Petani
                    </a>

                    <div class="udrop-divider"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="button" class="udrop-item udrop-logout" onclick="confirmLogout()">
                            <span class="udrop-icon">🚪</span> Logout
                        </button>
                    </form>

                </div>
            </div>
            @endauth

        </div>
    </div>
</header>

<script>
// ── Toggle dropdown
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    const chevron  = document.getElementById('userChevron');
    const isOpen   = dropdown.classList.contains('open');
    dropdown.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
}

// ── Tutup jika klik di luar
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('userDropWrap');
    if (wrap && !wrap.contains(e.target)) {
        document.getElementById('userDropdown')?.classList.remove('open');
        document.getElementById('userChevron')?.classList.remove('open');
    }
});

// ── Konfirmasi sebelum logout
function confirmLogout() {
    if (confirm('Yakin ingin keluar dari SEARA?')) {
        document.getElementById('logoutForm').submit();
    }
}

// ── Update badge chat unread
@auth
(function pollChatBadge() {
    async function fetchUnread() {
        try {
            const res  = await fetch('{{ route("chat.unread") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' }
            });
            const data = await res.json();
            const badge = document.getElementById('chatBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        } catch(e) { /* silent */ }
    }
    fetchUnread();
    setInterval(fetchUnread, 10000); // update tiap 10 detik
})();
@endauth
</script>