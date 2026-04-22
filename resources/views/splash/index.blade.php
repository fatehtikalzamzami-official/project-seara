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
            opacity: .032;
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
            padding: 5vh 6vw;
            gap: 4vw;
        }

        #ph4::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 70% 70% at 75% 20%, rgba(26, 92, 66, .95) 0%, transparent 65%),
                radial-gradient(ellipse 90% 80% at 20% 90%, rgba(11, 46, 34, 1) 0%, transparent 55%),
                var(--bg);
        }

        /* LEFT */
        .left-col {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            max-width: min(500px, 48vw);
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

        /* ══ FIX: headline-stack pakai relative positioning ══ */
        .headline-stack {
            position: relative;
            /* Tetap pakai fixed height agar layout tidak loncat */
            min-height: clamp(4.5rem, 8vw, 9rem);
            margin-bottom: 1.3rem;
            /* Clip overflow agar teks yg sedang transit tidak keliatan */
            overflow: hidden;
        }

        .hl {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.9rem, 4vw, 3.5rem);
            font-weight: 300;
            line-height: 1.18;
            color: var(--cream);
            /* Default: sembunyikan ke bawah + invisible */
            opacity: 0;
            transform: translateY(20px);
            /* Pastikan tidak bisa diklik saat tidak aktif */
            pointer-events: none;
            /* Transisi masuk */
            transition: opacity .55s ease, transform .55s ease;
            /* Sangat penting: visibility hidden saat tidak aktif
               agar tidak mengambil hit area / overlap visual */
            visibility: hidden;
        }

        .hl.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            visibility: visible;
        }

        /* Teks yang keluar: geser ke atas */
        .hl.leaving {
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
            transition: opacity .45s ease, transform .45s ease;
            /* Tetap visible saat animasi keluar berlangsung */
            visibility: visible;
        }

        .hl em {
            font-style: normal;
            color: var(--leaf);
        }

        /* ══ FIX: sub-stack sama seperti headline-stack ══ */
        .sub-stack {
            position: relative;
            min-height: clamp(3rem, 6vw, 5.5rem);
            margin-bottom: 2.2rem;
            overflow: hidden;
        }

        .sub {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            font-size: clamp(.82rem, 1.3vw, .96rem);
            font-weight: 300;
            line-height: 1.82;
            color: rgba(214, 237, 227, .6);
            max-width: 380px;
            opacity: 0;
            transform: translateY(14px);
            pointer-events: none;
            transition: opacity .55s ease, transform .55s ease;
            visibility: hidden;
        }

        .sub.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            visibility: visible;
        }

        .sub.leaving {
            opacity: 0;
            transform: translateY(-14px);
            pointer-events: none;
            transition: opacity .45s ease, transform .45s ease;
            visibility: visible;
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
            gap: .45rem;
            align-items: center;
            margin-bottom: 2rem;
        }

        .pdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(214, 237, 227, .18);
            transition: all .45s ease;
        }

        .pdot.on {
            width: 24px;
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
            transition: background .3s, transform .25s;
        }

        .btn-go:hover {
            background: #52dda0;
            transform: translateX(3px);
        }

        .btn-go svg {
            width: 13px;
            transition: transform .3s;
        }

        .btn-go:hover svg {
            transform: translateX(5px);
        }

        /* ══ RIGHT — CARD STACK ══ */
        .right-col {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            width: clamp(260px, 38vw, 460px);
            height: clamp(320px, 52vh, 580px);
        }

        .card {
            position: absolute;
            width: 72%;
            aspect-ratio: 3/4;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid rgba(61, 186, 126, .2);
            cursor: pointer;
            transition:
                transform .9s cubic-bezier(.34, 1.2, .64, 1),
                opacity .7s ease,
                box-shadow .6s ease;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(1.15) brightness(.85);
            display: block;
        }

        .card[data-pos="front"] {
            transform: translate(0%, 0%) rotate(-4deg);
            z-index: 3;
            box-shadow: 0 28px 72px rgba(0, 0, 0, .55), 0 0 0 1px rgba(61, 186, 126, .2);
        }

        .card[data-pos="mid"] {
            transform: translate(18%, 9%) rotate(5deg);
            z-index: 2;
            opacity: .85;
            box-shadow: 0 16px 40px rgba(0, 0, 0, .4);
        }

        .card[data-pos="back"] {
            transform: translate(34%, 18%) rotate(13deg);
            z-index: 1;
            opacity: .65;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .3);
        }

        .card[data-pos="gone"] {
            transform: translate(-90%, -75%) rotate(-22deg);
            z-index: 4;
            opacity: 0;
        }

        .card-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(11, 46, 34, .75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(61, 186, 126, .18);
            border-radius: 8px;
            padding: .5rem .75rem;
            font-size: .7rem;
            letter-spacing: .05em;
            color: rgba(214, 237, 227, .8);
            opacity: 0;
            transform: translateY(5px);
            transition: opacity .45s ease .2s, transform .45s ease .2s;
        }

        .card[data-pos="front"] .card-badge {
            opacity: 1;
            transform: none;
        }

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
                opacity: .4;
            }

            90% {
                opacity: .08;
            }

            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(.2);
            }
        }

        #pbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            width: 0%;
            background: linear-gradient(90deg, var(--leaf), #e8c97e);
            box-shadow: 0 0 10px var(--leaf);
            z-index: 100;
            transition: width .5s ease, opacity .5s ease;
        }

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

        @media (max-width:700px) {
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
                width: 85vw;
                height: 50vw;
                align-self: center;
            }

            .card {
                aspect-ratio: 4/3;
                width: 65%;
            }

            /* Mobile: tinggi stack lebih kecil */
            .headline-stack {
                min-height: clamp(5rem, 20vw, 7rem);
            }

            .sub-stack {
                min-height: clamp(4rem, 14vw, 6rem);
            }
        }
    </style>
