<style>
.navbar { background: var(--green-dark); border-bottom: 1px solid rgba(255,255,255,0.08); }
.navbar-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 0 24px;
    display: flex; align-items: center; gap: 4px;
}
.nav-link {
    padding: 10px 14px; color: rgba(255,255,255,0.75);
    font-size: 13px; font-weight: 600;
    transition: color 0.2s, background 0.2s;
    border-radius: 6px; display: flex; align-items: center; gap: 6px;
    white-space: nowrap;
}
.nav-link:hover { color: white; background: rgba(255,255,255,0.08); }
.nav-link.active { color: white; background: rgba(255,255,255,0.12); }
.nav-link.hot { color: var(--accent); }
.nav-link.hot:hover { background: rgba(255,107,53,0.1); }
</style>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">🌿 Semua Kategori</a>
        <a href="{{ route('home', ['kategori' => 'pertanian']) }}" class="nav-link">🌾 Pertanian</a>
        <a href="{{ route('home', ['kategori' => 'perkebunan']) }}" class="nav-link">🌳 Perkebunan</a>
        <a href="{{ route('home', ['kategori' => 'peternakan']) }}" class="nav-link">🐄 Peternakan</a>
        <a href="{{ route('home', ['kategori' => 'perikanan']) }}" class="nav-link">🐟 Perikanan</a>
        <a href="{{ route('home', ['kategori' => 'rempah']) }}" class="nav-link">🌿 Rempah & Bumbu</a>
        <a href="{{ route('home', ['kategori' => 'organik']) }}" class="nav-link">🥗 Organik</a>
        <a href="{{ route('home', ['kategori' => 'bibit']) }}" class="nav-link">🌱 Bibit & Pupuk</a>
        <a href="#" class="nav-link hot">🔥 Flash Sale</a>
        <a href="#" class="nav-link">👨‍🌾 Petani Lokal</a>
    </div>
</nav>
