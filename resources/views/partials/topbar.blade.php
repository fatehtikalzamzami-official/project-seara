<style>
    .topbar {
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 60%, var(--green-mid) 100%);
        position: sticky;
        top: 0;
        z-index: 200;
        box-shadow: 0 2px 12px rgba(44, 95, 46, 0.25);
    }

    .topbar-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 12px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-right: 2%
    }

    .logo img {
        height: 40px;
        width: auto;
        object-fit: contain;
    }

    .logo-badge {
        background: var(--white);
        color: var(--green-dark);
        font-weight: 900;
        font-size: 15px;
        padding: 5px 10px;
        border-radius: 8px;
        letter-spacing: 2px;
        line-height: 1;
    }

    .logo-sub {
        color: rgba(255, 255, 255, 0.7);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .search-bar {
        flex: 1;
        display: flex;
        align-items: center;
        background: var(--white);
        border-radius: 8px;
        overflow: hidden;
        height: 42px;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }

    .search-bar:focus-within {
        border-color: var(--green-light);
    }

    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        padding: 0 16px;
        font-family: 'Nunito', sans-serif;
        font-size: 14px;
        color: var(--text-dark);
        background: transparent;
    }

    .search-bar input::placeholder {
        color: var(--text-muted);
    }

    .search-btn {
        background: var(--green-light);
        border: none;
        height: 100%;
        padding: 0 18px;
        color: white;
        font-family: 'Nunito', sans-serif;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-btn:hover {
        background: var(--green-mid);
    }

    .topbar-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .topbar-icon-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        padding: 6px 12px;
        border-radius: 8px;
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        transition: background 0.2s;
        position: relative;
        text-decoration: none;
    }

    .topbar-icon-btn:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    .topbar-icon-btn svg {
        width: 22px;
        height: 22px;
    }

    .topbar-icon-btn span {
        font-size: 11px;
        font-weight: 600;
    }

    .cart-badge {
        position: absolute;
        top: 2px;
        right: 6px;
        background: var(--accent);
        color: white;
        font-size: 10px;
        font-weight: 800;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--green-dark);
    }

    /* ── SELLER / APPLY BUTTON ── */
    .topbar-seller-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        padding: 6px 14px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.15);
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        color: #fff;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        text-decoration: none;
    }

    .topbar-seller-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-1px);
    }

    .topbar-seller-btn svg {
        width: 22px;
        height: 22px;
    }

    .topbar-seller-btn span {
        font-size: 11px;
        font-weight: 700;
    }

    /* Jika user adalah seller → warna gold/aksen */
    .topbar-seller-btn.is-seller {
        background: rgba(232, 193, 80, 0.20);
        border-color: rgba(232, 193, 80, 0.55);
        color: #fde68a;
    }

    .topbar-seller-btn.is-seller:hover {
        background: rgba(232, 193, 80, 0.32);
        border-color: rgba(232, 193, 80, 0.85);
        color: #fef3c7;
    }

    /* Jika pending → abu-abu transparan */
    .topbar-seller-btn.is-pending {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(255, 255, 255, 0.18);
        color: rgba(255, 255, 255, 0.5);
        cursor: default;
    }

    .topbar-seller-btn.is-pending:hover {
        transform: none;
        background: rgba(255, 255, 255, 0.07);
    }

    /* ── USER BUTTON ── */
    .topbar-user-wrap {
        position: relative;
    }

    .topbar-user {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 6px 12px;
        cursor: pointer;
        color: white;
        transition: background 0.2s;
        font-family: 'Nunito', sans-serif;
    }

    .topbar-user:hover {
        background: rgba(255, 255, 255, 0.22);
    }

    .user-ava {
        width: 30px;
        height: 30px;
        background: var(--green-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
        flex-shrink: 0;
        color: white;
    }

    .user-txt {
        font-size: 12px;
        font-weight: 700;
        text-align: left;
    }

    .user-hello {
        font-size: 10px;
        opacity: 0.7;
        font-weight: 500;
    }

    .user-chevron {
        transition: transform 0.25s;
        opacity: 0.8;
    }

    .user-chevron.open {
        transform: rotate(180deg);
    }

    /* ── DROPDOWN ── */
    .user-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 248px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.14), 0 2px 8px rgba(0, 0, 0, 0.06);
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
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 10px 12px;
    }

    .udrop-ava {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--green-main), var(--green-dark));
        color: white;
        font-weight: 800;
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .udrop-name {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .udrop-email {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .udrop-role {
        display: inline-block;
        margin-top: 4px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: capitalize;
        background: var(--green-pale);
        color: var(--green-dark);
        padding: 2px 8px;
        border-radius: 20px;
    }

    .udrop-divider {
        height: 1px;
        background: var(--border);
        margin: 4px 0;
    }

    /* Menu items */
    .udrop-item {
        display: flex;
        align-items: center;
        gap: 11px;
        width: 100%;
        padding: 9px 10px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-dark);
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Nunito', sans-serif;
        transition: background 0.15s, color 0.15s;
        text-align: left;
    }

    .udrop-item:hover {
        background: var(--green-pale);
        color: var(--green-dark);
    }

    .udrop-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        flex-shrink: 0;
        background: var(--green-pale);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: background 0.15s;
    }

    .udrop-item:hover .udrop-icon {
        background: #c8e6c9;
    }

    .udrop-logout {
        color: #dc2626;
    }

    .udrop-logout:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    .udrop-logout .udrop-icon {
        background: #fef2f2;
    }

    .udrop-logout:hover .udrop-icon {
        background: #fecaca;
    }

    .udrop-item-seller {
        color: var(--green-dark) !important;
        font-weight: 800 !important;
    }

    .udrop-item-seller:hover {
        background: var(--green-pale) !important;
        color: var(--green-main) !important;
    }