</head>

<body>

    <div id="pbar"></div>

    <div id="splash">
        <div class="phase visible" id="ph1"></div>

        <div class="phase" id="ph2">
            <div class="center-stage">
                <span class="wordmark">SEARA</span>
            </div>
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
            <div class="particles" id="particles"></div>

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
                    </div>
                    <div class="sub-stack">
                        <p class="sub active" data-s="0">Solusi pintar jual beli hasil komoditas langsung dari tangan
                            petaninya — segar, terpercaya, dan tanpa perantara.</p>
                        <p class="sub" data-s="1">Kami menghubungkan petani lokal dengan pembeli secara langsung,
                            memastikan kesegaran dari ladang ke meja makanmu.</p>
                        <p class="sub" data-s="2">Dapatkan buah, sayur, dan hasil bumi pilihan dengan harga transparan —
                            langsung dari sumbernya, bukan tengkulak.</p>
                    </div>
                    <div class="progress-dots" id="pdots">
                        <div class="pdot on"></div>
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

            <div class="right-col" id="card-stack">
                <div class="card" data-pos="front" data-index="0">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=700&q=80"
                        alt="Sayuran hijau segar">
                    <div class="card-badge">🌿 Sayuran Segar</div>
                </div>
                <div class="card" data-pos="mid" data-index="1">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=700&q=80"
                        alt="Panen padi di sawah">
                    <div class="card-badge">🌾 Hasil Panen Padi</div>
                </div>
                <div class="card" data-pos="back" data-index="2">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=700&q=80"
                        alt="Buah-buahan lokal">
                    <div class="card-badge">🍊 Buah Lokal Pilihan</div>
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
            for (let i = 0; i < 22; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                const s = 2 + Math.random() * 3;
                p.style.cssText = `left:${Math.random() * 100}%;bottom:-8px;width:${s}px;height:${s}px;animation-duration:${7 + Math.random() * 12}s;animation-delay:${Math.random() * 18}s;`;
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

        /* ══ CARD SHUFFLE ══ */
        const INTERVAL = 3200;
        const cards = Array.from(document.querySelectorAll('.card'));
        let busy = false;
        let timer = null;
        let order = [0, 1, 2];

        function cardAt(posIdx) { return cards[order.indexOf(posIdx)]; }

        function shuffle() {
            if (busy) return;
            busy = true;

            const front = cardAt(0);
            const mid = cardAt(1);
            const back = cardAt(2);

            front.setAttribute('data-pos', 'gone');

            setTimeout(() => {
                mid.setAttribute('data-pos', 'front');
                back.setAttribute('data-pos', 'mid');
            }, 60);

            setTimeout(() => {
                front.style.transition = 'none';
                front.setAttribute('data-pos', 'back');
                front.getBoundingClientRect();
                front.style.transition = '';

                const fi = cards.indexOf(front);
                const mi = cards.indexOf(mid);
                const bi = cards.indexOf(back);
                order[mi] = 0;
                order[bi] = 1;
                order[fi] = 2;

                const newFrontIdx = parseInt(mid.getAttribute('data-index'));
                syncText(newFrontIdx);

                busy = false;
            }, 960);
        }

        /* ══ FIX: syncText pakai class "leaving" agar transisi keluar smooth ══ */
        function syncText(idx) {
            document.querySelectorAll('.hl').forEach(el => {
                const isActive = +el.dataset.s === idx;
                if (isActive) {
                    el.classList.remove('leaving');
                    el.classList.add('active');
                } else if (el.classList.contains('active')) {
                    // Sedang aktif → animasikan keluar
                    el.classList.add('leaving');
                    el.classList.remove('active');
                    // Hapus class leaving setelah transisi selesai
                    setTimeout(() => el.classList.remove('leaving'), 500);
                } else {
                    el.classList.remove('active', 'leaving');
                }
            });

            document.querySelectorAll('.sub').forEach(el => {
                const isActive = +el.dataset.s === idx;
                if (isActive) {
                    el.classList.remove('leaving');
                    el.classList.add('active');
                } else if (el.classList.contains('active')) {
                    el.classList.add('leaving');
                    el.classList.remove('active');
                    setTimeout(() => el.classList.remove('leaving'), 500);
                } else {
                    el.classList.remove('active', 'leaving');
                }
            });

            document.querySelectorAll('.pdot').forEach((el, i) => el.classList.toggle('on', i === idx));
        }

        function startShuffle() {
            timer = setInterval(shuffle, INTERVAL);
        }

        cards.forEach(c => {
            c.addEventListener('click', () => {
                if (c.getAttribute('data-pos') !== 'front') {
                    clearInterval(timer);
                    shuffle();
                    timer = setInterval(shuffle, INTERVAL);
                }
            });
        });

        function enterSite() {
            clearInterval(timer);
            $('eoverlay').classList.add('on');
            setTimeout(() => {
                alert('→ Redirect ke route("home") di Laravel-mu');
            }, 1000);
        }
    </script>
</body>

</html>