<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEARA – Splash Screen</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
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
            --text: #d6ede3;
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

        #ph1 {
            background: var(--bg);
            opacity: 1;
        }

        .center-stage {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            gap: 1.2rem;
        }

        .wordmark {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(2.6rem, 6vw, 4.8rem);
            letter-spacing: .38em;
            text-transform: uppercase;
            color: var(--cream);
            text-shadow: 0 0 60px rgba(61, 186, 126, .22);
        }

        .logo-svg {
            filter: drop-shadow(0 0 16px rgba(61, 186, 126, .55));
        }

        /* ══ PHASE 4 ══ */
        #ph4 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5vh 4vw 5vh 6vw;
            gap: 0;
            overflow: hidden;
        }

        #ph4::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 55% 60% at 82% 5%, rgba(40, 120, 80, .8) 0%, transparent 65%),
                radial-gradient(ellipse 45% 50% at 52% 50%, rgba(18, 62, 40, .55) 0%, transparent 60%),
                radial-gradient(ellipse 70% 65% at 10% 95%, rgba(4, 20, 12, 1) 0%, transparent 55%),
                radial-gradient(ellipse 38% 35% at 3% 8%, rgba(232, 201, 126, .05) 0%, transparent 55%),
                var(--bg);
        }

        #bg-deco {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        #bg-deco::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(61, 186, 126, .11) 1px, transparent 1px);
            background-size: 36px 36px;
            mask-image: radial-gradient(ellipse 75% 85% at 65% 50%, black 15%, transparent 72%);
        }

        #bg-deco::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(0deg,
                    transparent, transparent 79px,
                    rgba(61, 186, 126, .035) 79px,
                    rgba(61, 186, 126, .035) 80px);
        }

        /* ── LEFT ── */
        .left-col {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            max-width: min(460px, 38vw);
            display: flex;
            flex-direction: column;
        }

        .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            background: rgba(61, 186, 126, .1);
            border: 1px solid rgba(61, 186, 126, .25);
            border-radius: 100px;
            padding: .35rem .9rem .35rem .5rem;
            width: fit-content;
            margin-bottom: 1.8rem;
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .7s ease .2s, transform .7s ease .2s;
        }

        .brand-pill.in {
            opacity: 1;
            transform: none;
        }

        .brand-pill span {
            font-size: .72rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--leaf);
        }

        .headline-stack {
            display: grid;
            grid-template-areas: "stack";
            margin-bottom: 1.3rem;
        }

        .hl {
            grid-area: stack;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3.6vw, 3.4rem);
            font-weight: 300;
            line-height: 1.18;
            color: var(--cream);
            opacity: 0;
            transform: translateY(22px);
            pointer-events: none;
            transition: opacity .65s cubic-bezier(.4, 0, .2, 1), transform .65s cubic-bezier(.4, 0, .2, 1);
        }

        .hl.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .hl.leaving {
            opacity: 0;
            transform: translateY(-22px);
            pointer-events: none;
            transition: opacity .45s ease, transform .45s ease;
        }

        .hl em {
            font-style: normal;
            color: var(--leaf);
        }

        .sub-stack {
            display: grid;
            grid-template-areas: "stack";
            margin-bottom: 2.2rem;
        }

        .sub {
            grid-area: stack;
            font-size: clamp(.83rem, 1.15vw, .95rem);
            font-weight: 300;
            line-height: 1.85;
            color: rgba(214, 237, 227, .62);
            max-width: 360px;
            opacity: 0;
            transform: translateY(14px);
            pointer-events: none;
            transition: opacity .65s cubic-bezier(.4, 0, .2, 1), transform .65s cubic-bezier(.4, 0, .2, 1);
        }

        .sub.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .sub.leaving {
            opacity: 0;
            transform: translateY(-14px);
            pointer-events: none;
            transition: opacity .45s ease, transform .45s ease;
        }

        .text-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .9s ease, transform .9s ease;
        }

        .text-reveal.in {
            opacity: 1;
            transform: none;
        }

        .progress-dots {
            display: flex;
            gap: .4rem;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .pdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(214, 237, 227, .18);
            transition: all .45s ease;
        }

        .pdot.on {
            width: 22px;
            border-radius: 3px;
            background: var(--leaf);
        }

        .btn-row {
            display: flex;
            gap: 1.1rem;
            align-items: center;
        }

        .btn-skip {
            font-size: .76rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(214, 237, 227, .4);
            background: none;
            border: none;
            cursor: pointer;
            transition: color .3s;
        }

        .btn-skip:hover {
            color: var(--cream);
        }

        .btn-go {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            font-size: .8rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #0b2e22;
            background: var(--leaf);
            border: none;
            cursor: pointer;
            text-decoration: none;
            padding: .88rem 2rem;
            border-radius: 3px;
            transition: background .3s, transform .25s, box-shadow .3s;
            box-shadow: 0 4px 22px rgba(61, 186, 126, .28);
        }

        .btn-go:hover {
            background: #52dda0;
            transform: translateX(3px);
            box-shadow: 0 6px 32px rgba(61, 186, 126, .44);
        }

        .btn-go svg {
            width: 13px;
            transition: transform .3s;
        }

        .btn-go:hover svg {
            transform: translateX(5px);
        }

        /* ══ RIGHT — 6-CARD FAN ══ */
        .right-col {
            position: relative;
            z-index: 2;
            flex: 1 1 auto;
            /* Tidak pakai margin negatif — fan duduk di sisi kanan secara natural */
            min-width: 48vw;
            height: clamp(340px, 58vh, 620px);
        }

        /* card base */
        .card {
            position: absolute;
            width: clamp(155px, 16vw, 225px);
            aspect-ratio: 3/4;
            border-radius: 20px;
            overflow: hidden;
            border: 1.5px solid rgba(61, 186, 126, .2);
            cursor: pointer;
            will-change: transform, opacity;
            transition:
                transform 1.2s cubic-bezier(.16, 1, .3, 1),
                opacity 1.0s cubic-bezier(.16, 1, .3, 1),
                box-shadow .7s ease;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(1.15) brightness(.8);
            display: block;
            transition: filter .5s ease;
        }

        .card[data-pos="p0"] img {
            filter: saturate(1.3) brightness(.92);
        }

        /*
         * Fan posisi — anchor ke sisi kanan layar, bukan tengah.
         * Kartu dimulai dari ~15% kiri dari right-col dan membuka ke kanan.
         */
        .card[data-pos="p0"] {
            left: 12%;
            top: 50%;
            transform: translate(0, -50%) rotate(-6deg) translateY(-8px);
            z-index: 6;
            box-shadow: 0 36px 88px rgba(0, 0, 0, .65), 0 0 0 1px rgba(61, 186, 126, .28);
        }

        .card[data-pos="p1"] {
            left: 25%;
            top: 50%;
            transform: translate(0, -50%) rotate(1deg) translateY(10px);
            z-index: 5;
            opacity: .87;
            box-shadow: 0 22px 55px rgba(0, 0, 0, .48);
        }

        .card[data-pos="p2"] {
            left: 38%;
            top: 50%;
            transform: translate(0, -50%) rotate(8deg) translateY(24px);
            z-index: 4;
            opacity: .68;
            box-shadow: 0 16px 38px rgba(0, 0, 0, .38);
        }

        .card[data-pos="p3"] {
            left: 50%;
            top: 50%;
            transform: translate(0, -50%) rotate(14deg) translateY(36px);
            z-index: 3;
            opacity: .48;
            box-shadow: 0 10px 26px rgba(0, 0, 0, .3);
        }

        .card[data-pos="p4"] {
            left: 60%;
            top: 50%;
            transform: translate(0, -50%) rotate(19deg) translateY(44px);
            z-index: 2;
            opacity: .28;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .22);
        }

        .card[data-pos="p5"] {
            left: 68%;
            top: 50%;
            transform: translate(0, -50%) rotate(24deg) translateY(50px);
            z-index: 1;
            opacity: .12;
            box-shadow: none;
        }

        /* gone — terbang ke kiri atas, sepenuhnya hilang */
        .card[data-pos="gone"] {
            left: -5%;
            top: 0%;
            transform: translate(-120%, -120%) rotate(-28deg) scale(.7);
            z-index: 7;
            opacity: 0;
        }

        /* badge */
        .card-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(11, 46, 34, .8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(61, 186, 126, .18);
            border-radius: 10px;
            padding: .5rem .75rem;
            font-size: .7rem;
            letter-spacing: .05em;
            color: rgba(214, 237, 227, .88);
            opacity: 0;
            transform: translateY(6px);
            transition: opacity .5s ease .35s, transform .5s ease .35s;
        }

        .card[data-pos="p0"] .card-badge {
            opacity: 1;
            transform: none;
        }

        /* particles */
        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--leaf);
            opacity: 0;
            animation: rise linear infinite;
        }

        @keyframes rise {
            0% {
                opacity: 0;
                transform: translateY(0) scale(1);
            }

            10% {
                opacity: .36;
            }

            90% {
                opacity: .06;
            }

            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(.2);
            }
        }

        /* decorative rings */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(61, 186, 126, .07);
            pointer-events: none;
            animation: pulse-ring 9s ease-in-out infinite;
        }

        @keyframes pulse-ring {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: .07;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.05);
                opacity: .14;
            }
        }

        /* floating leaves */
        .leaf-deco {
            position: absolute;
            pointer-events: none;
            opacity: .055;
            animation: float-leaf 13s ease-in-out infinite;
        }

        @keyframes float-leaf {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-16px) rotate(7deg);
            }
        }

        /* progress bar */
        #pbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            width: 0%;
            background: linear-gradient(90deg, var(--leaf), var(--gold));
            box-shadow: 0 0 10px var(--leaf);
            z-index: 100;
            transition: width .5s ease, opacity .5s ease;
        }

        /* exit overlay */
        #eoverlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            background: var(--bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .8rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .7s ease;
        }

        #eoverlay.on {
            opacity: 1;
            pointer-events: auto;
        }

        #eoverlay .el {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            letter-spacing: .4em;
            color: var(--cream);
            opacity: 0;
            animation: fu .9s ease .15s forwards;
        }

        #eoverlay .et {
            font-size: .75rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(214, 237, 227, .38);
            opacity: 0;
            animation: fu .9s ease .45s forwards;
        }

        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        @media (max-width:860px) {
            #ph4 {
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
        }
    </style>
