<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SEARA') — Dari Petani Untuk Petani</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/LOGO_FIKS_LIGHT.png') }}">

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    {{-- Global CSS Variables & Base Styles --}}
    <style>
        :root {
            --green-dark: #2c5f2e;
            --green-main: #3a7d44;
            --green-mid: #4e9a55;
            --green-light: #6abf6a;
            --green-pale: #e8f5e9;
            --green-bg: #f4faf4;
            --accent: #ff6b35;
            --accent-soft: #fff3ee;
            --yellow: #ffc107;
            --text-dark: #1a2e1a;
            --text-mid: #4a6a4a;
            --text-muted: #8aaa8a;
            --border: #d4ebd4;
            --white: #ffffff;
            --shadow-sm: 0 2px 8px rgba(58, 125, 68, 0.10);
            --shadow-md: 0 6px 24px rgba(58, 125, 68, 0.14);
            --shadow-lg: 0 12px 40px rgba(58, 125, 68, 0.18);
            --r: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--green-bg);
            color: var(--text-dark);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--green-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--green-light);
            border-radius: 3px;
        }
    </style>

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body class="@yield('body-class')">

    {{-- Only show topbar/navbar if NOT splash --}}
    @unless(View::hasSection('hide-header'))
        @include('partials.topbar')
        @include('partials.navbar')
    @endunless

    {{-- Main Content --}}
    <main id="app-content" style="flex: 1;">
        @yield('content')
    </main>

    {{-- Only show footer if NOT splash or dashboard --}}
    @unless(View::hasSection('hide-footer'))
        @include('partials.footer')
    @endunless

    {{-- ── LOGOUT MODAL (global) ── --}}
    <div id="logoutModal" style="
        display:none; position:fixed; inset:0; z-index:9999;
        background:rgba(0,0,0,0.45); backdrop-filter:blur(4px);
        align-items:center; justify-content:center;">
        <div style="
            background:#fff; border-radius:20px; padding:32px 28px;
            width:100%; max-width:360px; margin:16px;
            box-shadow:0 20px 60px rgba(0,0,0,0.2);
            animation:modalIn .25s cubic-bezier(0.4,0,0.2,1);">
            <div style="text-align:center; margin-bottom:20px;">
                <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#e05c5c" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div style="font-size:17px;font-weight:800;color:#1a2e1a;margin-bottom:6px;">Yakin ingin keluar?</div>
                <div style="font-size:13px;color:#8aaa8a;font-weight:500;">Sesi kamu akan diakhiri dari SEARA.</div>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="closeLogoutModal()" style="
                    flex:1;padding:11px;border-radius:12px;border:1.5px solid #d4ebd4;
                    background:#fff;font-family:'Nunito',sans-serif;font-size:13px;
                    font-weight:700;color:#8aaa8a;cursor:pointer;transition:all .2s;"
                    onmouseover="this.style.borderColor='#3a7d44';this.style.color='#1a2e1a'"
                    onmouseout="this.style.borderColor='#d4ebd4';this.style.color='#8aaa8a'">
                    Batal
                </button>
                <button onclick="document.getElementById('globalLogoutForm').submit()" style="
                    flex:1;padding:11px;border-radius:12px;border:none;background:#e05c5c;
                    font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;
                    color:#fff;cursor:pointer;transition:background .2s;" onmouseover="this.style.background='#c94f4f'"
                    onmouseout="this.style.background='#e05c5c'">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    <form id="globalLogoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
        @csrf
    </form>

    <style>
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.93) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
        document.getElementById('logoutModal').addEventListener('click', function (e) {
            if (e.target === this) closeLogoutModal();
        });
    </script>

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</body>

</html>