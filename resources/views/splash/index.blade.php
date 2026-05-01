<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEARA – Pasar Tani Digital Indonesia</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: .025;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 65% 55% at 12% 18%, rgba(61, 186, 126, .13) 0%, transparent 58%),
                radial-gradient(ellipse 55% 48% at 90% 82%, rgba(61, 186, 126, .10) 0%, transparent 52%),
                radial-gradient(ellipse 40% 35% at 55% 50%, rgba(232, 201, 126, .05) 0%, transparent 60%);
        }

        #bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        #bg-deco {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .deco-ring {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .deco-ring-1 {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -160px;
            border: 1px solid rgba(61, 186, 126, .14);
        }

        .deco-ring-2 {
            width: 300px;
            height: 300px;
            top: 20px;
            left: -50px;
            border: 1px solid rgba(61, 186, 126, .18);
        }

        .deco-ring-3 {
            width: 680px;
            height: 680px;
            bottom: -280px;
            right: -220px;
            border: 1px solid rgba(61, 186, 126, .10);
        }

        .deco-ring-4 {
            width: 400px;
            height: 400px;
            bottom: -80px;
            right: -60px;
            border: 1px solid rgba(232, 201, 126, .12);
        }

        .deco-stripe {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: repeating-linear-gradient(-52deg, transparent 0px, transparent 22px, rgba(61, 186, 126, .032) 22px, rgba(61, 186, 126, .032) 23px);
        }

        @keyframes drift-a {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(8px, -12px) rotate(3deg);
            }

            66% {
                transform: translate(-6px, 8px) rotate(-2deg);
            }
        }

        @keyframes drift-b {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            40% {
                transform: translate(-10px, 6px) rotate(-4deg);
            }

            70% {
                transform: translate(7px, -8px) rotate(2deg);
            }
        }

        @keyframes drift-c {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(5px, 14px);
            }
        }

        .drift-a {
            animation: drift-a 18s ease-in-out infinite;
        }

        .drift-b {
            animation: drift-b 22s ease-in-out infinite;
        }

        .drift-c {
            animation: drift-c 14s ease-in-out infinite;
        }

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

        #ph3 {
            display: flex;
            flex-direction: row;
            background: var(--bg);
            overflow: hidden;
            position: relative;
            height: 100vh;
        }

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

        .right-col {
            flex: 0 0 auto;
            width: clamp(320px, 44vw, 580px);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 2vw;
            position: relative;
        }

        .cards-stack {
            position: relative;
            width: 100%;
            height: 380px;
        }

        .card {
            position: absolute;
            width: clamp(130px, 14vw, 175px);
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .09);
            background: #132e21;
            transform-origin: center bottom;
            transition: transform .9s cubic-bezier(.25, .9, .35, 1.05), opacity .9s ease, box-shadow .4s ease;
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
            background: #ffffff;
        }

        #ph3.login-active .login-panel {
            width: 500px;
            overflow-y: auto;
            overflow-x: hidden;
            height: 100vh;
        }

        .login-inner {
            width: 500px;
            min-height: 100%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 2.5rem 2.2rem 4rem;
            box-shadow: -8px 0 32px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .login-close-x {
            position: absolute;
            top: 20px;
            right: 24px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: #94a3b8;
            transition: all 0.2s;
            z-index: 10;
        }

        .login-close-x:hover {
            border-color: var(--leaf);
            color: var(--leaf);
            transform: scale(1.05);
            background: #f0fdf4;
        }

        .login-header {
            margin-bottom: 1.4rem;
            padding-bottom: 1.4rem;
            border-bottom: 1px solid #f0f4f2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .login-header-text {
            flex: 1;
        }

        .login-header-text::before {
            content: '';
            display: block;
            width: 24px;
            height: 2px;
            background: #3dba7e;
            margin-bottom: .8rem;
            border-radius: 2px;
        }

        .login-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.75rem;
            font-weight: 400;
            color: #0a2118;
            letter-spacing: -0.5px;
            line-height: 1.18;
            margin-bottom: 0.45rem;
        }

        .login-header h2 span {
            color: #3dba7e;
            font-style: italic;
            font-weight: 300;
        }

        .login-header p {
            font-size: 0.75rem;
            color: #8aa396;
            line-height: 1.6;
        }

        .login-header-logo {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: contain;
        }

        /* Auth Tabs */
        .auth-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: #f1f5f4;
            border-radius: 16px;
            padding: 4px;
            margin-bottom: 1.4rem;
        }

        .auth-tab {
            padding: 0.7rem 0;
            border-radius: 12px;
            border: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6f8f7c;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .auth-tab.active {
            background: white;
            color: #1e6645;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Google Button */
        .btn-google {
            width: 100%;
            background: white;
            border: 1.5px solid #e2edE6;
            padding: 0.8rem;
            border-radius: 14px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #2b4d3a;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-bottom: 1.6rem;
        }

        .btn-google:hover {
            border-color: var(--leaf);
            background: #fafefa;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(61, 186, 126, 0.1);
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        .form-divider {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 2.2rem;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .form-divider span {
            font-size: 0.7rem;
            color: #8ba396;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Divider text dinamis */
        #dividerText {
            /* updated by JS */
        }

        /* Input Fields */
        .field {
            margin-bottom: 1rem;
        }

        .field label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
            color: #3d6951;
            margin-bottom: 0.45rem;
        }

        .field-inner {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            pointer-events: none;
            color: #0a2118;
        }

        .field input,
        .field textarea {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 0.82rem 1rem 0.82rem 2.6rem;
            font-size: 0.88rem;
            color: #1a2e24;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
            resize: none;
            left: 10rem;
        }

        .field textarea {
            min-height: 72px;
            padding-top: 2.0rem;
            padding-bottom: 0.6rem;
        }

        .field input:focus,
        .field textarea:focus {
            outline: none;
            border-color: var(--leaf);
            box-shadow: 0 0 0 3px rgba(61, 186, 126, 0.12);
        }

        .field input::placeholder {
            color: #cbd5e1;
        }

        .field textarea::placeholder {
            color: #cbd5e1;
        }

        .pwd-row input {
            padding-right: 4.5rem;
        }

        .toggle-pwd {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            color: #7d9e8a;
            font-family: 'DM Sans', sans-serif;
            padding: 0.2rem 0.4rem;
            border-radius: 8px;
            transition: color 0.2s;
        }

        .toggle-pwd:hover {
            color: #1e6645;
        }

        .strength-bar {
            height: 4px;
            border-radius: 4px;
            background: #e2e8f0;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }

        .strength-label {
            font-size: 0.65rem;
            color: #8ba396;
            margin-top: 0.3rem;
            height: 14px;
            transition: color 0.3s;
        }

        /* Remember + Lupa — hanya muncul saat tab Masuk */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.6rem 0 1.2rem;
            font-size: 0.8rem;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            color: #54705f;
            cursor: pointer;
        }

        .check-label input {
            accent-color: var(--leaf);
            width: 16px;
            height: 16px;
            margin: 0;
        }

        .forgot {
            color: var(--leaf);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .forgot:hover {
            text-decoration: underline;
        }


        /* Submit Button */
        .btn-login {
            width: 100%;
            background: linear-gradient(105deg, #3dba7e 0%, #2a9d6e 100%);
            border: none;
            padding: 0.9rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: white;
            cursor: pointer;
            transition: all 0.25s;
            margin-top: 1.0rem;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 4px 12px rgba(61, 186, 126, 0.25);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2.8s infinite;
        }

        @keyframes shimmer {
            to {
                left: 160%;
            }
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(61, 186, 126, 0.35);
            background: linear-gradient(105deg, #52dda0 0%, #3dba7e 100%);
        }

        .trust-row {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin-top: 1.6rem;
            padding-top: 1.2rem;
            border-top: 1px solid #e2e8f0;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.65rem;
            color: #8ba396;
            letter-spacing: 0.03em;
        }

        /* STAT TICKER */
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

        .card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .card {
            width: 220px;
            height: 340px;
            overflow: hidden;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            #ph3 {
                flex-direction: column;
                height: 100%;
            }

            #ph3.login-active .main-content {
                display: none;
            }

            .login-panel {
                position: fixed !important;
                top: 0;
                right: 0;
                bottom: 0;
                left: auto;
                width: 100%;
                max-width: 440px;
                background: white;
                z-index: 1000;
                overflow-y: auto !important;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                height: 100vh !important;
            }

            #ph3.login-active .login-panel {
                transform: translateX(0);
                width: 100% !important;
                overflow-y: auto !important;
            }

            .login-inner {
                width: 100%;
                padding: 1.5rem;
                min-height: auto;
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
        }

        .corner-logo {
            position: absolute;
            top: 40px;
            left: 54px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .corner-logo img {
            height: 66px;
            width: 66px;
            object-fit: contain;
            filter: brightness(1.1);
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
            <!-- Corner Logo -->
            <div class="corner-logo">
                <img src="{{ asset('assets/logo-gold.png') }}" alt="SEARA Logo" />
            </div>
            <canvas id="bg-canvas" aria-hidden="true"
                style="position:absolute;inset:0;width:100%;height:100%;z-index:1;pointer-events:none;"></canvas>

            <div id="bg-deco" aria-hidden="true"
                style="position:absolute;inset:0;z-index:1;pointer-events:none;overflow:hidden;">
                <div class="deco-ring deco-ring-1 drift-a"></div>
                <div class="deco-ring deco-ring-2 drift-b"></div>
                <div class="deco-ring deco-ring-3 drift-c"></div>
                <div class="deco-ring deco-ring-4 drift-a"></div>
                <div class="deco-stripe"></div>
            </div>

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
                    </div>
                </div>

                <!-- Card stack -->
                <div class="right-col">
                    <div class="cards-stack" id="cardsStack">

                        <div class="card" data-idx="0">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card1.jpeg') }}" alt="Explore">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Temukan Produk Segar</div>
                                <div class="card-price">Langsung dari petani lokal</div>
                            </div>
                        </div>

                        <div class="card" data-idx="1">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card2.jpeg') }}" alt="Shop">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Belanja Lebih Mudah</div>
                                <div class="card-price">Tanpa ribet, tinggal klik</div>
                            </div>
                        </div>

                        <div class="card" data-idx="2">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card3.jpeg') }}" alt="Quality">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Kualitas Terjamin</div>
                                <div class="card-price">Segar & terpercaya</div>
                            </div>
                        </div>

                        <div class="card" data-idx="3">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card4.jpeg') }}" alt="Support">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Dukung Petani Lokal</div>
                                <div class="card-price">Setiap pembelian berarti</div>
                            </div>
                        </div>

                        <div class="card" data-idx="4">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card5.jpeg') }}" alt="Delivery">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Pengiriman Cepat</div>
                                <div class="card-price">Langsung ke rumahmu</div>
                            </div>
                        </div>

                        <div class="card" data-idx="5">
                            <div class="card-thumb">
                                <img src="{{ asset('assets/card7.jpeg') }}" alt="Start">
                            </div>
                            <div class="card-info">
                                <div class="card-name">Mulai Sekarang</div>
                                <div class="card-price">Gabung & rasakan bedanyak</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════
                 LOGIN PANEL – Masuk / Daftar
            ════════════════════════════════════════ -->
            <div class="login-panel" id="loginPanel">
                <div class="login-inner">
                    <button class="login-close-x" id="closeLoginBtn" title="Tutup">✕</button>

                    <!-- Header -->
                    <div class="login-header">
                        <div class="login-header-text">
                            <h2 id="panelTitle">Selamat datang<br>di <span>SEARA</span></h2>
                            <p id="panelSubtitle">Masuk untuk mulai bertransaksi.</p>
                        </div>
                        <img src="{{ asset('assets/logo-dark.png') }}" alt="SEARA Logo" class="login-header-logo">
                    </div>

                    <!-- Auth Tabs -->
                    <div class="auth-tabs">
                        <button class="auth-tab active" id="tabMasuk" onclick="switchTab('masuk')">Masuk</button>
                        <button class="auth-tab" id="tabDaftar" onclick="switchTab('daftar')">Daftar</button>
                    </div>

                    <!-- Google -->
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
                        <span id="googleBtnText">Lanjutkan dengan Google</span>
                    </button>

                    <!-- Divider -->
                    <div class="form-divider">
                        <span id="dividerText">atau masuk dengan email</span>
                    </div>

                    <!-- ══ FORM MASUK ══ -->
                    <div id="formMasuk">
                        <div class="field">
                            <label>Email / Nomor Ponsel</label>
                            <div class="field-inner">
                                <span class="field-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" id="loginEmail" placeholder="contoh@seara.id"
                                    autocomplete="email" />
                            </div>
                        </div>

                        <div class="field">
                            <label>Kata Sandi</label>
                            <div class="field-inner pwd-row">
                                <span class="field-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" id="loginPassword" placeholder="Kata sandi Anda"
                                    autocomplete="current-password" />
                                <button class="toggle-pwd" type="button"
                                    onclick="togglePwd('loginPassword', this)">Lihat</button>
                            </div>
                        </div>

                        <div class="options-row">
                            <label class="check-label">
                                <input type="checkbox" id="rememberCheck" /> Ingat saya
                            </label>
                            <a href="#" class="forgot" id="forgotLink">Lupa kata sandi?</a>
                        </div>

                        <button class="btn-login" id="doLoginBtn">Masuk ke Dashboard</button>

                    </div>

                    <!-- ══ FORM DAFTAR ══ -->
                    <div id="formDaftar" style="display:none;">

                        <div class="field">
                            <label>Email</label>
                            <div class="field-inner">
                                <span class="field-icon"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" id="regEmail" placeholder="contoh@seara.id" autocomplete="email" />
                            </div>
                        </div>

                        <div class="field">
                            <label>Username</label>
                            <div class="field-inner">
                                <span class="field-icon"><i class="fa-solid fa-at"></i></span>
                                <input type="text" id="regUsername" placeholder="Nama pengguna unik (tanpa spasi)"
                                    autocomplete="username" oninput="this.value = this.value.replace(/\s/g, '')" />
                            </div>
                        </div>

                        <div class="field">
                            <label>Nama Lengkap (Sesuai KTP)</label>
                            <div class="field-inner">
                                <span class="field-icon"><i class="fa-solid fa-user"></i></span>
                                <input type="text" id="regNama" placeholder="Masukkan Nama Lengkap"
                                    autocomplete="name" />
                            </div>
                        </div>

                        <div class="field">
                            <label>Alamat Rumah</label>
                            <div class="field-inner textarea">
                                <span class="field-icon"><i class="fa-solid fa-house"></i></span>
                                <textarea id="regAlamat" rows="3" placeholder="Masukkan Alamat Rumah"></textarea>
                            </div>
                        </div>

                        <div class="field">
                            <label>No. WhatsApp</label>
                            <div class="field-inner">
                                <span class="field-icon"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" id="regWa" placeholder="Contoh: 08123456789" autocomplete="tel" />
                            </div>
                        </div>

                        <div class="field">
                            <label>Kata Sandi</label>
                            <div class="field-inner pwd-row">
                                <span class="field-icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" id="regPassword" placeholder="Min. 8 karakter"
                                    autocomplete="new-password" />
                                <button class="toggle-pwd" type="button"
                                    onclick="togglePwd('regPassword', this)">Lihat</button>
                            </div>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-label" id="strengthLabel"></div>
                        </div>

                        <div class="field">
                            <label>Konfirmasi Kata Sandi</label>
                            <div class="field-inner pwd-row">
                                <span class="field-icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" id="regPasswordConfirm" placeholder="Ulangi kata sandi"
                                    autocomplete="new-password" />
                                <button class="toggle-pwd" type="button"
                                    onclick="togglePwd('regPasswordConfirm', this)">Lihat</button>
                            </div>
                        </div>

                        <button class="btn-login" id="doRegisterBtn" style="margin-top:0.6rem;">
                            Buat Akun Sekarang →
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="stat-ticker">
        <div class="ticker-track" id="tickerTrack"></div>
    </div>

    <script>
        /* ── BACKGROUND CANVAS ── */
        (function () {
            const canvas = document.getElementById('bg-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            function draw() {
                const W = canvas.offsetWidth || window.innerWidth;
                const H = canvas.offsetHeight || window.innerHeight;
                canvas.width = W; canvas.height = H;
                ctx.clearRect(0, 0, W, H);

                const green = 'rgba(61,186,126,';
                const gold = 'rgba(232,201,126,';
                const hexR = 26;
                const hexW = hexR * Math.sqrt(3);
                const hexH = hexR * 2;

                function hexPath(cx, cy, r) {
                    ctx.beginPath();
                    for (let i = 0; i < 6; i++) {
                        const a = Math.PI / 180 * (60 * i - 30);
                        i === 0 ? ctx.moveTo(cx + r * Math.cos(a), cy + r * Math.sin(a)) : ctx.lineTo(cx + r * Math.cos(a), cy + r * Math.sin(a));
                    }
                    ctx.closePath();
                }

                const clusters = [
                    { cx: W * 0.82, cy: H * 0.22, r: 180, oMax: 0.18 },
                    { cx: W * 0.10, cy: H * 0.72, r: 150, oMax: 0.14 },
                    { cx: W * 0.55, cy: H * 0.88, r: 120, oMax: 0.10 },
                ];

                clusters.forEach(cl => {
                    const pad = hexR * 2;
                    const startX = cl.cx - cl.r - pad, startY = cl.cy - cl.r - pad;
                    const endX = cl.cx + cl.r + pad, endY = cl.cy + cl.r + pad;
                    const rows = Math.ceil((endY - startY) / (hexH * 0.75)) + 2;
                    const cols = Math.ceil((endX - startX) / hexW) + 2;

                    for (let row = 0; row < rows; row++) {
                        for (let col = 0; col < cols; col++) {
                            const hx = startX + col * hexW + (row % 2 === 0 ? 0 : hexW / 2);
                            const hy = startY + row * (hexH * 0.75);
                            const dist = Math.sqrt((hx - cl.cx) ** 2 + (hy - cl.cy) ** 2);
                            if (dist > cl.r) continue;
                            const fade = Math.pow(1 - dist / cl.r, 1.4);
                            const alpha = fade * cl.oMax;
                            ctx.save(); ctx.globalAlpha = alpha;
                            ctx.strokeStyle = '#3dba7e'; ctx.lineWidth = 0.9;
                            hexPath(hx, hy, hexR - 1); ctx.stroke();
                            ctx.fillStyle = '#3dba7e'; ctx.globalAlpha = alpha * 1.8;
                            ctx.beginPath(); ctx.arc(hx, hy, 1.2, 0, Math.PI * 2); ctx.fill();
                            ctx.restore();
                        }
                    }
                });

                function bracket(x, y, dx, dy, opacity) {
                    ctx.save(); ctx.globalAlpha = opacity; ctx.strokeStyle = '#3dba7e'; ctx.lineWidth = 1.2;
                    ctx.beginPath(); ctx.moveTo(x + dx * 36, y); ctx.lineTo(x, y); ctx.lineTo(x, y + dy * 36);
                    ctx.stroke(); ctx.restore();
                }
                bracket(30, 24, 1, 1, 0.32); bracket(W - 30, 24, -1, 1, 0.32);
                bracket(30, H - 24, 1, -1, 0.24); bracket(W - 30, H - 24, -1, -1, 0.24);

                function cross(x, y, size, opacity) {
                    ctx.save(); ctx.globalAlpha = opacity; ctx.strokeStyle = '#3dba7e'; ctx.lineWidth = 0.8;
                    ctx.beginPath(); ctx.moveTo(x - size, y); ctx.lineTo(x + size, y);
                    ctx.moveTo(x, y - size); ctx.lineTo(x, y + size); ctx.stroke(); ctx.restore();
                }
                cross(W * .38, H * .18, 10, .35); cross(W * .22, H * .68, 10, .28);
                cross(W * .62, H * .42, 10, .32); cross(W * .72, H * .78, 10, .24);

                const dots = [
                    { x: W * .30, y: H * .24, r: 3, o: .30, c: green }, { x: W * .48, y: H * .55, r: 2, o: .25, c: green },
                    { x: W * .78, y: H * .34, r: 4, o: .18, c: gold }, { x: W * .90, y: H * .60, r: 3, o: .15, c: gold },
                ];
                dots.forEach(d => {
                    ctx.beginPath(); ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
                    ctx.fillStyle = d.c + '1)'; ctx.globalAlpha = d.o; ctx.fill();
                });

                function dashedLine(x1, y1, x2, y2, opacity) {
                    ctx.save(); ctx.globalAlpha = opacity; ctx.strokeStyle = '#3dba7e';
                    ctx.lineWidth = 0.7; ctx.setLineDash([4, 10]);
                    ctx.beginPath(); ctx.moveTo(x1, y1); ctx.lineTo(x2, y2); ctx.stroke();
                    ctx.setLineDash([]); ctx.restore();
                }
                dashedLine(0, H * .33, W * .28, H * .33, 0.14);
                dashedLine(W * .72, H * .67, W, H * .67, 0.14);

                function arc(cx, cy, r, startA, endA, opacity, color) {
                    ctx.save(); ctx.globalAlpha = opacity; ctx.strokeStyle = color; ctx.lineWidth = 0.8;
                    ctx.beginPath(); ctx.arc(cx, cy, r, startA, endA); ctx.stroke(); ctx.restore();
                }
                arc(W + 60, -60, 420, Math.PI * .55, Math.PI * 1.05, 0.12, '#3dba7e');
                arc(-60, H + 60, 280, -Math.PI * .3, Math.PI * .2, 0.10, '#3dba7e');
            }

            draw();
            window.addEventListener('resize', draw);
        })();
    </script>

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
                setTimeout(() => window.dispatchEvent(new Event('resize')), 50);
                setTimeout(() => { if (pbar) pbar.style.opacity = '0'; }, 700);
            }, 1700);

            /* ── ROTATING TEXT ── */
            const phrases = ['langsung dari sumbernya.', 'tanpa perantara, lebih adil.', 'dari petani, untuk Anda.', 'segar, terpercaya, terdekat.', 'harga terbaik tiap hari.'];
            let phraseIdx = 0;
            const rotEl = $('rotText');

            function rotatePhrases() {
                phraseIdx = (phraseIdx + 1) % phrases.length;
                rotEl.classList.remove('enter');
                rotEl.classList.add('exit');
                setTimeout(() => {
                    rotEl.textContent = phrases[phraseIdx];
                    rotEl.classList.remove('exit');
                    rotEl.classList.add('enter');
                }, 420);
            }
            setTimeout(() => { rotEl.classList.add('enter'); setInterval(rotatePhrases, 3000); }, 2200);

            /* ── CARD CAROUSEL ── */
            (function () {
                const cards = Array.from(document.querySelectorAll('.card'));
                const N = cards.length;
                const pos = [
                    { x: '-30%', y: '0px', s: 1, z: 100, o: 1, r: 0 },
                    { x: '-2%', y: '26px', s: .89, z: 80, o: .88, r: 5 },
                    { x: '24%', y: '50px', s: .79, z: 60, o: .72, r: 10 },
                    { x: '48%', y: '72px', s: .70, z: 40, o: .52, r: 15 },
                    { x: '68%', y: '90px', s: .62, z: 20, o: .34, r: 20 },
                    { x: '86%', y: '104px', s: .55, z: 5, o: .18, r: 25 },
                ];
                let order = cards.map((_, i) => i);

                function applyAll() {
                    order.forEach((ci, pi) => {
                        const c = cards[ci], p = pos[pi];
                        c.style.zIndex = p.z; c.style.opacity = p.o;
                        c.style.transform = `translateX(${p.x}) translateY(${p.y}) scale(${p.s}) rotate(${p.r}deg)`;
                        c.style.boxShadow = pi === 0 ? '0 28px 60px rgba(0,0,0,.6), 0 0 0 1.5px rgba(61,186,126,.4)' : '0 16px 40px rgba(0,0,0,.35)';
                    });
                }

                function rotate() {
                    const front = cards[order[0]];
                    front.style.transition = 'transform .5s cubic-bezier(.5,0,1,.8), opacity .45s ease';
                    front.style.transform = `translateX(-140%) translateY(80px) scale(.42) rotate(-18deg)`;
                    front.style.opacity = '0'; front.style.zIndex = '1';
                    setTimeout(() => {
                        order.push(order.shift());
                        const lp = pos[N - 1];
                        front.style.transition = 'none';
                        front.style.transform = `translateX(${lp.x}) translateY(${lp.y}) scale(${lp.s}) rotate(${lp.r}deg)`;
                        front.style.opacity = String(lp.o); front.style.zIndex = String(lp.z);
                        void front.getBoundingClientRect();
                        cards.forEach(c => { c.style.transition = 'transform .9s cubic-bezier(.25,.9,.35,1.05), opacity .9s ease, box-shadow .4s ease'; });
                        applyAll();
                    }, 520);
                }

                applyAll();
                setInterval(rotate, 2800);
            })();

            /* ── PANEL OPEN / CLOSE ── */
            window.openLogin = function () { $('ph3').classList.add('login-active'); };
            $('closeLoginBtn').addEventListener('click', () => $('ph3').classList.remove('login-active'));

            /* ── TAB SWITCH ── */
            window.switchTab = function (tab) {
                const isMasuk = tab === 'masuk';

                $('tabMasuk').classList.toggle('active', isMasuk);
                $('tabDaftar').classList.toggle('active', !isMasuk);

                $('formMasuk').style.display = isMasuk ? 'block' : 'none';
                $('formDaftar').style.display = isMasuk ? 'none' : 'block';

                // Header dinamis
                $('panelTitle').innerHTML = isMasuk
                    ? 'Selamat datang<br>di <span>SEARA</span>'
                    : 'Buat akun<br><span>SEARA</span> Anda';
                $('panelSubtitle').textContent = isMasuk
                    ? 'Masuk untuk mulai bertransaksi.'
                    : 'Daftar gratis, mulai berjualan & berbelanja.';

                // Teks pendukung
                $('googleBtnText').textContent = isMasuk ? 'Lanjutkan dengan Google' : 'Daftar dengan Google';
                $('dividerText').textContent = isMasuk ? 'atau masuk dengan email' : 'atau daftar dengan email';
            };

            /* ── TOGGLE PASSWORD ── */
            window.togglePwd = function (inputId, btn) {
                const inp = $(inputId);
                if (!inp) return;
                if (inp.type === 'password') { inp.type = 'text'; btn.textContent = 'Sembunyikan'; }
                else { inp.type = 'password'; btn.textContent = 'Lihat'; }
            };

            /* ── PASSWORD STRENGTH ── */
            const pwdInp = $('regPassword');
            const fill = $('strengthFill');
            const label = $('strengthLabel');
            if (pwdInp && fill) {
                pwdInp.addEventListener('input', () => {
                    const v = pwdInp.value;
                    let s = 0;
                    if (v.length >= 6) s += 25;
                    if (v.length >= 10) s += 20;
                    if (/[A-Z]/.test(v)) s += 20;
                    if (/[0-9]/.test(v)) s += 20;
                    if (/[^A-Za-z0-9]/.test(v)) s += 15;
                    const score = Math.min(s, 100);
                    fill.style.width = score + '%';
                    if (score < 35) { fill.style.background = '#e05c5c'; if (label) { label.textContent = 'Kata sandi terlalu lemah'; label.style.color = '#e05c5c'; } }
                    else if (score < 65) { fill.style.background = '#e8c97e'; if (label) { label.textContent = 'Kata sandi cukup'; label.style.color = '#c49d3e'; } }
                    else { fill.style.background = '#3dba7e'; if (label) { label.textContent = 'Kata sandi kuat'; label.style.color = '#3dba7e'; } }
                });
            }

            /* ── LOGIN SUBMIT ── */
            $('doLoginBtn').addEventListener('click', async e => {
                e.preventDefault();
                const email = $('loginEmail')?.value.trim();
                const pass = $('loginPassword')?.value;
                const remember = $('rememberCheck')?.checked;

                if (!email || !pass) { alert('Harap isi email dan kata sandi.'); return; }

                const btn = $('doLoginBtn');
                btn.textContent = 'Memproses…';
                btn.disabled = true;

                try {
                    const res = await fetch('/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                ?? '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ email, password: pass, remember }),
                    });

                    const data = await res.json();

                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message ?? 'Login gagal. Periksa email dan kata sandi.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan jaringan. Coba lagi.');
                } finally {
                    btn.textContent = 'Masuk ke Dashboard';
                    btn.disabled = false;
                }
            });

            /* ── REGISTER SUBMIT ── */
            $('doRegisterBtn').addEventListener('click', async e => {
                e.preventDefault();
                const email = $('regEmail')?.value.trim();
                const username = $('regUsername')?.value.trim();
                const nama = $('regNama')?.value.trim();
                const alamat = $('regAlamat')?.value.trim();
                const wa = $('regWa')?.value.trim();
                const pass = $('regPassword')?.value;
                const confirm = $('regPasswordConfirm')?.value;

                if (!email || !username || !nama || !alamat || !wa || !pass || !confirm) {
                    alert('Harap lengkapi semua field pendaftaran.'); return;
                }
                if (/\s/.test(username)) {
                    alert('Username tidak boleh mengandung spasi.'); return;
                }
                if (pass !== confirm) { alert('Kata sandi dan konfirmasi tidak cocok.'); return; }
                if (pass.length < 8) { alert('Kata sandi minimal 8 karakter.'); return; }

                const btn = $('doRegisterBtn');
                btn.textContent = 'Membuat akun…';
                btn.disabled = true;

                try {
                    const res = await fetch('/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            email,
                            username,               // ← tambah ini
                            nama_lengkap: nama,
                            alamat,
                            no_whatsapp: wa,
                            password: pass,
                            password_confirmation: confirm,
                        }),
                    });

                    const data = await res.json();
                    if (data.success) {
                        alert(data.message);
                        window.location.href = data.redirect;
                    } else {
                        const errs = data.errors
                            ? Object.values(data.errors).flat().join('\n')
                            : data.message ?? 'Pendaftaran gagal.';
                        alert(errs);
                    }
                } catch (err) {
                    alert('Terjadi kesalahan jaringan. Coba lagi.');
                } finally {
                    btn.textContent = 'Buat Akun Sekarang →';
                    btn.disabled = false;
                }
            });

            /* ── GOOGLE ── */
            $('googleBtn').addEventListener('click', () => alert('Login Google segera hadir.'));

            /* ── FORGOT ── */
            $('forgotLink').addEventListener('click', e => { e.preventDefault(); alert('Link reset password akan dikirim ke email Anda.'); });

            /* ── TICKER ── */
            const stats = [
                { l: 'TIM DEVELOPER', v: 'POLITEKNIK MANUFAKTUR NEGERI BANGKA BELITUNG' }, { l: 'Eksplor Produk Segar', v: 'Dapatkan hasil tani langsung dari petani' },
                { l: 'Mulai Jual Hasil Panen', v: 'Pasarkan produk pertanianmu lebih luas' }, { l: 'Provinsi Terjangkau', v: '27' },
                { l: 'Gabung Sekarang', v: 'Bangun ekosistem pertanian digital bersama' }, { l: 'Dijamin Kepuasan Berbelanja', v: '⭐ Bintang 5' },
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