</head>

<body>

    <div id="pbar"></div>

    <div id="splash">
        <div class="phase visible" id="ph1"></div>

        <div class="phase" id="ph2">
            <div class="center-stage"><span class="wordmark">SEARA</span></div>
        </div>

        <div class="phase" id="ph3">
            <div class="center-stage">
                <svg class="logo-svg" width="56" height="56" viewBox="0 0 60 60" fill="none">
                    <path d="M30 54C30 54 8 38 8 22C8 13 18 7 30 7C42 7 52 13 52 22C52 38 30 54 30 54Z" stroke="#3dba7e"
                        stroke-width="1.5" fill="none" />
                    <path d="M20 29Q30 13 40 29" stroke="#3dba7e" stroke-width="1.3" fill="none" />
                    <path d="M30 20Q28 34 30 42" stroke="#3dba7e" stroke-width="1.1" fill="none" />
                    <ellipse cx="30" cy="21" rx="3.5" ry="3.5" fill="#3dba7e" opacity=".4" />
                </svg>
                <span class="wordmark" style="font-size:clamp(1.8rem,4.5vw,3.2rem);letter-spacing:.42em">SEARA</span>
            </div>
        </div>

        <div class="phase" id="ph4">

            <div id="bg-deco">
                <div class="ring" style="width:500px;height:500px;left:62%;top:50%;animation-delay:0s;"></div>
                <div class="ring" style="width:320px;height:320px;left:75%;top:35%;animation-delay:3s;"></div>
                <div class="ring" style="width:700px;height:700px;left:55%;top:65%;animation-delay:6s;"></div>
                <div class="ring" style="width:200px;height:200px;left:48%;top:20%;animation-delay:1.5s;"></div>

                <svg class="leaf-deco" style="width:100px;top:8%;left:45%;animation-delay:0s;" viewBox="0 0 60 60"
                    fill="none">
                    <path d="M30 54C30 54 8 38 8 22C8 13 18 7 30 7C42 7 52 13 52 22C52 38 30 54 30 54Z" stroke="#3dba7e"
                        stroke-width="1.5" fill="rgba(61,186,126,.18)" />
                </svg>
                <svg class="leaf-deco" style="width:60px;bottom:15%;left:42%;animation-delay:5s;" viewBox="0 0 60 60"
                    fill="none">
                    <path d="M30 54C30 54 8 38 8 22C8 13 18 7 30 7C42 7 52 13 52 22C52 38 30 54 30 54Z" stroke="#3dba7e"
                        stroke-width="1.5" fill="rgba(61,186,126,.12)" />
                </svg>
                <svg class="leaf-deco" style="width:45px;top:65%;left:36%;animation-delay:9s;" viewBox="0 0 60 60"
                    fill="none">
                    <path d="M30 54C30 54 8 38 8 22C8 13 18 7 30 7C42 7 52 13 52 22C52 38 30 54 30 54Z" stroke="#3dba7e"
                        stroke-width="1.5" fill="rgba(61,186,126,.09)" />
                </svg>

                <div
                    style="position:absolute;top:0;left:41%;width:1px;height:100%;background:linear-gradient(to bottom,transparent,rgba(232,201,126,.09) 25%,rgba(232,201,126,.14) 60%,transparent);pointer-events:none;">
                </div>
                <div
                    style="position:absolute;top:15%;left:50%;width:200px;height:1px;background:linear-gradient(to right,rgba(232,201,126,.12),transparent);pointer-events:none;">
                </div>
            </div>

            <div class="particles" id="particles"></div>

            <!-- LEFT col -->
            <div class="left-col">
                <div class="brand-pill" id="brand-pill">
                    <svg width="18" height="18" viewBox="0 0 60 60" fill="none">
                        <path d="M30 54C30 54 8 38 8 22C8 13 18 7 30 7C42 7 52 13 52 22C52 38 30 54 30 54Z"
                            stroke="#3dba7e" stroke-width="2" fill="none" />
                        <path d="M20 29Q30 13 40 29" stroke="#3dba7e" stroke-width="1.5" fill="none" />
                        <path d="M30 20Q28 34 30 42" stroke="#3dba7e" stroke-width="1.2" fill="none" />
                    </svg>
                    <span>SEARA</span>
                </div>

                <div class="text-reveal" id="text-reveal">
                    <div class="headline-stack">
                        <h1 class="hl active" data-s="0">Selamat datang<br>di <em>SEARA</em></h1>
                        <h1 class="hl" data-s="1">Langsung dari<br><em>tangan petani</em></h1>
                        <h1 class="hl" data-s="2">Komoditas segar,<br><em>harga terbaik</em></h1>
                        <h1 class="hl" data-s="3">Tanpa perantara,<br><em>tanpa batas</em></h1>
                        <h1 class="hl" data-s="4">Dari ladang<br><em>ke mejamu</em></h1>
                        <h1 class="hl" data-s="5">Bergabung<br><em>bersama kami</em></h1>
                    </div>
                    <div class="sub-stack">
                        <p class="sub active" data-s="0">Solusi pintar jual beli hasil komoditas langsung dari tangan
                            petaninya — segar, terpercaya, dan tanpa perantara.</p>
                        <p class="sub" data-s="1">Kami menghubungkan petani lokal dengan pembeli secara langsung,
                            memastikan kesegaran dari ladang ke meja makanmu.</p>
                        <p class="sub" data-s="2">Dapatkan buah, sayur, dan hasil bumi pilihan dengan harga transparan —
                            langsung dari sumbernya, bukan tengkulak.</p>
                        <p class="sub" data-s="3">Ekosistem pertanian digital yang adil — petani mendapat harga layak,
                            pembeli mendapat kualitas terbaik.</p>
                        <p class="sub" data-s="4">Produk segar pilihan tiba di rumahmu dalam hitungan jam — langsung
                            dari kebun, tanpa rantai distribusi panjang.</p>
                        <p class="sub" data-s="5">Ribuan petani lokal menunggu untuk melayanimu. Daftar sekarang dan
                            nikmati kemudahan berbelanja hasil bumi.</p>
                    </div>
                    <div class="progress-dots" id="pdots">
                        <div class="pdot on"></div>
                        <div class="pdot"></div>
                        <div class="pdot"></div>
                        <div class="pdot"></div>
                        <div class="pdot"></div>
                        <div class="pdot"></div>
                    </div>
                    <div class="btn-row">
                        <button class="btn-skip" onclick="enterSite()">Lewati</button>
                        <a href="#" class="btn-go" onclick="enterSite();return false;">
                            Mulai Sekarang
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT — 6-card fan -->
            <div class="right-col" id="card-stack">
                <div class="card" data-pos="p0" data-index="0">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=700&q=80"
                        alt="Sayuran hijau segar">
                    <div class="card-badge">🌿 Sayuran Segar</div>
                </div>
                <div class="card" data-pos="p1" data-index="1">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=700&q=80" alt="Panen padi">
                    <div class="card-badge">🌾 Hasil Panen Padi</div>
                </div>
                <div class="card" data-pos="p2" data-index="2">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=700&q=80" alt="Buah lokal">
                    <div class="card-badge">🍊 Buah Lokal Pilihan</div>
                </div>
                <div class="card" data-pos="p3" data-index="3">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=700&q=80" alt="Rempah">
                    <div class="card-badge">🌶️ Rempah Nusantara</div>
                </div>
                <div class="card" data-pos="p4" data-index="4">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?w=700&q=80" alt="Beras">
                    <div class="card-badge">🍚 Beras Pilihan</div>
                </div>
                <div class="card" data-pos="p5" data-index="5">
                    <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=700&q=80"
                        alt="Hasil kebun">
                    <div class="card-badge">🥬 Hasil Kebun</div>
                </div>
            </div>

        </div>
    </div>

    <div id="eoverlay">
        <div class="el">SEARA</div>
        <div class="et">Memuat halaman…</div>
    </div>

    <script>
        const $ = id => document.getElementById(id);
        const pbar = $('pbar');
        function prog(p) { pbar.style.width = p + '%'; }

        /* particles */
        (function () {
            const c = $('particles');
            for (let i = 0; i < 30; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                const s = 1.5 + Math.random() * 3.5;
                p.style.cssText = `left:${Math.random() * 100}%;bottom:-8px;width:${s}px;height:${s}px;animation-duration:${8 + Math.random() * 15}s;animation-delay:${Math.random() * 22}s;`;
                c.appendChild(p);
            }
        })();

        /* splash sequence */
        (function () {
            const ph1 = $('ph1'), ph2 = $('ph2'), ph3 = $('ph3'), ph4 = $('ph4');
            prog(8);
            setTimeout(() => { ph1.classList.remove('visible'); ph2.classList.add('visible'); prog(35); }, 700);
            setTimeout(() => { ph2.classList.remove('visible'); ph3.classList.add('visible'); prog(62); }, 1900);
            setTimeout(() => { ph3.classList.remove('visible'); ph4.classList.add('visible'); prog(85); }, 3300);
            setTimeout(() => {
                $('brand-pill').classList.add('in');
                $('text-reveal').classList.add('in');
                prog(100);
                setTimeout(startShuffle, 900);
            }, 3650);
            setTimeout(() => { pbar.style.opacity = '0'; }, 4700);
        })();

        /* ══ 6-CARD SHUFFLE ENGINE ══ */
        const INTERVAL = 2800;
        const N = 6;
        const POSITIONS = ['p0', 'p1', 'p2', 'p3', 'p4', 'p5'];

        const cards = Array.from(document.querySelectorAll('.card'));
        let order = [0, 1, 2, 3, 4, 5]; // order[cardIndex] = positionIndex
        let busy = false;
        let timer = null;

        function cardAtPos(pi) { return cards[order.indexOf(pi)]; }

        function shuffle() {
            if (busy) return;
            busy = true;

            const front = cardAtPos(0);

            // 1. Terbangkan kartu depan ke posisi "gone"
            front.setAttribute('data-pos', 'gone');

            // 2. Setelah kartu depan mulai terbang, geser sisa kartu maju
            setTimeout(() => {
                cards.forEach(c => {
                    if (c === front) return;
                    const ci = cards.indexOf(c);
                    const cur = order[ci];
                    c.setAttribute('data-pos', POSITIONS[cur - 1]);
                });
            }, 100);

            // 3. Teleport kartu gone ke p5 tanpa flash
            //    Caranya: matikan transisi, pindah ke p5, set opacity 0 via style,
            //    paksa reflow, aktifkan transisi lagi, hapus inline opacity →
            //    CSS p5 opacity (.12) akan muncul smooth via transition.
            setTimeout(() => {
                // Matikan semua transisi dulu
                front.style.transition = 'none';
                // Sembunyikan secara eksplisit agar tidak terlihat saat teleport
                front.style.opacity = '0';
                // Pindahkan ke posisi p5 (di belakang)
                front.setAttribute('data-pos', 'p5');
                // Paksa browser hitung ulang layout
                front.getBoundingClientRect();
                // Aktifkan transisi kembali
                front.style.transition = '';
                // Biarkan CSS p5 yang kontrol opacity → akan fade-in smooth ke .12
                front.style.opacity = '';

                // Update order array
                const fi = cards.indexOf(front);
                order = order.map((pos, i) => i === fi ? 5 : pos - 1);

                // Sync teks ke kartu depan yang baru
                const newFront = cardAtPos(0);
                syncText(parseInt(newFront.getAttribute('data-index')));

                busy = false;
            }, 1200);
        }

        function syncText(idx) {
            document.querySelectorAll('.hl').forEach(el => {
                const on = +el.dataset.s === idx;
                if (on) {
                    el.classList.remove('leaving'); el.classList.add('active');
                } else if (el.classList.contains('active')) {
                    el.classList.add('leaving'); el.classList.remove('active');
                    setTimeout(() => el.classList.remove('leaving'), 500);
                } else {
                    el.classList.remove('active', 'leaving');
                }
            });
            document.querySelectorAll('.sub').forEach(el => {
                const on = +el.dataset.s === idx;
                if (on) {
                    el.classList.remove('leaving'); el.classList.add('active');
                } else if (el.classList.contains('active')) {
                    el.classList.add('leaving'); el.classList.remove('active');
                    setTimeout(() => el.classList.remove('leaving'), 500);
                } else {
                    el.classList.remove('active', 'leaving');
                }
            });
            document.querySelectorAll('.pdot').forEach((el, i) => el.classList.toggle('on', i === idx));
        }

        function startShuffle() { timer = setInterval(shuffle, INTERVAL); }

        // Klik kartu non-front → shuffle manual
        cards.forEach(c => {
            c.addEventListener('click', () => {
                if (c.getAttribute('data-pos') !== 'p0') {
                    clearInterval(timer); shuffle();
                    timer = setInterval(shuffle, INTERVAL);
                }
            });
        });

        function enterSite() {
            clearInterval(timer);
            $('eoverlay').classList.add('on');
            setTimeout(() => { alert('→ Redirect ke route("home") di Laravel-mu'); }, 1000);
        }
    </script>
</body>

</html>