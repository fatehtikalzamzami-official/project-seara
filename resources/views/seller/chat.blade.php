<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan — SEARA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --green-dark: #1a4731;
            --green-main: #2d8653;
            --green-mid: #3dba7e;
            --green-light: #52dda0;
            --green-pale: #f0fdf6;
            --green-bg: #f5f9f6;
            --accent: #e05c2e;
            --accent-soft: #fff0eb;
            --yellow: #f5a623;
            --yellow-soft: #fffbeb;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --text-dark: #0f2419;
            --text-mid: #3d5c49;
            --text-muted: #7a9585;
            --border: #e2ece7;
            --white: #ffffff;
            --bg: #f5f9f6;
            --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 18px rgba(0, 0, 0, .09);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark);
        }

        /* ── LAYOUT ── */
        .seller-wrap {
            display: flex;
            min-height: 100vh;
        }

        .seller-main {
            flex: 1;
            padding: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            flex-shrink: 0;
        }

        .page-header-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600;
        }

        .chat-unread-pill {
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            background: var(--accent);
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
        }

        /* ── CHAT BODY ── */
        .chat-body {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 0;
            flex: 1;
            min-height: 0;
            border-radius: 18px;
            overflow: hidden;
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-md);
        }

        /* ══════════════════════════════════
           PANEL KIRI — Daftar Room
           ══════════════════════════════════ */
        .rooms-panel {
            background: white;
            border-right: 1.5px solid var(--border);
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .rooms-panel-head {
            padding: 16px 16px 12px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .rooms-panel-head h2 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .rooms-search-wrap {
            position: relative;
        }

        .rooms-search {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            outline: none;
            background: var(--green-bg);
            transition: border-color .2s;
        }

        .rooms-search:focus {
            border-color: var(--green-main);
            background: white;
        }

        .rooms-search-ico {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .rooms-list {
            flex: 1;
            overflow-y: auto;
        }

        .rooms-list::-webkit-scrollbar {
            width: 3px;
        }

        .rooms-list::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        .room-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
            transition: background .15s;
            text-decoration: none;
            color: inherit;
        }

        .room-item:hover {
            background: var(--green-bg);
        }

        .room-item.active {
            background: var(--green-pale);
            border-right: 3px solid var(--green-main);
        }

        .room-item.has-unread .room-last-msg {
            font-weight: 800;
            color: var(--text-dark);
        }

        .room-ava {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--green-light), var(--green-dark));
            color: white;
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .room-info {
            flex: 1;
            min-width: 0;
        }

        .room-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .room-product-tag {
            font-size: 11px;
            color: var(--green-main);
            font-weight: 700;
            margin: 1px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .room-last-msg {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .room-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }

        .room-time {
            font-size: 10px;
            color: var(--text-muted);
        }

        .room-badge {
            background: var(--green-main);
            color: white;
            font-size: 10px;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .rooms-empty {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .rooms-empty .ico {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .rooms-empty p {
            font-size: 13px;
        }

        /* ══════════════════════════════════
           PANEL KANAN — Ruang Chat
           ══════════════════════════════════ */
        .msg-panel {
            display: flex;
            flex-direction: column;
            background: var(--green-bg);
            min-height: 0;
        }

        /* Placeholder */
        .msg-placeholder {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--text-muted);
        }

        .msg-placeholder .big-icon {
            font-size: 64px;
        }

        .msg-placeholder h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-mid);
        }

        .msg-placeholder p {
            font-size: 13px;
        }

        /* Header room aktif */
        .msg-head {
            background: white;
            border-bottom: 1.5px solid var(--border);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .msg-head-ava {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--green-main), var(--green-dark));
            color: white;
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .msg-head-info {
            flex: 1;
        }

        .msg-head-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .msg-head-status {
            font-size: 11px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }

        /* Online dot */
        .online-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .online-dot.online {
            background: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, .25);
        }

        .online-dot.offline {
            background: #9ca3af;
        }

        .status-text {
            font-size: 11px;
        }

        .status-text.online {
            color: #16a34a;
            font-weight: 700;
        }

        .status-text.offline {
            color: var(--text-muted);
        }

        .msg-head-product {
            font-size: 11px;
            font-weight: 700;
            background: var(--green-pale);
            color: var(--green-dark);
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* Area pesan */
        .msg-area {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            scroll-behavior: smooth;
        }

        .msg-area::-webkit-scrollbar {
            width: 4px;
        }

        .msg-area::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        /* Date separator */
        .date-sep {
            text-align: center;
            margin: 4px 0;
        }

        .date-sep span {
            font-size: 11px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, .8);
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid var(--border);
        }

        /* Bubble */
        .msg-row {
            display: flex;
            align-items: flex-end;
            gap: 7px;
        }

        .msg-row.mine {
            flex-direction: row-reverse;
        }

        .msg-ava {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--green-pale);
            color: var(--green-dark);
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .msg-ava.mine {
            background: var(--green-main);
            color: white;
        }

        .msg-grp {
            display: flex;
            flex-direction: column;
            gap: 2px;
            max-width: 65%;
        }

        .msg-row.mine .msg-grp {
            align-items: flex-end;
        }

        .bubble {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.6;
            word-break: break-word;
        }

        .bubble.other {
            background: white;
            color: var(--text-dark);
            border: 1.5px solid var(--border);
            border-bottom-left-radius: 4px;
        }

        .bubble.mine {
            background: var(--green-main);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .btime {
            font-size: 10px;
            color: var(--text-muted);
            padding: 0 2px;
        }

        .msg-row.mine .btime {
            text-align: right;
        }

        .bread {
            font-size: 10px;
            color: var(--green-main);
        }

        /* Konteks produk */
        .ctx-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
            flex-shrink: 0;
        }

        .ctx-emoji {
            font-size: 26px;
        }

        .ctx-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .ctx-price {
            font-size: 12px;
            color: var(--green-main);
            font-weight: 700;
        }

        /* Offer card */
        .offer-card {
            background: white;
            border: 2px solid var(--green-main);
            border-radius: 14px;
            padding: 14px 16px;
            max-width: 320px;
            width: 100%;
        }

        .offer-card.mine-card {
            align-self: flex-end;
            border-color: var(--green-light);
        }

        .offer-card-head {
            font-size: 12px;
            font-weight: 800;
            color: var(--green-dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .offer-price-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 6px;
        }

        .offer-price-new {
            font-size: 22px;
            font-weight: 900;
            color: var(--accent);
        }

        .offer-price-old {
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: line-through;
        }

        .offer-disc {
            font-size: 11px;
            font-weight: 800;
            background: #fff3ee;
            color: var(--accent);
            padding: 2px 7px;
            border-radius: 5px;
        }

        .offer-qty {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .offer-note {
            font-size: 12px;
            color: var(--text-mid);
            font-style: italic;
            margin-bottom: 10px;
            padding: 6px 10px;
            background: var(--green-pale);
            border-radius: 8px;
        }

        .offer-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .offer-status.pending {
            background: #fef9c3;
            color: #854d0e;
        }

        .offer-status.accepted {
            background: #dcfce7;
            color: #166534;
        }

        .offer-status.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .offer-status.countered {
            background: #e0f2fe;
            color: #075985;
        }

        .offer-status.cancelled {
            background: #f3f4f6;
            color: #6b7280;
        }

        .offer-actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .offer-btn {
            padding: 7px 14px;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: all .2s;
        }

        .offer-btn.accept {
            background: var(--green-main);
            color: white;
        }

        .offer-btn.accept:hover {
            background: var(--green-dark);
        }

        .offer-btn.reject {
            background: #fee2e2;
            color: #dc2626;
        }

        .offer-btn.reject:hover {
            background: #fecaca;
        }

        .offer-btn.counter {
            background: #e0f2fe;
            color: #0369a1;
        }

        .offer-btn.counter:hover {
            background: #bae6fd;
        }

        /* Typing */
        .typing-row {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .typing-bub {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            border-bottom-left-radius: 3px;
            padding: 9px 14px;
            display: flex;
            gap: 4px;
        }

        .typing-bub span {
            width: 6px;
            height: 6px;
            background: #bbb;
            border-radius: 50%;
            animation: tb .9s infinite;
        }

        .typing-bub span:nth-child(2) {
            animation-delay: .15s;
        }

        .typing-bub span:nth-child(3) {
            animation-delay: .3s;
        }

        @keyframes tb {

            0%,
            60%,
            100% {
                transform: translateY(0)
            }

            30% {
                transform: translateY(-5px)
            }
        }

        /* Quick replies */
        .quick-row {
            padding: 8px 14px;
            background: white;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .qr-btn {
            font-size: 11px;
            font-weight: 700;
            color: var(--green-dark);
            background: var(--green-pale);
            border: 1px solid var(--border);
            padding: 4px 10px;
            border-radius: 20px;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
            transition: all .15s;
            white-space: nowrap;
        }

        .qr-btn:hover {
            background: #c8e6c9;
            border-color: var(--green-main);
        }

        /* Input */
        .msg-input-wrap {
            background: white;
            border-top: 1.5px solid var(--border);
            padding: 10px 14px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            flex-shrink: 0;
        }

        .msg-input {
            flex: 1;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 9px 14px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            outline: none;
            resize: none;
            max-height: 100px;
            overflow-y: auto;
            transition: border-color .2s;
            line-height: 1.5;
        }

        .msg-input:focus {
            border-color: var(--green-main);
        }

        .msg-send {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--green-main);
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
        }

        .msg-send:hover {
            background: var(--green-dark);
            transform: scale(1.05);
        }

        .msg-send:active {
            transform: scale(.95);
        }

        .msg-send:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Modal Tawar */
        .offer-modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9500;
            background: rgba(0, 0, 0, .5);
            backdrop-filter: blur(3px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .offer-modal-bg.open {
            display: flex;
        }

        .offer-modal {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
            animation: modalIn .28s cubic-bezier(.22, 1, .36, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(12px)
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0)
            }
        }

        .offer-modal-head {
            padding: 20px 22px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .offer-modal-head h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .offer-modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--green-pale);
            color: var(--text-mid);
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .offer-modal-body {
            padding: 16px 22px 22px;
        }

        .offer-product-info {
            background: var(--green-pale);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .offer-product-emoji {
            font-size: 28px;
        }

        .offer-product-name {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .offer-product-orig {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .offer-form-group {
            margin-bottom: 14px;
        }

        .offer-form-label {
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
            display: block;
        }

        .offer-form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            outline: none;
            transition: border-color .2s;
            color: var(--text-dark);
        }

        .offer-form-input:focus {
            border-color: var(--green-main);
        }

        .offer-savings {
            background: #fff3ee;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .offer-savings-label {
            font-size: 12px;
            color: var(--text-muted);
        }

        .offer-savings-val {
            font-size: 15px;
            font-weight: 900;
            color: var(--accent);
        }

        .offer-submit-btn {
            width: 100%;
            padding: 13px;
            background: var(--green-main);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s;
        }

        .offer-submit-btn:hover {
            background: var(--green-dark);
        }

        .offer-submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Counter modal */
        .counter-modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9600;
            background: rgba(0, 0, 0, .5);
            backdrop-filter: blur(3px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .counter-modal-bg.open {
            display: flex;
        }

        @keyframes msgIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .msg-row {
            animation: msgIn .2s ease both;
        }

        @media (max-width: 768px) {
            .seller-main {
                padding: 12px;
            }

            .chat-body {
                grid-template-columns: 1fr;
            }

            .rooms-panel {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="seller-wrap">

        {{-- ══ SIDEBAR ══ --}}
        @include('partials.seller_sidebar')

        {{-- ══ MAIN ══ --}}
        <main class="seller-main">

            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-header-left">
                    <h1>
                        <i class="fa-solid fa-comments" style="color:var(--green-main)"></i>
                        Pesan Saya
                        @if($totalUnread > 0)
                            <span class="chat-unread-pill">{{ $totalUnread }} baru</span>
                        @endif
                    </h1>
                    <p>Kelola percakapan dengan pembeli di sini.</p>
                </div>
            </div>

            <div class="chat-body">

                {{-- ── PANEL KIRI: List room ── --}}
                <div class="rooms-panel">
                    <div class="rooms-panel-head">
                        <h2>Percakapan</h2>
                        <div class="rooms-search-wrap">
                            <i class="fa-solid fa-magnifying-glass rooms-search-ico"></i>
                            <input class="rooms-search" type="text" placeholder="Cari nama pembeli..."
                                oninput="filterRooms(this.value)">
                        </div>
                    </div>

                    <div class="rooms-list" id="roomsList">
                        @forelse($rooms as $room)
                            @php
                                $uid = Auth::id();
                                $other = $room->otherUser($uid);
                                $unread = $room->unreadCount($uid);
                                $lastMsg = $room->lastMessage;
                                $initials = strtoupper(substr($other->nama_lengkap ?? $other->name ?? 'U', 0, 2));
                            @endphp
                            <a href="{{ route('seller.chat.show', $room->id) }}"
                                class="room-item {{ isset($activeRoom) && $activeRoom->id === $room->id ? 'active' : '' }} {{ $unread > 0 ? 'has-unread' : '' }}"
                                data-room="{{ $room->id }}"
                                data-name="{{ strtolower($other->nama_lengkap ?? $other->name ?? '') }}">
                                <div class="room-ava">{{ $initials }}</div>
                                <div class="room-info">
                                    <div class="room-name">{{ $other->nama_lengkap ?? $other->name ?? 'Pengguna' }}</div>
                                    @if($room->harvest)
                                        <div class="room-product-tag">🌾 {{ $room->harvest->product->name ?? '' }}</div>
                                    @endif
                                    <div class="room-last-msg">
                                        @if($lastMsg)
                                            {{ $lastMsg->sender_id === $uid ? 'Kamu: ' : '' }}{{ Str::limit($lastMsg->body, 40) }}
                                        @else
                                            Mulai percakapan...
                                        @endif
                                    </div>
                                </div>
                                <div class="room-meta">
                                    <span
                                        class="room-time">{{ $room->last_message_at?->diffForHumans(null, true) ?? '' }}</span>
                                    @if($unread > 0)
                                        <span class="room-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="rooms-empty">
                                <div class="ico">💬</div>
                                <p>Belum ada percakapan.<br>Percakapan dari pembeli akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ── PANEL KANAN: Ruang chat ── --}}
                <div class="msg-panel" id="msgPanel">

                    @if(isset($activeRoom))
                        {{-- Header --}}
                        <div class="msg-head">
                            <div class="msg-head-ava">
                                {{ strtoupper(substr($activeOther->nama_lengkap ?? $activeOther->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="msg-head-info">
                                <div class="msg-head-name">
                                    {{ $activeOther->nama_lengkap ?? $activeOther->name ?? 'Pengguna' }}</div>
                                <div class="msg-head-status">
                                    <span class="online-dot {{ $activeOther->isOnline() ? 'online' : 'offline' }}"
                                        id="onlineDot"></span>
                                    <span class="status-text {{ $activeOther->isOnline() ? 'online' : 'offline' }}"
                                        id="onlineText">
                                        {{ $activeOther->onlineLabel() }}
                                    </span>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;">
                                @if($activeRoom->harvest)
                                    <div class="msg-head-product">🌾 {{ $activeRoom->harvest->product->name ?? '' }}</div>
                                @endif
                            </div>
                        </div>

                        {{-- Area pesan --}}
                        <div class="msg-area" id="msgArea">

                            @if($activeRoom->harvest)
                                <div class="ctx-card">
                                    <div class="ctx-emoji">🌾</div>
                                    <div>
                                        <div class="ctx-name">{{ $activeRoom->harvest->product->name ?? '' }}</div>
                                        <div class="ctx-price">Rp
                                            {{ number_format($activeRoom->harvest->price_per_unit, 0, ',', '.') }} /
                                            {{ $activeRoom->harvest->product->unit ?? 'kg' }}</div>
                                    </div>
                                </div>
                            @endif

                            @php $lastDate = null;
                            $myId = Auth::id(); @endphp
                            @foreach($activeMessages as $msg)
                                @php
                                    $msgDate = $msg->created_at->format('Y-m-d');
                                    $isMine = $msg->sender_id === $myId;
                                    $ini = strtoupper(substr($msg->sender->nama_lengkap ?? $msg->sender->name ?? 'U', 0, 2));
                                @endphp
                                @if($msgDate !== $lastDate)
                                    <div class="date-sep">
                                        <span>{{ $msg->created_at->isToday() ? 'Hari ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->format('d M Y')) }}</span>
                                    </div>
                                    @php $lastDate = $msgDate; @endphp
                                @endif
                                @php
                                    $isOfferMsg = preg_match('/\[offer:(\d+)\]/', $msg->body, $offerMatch);
                                    $offerObj = $isOfferMsg ? \App\Models\PriceOffer::find($offerMatch[1]) : null;
                                    $cleanBody = $isOfferMsg ? preg_replace('/\[offer:\d+\]/', '', $msg->body) : $msg->body;
                                @endphp
                                <div class="msg-row {{ $isMine ? 'mine' : '' }}" data-id="{{ $msg->id }}">
                                    <div class="msg-ava {{ $isMine ? 'mine' : '' }}">{{ $ini }}</div>
                                    <div class="msg-grp" style="max-width:70%;">
                                        @if($offerObj)
                                            <div class="offer-card {{ $isMine ? 'mine-card' : '' }}"
                                                data-offer-id="{{ $offerObj->id }}">
                                                <div class="offer-card-head">💰 Penawaran Harga</div>
                                                <div class="offer-price-row">
                                                    <span class="offer-price-new">Rp
                                                        {{ number_format($offerObj->counter_price ?? $offerObj->offer_price, 0, ',', '.') }}</span>
                                                    <span class="offer-price-old">Rp
                                                        {{ number_format($offerObj->original_price, 0, ',', '.') }}</span>
                                                    <span class="offer-disc">-{{ $offerObj->discountPct() }}%</span>
                                                </div>
                                                <div class="offer-qty">Jumlah: {{ $offerObj->quantity }}
                                                    {{ $activeRoom->harvest->product->unit ?? 'unit' }}</div>
                                                @if($offerObj->buyer_note)
                                                <div class="offer-note">"{{ $offerObj->buyer_note }}"</div>@endif
                                                @if($offerObj->seller_note && $offerObj->status !== 'pending')
                                                    <div class="offer-note" style="background:#e0f2fe;">Penjual:
                                                "{{ $offerObj->seller_note }}"</div>@endif
                                                @if($offerObj->counter_price && $offerObj->status === 'countered')
                                                    <div style="font-size:12px;color:#0369a1;font-weight:700;margin-bottom:8px;">🔄
                                                        Tawar balik: Rp {{ number_format($offerObj->counter_price, 0, ',', '.') }}</div>
                                                @endif
                                                <div class="offer-status {{ $offerObj->status }}">{{ $offerObj->statusLabel() }}
                                                </div>
                                                {{-- Seller menerima/menolak/tawar balik --}}
                                                @if($offerObj->isPending() && !$isMine && Auth::id() === ($activeRoom->harvest->seller->user_id ?? -1))
                                                    <div class="offer-actions">
                                                        <button class="offer-btn accept" onclick="acceptOffer({{ $offerObj->id }})">✅
                                                            Terima</button>
                                                        <button class="offer-btn counter"
                                                            onclick="openCounterModal({{ $offerObj->id }}, {{ $offerObj->offer_price }})">🔄
                                                            Tawar Balik</button>
                                                        <button class="offer-btn reject" onclick="rejectOffer({{ $offerObj->id }})">❌
                                                            Tolak</button>
                                                    </div>
                                                @elseif($offerObj->isCountered() && $isMine)
                                                    <div class="offer-actions">
                                                        <button class="offer-btn accept" onclick="acceptOffer({{ $offerObj->id }})">✅
                                                            Terima Tawar Balik</button>
                                                        <button class="offer-btn reject" onclick="rejectOffer({{ $offerObj->id }})">🚫
                                                            Tolak</button>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="bubble {{ $isMine ? 'mine' : 'other' }}" style="white-space:pre-line;">
                                                {{ $cleanBody }}</div>
                                        @endif
                                        <div class="btime">
                                            {{ $msg->created_at->format('H:i') }}
                                            @if($isMine && $msg->read_at)<span class="bread">✓✓</span>@endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- Quick replies --}}
                        <div class="quick-row" id="quickRow">
                            <button class="qr-btn" onclick="useQuick(this)">Stok masih tersedia</button>
                            <button class="qr-btn" onclick="useQuick(this)">Min. order 1 kg</button>
                            <button class="qr-btn" onclick="useQuick(this)">Bisa kirim luar kota</button>
                            <button class="qr-btn" onclick="useQuick(this)">Panen berikutnya minggu depan</button>
                        </div>

                        {{-- Input --}}
                        <div class="msg-input-wrap">
                            <textarea class="msg-input" id="msgInput" rows="1" placeholder="Tulis pesan..."
                                onkeydown="handleKey(event)" oninput="autoResize(this)"></textarea>
                            <button class="msg-send" id="sendBtn" onclick="sendMessage()">
                                <i class="fa-solid fa-paper-plane" style="font-size:15px;"></i>
                            </button>
                        </div>

                    @else
                        {{-- Placeholder --}}
                        <div class="msg-placeholder">
                            <div class="big-icon">💬</div>
                            <h3>Pilih percakapan</h3>
                            <p>Klik nama di sebelah kiri untuk membuka chat</p>
                        </div>
                    @endif

                </div>
            </div>

        </main>
    </div>

    {{-- ══ MODAL COUNTER OFFER ══ --}}
    @if(isset($activeRoom) && $activeRoom->harvest)
        <div class="counter-modal-bg" id="counterModalBg" onclick="closeCounterModal(event)">
            <div class="offer-modal">
                <div class="offer-modal-head">
                    <h3>🔄 Tawar Balik</h3>
                    <button class="offer-modal-close" onclick="closeCounterModal()">✕</button>
                </div>
                <div class="offer-modal-body">
                    <input type="hidden" id="counterOfferId">
                    <div class="offer-product-info">
                        <div class="offer-product-emoji">🌾</div>
                        <div>
                            <div class="offer-product-name">{{ $activeRoom->harvest->product->name ?? 'Produk' }}</div>
                            <div class="offer-product-orig">Harga asli: <strong>Rp
                                    {{ number_format($activeRoom->harvest->price_per_unit, 0, ',', '.') }}</strong> /
                                {{ $activeRoom->harvest->product->unit ?? 'kg' }}</div>
                        </div>
                    </div>
                    <div class="offer-form-group">
                        <label class="offer-form-label">Harga Tawar Balikmu</label>
                        <input type="number" class="offer-form-input" id="counterPriceInput" min="1"
                            placeholder="Masukkan harga...">
                    </div>
                    <div class="offer-form-group">
                        <label class="offer-form-label">Catatan (opsional)</label>
                        <input type="text" class="offer-form-input" id="counterNoteInput"
                            placeholder="Misal: ini harga terendah saya..." style="font-weight:500;font-size:13px;">
                    </div>
                    <button class="offer-submit-btn" onclick="submitCounter()">Kirim Tawar Balik</button>
                </div>
            </div>
        </div>
    @endif

    <script>
        @if(isset($activeRoom))
            const ROOM_ID = {{ $activeRoom->id }};
            const MY_ID = {{ Auth::id() }};
            const MY_INIT = '{{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? "U", 0, 2)) }}';
            const OTHER_INIT = '{{ strtoupper(substr($activeOther->nama_lengkap ?? $activeOther->name ?? "U", 0, 2)) }}';
            let lastId = {{ $activeMessages->last()?->id ?? 0 }};
            let polling = null;

            function scrollBottom(smooth = true) {
                const el = document.getElementById('msgArea');
                if (el) el.scrollTo({ top: el.scrollHeight, behavior: smooth ? 'smooth' : 'instant' });
            }
            scrollBottom(false);

            function autoResize(el) {
                el.style.height = 'auto';
                el.style.height = Math.min(el.scrollHeight, 100) + 'px';
            }

            function handleKey(e) {
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
            }

            function useQuick(btn) {
                document.getElementById('msgInput').value = btn.textContent.trim();
                document.getElementById('msgInput').focus();
                document.getElementById('quickRow').style.display = 'none';
            }

            function escHtml(str) {
                return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            }

            function renderBubble(msg) {
                const isMine = msg.is_mine;
                const init = isMine ? MY_INIT : OTHER_INIT;
                const div = document.createElement('div');
                div.className = 'msg-row ' + (isMine ? 'mine' : '');
                div.dataset.id = msg.id;
                const cleanBody = msg.body.replace(/\[offer:\d+\]/, '').trim();
                div.innerHTML = `
            <div class="msg-ava ${isMine ? 'mine' : ''}">${init}</div>
            <div class="msg-grp">
                <div class="bubble ${isMine ? 'mine' : 'other'}" style="white-space:pre-line">${escHtml(cleanBody)}</div>
                <div class="btime">${msg.time}</div>
            </div>`;
                return div;
            }

            async function sendMessage() {
                const input = document.getElementById('msgInput');
                const body = input.value.trim();
                if (!body) return;
                const btn = document.getElementById('sendBtn');
                btn.disabled = true;
                input.value = '';
                input.style.height = 'auto';
                document.getElementById('quickRow').style.display = 'none';

                try {
                    const res = await fetch(`/chat/${ROOM_ID}/send`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ body })
                    });
                    const data = await res.json();
                    const area = document.getElementById('msgArea');
                    data.messages.forEach(msg => {
                        if (msg.id > lastId) { area.appendChild(renderBubble(msg)); lastId = msg.id; }
                    });
                    scrollBottom();
                    updateRoomPreview(ROOM_ID, body);
                } catch (e) { console.error(e); }
                finally { btn.disabled = false; input.focus(); }
            }

            async function pollMessages() {
                try {
                    const res = await fetch(`/chat/${ROOM_ID}/poll?since=${lastId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await res.json();
                    if (data.messages?.length) {
                        const area = document.getElementById('msgArea');
                        data.messages.forEach(msg => {
                            if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                                area.appendChild(renderBubble(msg));
                                lastId = Math.max(lastId, msg.id);
                                updateRoomPreview(ROOM_ID, msg.body);
                            }
                        });
                        scrollBottom();
                    }
                } catch (e) { }
            }

            polling = setInterval(pollMessages, 3000);
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) clearInterval(polling);
                else polling = setInterval(pollMessages, 3000);
            });
        @endif

            // ── Filter room list ──
            function filterRooms(q) {
                q = q.toLowerCase();
                document.querySelectorAll('#roomsList .room-item').forEach(el => {
                    el.style.display = (el.dataset.name || '').includes(q) ? '' : 'none';
                });
            }

        function updateRoomPreview(roomId, text) {
            const item = document.querySelector(`[data-room="${roomId}"] .room-last-msg`);
            if (item) item.textContent = 'Kamu: ' + text.substring(0, 40);
        }

        // ── Online status polling ──
        @if(isset($activeOther))
            const OTHER_USER_ID = {{ $activeOther->id }};
            async function pollOnlineStatus() {
                try {
                    const res = await fetch(`/chat/online-status?user_id=${OTHER_USER_ID}`, {
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    });
                    const data = await res.json();
                    const dot = document.getElementById('onlineDot');
                    const txt = document.getElementById('onlineText');
                    if (!dot || !txt) return;
                    dot.className = 'online-dot ' + (data.is_online ? 'online' : 'offline');
                    txt.className = 'status-text ' + (data.is_online ? 'online' : 'offline');
                    txt.textContent = data.label;
                } catch (e) { }
            }
            setInterval(pollOnlineStatus, 15000);
        @endif

            // ── Offer actions (Seller) ──
            @if(isset($activeRoom) && $activeRoom->harvest)
                    async function acceptOffer(offerId) {
                        if (!confirm('Terima tawaran ini?')) return;
                        try {
                            const res = await fetch(`/offers/${offerId}/accept`, {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
                            });
                            const data = await res.json();
                            if (data.success) { showToast('✅ Tawaran diterima!'); setTimeout(() => location.reload(), 800); }
                        } catch (e) { }
                    }

                async function rejectOffer(offerId) {
                    const note = prompt('Alasan penolakan (opsional):') ?? '';
                    try {
                        const res = await fetch(`/offers/${offerId}/reject`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                            body: JSON.stringify({ seller_note: note })
                        });
                        const data = await res.json();
                        if (data.success) { showToast('❌ Tawaran ditolak.'); setTimeout(() => location.reload(), 800); }
                    } catch (e) { }
                }

                function openCounterModal(offerId, offerPrice) {
                    document.getElementById('counterOfferId').value = offerId;
                    document.getElementById('counterPriceInput').value = Math.round(offerPrice * 1.05);
                    document.getElementById('counterNoteInput').value = '';
                    document.getElementById('counterModalBg').classList.add('open');
                    document.getElementById('counterPriceInput').focus();
                }
                function closeCounterModal(e) {
                    if (!e || e.target === document.getElementById('counterModalBg'))
                        document.getElementById('counterModalBg').classList.remove('open');
                }
                async function submitCounter() {
                    const id = document.getElementById('counterOfferId').value;
                    const price = parseFloat(document.getElementById('counterPriceInput').value);
                    const note = document.getElementById('counterNoteInput').value.trim();
                    if (!price || price <= 0) { alert('Masukkan harga yang valid.'); return; }
                    try {
                        const res = await fetch(`/offers/${id}/counter`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                            body: JSON.stringify({ counter_price: price, seller_note: note })
                        });
                        const data = await res.json();
                        if (data.success) { closeCounterModal(); showToast('🔄 Tawar balik terkirim!'); setTimeout(() => location.reload(), 800); }
                    } catch (e) { }
                }
            @endif

        function showToast(msg) {
            let t = document.getElementById('chatToast');
            if (!t) {
                t = document.createElement('div');
                t.id = 'chatToast';
                t.style.cssText = 'position:fixed;bottom:32px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--green-dark);color:white;padding:11px 22px;border-radius:50px;font-size:14px;font-weight:700;opacity:0;transition:all .35s cubic-bezier(.22,1,.36,1);z-index:9999;pointer-events:none;box-shadow:0 8px 24px rgba(0,0,0,.2);white-space:nowrap;';
                document.body.appendChild(t);
            }
            t.textContent = msg;
            t.style.opacity = '1'; t.style.transform = 'translateX(-50%) translateY(0)';
            setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(-50%) translateY(20px)'; }, 2800);
        }
    </script>

</body>

</html>