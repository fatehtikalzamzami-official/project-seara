<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>SEARA – Akses Petani & Pembeli</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #0b2e22;
            --leaf: #3dba7e;
            --gold: #e8c97e;
            --cream: #f5ede0;
            --cream-light: #fffaf2;
            --text: #d6ede3;
            --dark-green: #0b2e22;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            background: var(--bg);
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: .028;
        }

        /* ── PROGRESS BAR ── */
        #pbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            background: var(--leaf);
            z-index: 10000;
            width: 0;
            transition: width .4s ease;
        }

        /* ── SPLASH ── */
        #splash {
            position: fixed;
            inset: 0;
        }

        .phase {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .85s ease;
            pointer-events: none;
        }

        .phase.visible {
            opacity: 1;
            pointer-events: auto;
        }

        /* PHASE 1 – intro wordmark */
        #ph1 {
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        .wordmark {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(2.6rem, 6vw, 4.8rem);
            letter-spacing: .38em;
            text-transform: uppercase;
            color: var(--cream);
            text-shadow: 0 0 60px rgba(61, 186, 126, .22);
            animation: wm-in 1.2s ease both;
        }

        @keyframes wm-in {
            from {
                opacity: 0;
                letter-spacing: .6em;
                filter: blur(6px);
            }

            to {
                opacity: 1;
                letter-spacing: .38em;
                filter: blur(0);
            }
        }

        /* PHASE 3 – SPLIT LAYOUT (langsung setelah splash) */
        #ph3 {
            display: flex;
            flex-direction: row;
            background: var(--bg);
            overflow: hidden;
        }

        /* Konten utama kiri */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5vh 4vw 5vh 5vw;
            gap: 2rem;
            overflow: hidden;
            transition: opacity .5s ease;
        }

        .left-col {
            flex: 1;
            max-width: 460px;
        }

        .brand-row {
            display: flex;
            align-items: baseline;
            gap: .8rem;
            margin-bottom: .4rem;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(2rem, 4vw, 3.4rem);
            letter-spacing: .32em;
            text-transform: uppercase;
            color: var(--cream);
        }

        .brand-dot {
            color: var(--leaf);
            font-size: 1.8rem;
        }

        .brand-sub {
            font-size: .72rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(214, 237, 227, .45);
            margin-bottom: 2rem;
        }

        .hero-headline {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(1.6rem, 3vw, 2.6rem);
            color: var(--cream);
            line-height: 1.25;
            margin-bottom: 1rem;
        }

        .hero-headline em {
            color: var(--gold);
            font-style: normal;
        }

        .hero-body {
            font-size: .85rem;
            color: rgba(214, 237, 227, .65);
            line-height: 1.75;
            max-width: 380px;
            margin-bottom: 2.4rem;
        }

        .cta-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--leaf);
            color: #0b2e22;
            border: none;
            padding: .8rem 2rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: .78rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .25s, transform .25s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary:hover {
            background: #52dda0;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(61, 186, 126, .4);
            color: var(--text);
            padding: .8rem 2rem;
            border-radius: 40px;
            font-size: .78rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: border-color .25s, color .25s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-secondary:hover {
            border-color: var(--leaf);
            color: var(--leaf);
        }

        /* Kolom kanan – kartu produk */
        .right-col {
            min-width: 280px;
            width: clamp(260px, 28vw, 380px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cards-stack {
            position: relative;
            width: 100%;
            max-width: 300px;
            height: 340px;
        }

        .card {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: clamp(120px, 25vw, 175px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .4);
            background: #1a3d2d;
            transition: transform .3s ease;
        }

        .card:hover {
            transform: translateX(-50%) scale(1.03);
        }

        .card-img {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            background: #1a3d2d;
        }

        .card-thumb {
            width: 100%;
            aspect-ratio: 3/4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            background: linear-gradient(160deg, #1a3d2d, #0b2e22);
        }

        .card-info {
            padding: .7rem .85rem .8rem;
            background: rgba(11, 46, 34, .9);
            backdrop-filter: blur(6px);
        }

        .card-name {
            font-size: .75rem;
            font-weight: 600;
            color: var(--cream);
            margin-bottom: .15rem;
        }

        .card-price {
            font-size: .68rem;
            color: var(--leaf);
        }

        .card:nth-child(1) {
            top: 0;
            left: 30%;
            z-index: 3;
        }

        .card:nth-child(2) {
            top: 40px;
            left: 50%;
            z-index: 2;
        }

        .card:nth-child(3) {
            top: 80px;
            left: 70%;
            z-index: 1;
        }

        /* ══ LOGIN PANEL ══ */
        .login-panel {
            width: 0;
            flex-shrink: 0;
            height: 100%;
            background: var(--cream-light);
            box-shadow: -8px 0 32px rgba(0, 0, 0, .3);
            z-index: 15;
            overflow: hidden;
            transition: width .7s cubic-bezier(.2, .9, .4, 1.1);
            border-left: 2px solid rgba(61, 186, 126, .4);
        }

        #ph3.login-active .login-panel {
            width: 440px;
            overflow-y: auto;
        }

        #ph3.login-active .main-content {
            opacity: .35;
            pointer-events: none;
        }

        .login-inner {
            width: 440px;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100%;
        }

        .login-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .login-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 500;
            color: var(--dark-green);
            letter-spacing: -.3px;
        }

        .login-header h2 span {
            color: var(--leaf);
        }

        .login-header p {
            font-size: .85rem;
            color: #4a5b52;
            margin-top: .6rem;
        }

        .input-group {
            margin-bottom: 1.3rem;
        }

        .input-group label {
            display: block;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 600;
            color: #2b5a42;
            margin-bottom: .45rem;
        }

        .input-group input {
            width: 100%;
            background: #fffef7;
            border: 1px solid #d4e2da;
            border-radius: 14px;
            padding: .85rem 1rem;
            font-size: .9rem;
            color: #1a2c24;
            font-family: 'DM Sans', sans-serif;
            transition: all .2s;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--leaf);
            box-shadow: 0 0 0 3px rgba(61, 186, 126, .2);
            background: white;
        }

        .flex-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: .2rem 0 1.8rem 0;
            font-size: .75rem;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: #2b5a42;
            cursor: pointer;
        }

        .checkbox input {
            accent-color: var(--leaf);
            width: 16px;
            height: 16px;
            margin: 0;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--leaf);
            text-decoration: none;
            font-weight: 500;
            transition: .2s;
        }

        .forgot-link:hover {
            color: #2b7a55;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            background: var(--leaf);
            border: none;
            padding: .9rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: .85rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #0b2e22;
            cursor: pointer;
            transition: all .25s;
            margin-bottom: 1rem;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-login:hover {
            background: #52dda0;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(61, 186, 126, .3);
        }

        .divider-or {
            display: flex;
            align-items: center;
            gap: .8rem;
            margin: .5rem 0 1rem;
            font-size: .72rem;
            color: #9ab3a7;
        }

        .divider-or::before,
        .divider-or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #d4e2da;
        }

        .btn-google {
            width: 100%;
            background: white;
            border: 1px solid #d4e2da;
            padding: .8rem;
            border-radius: 14px;
            font-size: .82rem;
            color: #2b5a42;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            margin-bottom: 1.2rem;
        }

        .btn-google:hover {
            border-color: var(--leaf);
            background: #f5fdf9;
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        .register-link {
            text-align: center;
            font-size: .8rem;
            color: #5b6e64;
        }

        .register-link a {
            color: var(--leaf);
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            margin-top: 2rem;
            text-align: center;
        }

        .back-home button {
            background: none;
            border: none;
            color: #7c8f84;
            font-size: .7rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            cursor: pointer;
            transition: color .2s;
            font-weight: 500;
        }

        .back-home button:hover {
            color: var(--dark-green);
        }

        /* ── STAT TICKER ── */
        .stat-ticker {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 38px;
            background: rgba(11, 46, 34, .85);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(61, 186, 126, .18);
            display: flex;
            align-items: center;
            overflow: hidden;
            z-index: 100;
        }

        .ticker-track {
            display: flex;
            gap: 4rem;
            white-space: nowrap;
            animation: ticker 28s linear infinite;
        }

        @keyframes ticker {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .ticker-item {
            font-size: .68rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(214, 237, 227, .5);
        }

        .ticker-item strong {
            color: var(--leaf);
            font-weight: 600;
        }

        /* ── RESPONSIVE ── */
        @media(max-width: 860px) {
            #ph3 {
                flex-direction: column;
            }

            #ph3.login-active .login-panel {
                width: 100%;
                height: auto;
            }

            #ph3.login-active .main-content {
                display: none;
            }

            .main-content {
                flex-direction: column;
                padding: 4vh 5vw 3vh;
                justify-content: center;
            }

            .left-col {
                max-width: 100%;
                order: 2;
            }

            .right-col {
                order: 1;
                min-width: unset;
                width: 100%;
                height: 44vw;
            }

            .card {
                width: clamp(90px, 22vw, 145px);
            }

            .login-inner {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div id="pbar"></div>

    <div id="splash">

        <!-- PHASE 1: Wordmark intro -->
        <div class="phase" id="ph1">
            <div class="wordmark">SEARA</div>
        </div>

        <!-- PHASE 3: Main + Login Panel (langsung setelah fase 1) -->
        <div class="phase" id="ph3">

            <!-- Konten utama -->
            <div class="main-content" id="mainContent">
                <div class="left-col">
                    <div class="brand-row">
                        <span class="brand-name">SEARA</span>
                        <span class="brand-dot">·</span>
                    </div>
                    <div class="brand-sub">Pasar Tani Digital Indonesia</div>
                    <h1 class="hero-headline">
                        Jual & beli hasil tani<br>
                        <em>langsung dari sumbernya.</em>
                    </h1>
                    <p class="hero-body">
                        Platform digital yang mempertemukan petani lokal dengan pembeli secara langsung —
                        tanpa perantara, harga lebih adil, kualitas terjamin dari ladang ke meja makan Anda.
                    </p>
                    <div class="cta-row">
                        <button class="btn-primary" onclick="openLogin()">Masuk / Daftar</button>
                        <button class="btn-secondary" onclick="alert('Jelajahi pasar segera hadir')">Jelajahi
                            Pasar</button>
                    </div>
                </div>

                <div class="right-col">
                    <div class="cards-stack">
                        <div class="card">
                            <div class="card-thumb">🌾</div>
                            <div class="card-info">
                                <div class="card-name">Beras Premium Cianjur</div>
                                <div class="card-price">Rp 14.000 / kg</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-thumb">🥦</div>
                            <div class="card-info">
                                <div class="card-name">Brokoli Organik</div>
                                <div class="card-price">Rp 18.500 / kg</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-thumb">🍅</div>
                            <div class="card-info">
                                <div class="card-name">Tomat Cherry Segar</div>
                                <div class="card-price">Rp 22.000 / kg</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login Panel -->
            <div class="login-panel" id="loginPanel">
                <div class="login-inner">
                    <div class="login-header">
                        <h2>Masuk ke <span>SEARA</span></h2>
                        <p>Akses pasar petani &amp; pembeli langsung</p>
                    </div>

                    <div class="input-group">
                        <label>Email / Nomor Ponsel</label>
                        <input type="email" id="loginEmail" placeholder="contoh@seara.id" autocomplete="email" />
                    </div>
                    <div class="input-group">
                        <label>Kata Sandi</label>
                        <input type="password" id="loginPassword" placeholder="••••••••"
                            autocomplete="current-password" />
                    </div>

                    <div class="flex-options">
                        <label class="checkbox">
                            <input type="checkbox" id="rememberCheck" /> Ingat saya
                        </label>
                        <a href="#" class="forgot-link" id="forgotLink">Lupa sandi?</a>
                    </div>

                    <button class="btn-login" id="doLoginBtn">Masuk ke Dashboard</button>

                    <div class="divider-or">atau</div>

                    <button class="btn-google" id="googleBtn">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4" />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853" />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                fill="#FBBC05" />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335" />
                        </svg>
                        Lanjutkan dengan Google
                    </button>

                    <div class="register-link">
                        Belum punya akun? <a href="#" id="registerRedirect">Daftar sekarang</a>
                    </div>

                    <div class="back-home">
                        <button id="closeLoginBtn">← Kembali ke Beranda</button>
                    </div>
                </div>
            </div>

        </div><!-- /#ph3 -->

    </div><!-- /#splash -->

    <!-- Stat Ticker -->
    <div class="stat-ticker">
        <div class="ticker-track" id="tickerTrack"></div>
    </div>

    <script>
        (function () {
            'use strict';

            const $ = id => document.getElementById(id);
            const ph1 = $('ph1');
            const ph3 = $('ph3');
            const pbar = $('pbar');

            /* ── PROGRESS BAR & SEQUENCE ── */
            let progress = 0;
            function updateProgress(value) {
                if (pbar) {
                    pbar.style.width = value + '%';
                }
            }

            // Mulai dengan progress bar
            updateProgress(10);
            setTimeout(() => updateProgress(35), 400);
            setTimeout(() => updateProgress(68), 1000);
            setTimeout(() => {
                updateProgress(88);
                // Transisi dari ph1 ke ph3
                ph1.classList.remove('visible');
                ph3.classList.add('visible');
                updateProgress(100);
                setTimeout(() => {
                    if (pbar) pbar.style.opacity = '0';
                }, 800);
            }, 1600);
            // Selesai splash, pastikan phase 3 aktif

            /* ── LOGIN PANEL SLIDE ── */
            window.openLogin = function () {
                ph3.classList.add('login-active');
            };

            const closeLoginBtn = $('closeLoginBtn');
            if (closeLoginBtn) {
                closeLoginBtn.addEventListener('click', () => {
                    ph3.classList.remove('login-active');
                });
            }

            const doLoginBtn = $('doLoginBtn');
            if (doLoginBtn) {
                doLoginBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const email = $('loginEmail')?.value.trim();
                    const pass = $('loginPassword')?.value.trim();
                    if (!email || !pass) {
                        alert('Harap isi email dan kata sandi.');
                        return;
                    }
                    alert(`✨ Selamat datang kembali, ${email}!\n(Redirect ke dashboard sesuai peran Anda)`);
                    // Di sini bisa redirect ke route Laravel: window.location.href = '/dashboard';
                });
            }

            // Demo button Google & register
            const googleBtn = $('googleBtn');
            if (googleBtn) {
                googleBtn.addEventListener('click', () => {
                    alert('Fitur login dengan Google akan tersedia segera.');
                });
            }
            const registerRedirect = $('registerRedirect');
            if (registerRedirect) {
                registerRedirect.addEventListener('click', (e) => {
                    e.preventDefault();
                    alert('Halaman pendaftaran anggota SEARA segera hadir.');
                });
            }
            const forgotLink = $('forgotLink');
            if (forgotLink) {
                forgotLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    alert('Kirim instruksi reset password ke email terdaftar.');
                });
            }

            /* ── STAT TICKER ── */
            const stats = [
                { label: 'Petani Aktif', val: '12.400+' },
                { label: 'Transaksi Hari Ini', val: '3.218' },
                { label: 'Produk Tersedia', val: '8.200+' },
                { label: 'Provinsi Terjangkau', val: '27' },
                { label: 'Nilai Transaksi Bulan Ini', val: 'Rp 4,2M' },
                { label: 'Rating Kepuasan', val: '4.9 / 5' },
            ];
            const doubled = [...stats, ...stats];
            const track = $('tickerTrack');
            if (track) {
                doubled.forEach(s => {
                    const el = document.createElement('span');
                    el.className = 'ticker-item';
                    el.innerHTML = `${s.label} <strong>${s.val}</strong>`;
                    track.appendChild(el);
                });
            }
        })();
    </script>
</body>

</html>