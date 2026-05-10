<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Panen – SEARA</title>
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
            --accent: #e05c2e;
            --accent-soft: #fff0eb;
            --yellow: #f5a623;
            --yellow-soft: #fffbeb;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --purple: #7c3aed;
            --purple-soft: #ede9fe;
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

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark);
        }

        /* ── Layout ── */
        .seller-wrap {
            display: flex;
            min-height: 100vh;
        }

        .seller-main {
            flex: 1;
            padding: 24px;
            overflow-x: hidden;
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .page-header-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600;
        }

        .page-header-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* ── Buttons ── */
        .btn-green {
            padding: 9px 18px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-main));
            border: none;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 13px;
            color: white;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(61, 186, 126, .25);
            text-decoration: none;
        }

        .btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(61, 186, 126, .3);
        }

        .btn-outline {
            padding: 9px 18px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: var(--text-mid);
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-outline:hover {
            border-color: var(--green-main);
            color: var(--green-dark);
        }

        /* ── Alert ── */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--green-dark);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* ── Upcoming Banner ── */
        .upcoming-banner {
            background: linear-gradient(135deg, var(--green-dark), #1e5c38);
            border-radius: var(--r);
            padding: 16px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            color: white;
        }

        .upcoming-banner .ub-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, .15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .upcoming-banner .ub-text strong {
            font-size: 15px;
            font-weight: 900;
            display: block;
        }

        .upcoming-banner .ub-text span {
            font-size: 12px;
            color: rgba(255, 255, 255, .7);
            font-weight: 600;
        }

        .upcoming-banner .ub-count {
            margin-left: auto;
            font-size: 32px;
            font-weight: 900;
            color: var(--green-light);
            line-height: 1;
        }

        /* ── Stats Bar ── */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 16px 18px;
            cursor: pointer;
            transition: all .2s;
        }

        .stat-card:hover,
        .stat-card.active {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--green-main);
        }

        .stat-card.active .stat-value {
            color: var(--green-main);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-icon.green {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .stat-icon.purple {
            background: var(--purple-soft);
            color: var(--purple);
        }

        .stat-icon.teal {
            background: #ccfbf1;
            color: #0f766e;
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
            color: #b45309;
        }

        .stat-icon.blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 3px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 900;
            color: var(--text-dark);
        }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
            flex: 1;
            min-width: 200px;
            max-width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-dark);
            background: transparent;
            width: 100%;
        }

        .search-box i {
            color: var(--text-muted);
            font-size: 13px;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-mid);
            background: white;
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--green-main);
        }

        /* ── View Toggle ── */
        .view-toggle {
            display: flex;
            gap: 4px;
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 4px;
            margin-left: auto;
        }

        .vt-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            background: transparent;
            color: var(--text-muted);
            font-size: 13px;
            transition: all .18s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vt-btn.active {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        /* ── Schedule Grid (card view) ── */
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .sc-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden;
            transition: all .2s;
            position: relative;
        }

        .sc-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--green-main);
        }

        /* Color bar kiri berdasarkan status */
        .sc-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .sc-card[data-status="direncanakan"]::before {
            background: var(--purple);
        }

        .sc-card[data-status="sedang_tumbuh"]::before {
            background: var(--green-main);
        }

        .sc-card[data-status="siap_panen"]::before {
            background: var(--yellow);
        }

        .sc-card[data-status="selesai"]::before {
            background: var(--blue);
        }

        .sc-card[data-status="gagal"]::before {
            background: var(--accent);
        }

        .sc-head {
            padding: 14px 16px 10px 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .sc-emoji {
            font-size: 36px;
            line-height: 1;
            flex-shrink: 0;
        }

        .sc-head-info {
            flex: 1;
        }

        .sc-category {
            font-size: 10px;
            font-weight: 800;
            color: var(--green-main);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 2px;
        }

        .sc-name {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1.25;
        }

        .sc-status-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .sc-body {
            padding: 0 16px 4px 20px;
        }

        /* Countdown chip */
        .sc-countdown {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green-pale);
            border-radius: 20px;
            padding: 5px 12px;
            margin-bottom: 12px;
            font-size: 12px;
            font-weight: 800;
            color: var(--green-dark);
        }

        .sc-countdown.urgent {
            background: #fef3c7;
            color: #92400e;
        }

        .sc-countdown.past {
            background: #f0fdf4;
            color: #166534;
        }

        .sc-countdown.overdue {
            background: #fef2f2;
            color: #b91c1c;
        }

        .sc-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }

        .sc-info-item {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .sc-info-label {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-muted);
        }

        .sc-info-value {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
        }

        .sc-tags {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .sc-tag {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .sc-tag.organic {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .sc-tag.metode {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .sc-notes {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            background: #fafafa;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 12px;
            border-left: 3px solid var(--border);
            line-height: 1.5;
        }

        .sc-footer {
            padding: 10px 16px 14px 20px;
            display: flex;
            gap: 8px;
            border-top: 1px solid var(--border);
        }

        .sc-btn {
            flex: 1;
            padding: 8px;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .sc-btn.edit {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .sc-btn.edit:hover {
            background: #bbf7d0;
        }

        .sc-btn.delete {
            background: #fef2f2;
            color: #b91c1c;
        }

        .sc-btn.delete:hover {
            background: #fecaca;
        }

        /* Status quick-change dropdown */
        .sc-btn.status-btn {
            background: var(--yellow-soft);
            color: #92400e;
        }

        .sc-btn.status-btn:hover {
            background: #fde68a;
        }

        /* ── List view ── */
        .schedule-list {
            display: none;
            flex-direction: column;
            gap: 10px;
        }

        .schedule-list.active {
            display: flex;
        }

        .schedule-grid.list-mode {
            display: none;
        }

        .sl-row {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 18px;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .sl-row::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .sl-row[data-status="direncanakan"]::before {
            background: var(--purple);
        }

        .sl-row[data-status="sedang_tumbuh"]::before {
            background: var(--green-main);
        }

        .sl-row[data-status="siap_panen"]::before {
            background: var(--yellow);
        }

        .sl-row[data-status="selesai"]::before {
            background: var(--blue);
        }

        .sl-row[data-status="gagal"]::before {
            background: var(--accent);
        }

        .sl-row:hover {
            transform: translateX(2px);
            box-shadow: var(--shadow-sm);
            border-color: var(--green-main);
        }

        .sl-emoji {
            font-size: 28px;
            flex-shrink: 0;
            width: 44px;
            text-align: center;
        }

        .sl-main {
            flex: 1;
            min-width: 0;
        }

        .sl-name {
            font-size: 14px;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .sl-meta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .sl-meta span {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sl-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ── Progress bar untuk growing phase ── */
        .sc-progress {
            margin-bottom: 12px;
        }

        .sc-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .sc-progress-bar {
            height: 6px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .sc-progress-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--green-main), var(--green-mid));
            transition: width .5s ease;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--r);
            border: 1px solid var(--border);
        }

        .empty-state i {
            font-size: 52px;
            color: var(--border);
            margin-bottom: 14px;
            display: block;
        }

        .empty-state h3 {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-mid);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 18px;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 22px;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            padding: 7px 13px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            border: 1.5px solid var(--border);
            text-decoration: none;
            color: var(--text-mid);
            background: white;
            transition: all .18s;
        }

        .pagination-wrap a:hover {
            border-color: var(--green-main);
            color: var(--green-dark);
        }

        .pagination-wrap span.active-page {
            background: var(--green-main);
            color: white;
            border-color: var(--green-main);
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            transform: translateY(20px);
            transition: transform .25s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
        }

        .modal-overlay.open .modal {
            transform: translateY(0);
        }

        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }

        .modal-head h2 {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: var(--text-muted);
            padding: 4px;
            border-radius: 6px;
            transition: color .18s;
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 22px;
            max-height: 72vh;
            overflow-y: auto;
        }

        .modal-foot {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            background: #fafcfa;
        }

        /* Form */
        .form-section {
            margin-bottom: 18px;
        }

        .form-section-title {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--green-dark);
            background: var(--green-pale);
            border-radius: 8px;
            padding: 7px 12px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
            margin-bottom: 5px;
        }

        .form-label .req {
            color: var(--accent);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-dark);
            background: white;
            outline: none;
            transition: border-color .2s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(45, 134, 83, .1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 72px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 3px;
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: var(--green-pale);
            border-radius: 9px;
            cursor: pointer;
        }

        .toggle-wrap label {
            font-size: 13px;
            font-weight: 700;
            color: var(--green-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-1 {
            animation: fadeUp .45s ease both;
        }

        .anim-2 {
            animation: fadeUp .45s .07s ease both;
        }

        .anim-3 {
            animation: fadeUp .45s .14s ease both;
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--green-dark);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
            transform: translateY(80px);
            opacity: 0;
            transition: all .3s ease;
            z-index: 9999;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.error {
            background: #b91c1c;
        }

        /* Status change select inside card */
        .status-select-inline {
            font-size: 11px;
            font-weight: 700;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 5px 8px;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            background: white;
            color: var(--text-mid);
            outline: none;
        }

        .status-select-inline:focus {
            border-color: var(--green-main);
        }

        @media (max-width: 768px) {
            .seller-sidebar {
                display: none;
            }

            .seller-main {
                padding: 16px;
            }

            .stats-bar {
                grid-template-columns: repeat(3, 1fr);
            }

            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-bar {
                grid-template-columns: 1fr 1fr;
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

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success anim-1">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error anim-1">
                    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Page Header --}}
            <div class="page-header anim-1">
                <div class="page-header-left">
                    <h1>Jadwal Panen <i class="fa-solid fa-calendar-days"
                            style="font-size:22px;color:var(--green-main)"></i></h1>
                    <p>Rencanakan & pantau siklus panen kebun Anda dari satu tempat.</p>
                </div>
                <div class="page-header-right">
                    <button class="btn-green" onclick="openModal()">
                        <i class="fa-solid fa-plus"></i> Tambah Jadwal
                    </button>
                </div>
            </div>

            {{-- Upcoming Banner --}}
            @if($upcoming > 0)
                <div class="upcoming-banner anim-1">
                    <div class="ub-icon"><i class="fa-solid fa-tractor"></i></div>
                    <div class="ub-text">
                        <strong>Panen dalam 7 Hari!</strong>
                        <span>Siapkan peralatan & transportasi untuk produk yang akan panen.</span>
                    </div>
                    <div class="ub-count">{{ $upcoming }}</div>
                </div>
            @endif

            {{-- Stats Bar --}}
            <div class="stats-bar anim-2" id="statsBar">
                <div class="stat-card active" onclick="filterByStatus('')" data-filter="">
                    <div class="stat-icon green"><i class="fa-solid fa-calendar-days"></i></div>
                    <div class="stat-label">Total Jadwal</div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('direncanakan')" data-filter="direncanakan">
                    <div class="stat-icon purple"><i class="fa-solid fa-calendar-plus"></i></div>
                    <div class="stat-label">Direncanakan</div>
                    <div class="stat-value">{{ $stats['direncanakan'] }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('sedang_tumbuh')" data-filter="sedang_tumbuh">
                    <div class="stat-icon teal"><i class="fa-solid fa-seedling"></i></div>
                    <div class="stat-label">Sedang Tumbuh</div>
                    <div class="stat-value">{{ $stats['sedang_tumbuh'] }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('siap_panen')" data-filter="siap_panen">
                    <div class="stat-icon yellow"><i class="fa-solid fa-tractor"></i></div>
                    <div class="stat-label">Siap Panen</div>
                    <div class="stat-value">{{ $stats['siap_panen'] }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('selesai')" data-filter="selesai">
                    <div class="stat-icon blue"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="filter-bar anim-2">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Cari tanaman..." oninput="filterCards()">
                </div>
                <select class="filter-select" id="filterCategory" onchange="filterCards()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select class="filter-select" id="filterMetode" onchange="filterCards()">
                    <option value="">Semua Metode</option>
                    <option value="organik">🌿 Organik</option>
                    <option value="hidroponik">💧 Hidroponik</option>
                    <option value="konvensional">🌾 Konvensional</option>
                </select>

                {{-- View Toggle --}}
                <div class="view-toggle">
                    <button class="vt-btn active" id="btnGrid" onclick="setView('grid')" title="Tampilan Grid">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                    <button class="vt-btn" id="btnList" onclick="setView('list')" title="Tampilan List">
                        <i class="fa-solid fa-list"></i>
                    </button>
                </div>
            </div>

            {{-- ══ CONTENT ══ --}}
            @if($schedules->isEmpty())
                <div class="empty-state anim-3">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <h3>Belum ada jadwal panen</h3>
                    <p>Mulai rencanakan siklus panen Anda agar hasil kebun lebih terorganisir.</p>
                    <button class="btn-green" onclick="openModal()" style="margin:0 auto">
                        <i class="fa-solid fa-plus"></i> Buat Jadwal Pertama
                    </button>
                </div>
            @else

                {{-- ── GRID VIEW ── --}}
                <div class="schedule-grid anim-3" id="scheduleGrid">
                    @foreach($schedules as $s)
                        @php
                            $sisaHari = (int) now()->startOfDay()->diffInDays(
                                \Carbon\Carbon::parse($s->estimasi_panen)->startOfDay(),
                                false
                            );
                            $countdownClass = $sisaHari < 0 ? 'overdue' : ($sisaHari <= 7 ? 'urgent' : ($sisaHari == 0 ? 'past' : ''));
                            $countdownText = $sisaHari < 0
                                ? abs($sisaHari) . ' hari telat'
                                : ($sisaHari == 0 ? 'Hari ini!' : $sisaHari . ' hari lagi');
                            $countdownIcon = $sisaHari < 0 ? 'fa-triangle-exclamation' : ($sisaHari <= 3 ? 'fa-fire' : 'fa-clock');

                            $emoji = match (strtolower($s->category->name ?? '')) {
                                'sayuran' => '🥬', 'buah' => '🍎',
                                'beras', 'palawija' => '🌾', 'rempah', 'bumbu' => '🌶️',
                                'umbi' => '🥕', 'kacang' => '🫘', default => '🌱'
                            };

                            $badge = match ($s->status) {
                                'direncanakan' => ['#ede9fe', '#5b21b6', 'Direncanakan', 'fa-calendar-plus'],
                                'sedang_tumbuh' => ['#d1fae5', '#065f46', 'Sedang Tumbuh', 'fa-seedling'],
                                'siap_panen' => ['#fef9c3', '#92400e', 'Siap Panen', 'fa-tractor'],
                                'selesai' => ['#f0fdf4', '#166534', 'Selesai', 'fa-circle-check'],
                                'gagal' => ['#fef2f2', '#991b1b', 'Gagal', 'fa-circle-xmark'],
                                default => ['#f3f4f6', '#374151', $s->status, 'fa-circle'],
                            };

                            // Hitung progres tanam → panen
                            $progress = 0;
                            if ($s->tanggal_tanam) {
                                $totalDays = \Carbon\Carbon::parse($s->tanggal_tanam)
                                    ->diffInDays(\Carbon\Carbon::parse($s->estimasi_panen));
                                $passedDays = \Carbon\Carbon::parse($s->tanggal_tanam)->diffInDays(now(), false);
                                $progress = $totalDays > 0 ? min(100, max(0, round(($passedDays / $totalDays) * 100))) : 100;
                            }
                        @endphp

                        <div class="sc-card" data-status="{{ $s->status }}" data-name="{{ strtolower($s->nama_tanaman) }}"
                            data-category="{{ $s->category->name ?? '' }}" data-metode="{{ $s->metode_tanam ?? '' }}">

                            <div class="sc-head">
                                <div class="sc-emoji">{{ $emoji }}</div>
                                <div class="sc-head-info">
                                    <div class="sc-category">{{ $s->category->name ?? 'Umum' }}</div>
                                    <div class="sc-name">{{ $s->nama_tanaman }}</div>
                                </div>
                                <span class="sc-status-badge" style="background:{{ $badge[0] }};color:{{ $badge[1] }}">
                                    <i class="fa-solid {{ $badge[3] }}"></i>
                                    {{ $badge[2] }}
                                </span>
                            </div>

                            <div class="sc-body">

                                {{-- Countdown chip --}}
                                <div class="sc-countdown {{ $countdownClass }}">
                                    <i class="fa-solid {{ $countdownIcon }}"></i>
                                    <span>
                                        Panen: {{ \Carbon\Carbon::parse($s->estimasi_panen)->isoFormat('D MMM YYYY') }}
                                        &nbsp;·&nbsp; {{ $countdownText }}
                                    </span>
                                </div>

                                {{-- Progress bar (hanya jika ada tanggal_tanam & status bukan selesai/gagal) --}}
                                @if($s->tanggal_tanam && !in_array($s->status, ['selesai', 'gagal']))
                                    <div class="sc-progress">
                                        <div class="sc-progress-label">
                                            <span><i class="fa-solid fa-seedling"></i>
                                                {{ \Carbon\Carbon::parse($s->tanggal_tanam)->isoFormat('D MMM') }}</span>
                                            <span>{{ $progress }}% masa tanam</span>
                                            <span><i class="fa-solid fa-tractor"></i>
                                                {{ \Carbon\Carbon::parse($s->estimasi_panen)->isoFormat('D MMM') }}</span>
                                        </div>
                                        <div class="sc-progress-bar">
                                            <div class="sc-progress-fill" style="width:{{ $progress }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Info grid --}}
                                <div class="sc-info-grid">
                                    @if($s->estimasi_kuantitas)
                                        <div class="sc-info-item">
                                            <span class="sc-info-label"><i class="fa-solid fa-scale-balanced"></i> Est.
                                                Kuantitas</span>
                                            <span class="sc-info-value">{{ number_format($s->estimasi_kuantitas, 1) }}
                                                {{ $s->satuan ?? '' }}</span>
                                        </div>
                                    @endif
                                    @if($s->kebun_lokasi)
                                        <div class="sc-info-item">
                                            <span class="sc-info-label"><i class="fa-solid fa-location-dot"></i> Lokasi</span>
                                            <span class="sc-info-value">{{ Str::limit($s->kebun_lokasi, 22) }}</span>
                                        </div>
                                    @endif
                                    @if($s->luas_lahan)
                                        <div class="sc-info-item">
                                            <span class="sc-info-label"><i class="fa-solid fa-ruler-combined"></i> Luas Lahan</span>
                                            <span class="sc-info-value">{{ number_format($s->luas_lahan) }} m²</span>
                                        </div>
                                    @endif
                                    @if($s->tanggal_tanam)
                                        <div class="sc-info-item">
                                            <span class="sc-info-label"><i class="fa-regular fa-calendar"></i> Tgl Tanam</span>
                                            <span
                                                class="sc-info-value">{{ \Carbon\Carbon::parse($s->tanggal_tanam)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Tags --}}
                                <div class="sc-tags">
                                    @if($s->is_organic)
                                        <span class="sc-tag organic"><i class="fa-solid fa-leaf"></i> Organik</span>
                                    @endif
                                    @if($s->metode_tanam)
                                        <span class="sc-tag metode">{{ ucfirst($s->metode_tanam) }}</span>
                                    @endif
                                </div>

                                {{-- Catatan --}}
                                @if($s->catatan)
                                    <div class="sc-notes">
                                        <i class="fa-solid fa-note-sticky" style="color:var(--yellow)"></i>
                                        {{ Str::limit($s->catatan, 100) }}
                                    </div>
                                @endif

                            </div>

                            <div class="sc-footer">
                                {{-- Quick status update --}}
                                <form method="POST" action="{{ route('seller.jadwal.status', $s->id) }}" style="flex:1">
                                    @csrf @method('PATCH')
                                    <select name="status" class="status-select-inline" style="width:100%"
                                        onchange="this.form.submit()" title="Ubah status cepat">
                                        <option value="direncanakan" {{ $s->status === 'direncanakan' ? 'selected' : '' }}>📅
                                            Direncanakan</option>
                                        <option value="sedang_tumbuh" {{ $s->status === 'sedang_tumbuh' ? 'selected' : '' }}>🌱
                                            Sedang Tumbuh</option>
                                        <option value="siap_panen" {{ $s->status === 'siap_panen' ? 'selected' : '' }}>🚜 Siap
                                            Panen</option>
                                        <option value="selesai" {{ $s->status === 'selesai' ? 'selected' : '' }}>✅ Selesai
                                        </option>
                                        <option value="gagal" {{ $s->status === 'gagal' ? 'selected' : '' }}>❌ Gagal</option>
                                    </select>
                                </form>
                                <button class="sc-btn edit" onclick="openEditModal(
                                    {{ $s->id }},
                                    '{{ addslashes($s->nama_tanaman) }}',
                                    {{ $s->category_id ?? 'null' }},
                                    '{{ $s->tanggal_tanam?->format('Y-m-d') ?? '' }}',
                                    '{{ $s->estimasi_panen->format('Y-m-d') }}',
                                    {{ $s->estimasi_kuantitas ?? 'null' }},
                                    '{{ $s->satuan ?? '' }}',
                                    '{{ addslashes($s->kebun_lokasi ?? '') }}',
                                    '{{ $s->metode_tanam ?? '' }}',
                                    '{{ $s->status }}',
                                    '{{ addslashes($s->catatan ?? '') }}',
                                    {{ $s->luas_lahan ?? 'null' }},
                                    {{ $s->is_organic ? 'true' : 'false' }}
                                )">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <button class="sc-btn delete"
                                    onclick="confirmDelete({{ $s->id }}, '{{ addslashes($s->nama_tanaman) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ── LIST VIEW ── --}}
                <div class="schedule-list anim-3" id="scheduleList">
                    @foreach($schedules as $s)
                        @php
                            $sisaHari = (int) now()->startOfDay()->diffInDays(
                                \Carbon\Carbon::parse($s->estimasi_panen)->startOfDay(),
                                false
                            );
                            $emoji = match (strtolower($s->category->name ?? '')) {
                                'sayuran' => '🥬', 'buah' => '🍎', 'beras', 'palawija' => '🌾',
                                'rempah', 'bumbu' => '🌶️', 'umbi' => '🥕', 'kacang' => '🫘', default => '🌱'
                            };
                            $badge = match ($s->status) {
                                'direncanakan' => ['#ede9fe', '#5b21b6', 'Direncanakan'],
                                'sedang_tumbuh' => ['#d1fae5', '#065f46', 'Sedang Tumbuh'],
                                'siap_panen' => ['#fef9c3', '#92400e', 'Siap Panen'],
                                'selesai' => ['#f0fdf4', '#166534', 'Selesai'],
                                'gagal' => ['#fef2f2', '#991b1b', 'Gagal'],
                                default => ['#f3f4f6', '#374151', $s->status],
                            };
                        @endphp
                        <div class="sl-row" data-status="{{ $s->status }}" data-name="{{ strtolower($s->nama_tanaman) }}"
                            data-category="{{ $s->category->name ?? '' }}" data-metode="{{ $s->metode_tanam ?? '' }}">

                            <div class="sl-emoji">{{ $emoji }}</div>
                            <div class="sl-main">
                                <div class="sl-name">{{ $s->nama_tanaman }}</div>
                                <div class="sl-meta">
                                    <span><i class="fa-solid fa-tractor"></i> Panen
                                        {{ \Carbon\Carbon::parse($s->estimasi_panen)->isoFormat('D MMM YYYY') }}</span>
                                    @if($s->kebun_lokasi)<span><i class="fa-solid fa-location-dot"></i>
                                    {{ $s->kebun_lokasi }}</span>@endif
                                    @if($s->estimasi_kuantitas)<span><i class="fa-solid fa-scale-balanced"></i>
                                    {{ $s->estimasi_kuantitas }} {{ $s->satuan }}</span>@endif
                                    <span>
                                        {{ $sisaHari >= 0 ? $sisaHari . ' hari lagi' : abs($sisaHari) . ' hari telat' }}
                                    </span>
                                </div>
                            </div>
                            <div class="sl-right">
                                <span class="sc-status-badge" style="background:{{ $badge[0] }};color:{{ $badge[1] }}">
                                    {{ $badge[2] }}
                                </span>
                                <button class="sc-btn edit" style="width:auto;padding:7px 12px"
                                    onclick="openEditModal({{ $s->id }},'{{ addslashes($s->nama_tanaman) }}',{{ $s->category_id ?? 'null' }},'{{ $s->tanggal_tanam?->format('Y-m-d') ?? '' }}','{{ $s->estimasi_panen->format('Y-m-d') }}',{{ $s->estimasi_kuantitas ?? 'null' }},'{{ $s->satuan ?? '' }}','{{ addslashes($s->kebun_lokasi ?? '') }}','{{ $s->metode_tanam ?? '' }}','{{ $s->status }}','{{ addslashes($s->catatan ?? '') }}',{{ $s->luas_lahan ?? 'null' }},{{ $s->is_organic ? 'true' : 'false' }})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="sc-btn delete" style="width:auto;padding:7px 12px"
                                    onclick="confirmDelete({{ $s->id }}, '{{ addslashes($s->nama_tanaman) }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($schedules->hasPages())
                    <div class="pagination-wrap">{{ $schedules->links() }}</div>
                @endif

            @endif {{-- end isEmpty --}}

        </main>
    </div>

    {{-- ══ MODAL TAMBAH / EDIT ══ --}}
    <div class="modal-overlay" id="modalOverlay" onclick="closeModalOnBg(event)">
        <div class="modal">
            <div class="modal-head">
                <h2 id="modalTitle"><i class="fa-solid fa-plus" style="color:var(--green-main)"></i> Tambah Jadwal</h2>
                <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="jadwalForm" method="POST" action="{{ route('seller.jadwal.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body">

                    {{-- Seksi 1: Data Tanaman --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fa-solid fa-leaf"></i> Data Tanaman
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Tanaman <span class="req">*</span></label>
                                <input type="text" name="nama_tanaman" id="namaTanaman" class="form-input"
                                    placeholder="cth: Tomat, Cabai, Bayam..." required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" id="categorySelect" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Metode Tanam</label>
                                <select name="metode_tanam" id="metodeTanamInput" class="form-select">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="organik">🌿 Organik</option>
                                    <option value="hidroponik">💧 Hidroponik</option>
                                    <option value="konvensional">🌾 Konvensional</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status <span class="req">*</span></label>
                                <select name="status" id="statusInput" class="form-select" required>
                                    <option value="direncanakan">📅 Direncanakan</option>
                                    <option value="sedang_tumbuh">🌱 Sedang Tumbuh</option>
                                    <option value="siap_panen">🚜 Siap Panen</option>
                                    <option value="selesai">✅ Selesai</option>
                                    <option value="gagal">❌ Gagal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Seksi 2: Jadwal & Estimasi --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fa-solid fa-calendar-days"></i> Jadwal & Estimasi
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tanggal Tanam</label>
                                <input type="date" name="tanggal_tanam" id="tanggalTanam" class="form-input">
                                <span class="form-hint">Opsional — digunakan untuk hitung progres tumbuh</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Estimasi Panen <span class="req">*</span></label>
                                <input type="date" name="estimasi_panen" id="estimasiPanen" class="form-input" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Est. Kuantitas</label>
                                <input type="number" name="estimasi_kuantitas" id="estimasiKuantitas" class="form-input"
                                    placeholder="cth: 100" min="0" step="0.1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" id="satuanInput" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="kg">kg</option>
                                    <option value="gram">gram</option>
                                    <option value="ikat">ikat</option>
                                    <option value="karung">karung</option>
                                    <option value="liter">liter</option>
                                    <option value="buah">buah</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Seksi 3: Info Kebun --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fa-solid fa-tractor"></i> Info Kebun
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Lokasi Kebun</label>
                                <input type="text" name="kebun_lokasi" id="kebunLokasiInput" class="form-input"
                                    placeholder="cth: Lembang, Bandung Barat">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Luas Lahan (m²)</label>
                                <input type="number" name="luas_lahan" id="luasLahan" class="form-input"
                                    placeholder="cth: 500" min="0" step="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatanInput" class="form-textarea"
                                placeholder="cth: bibit dari varietas unggul, perkiraan cuaca baik..."></textarea>
                        </div>

                        <div class="toggle-wrap" onclick="document.getElementById('isOrganicInput').click()">
                            <input type="checkbox" name="is_organic" id="isOrganicInput" value="1"
                                style="width:18px;height:18px;accent-color:var(--green-main)">
                            <label for="isOrganicInput">
                                <i class="fa-solid fa-leaf" style="color:var(--green-main)"></i>
                                Tanaman ini ditanam secara organik (tanpa pestisida/kimia)
                            </label>
                        </div>
                    </div>

                </div>{{-- end modal-body --}}

                <div class="modal-foot">
                    <button type="button" class="btn-outline" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-green">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══ MODAL KONFIRMASI HAPUS ══ --}}
    <div class="modal-overlay" id="deleteOverlay" onclick="closeDeleteOnBg(event)">
        <div class="modal" style="max-width:400px">
            <div class="modal-head">
                <h2><i class="fa-solid fa-trash" style="color:#b91c1c"></i> Hapus Jadwal</h2>
                <button class="modal-close" onclick="closeDelete()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:14px;font-weight:600;color:var(--text-mid)">
                    Apakah Anda yakin ingin menghapus jadwal panen
                    <strong id="deleteJadwalName"></strong>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-foot">
                <button class="btn-outline" onclick="closeDelete()">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit"
                        style="padding:9px 18px;background:#b91c1c;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i> <span id="toastMsg"></span></div>

    <script>
        /* ── View Toggle (Grid / List) ── */
        function setView(mode) {
            const grid = document.getElementById('scheduleGrid');
            const list = document.getElementById('scheduleList');
            const btnG = document.getElementById('btnGrid');
            const btnL = document.getElementById('btnList');

            if (mode === 'grid') {
                grid.style.display = '';
                list.classList.remove('active');
                btnG.classList.add('active');
                btnL.classList.remove('active');
                localStorage.setItem('jadwalView', 'grid');
            } else {
                grid.style.display = 'none';
                list.classList.add('active');
                btnG.classList.remove('active');
                btnL.classList.add('active');
                localStorage.setItem('jadwalView', 'list');
            }
        }
        // Restore last view preference
        (function () {
            const saved = localStorage.getItem('jadwalView');
            if (saved === 'list') setView('list');
        })();

        /* ── Stats card filter ── */
        function filterByStatus(status) {
            // Toggle active di stat-card
            document.querySelectorAll('.stat-card').forEach(c => {
                c.classList.toggle('active', c.dataset.filter === status);
            });

            const cards = document.querySelectorAll('.sc-card, .sl-row');
            cards.forEach(card => {
                const match = !status || card.dataset.status === status;
                card.style.display = match ? '' : 'none';
            });
        }

        /* ── Text / category / metode filter ── */
        function filterCards() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const cat = document.getElementById('filterCategory').value;
            const met = document.getElementById('filterMetode').value;

            document.querySelectorAll('.sc-card, .sl-row').forEach(card => {
                const nameMatch = !q || card.dataset.name.includes(q);
                const catMatch = !cat || card.dataset.category === cat;
                const metodeMatch = !met || card.dataset.metode === met;
                card.style.display = (nameMatch && catMatch && metodeMatch) ? '' : 'none';
            });
        }

        /* ── Modal Tambah ── */
        function openModal() {
            document.getElementById('modalTitle').innerHTML =
                '<i class="fa-solid fa-plus" style="color:var(--green-main)"></i> Tambah Jadwal Panen';
            document.getElementById('jadwalForm').action = '{{ route("seller.jadwal.store") }}';
            document.getElementById('formMethod').value = 'POST';
            resetForm();
            document.getElementById('modalOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        /* ── Modal Edit ── */
        function openEditModal(id, nama, categoryId, tanggalTanam, estimasiPanen,
            kuantitas, satuan, lokasi, metode, status, catatan,
            luas, isOrganic) {
            document.getElementById('modalTitle').innerHTML =
                '<i class="fa-solid fa-pen" style="color:var(--green-main)"></i> Edit Jadwal Panen';
            document.getElementById('jadwalForm').action = `/seller/jadwal/${id}`;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('namaTanaman').value = nama;
            document.getElementById('categorySelect').value = categoryId || '';
            document.getElementById('tanggalTanam').value = tanggalTanam || '';
            document.getElementById('estimasiPanen').value = estimasiPanen;
            document.getElementById('estimasiKuantitas').value = kuantitas || '';
            document.getElementById('satuanInput').value = satuan || '';
            document.getElementById('kebunLokasiInput').value = lokasi || '';
            document.getElementById('metodeTanamInput').value = metode || '';
            document.getElementById('statusInput').value = status;
            document.getElementById('catatanInput').value = catatan || '';
            document.getElementById('luasLahan').value = luas || '';
            document.getElementById('isOrganicInput').checked = isOrganic;

            document.getElementById('modalOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        function closeModalOnBg(e) { if (e.target.id === 'modalOverlay') closeModal(); }

        function resetForm() {
            ['namaTanaman', 'tanggalTanam', 'estimasiPanen', 'estimasiKuantitas',
                'kebunLokasiInput', 'catatanInput', 'luasLahan'].forEach(id => {
                    document.getElementById(id).value = '';
                });
            document.getElementById('categorySelect').value = '';
            document.getElementById('satuanInput').value = '';
            document.getElementById('metodeTanamInput').value = '';
            document.getElementById('statusInput').value = 'direncanakan';
            document.getElementById('isOrganicInput').checked = false;
        }

        /* ── Modal Hapus ── */
        function confirmDelete(id, nama) {
            document.getElementById('deleteJadwalName').textContent = nama;
            document.getElementById('deleteForm').action = `/seller/jadwal/${id}`;
            document.getElementById('deleteOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDelete() {
            document.getElementById('deleteOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        function closeDeleteOnBg(e) { if (e.target.id === 'deleteOverlay') closeDelete(); }

        /* ── Escape key ── */
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') { closeModal(); closeDelete(); }
        });

        /* ── Auto-dismiss alerts ── */
        @if(session('success') || session('error'))
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(el => {
                    el.style.transition = 'opacity .5s';
                    el.style.opacity = '0';
                });
            }, 4000);
        @endif
    </script>

</body>

</html>