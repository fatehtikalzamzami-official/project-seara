@extends('layouts.app')

@section('title', ($sellerProfile->nama_toko ?? 'Profil Toko') . ' — SEARA')

@section('hide-footer')@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; }

/* LAYOUT */
.page-shell {
  max-width: 1160px; margin: 0 auto;
  padding: clamp(1.25rem,3vw,2rem) clamp(1rem,3vw,2rem);
  display: grid; grid-template-columns: 320px 1fr;
  gap: clamp(1rem,2vw,1.5rem); align-items: start;
}
@media (max-width: 840px) { .page-shell { grid-template-columns: 1fr; } }

/* HERO CARD */
.hero-card {
  background: var(--green-dark); border-radius: 20px; overflow: hidden;
  border: 0.5px solid rgba(255,255,255,0.07);
  position: sticky; top: 74px;
}
@media (max-width: 840px) { .hero-card { position: static; border-radius: 16px; } }

.hero-top {
  padding: 1.5rem 1.5rem 1.75rem; background: rgba(0,0,0,0.2); position: relative;
}
.hero-top::after {
  content: ''; position: absolute; bottom: 0; left: 1.5rem; right: 1.5rem;
  height: 0.5px; background: rgba(255,255,255,0.08);
}
.hero-avatar {
  width: 76px; height: 76px; border-radius: 50%; background: var(--green-mid);
  border: 2.5px solid rgba(255,255,255,0.15);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Playfair Display',serif; font-size: 22px; font-weight: 700;
  color: white; margin-bottom: 14px; overflow: hidden;
}
.hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
.hero-name {
  font-family: 'Playfair Display',serif; font-size: 21px; font-weight: 700; color: #fff;
  letter-spacing: -0.025em; margin-bottom: 10px; line-height: 1.2;
}
.badge-row { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 12px; }
.badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 100px; }
.badge-verified { background: rgba(240,184,48,0.16); color: #f0c050; border: 0.5px solid rgba(240,184,48,0.28); }
.badge-cat { background: rgba(255,255,255,0.09); color: rgba(255,255,255,0.78); border: 0.5px solid rgba(255,255,255,0.13); }
.badge-open { background: rgba(74,200,120,0.15); color: #6ee89c; border: 0.5px solid rgba(74,200,120,0.28); }
.badge-closed { background: rgba(220,80,80,0.15); color: #f09090; border: 0.5px solid rgba(220,80,80,0.28); }
.hero-meta { font-size: 12px; color: rgba(255,255,255,0.38); display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.hero-meta-dot { width: 3px; height: 3px; border-radius: 50%; background: rgba(255,255,255,0.2); flex-shrink: 0; }

/* STATS */
.stats-strip { display: grid; grid-template-columns: repeat(3,1fr); border-top: 0.5px solid rgba(255,255,255,0.06); }
.stat-cell { padding: 15px 8px; text-align: center; border-right: 0.5px solid rgba(255,255,255,0.06); }
.stat-cell:last-child { border-right: none; }
.stat-val { font-family: 'Playfair Display',serif; font-size: 20px; font-weight: 700; color: var(--green-pale); line-height: 1; margin-bottom: 4px; }
.stat-lbl { font-size: 10px; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.06em; }

/* CTA */
.hero-cta { padding: 12px 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; background: rgba(0,0,0,0.2); border-top: 0.5px solid rgba(255,255,255,0.05); }
.btn-chat, .btn-wa {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  padding: 11px 8px; border-radius: 10px; font-size: 13px; font-weight: 600;
  font-family: 'Nunito',sans-serif; border: none; cursor: pointer;
  transition: opacity 0.15s, transform 0.1s; text-decoration: none;
}
.btn-chat { background: var(--accent); color: #fff; }
.btn-chat:hover { opacity: 0.88; }
.btn-wa { background: #22c55e; color: #fff; }
.btn-wa:hover { opacity: 0.88; }
.btn-chat:active, .btn-wa:active { transform: scale(0.97); }
.btn-chat i, .btn-wa i { font-size: 15px; }

/* INFO ROWS */
.info-block { padding: 6px 14px 14px; border-top: 0.5px solid rgba(255,255,255,0.05); }
.info-row { display: flex; align-items: center; gap: 10px; padding: 9px 0; border-bottom: 0.5px solid rgba(255,255,255,0.05); }
.info-row:last-child { border-bottom: none; }
.info-icon { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.info-icon i { font-size: 15px; color: var(--green-pale); }
.info-text { flex: 1; min-width: 0; }
.info-label { font-size: 10px; color: rgba(255,255,255,0.32); margin-bottom: 1px; text-transform: uppercase; letter-spacing: 0.04em; }
.info-value { font-size: 13px; color: rgba(255,255,255,0.80); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.info-sub { font-size: 11px; color: rgba(255,255,255,0.30); margin-top: 1px; }
.info-action { font-size: 12px; color: var(--green-light); font-weight: 600; white-space: nowrap; flex-shrink: 0; }
.online-dot { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 600; color: #6ee89c; margin-top: 2px; }
.online-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #4ade80; display: inline-block; }

/* MAIN */
.main-col { display: flex; flex-direction: column; gap: 1.25rem; }

/* SECTION CARD */
.section-card { background: white; border-radius: 16px; border: 0.5px solid var(--border); overflow: hidden; }
.section-card-header { padding: 1rem 1.25rem 0.8rem; border-bottom: 0.5px solid var(--green-pale); display: flex; align-items: center; justify-content: space-between; }
.section-card-title { font-family: 'Playfair Display',serif; font-size: 14px; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 7px; }
.section-card-title i { font-size: 16px; color: var(--green-main); }
.section-card-count { font-size: 11px; font-weight: 600; background: var(--green-pale); color: var(--green-dark); padding: 3px 10px; border-radius: 100px; }
.section-card-body { padding: 1rem 1.25rem; }

/* ABOUT */
.about-text { font-size: 14px; color: var(--text-mid); line-height: 1.8; }

/* PRODUCT GRID */
.product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 9px; }
.prod-card { background: var(--green-bg); border: 0.5px solid var(--border); border-radius: 10px; padding: 10px; display: block; color: inherit; transition: transform 0.15s, box-shadow 0.15s; text-decoration: none; }
.prod-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.prod-thumb { width: 100%; aspect-ratio: 1; background: var(--green-pale); border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 8px; overflow: hidden; }
.prod-thumb img { width: 100%; height: 100%; object-fit: cover; }
.prod-thumb i { font-size: 24px; color: var(--green-main); }
.prod-name { font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 3px; line-height: 1.3; }
.prod-price { font-size: 12px; color: var(--accent); font-weight: 700; }
.prod-stock { font-size: 10px; color: var(--text-muted); margin-top: 3px; }
.prod-organic { display: inline-flex; align-items: center; gap: 3px; font-size: 9px; font-weight: 700; background: var(--green-pale); color: var(--green-dark); padding: 2px 6px; border-radius: 100px; margin-top: 4px; }
.prod-more { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; background: var(--green-pale); border-color: var(--border); cursor: pointer; }
.prod-more .prod-thumb { background: var(--green-pale); width: 100%; }
.prod-more .prod-thumb i { color: var(--green-main); font-size: 22px; }
.prod-more-label { font-size: 11px; font-weight: 700; color: var(--green-dark); text-align: center; }

/* RATING */
.rating-summary { display: flex; align-items: center; gap: 16px; padding-bottom: 12px; border-bottom: 0.5px solid var(--border); margin-bottom: 12px; }
.rating-score { font-family: 'Playfair Display',serif; font-size: 44px; font-weight: 800; color: var(--text-dark); line-height: 1; }
.rating-stars { color: #e8a020; font-size: 19px; margin-bottom: 4px; letter-spacing: 1px; }
.rating-count { font-size: 12px; color: var(--text-muted); }
.rating-empty { text-align: center; padding: 14px 0; }
.rating-empty i { font-size: 26px; color: var(--border); display: block; margin-bottom: 6px; }
.rating-empty p { font-size: 12px; color: var(--text-muted); }

/* HOURS */
.hours-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 8px; }
.hour-item { background: var(--green-bg); border: 0.5px solid var(--border); border-radius: 10px; padding: 10px 12px; }
.hour-item.today { background: var(--green-pale); border-color: var(--green-light); }
.hour-day { font-size: 12px; font-weight: 700; color: var(--text-mid); margin-bottom: 2px; display: flex; align-items: center; gap: 5px; }
.hour-item.today .hour-day { color: var(--green-dark); }
.today-pip { font-size: 9px; background: var(--green-main); color: #fff; padding: 1px 5px; border-radius: 100px; font-weight: 700; }
.hour-time { font-size: 11px; color: var(--text-muted); }
.hour-badge { display: inline-block; font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 100px; margin-top: 5px; }
.hour-open { background: var(--green-pale); color: var(--green-dark); }
.hour-closed { background: #f4f4f4; color: var(--text-muted); }

/* SHIPPING */
.ship-chips { display: flex; flex-wrap: wrap; gap: 7px; }
.ship-chip { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; background: var(--green-pale); color: var(--green-dark); padding: 5px 12px; border-radius: 100px; border: 0.5px solid var(--border); }
.ship-chip i { font-size: 12px; }

/* ANIMATIONS */
@keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
.hero-card { animation: fadeUp 0.38s 0.04s both; }
.main-col > *:nth-child(1) { animation: fadeUp 0.38s 0.10s both; }
.main-col > *:nth-child(2) { animation: fadeUp 0.38s 0.16s both; }
.main-col > *:nth-child(3) { animation: fadeUp 0.38s 0.22s both; }
.main-col > *:nth-child(4) { animation: fadeUp 0.38s 0.28s both; }
.main-col > *:nth-child(5) { animation: fadeUp 0.38s 0.34s both; }
</style>
@endpush

@section('content')
<div class="page-shell">

  {{-- ══ SIDEBAR / HERO CARD ══ --}}
  <aside>
    <div class="hero-card">

      <div class="hero-top">
        <div class="hero-avatar">
          @if($sellerProfile->foto_toko)
            <img src="{{ asset('storage/' . $sellerProfile->foto_toko) }}" alt="{{ $sellerProfile->nama_toko }}">
          @else
            {{ strtoupper(substr($sellerProfile->nama_toko ?? 'T', 0, 2)) }}
          @endif
        </div>

        <div class="hero-name">{{ $sellerProfile->nama_toko ?? 'Nama Toko' }}</div>

        <div class="badge-row">
          @if($sellerProfile->is_verified ?? false)
            <span class="badge badge-verified">
              <i class="ti ti-shield-check" style="font-size:11px"></i> Petani Terverifikasi
            </span>
          @endif
          @if($sellerProfile->kategori_utama)
            <span class="badge badge-cat">{{ $sellerProfile->kategori_utama }}</span>
          @endif
          @if($sellerProfile->is_open)
            <span class="badge badge-open">● Buka</span>
          @else
            <span class="badge badge-closed">● Tutup</span>
          @endif
        </div>

        <div class="hero-meta">
          @if($sellerProfile->created_at)
            <span>Bergabung {{ $sellerProfile->created_at->translatedFormat('M Y') }}</span>
          @endif
          @if($sellerProfile->kota_kabupaten)
            <span class="hero-meta-dot"></span>
            <span>{{ $sellerProfile->kota_kabupaten }}@if($sellerProfile->provinsi), {{ $sellerProfile->provinsi }}@endif</span>
          @endif
        </div>
      </div>

      <div class="stats-strip">
        <div class="stat-cell">
          <div class="stat-val">{{ $harvests->count() ?? 0 }}</div>
          <div class="stat-lbl">Produk</div>
        </div>
        <div class="stat-cell">
          <div class="stat-val">{{ $sellerProfile->total_transaksi ?? 0 }}</div>
          <div class="stat-lbl">Pesanan</div>
        </div>
        <div class="stat-cell">
          <div class="stat-val">{{ number_format($sellerProfile->rating ?? 0, 1) }} ★</div>
          <div class="stat-lbl">Rating</div>
        </div>
      </div>

      <div class="hero-cta">
        @auth
          <a href="{{ route('chat.show', $seller->user_id) }}" class="btn-chat">
            <i class="ti ti-message-circle"></i> Chat Petani
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-chat">
            <i class="ti ti-message-circle"></i> Chat Petani
          </a>
        @endauth

        @if($seller->user->no_whatsapp ?? null)
          <a href="https://wa.me/62{{ ltrim($seller->user->no_whatsapp, '0') }}?text=Halo%20{{ urlencode($sellerProfile->nama_toko) }}%2C%20saya%20melihat%20toko%20Anda%20di%20SEARA"
             target="_blank" class="btn-wa">
            <i class="ti ti-brand-whatsapp"></i> WhatsApp
          </a>
        @else
          <span class="btn-wa" style="opacity:0.4;cursor:default;">
            <i class="ti ti-brand-whatsapp"></i> WhatsApp
          </span>
        @endif
      </div>

      <div class="info-block">
        <div class="info-row">
          <div class="info-icon"><i class="ti ti-user"></i></div>
          <div class="info-text">
            <div class="info-label">Nama Petani</div>
            <div class="info-value">{{ $seller->user->nama_lengkap ?? '-' }}</div>
            <div class="online-dot">Online</div>
          </div>
        </div>

        @if($sellerProfile->kota_kabupaten || $sellerProfile->alamat_toko)
        <div class="info-row">
          <div class="info-icon"><i class="ti ti-map-pin"></i></div>
          <div class="info-text">
            <div class="info-label">Lokasi</div>
            <div class="info-value">{{ $sellerProfile->kota_kabupaten ?? '' }}@if($sellerProfile->provinsi), {{ $sellerProfile->provinsi }}@endif</div>
            @if($sellerProfile->alamat_toko)
              <div class="info-sub">{{ $sellerProfile->alamat_toko }}</div>
            @endif
          </div>
        </div>
        @endif

        @if($seller->user->no_whatsapp ?? null)
        <div class="info-row">
          <div class="info-icon"><i class="ti ti-brand-whatsapp"></i></div>
          <div class="info-text">
            <div class="info-label">WhatsApp</div>
            <div class="info-value">{{ $seller->user->no_whatsapp }}</div>
          </div>
          <a href="https://wa.me/62{{ ltrim($seller->user->no_whatsapp, '0') }}" target="_blank" class="info-action">Hubungi →</a>
        </div>
        @endif

        @if($sellerProfile->verified_at ?? null)
        <div class="info-row">
          <div class="info-icon"><i class="ti ti-shield-check"></i></div>
          <div class="info-text">
            <div class="info-label">Verifikasi SEARA</div>
            <div class="info-value" style="color:#6ee89c;">Terverifikasi {{ $sellerProfile->verified_at->translatedFormat('d M Y') }}</div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </aside>

  {{-- ══ MAIN CONTENT ══ --}}
  <main class="main-col">

    {{-- TENTANG TOKO --}}
    @if($sellerProfile->deskripsi_toko)
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-card-title"><i class="ti ti-info-circle"></i> Tentang Toko</div>
      </div>
      <div class="section-card-body">
        <p class="about-text">{{ $sellerProfile->deskripsi_toko }}</p>
      </div>
    </div>
    @endif

    {{-- PRODUK --}}
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-card-title"><i class="ti ti-basket"></i> Produk Tersedia</div>
        <span class="section-card-count">{{ $harvests->count() }} item</span>
      </div>
      <div class="section-card-body">
        <div class="product-grid">
          @forelse($harvests->take(5) as $harvest)
            <a href="{{ route('buyer.product.show', $harvest->id) }}" class="prod-card">
              <div class="prod-thumb">
                @if($harvest->product->foto ?? null)
                  <img src="{{ asset('storage/' . $harvest->product->foto) }}" alt="{{ $harvest->product->nama_produk }}">
                @else
                  {{ $harvest->product->emoji ?? '🌿' }}
                @endif
              </div>
              <div class="prod-name">{{ $harvest->product->nama_produk ?? '-' }}</div>
              <div class="prod-price">Rp {{ number_format($harvest->price_per_unit, 0, ',', '.') }}/{{ $harvest->product->satuan ?? 'kg' }}</div>
              <div class="prod-stock">Stok: {{ $harvest->remaining_stock }} {{ $harvest->product->satuan ?? 'kg' }}</div>
              @if($harvest->is_organic)
                <span class="prod-organic"><i class="ti ti-leaf" style="font-size:9px"></i> Organik</span>
              @endif
            </a>
          @empty
            <p style="color:var(--text-muted);font-size:13px;grid-column:1/-1;">Belum ada produk tersedia.</p>
          @endforelse

          @if($harvests->count() > 5)
            <div class="prod-card prod-more">
              <div class="prod-thumb"><i class="ti ti-dots"></i></div>
              <div class="prod-more-label">+{{ $harvests->count() - 5 }} produk lagi</div>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ULASAN --}}
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-card-title"><i class="ti ti-star"></i> Ulasan Pembeli</div>
        <span class="section-card-count">{{ $sellerProfile->total_ulasan ?? 0 }} ulasan</span>
      </div>
      <div class="section-card-body">
        @if(($sellerProfile->rating ?? 0) > 0)
          <div class="rating-summary">
            <div class="rating-score">{{ number_format($sellerProfile->rating, 1) }}</div>
            <div>
              <div class="rating-stars">
                @for($i = 1; $i <= 5; $i++)
                  {{ $i <= round($sellerProfile->rating) ? '★' : '☆' }}
                @endfor
              </div>
              <div class="rating-count">Berdasarkan {{ $sellerProfile->total_ulasan ?? 0 }} ulasan pembeli</div>
            </div>
          </div>
        @endif
        <div class="rating-empty">
          <i class="ti ti-message-circle"></i>
          <p>Detail ulasan belum tersedia. Periksa kembali nanti.</p>
        </div>
      </div>
    </div>

    {{-- JAM OPERASIONAL --}}
    @if($sellerProfile->jam_operasional ?? null)
    @php
      $jamOps = is_array($sellerProfile->jam_operasional)
        ? $sellerProfile->jam_operasional
        : json_decode($sellerProfile->jam_operasional, true);
      $hariIni = strtolower(now()->locale('id')->dayName);
    @endphp
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-card-title"><i class="ti ti-clock"></i> Jam Operasional</div>
      </div>
      <div class="section-card-body">
        <div class="hours-grid">
          @foreach($jamOps as $hari => $jam)
            @php $isToday = $hari === $hariIni; @endphp
            <div class="hour-item {{ $isToday ? 'today' : '' }}">
              <div class="hour-day">
                {{ ucfirst($hari) }}
                @if($isToday)<span class="today-pip">Hari ini</span>@endif
              </div>
              <div class="hour-time">{{ $jam === 'Tutup' ? '-' : $jam }}</div>
              <span class="hour-badge {{ $jam === 'Tutup' ? 'hour-closed' : 'hour-open' }}">
                {{ $jam === 'Tutup' ? 'Tutup' : 'Buka' }}
              </span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    {{-- PENGIRIMAN --}}
    @if($sellerProfile->metode_pengiriman ?? null)
    @php
      $metode = is_array($sellerProfile->metode_pengiriman)
        ? $sellerProfile->metode_pengiriman
        : json_decode($sellerProfile->metode_pengiriman, true);
    @endphp
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-card-title"><i class="ti ti-truck"></i> Layanan Pengiriman</div>
      </div>
      <div class="section-card-body">
        <div class="ship-chips">
          @foreach($metode as $m)
            <span class="ship-chip"><i class="ti ti-check"></i> {{ $m }}</span>
          @endforeach
        </div>
      </div>
    </div>
    @endif

  </main>
</div>
@endsection