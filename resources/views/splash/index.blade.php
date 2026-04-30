<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>SEARA – Pasar Tani Digital Indonesia</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=DM+Sans:wght@300;400;500;600&display=swap"
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
            --bg: #081f17;
            --bg2: #0d2b1e;
            --leaf: #3dba7e;
            --leaf2: #52dda0;
            --gold: #e8c97e;
            --cream: #f5ede0;
            --cream-lt: #fffaf2;
            --text: #d6ede3;
            --muted: rgba(214, 237, 227, .5);
            --panel-bg: #f7faf8;
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

        /* ─── GRAIN OVERLAY ─── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: .025;
        }

        /* ─── BACKGROUND PATTERN ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 70% 60% at 15% 20%, rgba(61, 186, 126, .08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 88% 80%, rgba(61, 186, 126, .06) 0%, transparent 55%),
                url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Ccircle cx='40' cy='40' r='1.2' fill='%233dba7e' fill-opacity='0.09'/%3E%3Ccircle cx='0' cy='0' r='1.2' fill='%233dba7e' fill-opacity='0.09'/%3E%3Ccircle cx='80' cy='0' r='1.2' fill='%233dba7e' fill-opacity='0.09'/%3E%3Ccircle cx='0' cy='80' r='1.2' fill='%233dba7e' fill-opacity='0.09'/%3E%3Ccircle cx='80' cy='80' r='1.2' fill='%233dba7e' fill-opacity='0.09'/%3E%3Cline x1='0' y1='40' x2='80' y2='40' stroke='%233dba7e' stroke-opacity='0.04' stroke-width='0.5'/%3E%3Cline x1='40' y1='0' x2='40' y2='80' stroke='%233dba7e' stroke-opacity='0.04' stroke-width='0.5'/%3E%3C/g%3E%3C/svg%3E");
        }

        /* ─── PROGRESS BAR ─── */
        #pbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--leaf), var(--gold));
            z-index: 10000;
            width: 0;
            transition: width .4s ease;
        }

        /* ─── SPLASH WRAPPER ─── */
        #splash {
            position: fixed;
            inset: 0;
            z-index: 1;
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

        /* PHASE 1 – wordmark */
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
            letter-spacing: .42em;
            text-transform: uppercase;
            color: var(--cream);
            animation: wm-in 1.2s ease both;
        }

        @keyframes wm-in {
            from {
                opacity: 0;
                letter-spacing: .65em;
                filter: blur(8px);
            }

            to {
                opacity: 1;
                letter-spacing: .42em;
                filter: blur(0);
            }
        }

        /* ─── PHASE 3 LAYOUT ─── */
        #ph3 {
            display: flex;
            flex-direction: row;
            background: var(--bg);
            overflow: hidden;
        }

        /* ─ LEFT CONTENT ─ */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5vh 3vw 5vh 5vw;
            gap: 1.5rem;
            overflow: hidden;
            transition: opacity .5s ease;
            position: relative;
            z-index: 2;
        }

        .left-col {
            flex: 0 0 auto;
            width: min(460px, 48%);
        }

        .brand-row {
            display: flex;
            align-items: baseline;
            gap: .7rem;
            margin-bottom: .3rem;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(1.8rem, 3.2vw, 3rem);
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--cream);
        }

        .brand-dot {
            color: var(--leaf);
            font-size: 1.6rem;
            line-height: 1;
        }

        .brand-sub {
            font-size: .68rem;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1.8rem;
        }

        /* ─ ANIMATED HEADLINE ─ */
        .hero-headline {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(1.55rem, 2.6vw, 2.5rem);
            color: var(--cream);
            line-height: 1.28;
            margin-bottom: 1rem;
            min-height: 3.6em;
        }

        .hero-headline .static {
            display: block;
        }

        .hero-headline .rotating-wrap {
            display: inline-block;
            overflow: hidden;
            vertical-align: bottom;
        }

        .rotating-text {
            display: block;
            color: var(--gold);
            animation: slide-word 0s ease both;
            line-height: 1.28;
        }

        .rotating-text.enter {
            animation: word-in .55s cubic-bezier(.2, .9, .4, 1) both;
        }

        .rotating-text.exit {
            animation: word-out .4s cubic-bezier(.4, 0, 1, 1) both;
        }

        @keyframes word-in {
            from {
                opacity: 0;
                transform: translateY(110%);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes word-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-110%);
            }
        }

        .hero-body {
            font-size: .82rem;
            color: rgba(214, 237, 227, .6);
            line-height: 1.8;
            max-width: 360px;
            margin-bottom: 2.2rem;
            font-weight: 300;
        }

        .cta-row {
            display: flex;
            gap: .85rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--leaf);
            color: #081f17;
            border: none;
            padding: .75rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: .75rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .25s;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 0 0 0 rgba(61, 186, 126, 0);
        }

        .btn-primary:hover {
            background: var(--leaf2);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(61, 186, 126, .3);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(61, 186, 126, .3);
            color: var(--muted);
            padding: .75rem 1.8rem;
            border-radius: 40px;
            font-size: .75rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .25s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-secondary:hover {
            border-color: var(--leaf);
            color: var(--leaf);
        }

        /* ─ CARD STACK ─ */
        .right-col {
            flex: 0 0 auto;
            width: clamp(280px, 36vw, 480px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cards-stack {
            position: relative;
            width: 100%;
            height: 380px;
        }

        .card {
            position: absolute;
            /* JS handles transform */
            width: clamp(130px, 14vw, 175px);
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .09);
            background: #132e21;
            transform-origin: center bottom;
            transition:
                transform .9s cubic-bezier(.25, .9, .35, 1.05),
                opacity .9s ease,
                box-shadow .4s ease;
            will-change: transform, opacity;
            cursor: default;
        }

        .card-thumb {
            width: 100%;
            aspect-ratio: 3/4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            background: linear-gradient(150deg, #1a3d2b, #0d2418);
        }

        .card-info {
            padding: .65rem .85rem .75rem;
            background: rgba(9, 30, 20, .92);
            backdrop-filter: blur(6px);
        }

        .card-name {
            font-size: .72rem;
            font-weight: 600;
            color: var(--cream);
            margin-bottom: .15rem;
        }

        .card-price {
            font-size: .65rem;
            color: var(--leaf);
        }

        /* ─── LOGIN PANEL ─── */
        .login-panel {
            width: 0;
            flex-shrink: 0;
            height: 100%;
            overflow: hidden;
            transition: width .75s cubic-bezier(.2, .9, .4, 1.05);
            position: relative;
            z-index: 15;
        }

        #ph3.login-active .login-panel {
            width: 460px;
            overflow-y: auto;
        }

        #ph3.login-active .main-content {
            opacity: .25;
            pointer-events: none;
        }

        .login-inner {
            width: 460px;
            min-height: 100%;
            background: var(--panel-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 2.4rem;
            border-left: 1px solid rgba(61, 186, 126, .2);
            box-shadow: -12px 0 48px rgba(0, 0, 0, .35);
        }

        /* ── badge ── */
        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(61, 186, 126, .1);
            border: 1px solid rgba(61, 186, 126, .25);
            border-radius: 40px;
            padding: .32rem .9rem;
            font-size: .65rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #1e6645;
            font-weight: 700;
            margin-bottom: 1.4rem;
            width: fit-content;
        }

        .login-badge i {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--leaf);
            animation: pulse-dot 1.8s ease infinite;
            flex-shrink: 0;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(1.5);
            }
        }

        /* ── header ── */
        .login-header {
            margin-bottom: 1.8rem;
        }

        .login-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.1rem;
            font-weight: 500;
            color: #0e2a1c;
            letter-spacing: -.4px;
            line-height: 1.15;
            margin-bottom: .5rem;
        }

        .login-header h2 span {
            color: var(--leaf);
        }

        .login-header p {
            font-size: .8rem;
            color: #5a7566;
            line-height: 1.5;
        }

        /* ── role tabs ── */
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .5rem;
            margin-bottom: 1.8rem;
            background: #edf2ef;
            border-radius: 16px;
            padding: .4rem;
        }

        .role-tab {
            padding: .65rem .5rem;
            border-radius: 12px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            font-weight: 600;
            color: #5a7566;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
        }

        .role-tab .t-icon {
            font-size: 1.1rem;
        }

        .role-tab.active {
            background: white;
            color: #0e2a1c;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .1);
        }

        /* ── divider ── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: .8rem;
            margin-bottom: 1.4rem;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #dce8e1;
        }

        .form-divider span {
            font-size: .68rem;
            color: #8ea899;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        /* ── google btn ── */
        .btn-google {
            width: 100%;
            background: white;
            border: 1.5px solid #dce8e1;
            padding: .78rem;
            border-radius: 14px;
            font-size: .8rem;
            color: #2b4d3a;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            margin-bottom: 1.4rem;
        }

        .btn-google:hover {
            border-color: var(--leaf);
            background: #f4fdf8;
            transform: translateY(-1px);
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        /* ── input field ── */
        .field {
            margin-bottom: 1rem;
        }

        .field label {
            display: block;
            font-size: .67rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-weight: 700;
            color: #2e5c43;
            margin-bottom: .45rem;
        }

        .field-inner {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: .9rem;
            pointer-events: none;
            opacity: .4;
        }

        .field input {
            width: 100%;
            background: white;
            border: 1.5px solid #dce8e1;
            border-radius: 14px;
            padding: .82rem 1rem .82rem 2.7rem;
            font-size: .88rem;
            color: #1a2e24;
            font-family: 'DM Sans', sans-serif;
            transition: all .2s;
        }

        .field input:focus {
            outline: none;
            border-color: var(--leaf);
            box-shadow: 0 0 0 3.5px rgba(61, 186, 126, .15);
            background: #fff;
        }

        .field input::placeholder {
            color: #b0c4ba;
        }

        /* ── password field ── */
        .pwd-row {
            position: relative;
        }

        .pwd-row input {
            padding-right: 5rem;
        }

        .toggle-pwd {
            position: absolute;
            right: .85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: .72rem;
            font-weight: 600;
            color: #5a7566;
            font-family: 'DM Sans', sans-serif;
            padding: .2rem .4rem;
            border-radius: 6px;
            transition: color .2s;
        }

        .toggle-pwd:hover {
            color: #1e6645;
        }

        /* strength bar */
        .strength-bar {
            height: 3px;
            border-radius: 4px;
            background: #e4ede9;
            margin-top: .5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width .4s, background .4s;
        }

        /* ── options row ── */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: .6rem 0 1.4rem;
            font-size: .75rem;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: .45rem;
            color: #4a6459;
            cursor: pointer;
        }

        .check-label input {
            accent-color: var(--leaf);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .forgot {
            color: var(--leaf);
            text-decoration: none;
            font-weight: 600;
            font-size: .74rem;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        /* ── login CTA ── */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #3dba7e 0%, #2da06c 100%);
            border: none;
            padding: .9rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: .82rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #fff;
            cursor: pointer;
            transition: all .25s;
            margin-bottom: 1rem;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 4px 20px rgba(61, 186, 126, .25);
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 55%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .18), transparent);
            animation: shimmer 2.8s infinite;
        }

        @keyframes shimmer {
            to {
                left: 160%;
            }
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(61, 186, 126, .35);
            background: linear-gradient(135deg, #52dda0 0%, #3dba7e 100%);
        }

        /* ── register link ── */
        .reg-row {
            text-align: center;
            font-size: .78rem;
            color: #6b8378;
        }

        .reg-row a {
            color: var(--leaf);
            font-weight: 700;
            text-decoration: none;
        }

        .reg-row a:hover {
            text-decoration: underline;
        }

        /* ── trust row ── */
        .trust-row {
            display: flex;
            justify-content: center;
            gap: 1.4rem;
            margin-top: 1.6rem;
            padding-top: 1.4rem;
            border-top: 1px solid #e4ede9;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .63rem;
            color: #8ea899;
            letter-spacing: .04em;
        }

        .trust-item .ti {
            font-size: .85rem;
        }

        /* ── back home ── */
        .back-home {
            margin-top: 1.8rem;
            text-align: center;
        }

        .back-home button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: .7rem;
            color: #8ea899;
            font-family: 'DM Sans', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: color .2s;
            font-weight: 500;
            letter-spacing: .04em;
        }

        .back-home button:hover {
            color: #0e2a1c;
        }

        /* ─── STAT TICKER ─── */
        .stat-ticker {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 36px;
            background: rgba(8, 31, 23, .9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(61, 186, 126, .15);
            display: flex;
            align-items: center;
            overflow: hidden;
            z-index: 100;
        }

        .ticker-track {
            display: flex;
            gap: 4rem;
            white-space: nowrap;
            animation: ticker 30s linear infinite;
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
            font-size: .65rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(214, 237, 227, .4);
        }

        .ticker-item strong {
            color: var(--leaf);
            font-weight: 700;
        }

        .ticker-sep {
            color: rgba(61, 186, 126, .3);
            margin: 0 .5rem;
        }

        /* ─── RESPONSIVE ─── */
        @media(max-width:900px) {
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
                padding: 3vh 5vw 2vh;
                justify-content: center;
            }

            .left-col {
                width: 100%;
                order: 2;
            }

            .right-col {
                order: 1;
                width: 100%;
                height: 45vw;
                min-width: unset;
            }

            .login-inner {
                width: 100%;
                max-width: 420px;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>
    <div id="pbar"></div>

    <div id="splash">

        <!-- Phase 1: wordmark -->
        <div class="phase" id="ph1">
            <div class="wordmark">SEARA</div>
        </div>

        <!-- Phase 3: main UI -->
        <div class="phase" id="ph3">

            <!-- Main content -->
            <div class="main-content" id="mainContent">
                <div class="left-col">
                    <div class="brand-row">
                        <span class="brand-name">SEARA</span>
                        <span class="brand-dot">·</span>
                    </div>
                    <div class="brand-sub">Pasar Tani Digital Indonesia</div>

                    <h1 class="hero-headline">
                        <span class="static">Jual &amp; beli hasil tani</span>
                        <span class="rotating-wrap">
                            <span class="rotating-text" id="rotText">langsung dari sumbernya.</span>
                        </span>
                    </h1>

                    <p class="hero-body">
                        Platform digital yang mempertemukan petani lokal dengan pembeli —
                        tanpa perantara, harga lebih adil, kualitas terjamin dari ladang ke meja makan Anda.
                    </p>

                    <div class="cta-row">
                        <button class="btn-primary" onclick="openLogin()">Masuk / Daftar</button>
                        <button class="btn-secondary" onclick="alert('Segera hadir!')">Jelajahi Pasar</button>
                    </div>
                </div>

                <!-- Card stack -->
                <div class="right-col">
                    <div class="cards-stack" id="cardsStack">
                        <div class="card" data-idx="0">
                            <div class="card-thumb">🌾</div>
                            <div class="card-info">
                                <div class="card-name">Beras Premium Cianjur</div>
                                <div class="card-price">Rp 14.000 / kg</div>
                            </div>
                        </div>
                        <div class="card" data-idx="1">
                            <div class="card-thumb">🥦</div>
                            <div class="card-info">
                                <div class="card-name">Brokoli Organik Bandung</div>
                                <div class="card-price">Rp 18.500 / kg</div>
                            </div>
                        </div>
                        <div class="card" data-idx="2">
                            <div class="card-thumb">🍅</div>
                            <div class="card-info">
                                <div class="card-name">Tomat Cherry Segar</div>
                                <div class="card-price">Rp 22.000 / kg</div>
                            </div>
                        </div>
                        <div class="card" data-idx="3">
                            <div class="card-thumb">🌽</div>
                            <div class="card-info">
                                <div class="card-name">Jagung Manis Magelang</div>
                                <div class="card-price">Rp 8.000 / kg</div>
                            </div>
                        </div>
                        <div class="card" data-idx="4">
                            <div class="card-thumb">🧅</div>
                            <div class="card-info">
                                <div class="card-name">Bawang Merah Brebes</div>
                                <div class="card-price">Rp 32.000 / kg</div>
                            </div>
                        </div>
                        <div class="card" data-idx="5">
                            <div class="card-thumb">🥕</div>
                            <div class="card-info">
                                <div class="card-name">Wortel Organik Lembang</div>
                                <div class="card-price">Rp 12.500 / kg</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login panel -->
            <div class="login-panel" id="loginPanel">
                <div class="login-inner">

                    <div class="login-badge"><i></i> Akses Aman &amp; Terverifikasi</div>

                    <div class="login-header">
                        <h2>Masuk ke <span>SEARA</span></h2>
                        <p>Pilih peran Anda untuk pengalaman yang lebih personal</p>
                    </div>

                    <!-- Role tabs -->
                    <div class="role-tabs">
                        <button class="role-tab active" id="roleFarmer" onclick="setRole('farmer')">
                            <span class="t-icon">👨‍🌾</span> Saya Petani
                        </button>
                        <button class="role-tab" id="roleBuyer" onclick="setRole('buyer')">
                            <span class="t-icon">🛒</span> Saya Pembeli
                        </button>
                    </div>

                    <!-- Google SSO -->
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

                    <div class="form-divider"><span>atau masuk dengan email</span></div>

                    <!-- Fields -->
                    <div class="field">
                        <label>Email / Nomor Ponsel</label>
                        <div class="field-inner">
                            <span class="field-icon">✉️</span>
                            <input type="email" id="loginEmail" placeholder="contoh@seara.id" autocomplete="email" />
                        </div>
                    </div>

                    <div class="field">
                        <label>Kata Sandi</label>
                        <div class="field-inner pwd-row">
                            <span class="field-icon">🔒</span>
                            <input type="password" id="loginPassword" placeholder="Min. 8 karakter"
                                autocomplete="current-password" />
                            <button class="toggle-pwd" id="togglePwdBtn" onclick="togglePwd()">Lihat</button>
                        </div>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                    </div>

                    <div class="options-row">
                        <label class="check-label">
                            <input type="checkbox" id="rememberCheck" /> Ingat saya
                        </label>
                        <a href="#" class="forgot" id="forgotLink">Lupa kata sandi?</a>
                    </div>

                    <button class="btn-login" id="doLoginBtn">Masuk ke Dashboard →</button>

                    <div class="reg-row">
                        Belum punya akun? <a href="#" id="registerRedirect">Daftar sekarang</a>
                    </div>

                    <div class="trust-row">
                        <div class="trust-item"><span class="ti">🔐</span> SSL Aman</div>
                        <div class="trust-item"><span class="ti">✅</span> Terverifikasi</div>
                        <div class="trust-item"><span class="ti">🇮🇩</span> Server Lokal</div>
                    </div>

                    <div class="back-home">
                        <button id="closeLoginBtn">← Kembali ke Beranda</button>
                    </div>

                </div>
            </div>
        </div><!-- /#ph3 -->
    </div><!-- /#splash -->

    <!-- Ticker -->
    <div class="stat-ticker">
        <div class="ticker-track" id="tickerTrack"></div>
    </div>

    <script>
        (function () {
            'use strict';

            const $ = id => document.getElementById(id);

            /* ── PROGRESS BAR ── */
            const pbar = $('pbar');
            function prog(v) { if (pbar) pbar.style.width = v + '%'; }
            prog(10);
            setTimeout(() => prog(40), 400);
            setTimeout(() => prog(72), 1000);
            setTimeout(() => {
                prog(100);
                $('ph1').classList.remove('visible');
                $('ph3').classList.add('visible');
                setTimeout(() => { if (pbar) pbar.style.opacity = '0'; }, 700);
            }, 1700);

            /* ── ROTATING HERO TEXT ── */
            const phrases = [
                'langsung dari sumbernya.',
                'tanpa perantara, lebih adil.',
                'dari petani, untuk Anda.',
                'segar, terpercaya, terdekat.',
                'harga terbaik tiap hari.',
            ];
            let phraseIdx = 0;
            const rotEl = $('rotText');
            function rotatePhrases() {
                phraseIdx = (phraseIdx + 1) % phrases.length;
                // Exit animation
                rotEl.classList.remove('enter');
                rotEl.classList.add('exit');
                setTimeout(() => {
                    rotEl.textContent = phrases[phraseIdx];
                    rotEl.classList.remove('exit');
                    rotEl.classList.add('enter');
                }, 420);
            }
            // Start rotating after page is visible
            setTimeout(() => {
                rotEl.classList.add('enter');
                setInterval(rotatePhrases, 3000);
            }, 2200);

            /* ── CARD CAROUSEL ── */
            (function () {
                const cards = Array.from(document.querySelectorAll('.card'));
                const N = cards.length;

                // Positions: index 0 = front, N-1 = back
                // We spread them wide like a fan toward center
                const pos = [
                    { x: '-50%', y: '0px', s: 1, z: 100, o: 1, r: 0 },  // front-center
                    { x: '-22%', y: '28px', s: .89, z: 80, o: .88, r: 5 },
                    { x: '4%', y: '54px', s: .79, z: 60, o: .72, r: 10 },
                    { x: '28%', y: '76px', s: .7, z: 40, o: .52, r: 15 },
                    { x: '50%', y: '93px', s: .62, z: 20, o: .34, r: 20 },
                    { x: '68%', y: '106px', s: .55, z: 5, o: .18, r: 25 }, // back
                ];

                let order = cards.map((_, i) => i);

                function applyAll() {
                    order.forEach((ci, pi) => {
                        const c = cards[ci];
                        const p = pos[pi];
                        c.style.zIndex = p.z;
                        c.style.opacity = p.o;
                        c.style.transform = `translateX(${p.x}) translateY(${p.y}) scale(${p.s}) rotate(${p.r}deg)`;
                        c.style.boxShadow = pi === 0
                            ? '0 28px 60px rgba(0,0,0,.6), 0 0 0 1.5px rgba(61,186,126,.4)'
                            : '0 16px 40px rgba(0,0,0,.35)';
                    });
                }

                function rotate() {
                    const frontIdx = order[0];
                    const front = cards[frontIdx];

                    // Animate front card out: swoop left-behind
                    front.style.transition = 'transform .5s cubic-bezier(.5,0,1,.8), opacity .45s ease';
                    front.style.transform = `translateX(-140%) translateY(80px) scale(.42) rotate(-18deg)`;
                    front.style.opacity = '0';
                    front.style.zIndex = '1';

                    setTimeout(() => {
                        // Move to back of order
                        order.push(order.shift());

                        // Snap to back position without animation
                        const lp = pos[N - 1];
                        front.style.transition = 'none';
                        front.style.transform = `translateX(${lp.x}) translateY(${lp.y}) scale(${lp.s}) rotate(${lp.r}deg)`;
                        front.style.opacity = String(lp.o);
                        front.style.zIndex = String(lp.z);

                        // Force reflow
                        void front.getBoundingClientRect();

                        // Re-enable transitions and slide everyone into place
                        cards.forEach(c => {
                            c.style.transition = 'transform .9s cubic-bezier(.25,.9,.35,1.05), opacity .9s ease, box-shadow .4s ease';
                        });
                        applyAll();
                    }, 520);
                }

                applyAll();
                setInterval(rotate, 2800);
            })();

            /* ── LOGIN PANEL ── */
            window.openLogin = function () {
                $('ph3').classList.add('login-active');
            };
            const closeBtn = $('closeLoginBtn');
            if (closeBtn) closeBtn.addEventListener('click', () => {
                $('ph3').classList.remove('login-active');
            });

            /* Role tabs */
            window.setRole = function (role) {
                $('roleFarmer').classList.toggle('active', role === 'farmer');
                $('roleBuyer').classList.toggle('active', role === 'buyer');
            };

            /* Toggle password */
            window.togglePwd = function () {
                const inp = $('loginPassword');
                const btn = $('togglePwdBtn');
                if (!inp) return;
                if (inp.type === 'password') {
                    inp.type = 'text'; if (btn) btn.textContent = 'Sembunyikan';
                } else {
                    inp.type = 'password'; if (btn) btn.textContent = 'Lihat';
                }
            };

            /* Password strength */
            const pwdInp = $('loginPassword');
            const fill = $('strengthFill');
            if (pwdInp && fill) {
                pwdInp.addEventListener('input', () => {
                    const v = pwdInp.value;
                    let s = 0;
                    if (v.length >= 6) s += 25;
                    if (v.length >= 10) s += 20;
                    if (/[A-Z]/.test(v)) s += 20;
                    if (/[0-9]/.test(v)) s += 20;
                    if (/[^A-Za-z0-9]/.test(v)) s += 15;
                    fill.style.width = Math.min(s, 100) + '%';
                    fill.style.background = s < 35 ? '#e05c5c' : s < 65 ? '#e8c97e' : '#3dba7e';
                });
            }

            /* Login action */
            const doLoginBtn = $('doLoginBtn');
            if (doLoginBtn) {
                doLoginBtn.addEventListener('click', e => {
                    e.preventDefault();
                    const email = $('loginEmail')?.value.trim();
                    const pass = $('loginPassword')?.value.trim();
                    if (!email || !pass) { alert('Harap isi email dan kata sandi.'); return; }
                    alert(`✨ Selamat datang, ${email}!\nMengarahkan ke dashboard…`);
                });
            }

            const googleBtn = $('googleBtn');
            if (googleBtn) googleBtn.addEventListener('click', () => alert('Login Google segera hadir.'));

            const regLink = $('registerRedirect');
            if (regLink) regLink.addEventListener('click', e => { e.preventDefault(); alert('Halaman daftar segera hadir.'); });

            const forgotLink = $('forgotLink');
            if (forgotLink) forgotLink.addEventListener('click', e => { e.preventDefault(); alert('Reset password akan dikirim ke email terdaftar.'); });

            /* ── STAT TICKER ── */
            const stats = [
                { l: 'Petani Aktif', v: '12.400+' }, { l: 'Transaksi Hari Ini', v: '3.218' },
                { l: 'Produk Tersedia', v: '8.200+' }, { l: 'Provinsi Terjangkau', v: '27' },
                { l: 'Nilai Transaksi Bulan Ini', v: 'Rp 4,2M' }, { l: 'Rating Kepuasan', v: '4.9 / 5' },
            ];
            const doubled = [...stats, ...stats];
            const track = $('tickerTrack');
            if (track) {
                doubled.forEach(s => {
                    const el = document.createElement('span');
                    el.className = 'ticker-item';
                    el.innerHTML = `${s.l} <strong>${s.v}</strong>`;
                    track.appendChild(el);
                });
            }

        })();
    </script>
</body>

</html>