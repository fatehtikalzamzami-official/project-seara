<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEARA – Solusi Komoditas Petani</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:        #0b2e22;
            --bg-mid:    #0f3d2d;
            --teal:      #1a5c42;
            --leaf:      #3dba7e;
            --cream:     #f5ede0;
            --warm:      #e8c97e;
            --text:      #d6ede3;
        }

        html, body {
            width: 100%; height: 100%;
            background: var(--bg);
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
        }

        /* ─── NOISE GRAIN ─── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: .035;
        }

        /* ─── STAGE WRAPPER ─── */
        #splash {
            position: fixed; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }

        /* ─── PHASE 1 – blank dark ─── */
        #phase-1 {
            position: absolute; inset: 0;
            background: var(--bg);
            opacity: 1;
            transition: opacity .8s ease;
        }

        /* ─── PHASE 2 – wordmark ─── */
        #phase-2 {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            opacity: 0;
            transition: opacity .9s ease;
        }

        .wordmark {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: clamp(2.8rem, 7vw, 5rem);
            letter-spacing: .35em;
            text-transform: uppercase;
            color: var(--cream);
            text-shadow: 0 0 60px rgba(61,186,126,.25);
        }

        /* ─── PHASE 3 – icon + wordmark ─── */
        #phase-3 {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 1.2rem;
            opacity: 0;
            transition: opacity .9s ease;
        }

        .logo-icon svg {
            width: clamp(40px, 6vw, 64px);
            height: auto;
            filter: drop-shadow(0 0 18px rgba(61,186,126,.5));
        }

        /* ─── PHASE 4 – ONBOARDING ─── */
        #phase-4 {
            position: absolute; inset: 0;
            opacity: 0;
            transition: opacity 1s ease;
            overflow: hidden;
        }

        /* layered radial BG */
        #phase-4::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 65% 30%, rgba(26,92,66,.9) 0%, transparent 70%),
                radial-gradient(ellipse 100% 80% at 30% 80%, rgba(11,46,34,1) 0%, transparent 60%),
                var(--bg);
        }

        /* decorative circles */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(61,186,126,.15);
            pointer-events: none;
        }
        .ring-1 { width: 520px; height: 520px; top: -100px; right: -80px; }
        .ring-2 { width: 360px; height: 360px; top: -40px; right: -20px; }
        .ring-3 { width: 200px; height: 200px; top: 30px; right: 40px; }

        /* ── hero image circle ── */
        .hero-wrap {
            position: absolute;
            top: 6vh; right: 5vw;
            width: clamp(280px, 42vw, 520px);
            aspect-ratio: 1;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(61,186,126,.35);
            box-shadow: 0 0 80px rgba(61,186,126,.2), inset 0 0 40px rgba(0,0,0,.4);
            transform: scale(.85);
            opacity: 0;
            transition: transform 1s cubic-bezier(.16,1,.3,1), opacity 1s ease;
        }
        .hero-wrap.show { transform: scale(1); opacity: 1; }

        .hero-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: saturate(1.2) brightness(.9);
        }

        /* ── left content ── */
        .onboard-content {
            position: absolute;
            bottom: 8vh; left: 6vw;
            max-width: min(560px, 90vw);
        }

        .brand-tag {
            display: flex; align-items: center; gap: .7rem;
            margin-bottom: 2.4rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all .8s ease .3s;
        }
        .brand-tag.show { opacity: 1; transform: none; }

        .brand-tag svg { width: 28px; }
        .brand-tag span {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; letter-spacing: .3em;
            color: var(--cream);
        }

        .headline {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 4.5vw, 3.6rem);
            font-weight: 300;
            line-height: 1.15;
            color: var(--cream);
            margin-bottom: 1.2rem;
            opacity: 0; transform: translateY(30px);
            transition: all .9s ease .5s;
        }
        .headline.show { opacity: 1; transform: none; }
        .headline em { font-style: normal; color: var(--leaf); }

        .subtext {
            font-size: clamp(.85rem, 1.4vw, 1rem);
            font-weight: 300;
            line-height: 1.7;
            color: rgba(214,237,227,.7);
            max-width: 420px;
            margin-bottom: 2.8rem;
            opacity: 0; transform: translateY(30px);
            transition: all .9s ease .7s;
        }
        .subtext.show { opacity: 1; transform: none; }

        /* ── progress dots ── */
        .dots {
            display: flex; gap: .5rem; align-items: center;
            margin-bottom: 2rem;
            opacity: 0; transition: opacity .6s ease 1s;
        }
        .dots.show { opacity: 1; }
        .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: rgba(214,237,227,.25);
            transition: all .4s ease;
        }
        .dot.active { width: 24px; border-radius: 4px; background: var(--leaf); }

        /* ── CTA buttons ── */
        .actions {
            display: flex; gap: 1rem; align-items: center;
            opacity: 0; transform: translateY(20px);
            transition: all .9s ease .9s;
        }
        .actions.show { opacity: 1; transform: none; }

        .btn-skip {
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem; letter-spacing: .12em; text-transform: uppercase;
            color: rgba(214,237,227,.5);
            background: none; border: none; cursor: pointer;
            padding: .6rem 0;
            transition: color .3s;
        }
        .btn-skip:hover { color: var(--cream); }

        .btn-next {
            display: inline-flex; align-items: center; gap: .6rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem; font-weight: 500; letter-spacing: .08em; text-transform: uppercase;
            color: var(--bg);
            background: var(--leaf);
            border: none; cursor: pointer;
            padding: .85rem 2rem;
            border-radius: 3px;
            transition: background .3s, transform .2s;
            text-decoration: none;
        }
        .btn-next:hover { background: #4fd494; transform: translateX(3px); }
        .btn-next svg { width: 14px; transition: transform .3s; }
        .btn-next:hover svg { transform: translateX(4px); }

        /* ── decorative leaf particles ── */
        .particles {
            position: absolute; inset: 0;
            pointer-events: none; overflow: hidden;
        }
        .particle {
            position: absolute;
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--leaf);
            opacity: 0;
            animation: float linear infinite;
        }

        @keyframes float {
            0%   { opacity: 0; transform: translateY(0) rotate(0deg); }
            10%  { opacity: .6; }
            90%  { opacity: .2; }
            100% { opacity: 0; transform: translateY(-100vh) rotate(360deg); }
        }

        /* ─── PROGRESS BAR ─── */
        #progress-bar {
            position: fixed; top: 0; left: 0;
            height: 2px;
            background: var(--leaf);
            width: 0%;
            transition: width .4s ease;
            z-index: 100;
            box-shadow: 0 0 12px var(--leaf);
        }

        /* ─── ENTER SITE overlay ─── */
        #enter-overlay {
            position: fixed; inset: 0; z-index: 200;
            background: var(--bg);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .6s ease;
        }
        #enter-overlay.visible { opacity: 1; pointer-events: auto; }
        #enter-overlay p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem; letter-spacing: .25em;
            color: rgba(214,237,227,.6);
        }
    </style>
