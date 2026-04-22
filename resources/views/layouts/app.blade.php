<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SEARA') — Dari Petani Untuk Petani</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    {{-- Global CSS Variables & Base Styles --}}
    <style>
        :root {
            --green-dark:  #2c5f2e;
            --green-main:  #3a7d44;
            --green-mid:   #4e9a55;
            --green-light: #6abf6a;
            --green-pale:  #e8f5e9;
            --green-bg:    #f4faf4;
            --accent:      #ff6b35;
            --accent-soft: #fff3ee;
            --yellow:      #ffc107;
            --text-dark:   #1a2e1a;
            --text-mid:    #4a6a4a;
            --text-muted:  #8aaa8a;
            --border:      #d4ebd4;
            --white:       #ffffff;
            --shadow-sm:   0 2px 8px rgba(58,125,68,0.10);
            --shadow-md:   0 6px 24px rgba(58,125,68,0.14);
            --shadow-lg:   0 12px 40px rgba(58,125,68,0.18);
            --r: 12px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; background: var(--green-bg); color: var(--text-dark); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ::-webkit-scrollbar { width: 5px; height: 4px; }
        ::-webkit-scrollbar-track { background: var(--green-bg); }
        ::-webkit-scrollbar-thumb { background: var(--green-light); border-radius: 3px; }
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
    <main id="app-content">
        @yield('content')
    </main>

    {{-- Only show footer if NOT splash or dashboard --}}
    @unless(View::hasSection('hide-footer'))
        @include('partials.footer')
    @endunless

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>
