<style>
/* ─── SELLER SIDEBAR PARTIAL ─── */
.seller-sidebar {
    width: 240px;
    flex-shrink: 0;
    background: var(--white);
    border-right: 1px solid var(--border);
    padding: 24px 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

.sidebar-section {
    padding: 0 16px;
    margin-bottom: 6px;
}

.sidebar-label {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--text-muted);
    padding: 6px 8px 4px;
    display: block;
}

.sidebar-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-mid);
    text-decoration: none;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-family: 'Nunito', sans-serif;
    transition: all .18s;
    position: relative;
}

.sidebar-item:hover {
    background: var(--green-pale);
    color: var(--green-dark);
}

.sidebar-item.active {
    background: linear-gradient(135deg, var(--green-pale), #d1fae5);
    color: var(--green-dark);
}

.sidebar-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    bottom: 20%;
    width: 3px;
    background: var(--green-mid);
    border-radius: 0 3px 3px 0;
}

.sidebar-item .si-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--green-pale);
    flex-shrink: 0;
    transition: background .18s;
    font-size: 14px;
    color: var(--green-dark);
}

.sidebar-item:hover .si-icon,
.sidebar-item.active .si-icon {
    background: #c6f6d5;
}

.sidebar-badge {
    margin-left: auto;
    background: var(--accent);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 10px;
}

.sidebar-divider {
    height: 1px;
    background: var(--border);
    margin: 8px 16px;
}

.sidebar-profile {
    margin: 0 16px 20px;
    background: linear-gradient(135deg, var(--green-dark), #1e5c38);
    border-radius: 12px;
    padding: 16px;
}

.sp-ava {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .15);
    border: 2px solid rgba(255, 255, 255, .3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 16px;
    color: white;
    margin-bottom: 10px;
}

.sp-name {
    font-size: 13px;
    font-weight: 800;
    color: white;
    margin-bottom: 2px;
}

.sp-role {
    font-size: 10px;
    color: #a8e6c3;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
}

.sp-stats {
    display: flex;
    gap: 12px;
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 255, 255, .12);
}

.sp-stat { text-align: center; }

.sp-stat strong {
    display: block;
    font-size: 15px;
    font-weight: 900;
    color: white;
}

.sp-stat span {
    font-size: 10px;
    color: rgba(255, 255, 255, .6);
    font-weight: 600;
}

/* Back to buyer button */
.back-buyer-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    background: white;
    text-decoration: none;
    cursor: pointer;
    transition: all .22s;
    position: relative;
    overflow: hidden;
}

.back-buyer-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--green-pale), #d1fae5);
    opacity: 0;
    transition: opacity .22s;
}

.back-buyer-btn:hover {
    border-color: var(--green-main);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.back-buyer-btn:hover::before { opacity: 1; }

.back-buyer-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    flex-shrink: 0;
    background: var(--green-pale);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: var(--green-dark);
    position: relative;
    z-index: 1;
    transition: background .22s;
}

.back-buyer-btn:hover .back-buyer-icon { background: #bbf7d0; }

.back-buyer-text {
    flex: 1;
    position: relative;
    z-index: 1;
}

.back-buyer-label {
    display: block;
    font-size: 12px;
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1.2;
}

.back-buyer-sub {
    display: block;
    font-size: 10px;
    font-weight: 700;
    color: var(--text-muted);
    margin-top: 1px;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.back-buyer-tag {
    font-size: 13px;
    color: var(--text-muted);
    position: relative;
    z-index: 1;
    transition: color .22s;
}

.back-buyer-btn:hover .back-buyer-tag { color: var(--green-main); }

@media(max-width:768px) {
    .seller-sidebar { display: none; }
}
</style>

<aside class="seller-sidebar">

    {{-- Profile card --}}
    <a href="{{ route('seller.profile.view') }}" class="sidebar-profile" style="display:block;text-decoration:none;cursor:pointer;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'" title="Lihat profil toko">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
            <div class="sp-ava">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 2)) }}</div>
            <span style="font-size:10px;color:rgba(255,255,255,.55);font-weight:700;letter-spacing:.5px;display:flex;align-items:center;gap:4px">
                <i class="fa-solid fa-pen" style="font-size:9px"></i> Edit Profil
            </span>
        </div>
        <div class="sp-name">{{ auth()->user()->nama_lengkap ?? 'Penjual' }}</div>
        <div class="sp-role">⭐ Petani Terverifikasi</div>
        <div class="sp-stats">
            <div class="sp-stat"><strong>12</strong><span>Produk</span></div>
            <div class="sp-stat"><strong>24</strong><span>Pesanan</span></div>
            <div class="sp-stat"><strong>4.9</strong><span>Rating</span></div>
        </div>
    </a>

    {{-- Tombol balik ke buyer --}}
    <div style="padding:0 16px 14px;">
        <a href="{{ route('buyer.dashboard') }}" class="back-buyer-btn">
            <span class="back-buyer-icon"><i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i></span>
            <span class="back-buyer-text">
                <span class="back-buyer-label">Kembali ke Marketplace</span>
                <span class="back-buyer-sub">Mode Pembeli</span>
            </span>
            <i class="fa-solid fa-store-slash back-buyer-tag" aria-hidden="true"></i>
        </a>
    </div>

    {{-- Menu Utama --}}
    <div class="sidebar-section">
        <span class="sidebar-label">Utama</span>
        <a href="{{ route('seller.dashboard') }}"
           class="sidebar-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <span class="si-icon"><i class="fa-solid fa-house-chimney" aria-hidden="true"></i></span>
            Dashboard
        </a>
        <a href="#"
           class="sidebar-item">
            <span class="si-icon"><i class="fa-solid fa-box" aria-hidden="true"></i></span>
            Pesanan Masuk
            <span class="sidebar-badge">3</span>
        </a>
        <a href="{{ route('chat.index') }}"
           class="sidebar-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
            <span class="si-icon"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i></span>
            Pesan Chat
        </a>
    </div>

    <div class="sidebar-divider"></div>

    <div class="sidebar-section">
        <span class="sidebar-label">Kelola</span>
        <a href="{{ route('seller.products.index') }}"
           class="sidebar-item {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
            <span class="si-icon"><i class="fa-solid fa-wheat-awn" aria-hidden="true"></i></span>
            Produk Saya
        </a>
        <a href="#"
           class="sidebar-item">
            <span class="si-icon"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
            Jadwal Panen
        </a>
        <a href="#"
           class="sidebar-item">
            <span class="si-icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></span>
            Laporan Penjualan
        </a>
        <a href="#"
           class="sidebar-item">
            <span class="si-icon"><i class="fa-solid fa-wallet" aria-hidden="true"></i></span>
            Keuangan
        </a>
    </div>

    <div class="sidebar-divider"></div>

    <div class="sidebar-section">
        <span class="sidebar-label">Akun</span>
        <a href="{{ route('seller.profile.view') }}"
           class="sidebar-item {{ request()->routeIs('seller.profile.*') ? 'active' : '' }}">
            <span class="si-icon"><i class="fa-solid fa-store" aria-hidden="true"></i></span>
            Profil Toko
        </a>
        <a href="#"
           class="sidebar-item">
            <span class="si-icon"><i class="fa-solid fa-gear" aria-hidden="true"></i></span>
            Pengaturan
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-item">
                <span class="si-icon"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i></span>
                Keluar
            </button>
        </form>
    </div>

</aside>