</head>
<body>

<div id="progress-bar"></div>

<div id="splash">

    {{-- PHASE 1: blank --}}
    <div id="phase-1"></div>

    {{-- PHASE 2: wordmark --}}
    <div id="phase-2">
        <span class="wordmark">SEARA</span>
    </div>

    {{-- PHASE 3: icon + wordmark --}}
    <div id="phase-3">
        <div class="logo-icon">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 52 C30 52 10 38 10 22 C10 14 18 8 30 8 C42 8 50 14 50 22 C50 38 30 52 30 52Z" fill="none" stroke="#3dba7e" stroke-width="1.5"/>
                <path d="M22 28 Q30 14 38 28" fill="none" stroke="#3dba7e" stroke-width="1.2"/>
                <path d="M26 20 Q30 30 30 38" fill="none" stroke="#3dba7e" stroke-width="1"/>
                <circle cx="30" cy="22" r="3" fill="#3dba7e" opacity=".5"/>
                <path d="M18 34 C22 30 38 30 42 34" fill="none" stroke="#3dba7e" stroke-width="1" opacity=".5"/>
            </svg>
        </div>
        <span class="wordmark" style="font-size: clamp(2rem,5vw,3.6rem);">SEARA</span>
    </div>

    {{-- PHASE 4: Onboarding --}}
    <div id="phase-4">

        {{-- decorative rings --}}
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>

        {{-- floating particles --}}
        <div class="particles" id="particles"></div>

        {{-- hero image --}}
        <div class="hero-wrap" id="hero-wrap">
            {{-- Replace src with your actual farm image --}}
            <img
                src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&q=80"
                alt="Hasil panen segar dari petani"
            >
        </div>

        {{-- left content --}}
        <div class="onboard-content">

            <div class="brand-tag" id="brand-tag">
                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 52 C30 52 10 38 10 22 C10 14 18 8 30 8 C42 8 50 14 50 22 C50 38 30 52 30 52Z" fill="none" stroke="#3dba7e" stroke-width="2"/>
                    <path d="M22 28 Q30 14 38 28" fill="none" stroke="#3dba7e" stroke-width="1.5"/>
                    <path d="M26 20 Q30 30 30 38" fill="none" stroke="#3dba7e" stroke-width="1.2"/>
                </svg>
                <span>SEARA</span>
            </div>

            <h1 class="headline" id="headline">
                Selamat datang<br>di <em>SEARA</em>
            </h1>

            <p class="subtext" id="subtext">
                Solusi pintar untuk jual beli hasil komoditas langsung dari tangan petaninya — segar, terpercaya, dan tanpa perantara.
            </p>

            <div class="dots" id="dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>

            <div class="actions" id="actions">
                <button class="btn-skip" onclick="skipToSite()">Lewati</button>
                <a href="{{ route('home') }}" class="btn-next">
                    Mulai Sekarang
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>