</style>

<header class="topbar">
    <div class="topbar-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}" alt="SEARA Logo">
        </a>

        {{-- Search --}}
        <div class="search-wrap" style="flex:1;position:relative;">
            <form action="{{ route('search.index') }}" method="GET" class="search-bar" id="searchForm"
                autocomplete="off">
                <input type="text" name="q" id="searchInput" placeholder="Cari sayuran, buah, beras, rempah..."
                    value="{{ request('q') }}" autocomplete="off">
                <button type="submit" class="search-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" width="16"
                        height="16">
                        <circle cx="11" cy="11" r="8" />
                        <path stroke-linecap="round" d="m21 21-4.35-4.35" />
                    </svg>
                    Cari
                </button>
            </form>
            {{-- Autocomplete dropdown --}}
            <div id="searchSuggest" style="
                display:none;
                position:absolute;
                top:calc(100% + 6px);
                left:0; right:0;
                background:white;
                border:1px solid #e0e0e0;
                border-radius:10px;
                box-shadow:0 8px 28px rgba(0,0,0,0.13);
                z-index:9999;
                overflow:hidden;
            "></div>
        </div>

        {{-- Actions --}}
        <div class="topbar-actions">

            {{-- Wishlist --}}
            <a href="{{ auth()->check() ? route('wishlist.index') : route('home') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span>Wishlist</span>
                <div class="cart-badge" id="wishlistBadge" style="display:none">0</div>
            </a>

            {{-- Chat --}}
            @auth
                <a href="{{ route('chat.index') }}" class="topbar-icon-btn" id="chatTopbarBtn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Pesan</span>
                    <div class="cart-badge" id="chatBadge" style="display:none;">0</div>
                </a>
            @endauth

            {{-- Keranjang --}}
            <a href="{{ route('cart.index') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Keranjang</span>
                <div class="cart-badge" id="cartBadge" style="display:none">0</div>
            </a>

            {{-- Pesanan --}}
            <a href="{{ route('orders.index') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Pesanan</span>
            </a>

            {{-- Dashboard --}}
            <a href="{{ route('buyer.dashboard') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- ── TOMBOL SELLER / DAFTAR SELLER (BARU) ── --}}
            @auth
                @if(Auth::user()->role === 'seller')
                    {{-- User adalah seller → tombol masuk ke dashboard seller, warna gold --}}
                    <a href="{{ route('seller.dashboard') }}" class="topbar-seller-btn is-seller"
                        title="Buka Dashboard Penjual">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>🌾 Toko Saya</span>
                    </a>

                @elseif(Auth::user()->role === 'buyer')
                    @php $application = Auth::user()->sellerApplication; @endphp

                    @if(!$application || $application->status === 'rejected')
                        {{-- Belum daftar / ditolak → ajak daftar jadi seller --}}
                        <a href="{{ route('buyer.apply.create') }}" class="topbar-seller-btn" title="Daftar sebagai penjual">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Jadi Seller</span>
                        </a>

                    @elseif(in_array($application->status, ['pending', 'reviewing']))
                        {{-- Sedang diproses → tombol abu-abu non-klik --}}
                        <a href="{{ route('buyer.application.status') }}" class="topbar-seller-btn is-pending"
                            title="Pengajuan sedang diproses">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Menunggu...</span>
                        </a>
                    @endif
                @endif
            @endauth
            {{-- ── END TOMBOL SELLER ── --}}

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
                        <svg class="user-chevron" id="userChevron" width="14" height="14" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
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
                            <span class="udrop-icon"><i class="fa-solid fa-house"></i></span> Dashboard
                        </a>

                        <a href="{{ route('buyer.profile') }}" class="udrop-item">
                            <span class="udrop-icon"><i class="fa-solid fa-user"></i></span> Profil Saya
                        </a>

                        <a href="{{ route('orders.index') }}" class="udrop-item">
                            <span class="udrop-icon"><i class="fa-solid fa-clipboard-list"></i></span> Pesanan Saya
                        </a>

                        <a href="{{ route('cart.index') }}" class="udrop-item">
                            <span class="udrop-icon"><i class="fa-solid fa-cart-shopping"></i></span> Keranjang Belanja
                        </a>

                        <a href="{{ route('chat.index') }}" class="udrop-item">
                            <span class="udrop-icon"><i class="fa-solid fa-comments"></i></span> Chat Petani
                        </a>
                        @if(Auth::user()->role === 'buyer')
                            @php $application = Auth::user()->sellerApplication; @endphp
                            <div class="udrop-divider"></div>
                            @if(!$application || $application->status === 'rejected')
                                <a href="{{ route('buyer.apply.create') }}" class="udrop-item udrop-item-seller">
                                    <span class="udrop-icon"><i class="fa-solid fa-store"></i></span> Jadi Seller
                                </a>
                            @elseif(in_array($application->status, ['pending', 'reviewing']))
                                <a href="{{ route('buyer.application.status') }}" class="udrop-item" style="opacity:0.75">
                                    <span class="udrop-icon"><i class="fa-solid fa-clock"></i></span> Pengajuan Diproses...
                                </a>
                            @endif
                        @elseif(Auth::user()->role === 'seller')
                            <div class="udrop-divider"></div>
                            <a href="{{ route('seller.dashboard') }}" class="udrop-item udrop-item-seller">
                                <span class="udrop-icon"><i class="fa-solid fa-store"></i></span> Dashboard Seller
                            </a>
                        @endif

                        <div class="udrop-divider"></div>

                        {{-- Logout --}}
                        {{-- ✅ Sesudah --}} <button type="button" class="udrop-item udrop-logout"
                            onclick="openLogoutModal()">
                            <span class="udrop-icon"><i class="fa-solid fa-sign-out-alt"></i></span> Keluar
                        </button>

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
        const chevron = document.getElementById('userChevron');
        const isOpen = dropdown.classList.contains('open');
        dropdown.classList.toggle('open', !isOpen);
        chevron.classList.toggle('open', !isOpen);
    }

    // ── Tutup jika klik di luar
    document.addEventListener('click', function (e) {
        const wrap = document.getElementById('userDropWrap');
        if (wrap && !wrap.contains(e.target)) {
            document.getElementById('userDropdown')?.classList.remove('open');
            document.getElementById('userChevron')?.classList.remove('open');
        }
    });

    // ── Konfirmasi sebelum logout
    // ✅ Sesudah

    // ── Update badge chat unread
    @auth
        (function pollChatBadge() {
            async function fetchUnread() {
                try {
                    const res = await fetch('{{ route("chat.unread") }}', {
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
                } catch (e) { /* silent */ }
            }
            fetchUnread();
            setInterval(fetchUnread, 10000);
        })();

        // ── Update badge wishlist
        (function pollWishlistBadge() {
            async function fetchWishlistCount() {
                try {
                    const res = await fetch('{{ route("wishlist.count") }}', {
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' }
                    });
                    const data = await res.json();
                    const badge = document.getElementById('wishlistBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                    // ✅ Ganti dengan ini
                } catch (e) { /* silent */ }
            }
            fetchWishlistCount();
            setInterval(fetchWishlistCount, 15000);
        })();
    @endauth

    // ── Autocomplete / Search Suggestion ──────────────────────
    (function () {
        const input = document.getElementById('searchInput');
        const suggest = document.getElementById('searchSuggest');
        if (!input || !suggest) return;

        let debounceTimer = null;
        let activeIndex = -1;
        let suggestions = [];

        function renderSuggestions(items) {
            suggestions = items;
            activeIndex = -1;
            if (!items.length) { hideSuggest(); return; }

            const typeLabel = { produk: 'Produk', petani: 'Petani' };
            let html = '<div style="padding:6px 0;">';
            items.forEach((item, i) => {
                html += `
            <div class="sg-item" data-index="${i}" style="
                display:flex; align-items:center; gap:10px;
                padding:9px 14px; cursor:pointer;
                font-size:13px; font-weight:700; color:#2d2d2d;
                transition:background 0.12s;
            " onmousedown="window._sgSelect(${i})">
                <span style="font-size:18px;width:26px;text-align:center;">${item.icon}</span>
                <span style="flex:1;">${escapeHtml(item.label)}</span>
                <span style="font-size:10px;font-weight:600;color:#888;background:#f4f4f4;padding:2px 7px;border-radius:20px;">${typeLabel[item.type] ?? item.type}</span>
            </div>`;
            });
            html += '</div>';

            // Footer hint
            html += `<div style="padding:7px 14px;border-top:1px solid #f0f0f0;font-size:11px;color:#aaa;font-weight:600;">
            Tekan Enter untuk cari semua hasil
        </div>`;

            suggest.innerHTML = html;
            suggest.style.display = 'block';

            // Hover style
            suggest.querySelectorAll('.sg-item').forEach(el => {
                el.addEventListener('mouseenter', () => { el.style.background = '#f0faf0'; });
                el.addEventListener('mouseleave', () => { el.style.background = 'transparent'; });
            });
        }

        window._sgSelect = function (index) {
            const item = suggestions[index];
            if (!item) return;
            input.value = item.query;
            hideSuggest();
            document.getElementById('searchForm').submit();
        };

        function hideSuggest() {
            suggest.style.display = 'none';
            suggest.innerHTML = '';
            activeIndex = -1;
        }

        function escapeHtml(str) {
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function highlightItem(idx) {
            const items = suggest.querySelectorAll('.sg-item');
            items.forEach((el, i) => {
                el.style.background = i === idx ? '#f0faf0' : 'transparent';
            });
        }

        // Input event
        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            if (q.length < 3) { hideSuggest(); return; }

            debounceTimer = setTimeout(async () => {
                try {
                    const url = '{{ route("search.suggest") }}?q=' + encodeURIComponent(q);
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    const data = await res.json();
                    renderSuggestions(data);
                } catch (e) { hideSuggest(); }
            }, 250);
        });

        // Keyboard navigation
        input.addEventListener('keydown', function (e) {
            const items = suggest.querySelectorAll('.sg-item');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                highlightItem(activeIndex);
                if (suggestions[activeIndex]) input.value = suggestions[activeIndex].query;
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, -1);
                highlightItem(activeIndex);
                if (activeIndex >= 0 && suggestions[activeIndex]) input.value = suggestions[activeIndex].query;
            } else if (e.key === 'Escape') {
                hideSuggest();
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0 && suggestions[activeIndex]) {
                    e.preventDefault();
                    window._sgSelect(activeIndex);
                }
                // else let form submit normally
            }
        });

        // Tutup suggestion jika klik di luar
        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !suggest.contains(e.target)) {
                hideSuggest();
            }
        });

        input.addEventListener('focus', function () {
            if (this.value.trim().length >= 3 && suggestions.length) {
                suggest.style.display = 'block';
            }
        });
    })();
    // ──────────────────────────────────────────────────────────
</script>