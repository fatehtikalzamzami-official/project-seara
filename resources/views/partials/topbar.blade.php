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
.logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
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
.topbar-user {
    display: flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px; padding: 6px 12px;
    cursor: pointer; color: white; transition: background 0.2s; text-decoration: none;
}
.topbar-user:hover { background: rgba(255,255,255,0.2); }
.user-ava {
    width: 28px; height: 28px; background: var(--green-light);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800; flex-shrink: 0;
}
.user-txt { font-size: 12px; font-weight: 700; }
.user-hello { font-size: 10px; opacity: 0.7; font-weight: 500; }
</style>

<header class="topbar">
    <div class="topbar-inner">
        <a href="{{ route('home') }}" class="logo">
            <div>
                <div class="logo-badge">🌾 SEARA</div>
                <div class="logo-sub">Dari Petani, Untuk Petani</div>
            </div>
        </a>

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

        <div class="topbar-actions">
            <a href="#" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>Wishlist</span>
            </a>

            <a href="#" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Keranjang</span>
                <div class="cart-badge">4</div>
            </a>

            <a href="#" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Pesanan</span>
            </a>

            {{-- Link ke Dashboard --}}
            <a href="{{ route('dashboard') }}" class="topbar-icon-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="#" class="topbar-user">
                <div class="user-ava">RF</div>
                <div>
                    <div class="user-hello">Selamat datang,</div>
                    <div class="user-txt">Pak Rafly</div>
                </div>
            </a>
        </div>
    </div>
</header>