</div>

{{-- enter overlay --}}
<div id="enter-overlay">
    <p>Memasuki SEARA…</p>
</div>

<script>
const $ = id => document.getElementById(id);
const bar = $('progress-bar');

function setProgress(pct) {
    bar.style.width = pct + '%';
}

function show(el, delay = 0) {
    setTimeout(() => { el.style.opacity = '1'; }, delay);
}
function hide(el, delay = 0) {
    setTimeout(() => { el.style.opacity = '0'; }, delay);
}

// ── particle rain ──
(function spawnParticles() {
    const container = $('particles');
    for (let i = 0; i < 18; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + '%';
        p.style.bottom = '-10px';
        p.style.animationDuration = (6 + Math.random() * 10) + 's';
        p.style.animationDelay = (Math.random() * 14) + 's';
        p.style.opacity = 0;
        container.appendChild(p);
    }
})();

// ── SEQUENCE ──
(function runSequence() {
    const p1 = $('phase-1');
    const p2 = $('phase-2');
    const p3 = $('phase-3');
    const p4 = $('phase-4');

    // t=0: Phase 1 visible (blank teal) for 600ms
    setProgress(5);

    // t=600: fade Phase 1 out, fade Phase 2 in (wordmark only)
    setTimeout(() => {
        p1.style.opacity = '0';
        p2.style.opacity = '1';
        setProgress(30);
    }, 600);

    // t=1800: fade Phase 2 out, fade Phase 3 in (icon + wordmark)
    setTimeout(() => {
        p2.style.opacity = '0';
        p3.style.opacity = '1';
        setProgress(55);
    }, 1800);

    // t=3200: fade Phase 3 out, fade Phase 4 in (onboarding)
    setTimeout(() => {
        p3.style.opacity = '0';
        p4.style.opacity = '1';
        setProgress(80);
    }, 3200);

    // t=3500: reveal hero + content stagger
    setTimeout(() => {
        $('hero-wrap').classList.add('show');
        $('brand-tag').classList.add('show');
        $('headline').classList.add('show');
        $('subtext').classList.add('show');
        $('dots').classList.add('show');
        $('actions').classList.add('show');
        setProgress(100);
    }, 3500);

    // t=4000: hide progress bar
    setTimeout(() => { bar.style.opacity = '0'; }, 4500);
})();

// ── SKIP ──
function skipToSite() {
    const overlay = $('enter-overlay');
    overlay.classList.add('visible');
    setTimeout(() => {
        window.location.href = '{{ route("home") }}';
    }, 800);
}
</script>
</body>
</html>
