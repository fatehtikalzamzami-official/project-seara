@extends('layouts.app')

@section('title', 'Dashboard Penjual – SEARA')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
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
            --text-dark: #0f2419;
            --text-mid: #3d5c49;
            --text-muted: #7a9585;
            --border: #e2ece7;
            --white: #ffffff;
            --bg: #f5f9f6;
            --r: 14px;
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, .06);
            --shadow-md: 0 4px 18px rgba(0, 0, 0, .09);
            --shadow-lg: 0 12px 40px rgba(0, 0, 0, .12);
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

        /* ─── SELLER TOPBAR ACCENT ─── */
        .seller-ribbon {
            background: linear-gradient(135deg, var(--green-dark), #1e5c38);
            padding: 7px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: rgba(255, 255, 255, .8);
            font-weight: 600;
        }

        .seller-ribbon strong {
            color: #a8e6c3;
        }

        .ribbon-actions {
            display: flex;
            gap: 16px;
        }

        .ribbon-actions a {
            color: rgba(255, 255, 255, .75);
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            transition: color .2s;
        }

        .ribbon-actions a:hover {
            color: #fff;
        }

        .ribbon-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ade80;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 6px #4ade80;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        /* ─── PAGE WRAP ─── */
        .seller-wrap {
            display: flex;
            min-height: calc(100vh - 120px);
        }

        /* ─── SIDEBAR ─── */
        .seller-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 24px 0;
            position: sticky;
            top: 0;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .sidebar-section {
            padding: 0 16px;
            margin-bottom: 6px;
        }

        .sidebar-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 6px 8px 4px;
            display: block;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: 'Nunito', sans-serif;
            transition: all .18s;
            position: relative;
        }

        .sidebar-item:hover {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, var(--green-pale), #d1fae5);
            color: var(--green-dark);
        }

        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: var(--green-mid);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            background: var(--green-pale);
            flex-shrink: 0;
            transition: background .18s;
        }

        .sidebar-item:hover .sidebar-icon,
        .sidebar-item.active .sidebar-icon {
            background: #c6f6d5;
        }

        .sidebar-badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 16px;
        }

        /* Seller profile card in sidebar */
        .sidebar-profile {
            margin: 0 16px 20px;
            background: linear-gradient(135deg, var(--green-dark), #1e5c38);
            border-radius: 12px;
            padding: 16px;
        }

        .sp-ava {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            border: 2px solid rgba(255, 255, 255, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 16px;
            color: white;
            margin-bottom: 10px;
        }

        .sp-name {
            font-size: 13px;
            font-weight: 800;
            color: white;
            margin-bottom: 2px;
        }

        .sp-role {
            font-size: 10px;
            color: #a8e6c3;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .sp-stats {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, .12);
        }

        .sp-stat {
            text-align: center;
        }

        .sp-stat strong {
            display: block;
            font-size: 15px;
            font-weight: 900;
            color: white;
        }

        .sp-stat span {
            font-size: 10px;
            color: rgba(255, 255, 255, .6);
            font-weight: 600;
        }

        /* ─── MAIN CONTENT ─── */
        .seller-main {
            flex: 1;
            padding: 24px;
            overflow-x: hidden;
        }

        /* Page header */
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
            line-height: 1.2;
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

        /* ─── STAT CARDS ─── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
            transition: all .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--green-main);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            transform: translate(20px, -20px);
            opacity: .07;
        }

        .stat-card.green::after {
            background: var(--green-mid);
        }

        .stat-card.orange::after {
            background: var(--accent);
        }

        .stat-card.blue::after {
            background: var(--blue);
        }

        .stat-card.yellow::after {
            background: var(--yellow);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .stat-icon.green {
            background: var(--green-pale);
        }

        .stat-icon.orange {
            background: var(--accent-soft);
        }

        .stat-icon.blue {
            background: var(--blue-soft);
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .stat-delta {
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-delta.up {
            color: var(--green-main);
        }

        .stat-delta.down {
            color: var(--accent);
        }

        .stat-trend {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* ─── GRID LAYOUT ─── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
            margin-bottom: 16px;
        }

        .content-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        /* ─── CARD BASE ─── */
        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-head h3 {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-head h3 .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green-mid);
            display: inline-block;
        }

        .card-action {
            font-size: 12px;
            font-weight: 700;
            color: var(--green-main);
            text-decoration: none;
            transition: color .2s;
        }

        .card-action:hover {
            color: var(--green-dark);
        }

        .card-body {
            padding: 20px;
        }

        /* ─── CHART AREA ─── */
        .chart-wrap {
            position: relative;
            height: 220px;
            margin-top: 4px;
        }

        /* ─── QUICK ACTIONS ─── */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 16px;
        }

        .qa-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: white;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: var(--text-mid);
            transition: all .2s;
            text-decoration: none;
        }

        .qa-btn:hover {
            border-color: var(--green-main);
            background: var(--green-pale);
            color: var(--green-dark);
            transform: translateY(-1px);
        }

        .qa-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* ─── ORDER TABLE ─── */
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-muted);
            padding: 10px 16px;
            text-align: left;
            background: #fafcfa;
            border-bottom: 1px solid var(--border);
        }

        .order-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f5f2;
            font-size: 13px;
            vertical-align: middle;
        }

        .order-table tr:last-child td {
            border-bottom: none;
        }

        .order-table tr:hover td {
            background: var(--green-pale);
        }

        .order-id {
            font-weight: 800;
            color: var(--green-dark);
            font-size: 12px;
        }

        .order-product {
            font-weight: 700;
            color: var(--text-dark);
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .order-buyer {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .order-amount {
            font-weight: 800;
            color: var(--text-dark);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        .status-pill.baru {
            background: var(--blue-soft);
            color: #1d4ed8;
        }

        .status-pill.proses {
            background: var(--yellow-soft);
            color: #92400e;
        }

        .status-pill.kirim {
            background: #f0fdf4;
            color: var(--green-dark);
        }

        .status-pill.selesai {
            background: var(--green-pale);
            color: var(--green-main);
        }

        .status-pill.batal {
            background: #fef2f2;
            color: #b91c1c;
        }

        /* ─── TOP PRODUCTS ─── */
        .prod-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f5f2;
        }

        .prod-row:last-child {
            border-bottom: none;
        }

        .prod-rank {
            width: 22px;
            font-size: 12px;
            font-weight: 900;
            color: var(--text-muted);
            text-align: center;
            flex-shrink: 0;
        }

        .prod-rank.gold {
            color: #f5a623;
        }

        .prod-rank.silver {
            color: #94a3b8;
        }

        .prod-rank.bronze {
            color: #cd7c3a;
        }

        .prod-thumb {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: var(--green-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .prod-info {
            flex: 1;
            min-width: 0;
        }

        .prod-info-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .prod-info-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .prod-rev {
            text-align: right;
            flex-shrink: 0;
        }

        .prod-rev-val {
            font-size: 13px;
            font-weight: 900;
            color: var(--text-dark);
        }

        .prod-rev-pcs {
            font-size: 11px;
            color: var(--green-main);
            font-weight: 700;
        }

        .prod-bar-wrap {
            height: 4px;
            background: #e2ece7;
            border-radius: 4px;
            margin-top: 3px;
            overflow: hidden;
        }

        .prod-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--green-mid), var(--green-light));
            border-radius: 4px;
        }

        /* ─── HARVEST CALENDAR ─── */
        .harvest-list {
            padding: 0 20px 20px;
        }

        .harvest-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f5f2;
        }

        .harvest-item:last-child {
            border-bottom: none;
        }

        .harvest-date {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--green-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .harvest-date .hd-day {
            font-size: 16px;
            font-weight: 900;
            color: white;
            line-height: 1;
        }

        .harvest-date .hd-mon {
            font-size: 9px;
            font-weight: 700;
            color: #a8e6c3;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .harvest-info {
            flex: 1;
        }

        .harvest-info-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .harvest-info-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        .harvest-stock {
            text-align: right;
        }

        .harvest-stock-val {
            font-size: 13px;
            font-weight: 900;
            color: var(--green-main);
        }

        .harvest-stock-lbl {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .harvest-urgency {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .harvest-urgency.today {
            background: var(--accent);
            box-shadow: 0 0 6px var(--accent);
        }

        .harvest-urgency.soon {
            background: var(--yellow);
        }

        .harvest-urgency.ok {
            background: var(--green-mid);
        }

        /* ─── ALERT BANNER ─── */
        .alert-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .alert-banner.warning {
            background: var(--yellow-soft);
            border: 1px solid #fde68a;
        }

        .alert-banner.info {
            background: var(--blue-soft);
            border: 1px solid #bfdbfe;
        }

        .alert-banner.success {
            background: var(--green-pale);
            border: 1px solid #bbf7d0;
        }

        .alert-banner-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .alert-banner-text {
            flex: 1;
            font-size: 13px;
            font-weight: 700;
        }

        .alert-banner.warning .alert-banner-text {
            color: #92400e;
        }

        .alert-banner.info .alert-banner-text {
            color: #1e40af;
        }

        .alert-banner.success .alert-banner-text {
            color: var(--green-dark);
        }

        .alert-banner-text small {
            display: block;
            font-size: 11px;
            font-weight: 600;
            opacity: .75;
            margin-top: 1px;
        }

        .alert-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            opacity: .5;
            transition: opacity .2s;
            padding: 2px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* ─── INCOME SUMMARY ─── */
        .income-card {
            background: linear-gradient(135deg, var(--green-dark) 0%, #1e6641 60%, #246b4a 100%);
            border-radius: var(--r);
            padding: 22px;
            position: relative;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .income-card::before {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .income-card::after {
            content: '';
            position: absolute;
            right: 20px;
            bottom: -50px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .income-label {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, .6);
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .income-value {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: white;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .income-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, .55);
            font-weight: 600;
        }

        .income-change {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .12);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 800;
            color: #a8e6c3;
            margin-top: 12px;
        }

        .income-breakdown {
            display: flex;
            gap: 16px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, .12);
            position: relative;
            z-index: 1;
        }

        .income-brk {
            flex: 1;
        }

        .income-brk-val {
            font-size: 15px;
            font-weight: 900;
            color: white;
        }

        .income-brk-lbl {
            font-size: 10px;
            color: rgba(255, 255, 255, .55);
            font-weight: 600;
            margin-top: 2px;
        }

        /* ─── SECTION ANIMATIONS ─── */
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
            animation: fadeUp .5s ease both;
        }

        .anim-2 {
            animation: fadeUp .5s .06s ease both;
        }

        .anim-3 {
            animation: fadeUp .5s .12s ease both;
        }

        .anim-4 {
            animation: fadeUp .5s .18s ease both;
        }

        .anim-5 {
            animation: fadeUp .5s .24s ease both;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .content-grid-3 {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .seller-sidebar {
                display: none;
            }

            .seller-main {
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Seller Ribbon --}}
    <div class="seller-ribbon">
        <div>
            <span class="ribbon-dot"></span>
            Laman Penjual · <strong>{{ Auth::user()->nama_lengkap ?? 'Petani' }}</strong>
            &nbsp;·&nbsp; Toko aktif sejak {{ optional(Auth::user()->seller)->created_at?->format('M Y') ?? 'Baru' }}
        </div>
        <div class="ribbon-actions">
            <a href="{{ route('home') }}">← Kembali ke Marketplace</a>
            <a href="#">Pusat Bantuan</a>
            <a href="#">Pengaturan Toko</a>
        </div>
    </div>

    <div class="seller-wrap">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="seller-sidebar">

            {{-- Profile card --}}
            <div class="sidebar-profile">
                <div class="sp-ava">{{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'P', 0, 2)) }}</div>
                <div class="sp-name">{{ \Illuminate\Support\Str::limit(Auth::user()->nama_lengkap ?? 'Petani', 20) }}</div>
                <div class="sp-role">⭐ Petani Terverifikasi</div>
                <div class="sp-stats">
                    <div class="sp-stat">
                        <strong>{{ optional(Auth::user()->seller)->total_products ?? 0 }}</strong><span>Produk</span></div>
                    <div class="sp-stat">
                        <strong>{{ optional(Auth::user()->seller)->total_orders ?? 0 }}</strong><span>Pesanan</span></div>
                    <div class="sp-stat"><strong>4.9</strong><span>Rating</span></div>
                </div>
            </div>

            {{-- Menu --}}
            <div class="sidebar-section">
                <span class="sidebar-label">Utama</span>
                <a href="#" class="sidebar-item active">
                    <span class="sidebar-icon">🏠</span> Dashboard
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">📦</span> Pesanan Masuk
                    <span class="sidebar-badge">3</span>
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">💬</span> Pesan Chat
                    <span class="sidebar-badge">5</span>
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Kelola</span>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">🌾</span> Produk Saya
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">🗓️</span> Jadwal Panen
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">📊</span> Laporan Penjualan
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">💰</span> Keuangan
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Akun</span>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">🏪</span> Profil Toko
                </a>
                <a href="#" class="sidebar-item">
                    <span class="sidebar-icon">⚙️</span> Pengaturan
                </a>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <main class="seller-main">

            {{-- Alert banners --}}
            <div class="alert-banner warning anim-1" id="alertStok">
                <div class="alert-banner-icon">⚠️</div>
                <div class="alert-banner-text">
                    3 produk stok hampir habis!
                    <small>Segera perbarui stok untuk menghindari kehilangan pesanan.</small>
                </div>
                <a href="#" style="font-size:12px;font-weight:800;color:#92400e;margin-right:10px;">Perbarui</a>
                <button class="alert-close" onclick="this.closest('.alert-banner').remove()">✕</button>
            </div>

            <div class="alert-banner info anim-1" id="alertPanen" style="margin-top:-4px;">
                <div class="alert-banner-icon">🌾</div>
                <div class="alert-banner-text">
                    Panen hari ini: <strong>Tomat Merah 50kg</strong> siap dijual!
                    <small>Klik untuk langsung listing produk panen hari ini.</small>
                </div>
                <a href="#" style="font-size:12px;font-weight:800;color:#1e40af;margin-right:10px;">Listing Sekarang</a>
                <button class="alert-close" onclick="this.closest('.alert-banner').remove()">✕</button>
            </div>

            {{-- Page header --}}
            <div class="page-header anim-2">
                <div class="page-header-left">
                    <h1>Dashboard Penjual 🌾</h1>
                    <p>Selamat datang kembali, {{ Auth::user()->nama_lengkap ?? 'Petani' }}! Ini ringkasan tokomu hari ini.
                    </p>
                </div>
                <div class="page-header-right">
                    <a href="#" class="btn-outline">📊 Unduh Laporan</a>
                    <a href="#" class="btn-green">+ Tambah Produk</a>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="stats-grid anim-2">
                <div class="stat-card green">
                    <div class="stat-icon green">💰</div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value">Rp
                        {{ number_format(optional(Auth::user()->seller)->total_revenue ?? 4850000, 0, ',', '.') }}</div>
                    <div class="stat-delta up">▲ 18% <span class="stat-trend">vs bulan lalu</span></div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon orange">📦</div>
                    <div class="stat-label">Pesanan Masuk</div>
                    <div class="stat-value">{{ optional(Auth::user()->seller)->total_orders ?? 24 }}</div>
                    <div class="stat-delta up">▲ 5 <span class="stat-trend">minggu ini</span></div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-icon blue">🌿</div>
                    <div class="stat-label">Produk Aktif</div>
                    <div class="stat-value">{{ optional(Auth::user()->seller)->total_products ?? 12 }}</div>
                    <div class="stat-delta down">▼ 2 <span class="stat-trend">stok habis</span></div>
                </div>
                <div class="stat-card yellow">
                    <div class="stat-icon yellow">⭐</div>
                    <div class="stat-label">Rating Toko</div>
                    <div class="stat-value">4.9</div>
                    <div class="stat-delta up">▲ 0.1 <span class="stat-trend">dari 127 ulasan</span></div>
                </div>
            </div>

            {{-- Income summary + Quick actions --}}
            <div class="content-grid anim-3">
                <div>
                    {{-- Income green card --}}
                    <div class="income-card">
                        <div class="income-label">Pendapatan Bulan Ini</div>
                        <div class="income-value">Rp 4.850.000</div>
                        <div class="income-sub">dari 24 pesanan selesai</div>
                        <div class="income-change">▲ 18% lebih tinggi dari bulan lalu</div>
                        <div class="income-breakdown">
                            <div class="income-brk">
                                <div class="income-brk-val">Rp 3.200.000</div>
                                <div class="income-brk-lbl">Sudah dicairkan</div>
                            </div>
                            <div class="income-brk">
                                <div class="income-brk-val">Rp 1.650.000</div>
                                <div class="income-brk-lbl">Menunggu</div>
                            </div>
                            <div class="income-brk">
                                <div class="income-brk-val">Rp 0</div>
                                <div class="income-brk-lbl">Ditahan</div>
                            </div>
                        </div>
                    </div>

                    {{-- Chart --}}
                    <div class="card">
                        <div class="card-head">
                            <h3><span class="dot"></span> Grafik Penjualan 7 Hari</h3>
                            <a href="#" class="card-action">Lihat detail →</a>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrap">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    {{-- Quick actions --}}
                    <div class="card" style="margin-bottom:14px;">
                        <div class="card-head">
                            <h3><span class="dot"></span> Aksi Cepat</h3>
                        </div>
                        <div class="quick-actions">
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#f0fdf4;">🌾</span> Tambah Produk
                            </a>
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#fff7ed;">🗓️</span> Jadwal Panen
                            </a>
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#eff6ff;">📦</span> Kelola Stok
                            </a>
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#fef9c3;">💰</span> Tarik Dana
                            </a>
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#fdf2f8;">📸</span> Update Foto
                            </a>
                            <a href="#" class="qa-btn">
                                <span class="qa-icon" style="background:#f0fdf4;">🎁</span> Buat Promo
                            </a>
                        </div>
                    </div>

                    {{-- Panen Mendatang --}}
                    <div class="card">
                        <div class="card-head">
                            <h3><span class="dot"></span> Jadwal Panen</h3>
                            <a href="#" class="card-action">Semua →</a>
                        </div>
                        <div class="harvest-list">
                            @php
                                $harvests_sample = [
                                    ['day' => date('d'), 'mon' => 'Mei', 'name' => 'Tomat Merah', 'sub' => 'Grade A · 50 kg siap', 'stok' => '50 kg', 'urgency' => 'today'],
                                    ['day' => date('d', strtotime('+2 days')), 'mon' => 'Mei', 'name' => 'Bayam Organik', 'sub' => 'Segar · 30 ikat', 'stok' => '30 ikat', 'urgency' => 'soon'],
                                    ['day' => date('d', strtotime('+5 days')), 'mon' => 'Mei', 'name' => 'Cabai Merah', 'sub' => 'Pedas · 20 kg', 'stok' => '20 kg', 'urgency' => 'ok'],
                                ];
                            @endphp

                            @foreach($harvests_sample as $h)
                                <div class="harvest-item">
                                    <div class="harvest-date">
                                        <span class="hd-day">{{ $h['day'] }}</span>
                                        <span class="hd-mon">{{ $h['mon'] }}</span>
                                    </div>
                                    <div class="harvest-info">
                                        <div class="harvest-info-name">{{ $h['name'] }}</div>
                                        <div class="harvest-info-sub">{{ $h['sub'] }}</div>
                                    </div>
                                    <div class="harvest-urgency {{ $h['urgency'] }}"></div>
                                    <div class="harvest-stock">
                                        <div class="harvest-stock-val">{{ $h['stok'] }}</div>
                                        <div class="harvest-stock-lbl">siap</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orders + Top Products --}}
            <div class="content-grid anim-4">

                {{-- Recent Orders --}}
                <div class="card">
                    <div class="card-head">
                        <h3><span class="dot"></span> Pesanan Terbaru</h3>
                        <a href="#" class="card-action">Lihat Semua →</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Produk</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $orders_sample = [
                                        ['id' => '#SR-2841', 'prod' => 'Tomat Merah 2kg', 'buyer' => 'Andi S.', 'amount' => 'Rp 18.000', 'status' => 'baru'],
                                        ['id' => '#SR-2840', 'prod' => 'Bayam Organik 1 ikat', 'buyer' => 'Siti R.', 'amount' => 'Rp 8.500', 'status' => 'proses'],
                                        ['id' => '#SR-2839', 'prod' => 'Cabai Merah 500gr', 'buyer' => 'Budi H.', 'amount' => 'Rp 12.000', 'status' => 'kirim'],
                                        ['id' => '#SR-2838', 'prod' => 'Wortel 1kg', 'buyer' => 'Dewi M.', 'amount' => 'Rp 9.000', 'status' => 'selesai'],
                                        ['id' => '#SR-2837', 'prod' => 'Kangkung 2 ikat', 'buyer' => 'Rudi P.', 'amount' => 'Rp 6.000', 'status' => 'selesai'],
                                    ];
                                @endphp
                                @foreach($orders_sample as $o)
                                    <tr>
                                        <td><span class="order-id">{{ $o['id'] }}</span></td>
                                        <td>
                                            <div class="order-product">{{ $o['prod'] }}</div>
                                        </td>
                                        <td><span class="order-buyer">{{ $o['buyer'] }}</span></td>
                                        <td><span class="order-amount">{{ $o['amount'] }}</span></td>
                                        <td>
                                            @php
                                                $labels = ['baru' => 'Baru', 'proses' => 'Diproses', 'kirim' => 'Dikirim', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'];
                                            @endphp
                                            <span class="status-pill {{ $o['status'] }}">{{ $labels[$o['status']] }}</span>
                                        </td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Top Products --}}
                <div class="card">
                    <div class="card-head">
                        <h3><span class="dot"></span> Produk Terlaris</h3>
                        <a href="#" class="card-action">Kelola →</a>
                    </div>
                    <div class="card-body">
                        @php
                            $top_prods = [
                                ['emoji' => '🍅', 'name' => 'Tomat Merah Grade A', 'sub' => '48 terjual bulan ini', 'rev' => 'Rp 432k', 'pct' => 100],
                                ['emoji' => '🥬', 'name' => 'Bayam Organik Segar', 'sub' => '35 terjual bulan ini', 'rev' => 'Rp 297k', 'pct' => 72],
                                ['emoji' => '🌶️', 'name' => 'Cabai Merah Keriting', 'sub' => '28 terjual bulan ini', 'rev' => 'Rp 336k', 'pct' => 58],
                                ['emoji' => '🥕', 'name' => 'Wortel Lokal 1kg', 'sub' => '21 terjual bulan ini', 'rev' => 'Rp 189k', 'pct' => 44],
                                ['emoji' => '🧅', 'name' => 'Bawang Merah Brebes', 'sub' => '16 terjual bulan ini', 'rev' => 'Rp 224k', 'pct' => 33],
                            ];
                            $rank_classes = ['gold', 'silver', 'bronze', '', ''];
                            $rank_symbols = ['🥇', '🥈', '🥉', '4', '5'];
                        @endphp

                        @foreach($top_prods as $i => $p)
                            <div class="prod-row">
                                <div class="prod-rank {{ $rank_classes[$i] }}">{{ $rank_symbols[$i] }}</div>
                                <div class="prod-thumb">{{ $p['emoji'] }}</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">{{ $p['name'] }}</div>
                                    <div class="prod-info-sub">{{ $p['sub'] }}</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:{{ $p['pct'] }}%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">{{ $p['rev'] }}</div>
                                    <div class="prod-rev-pcs">{{ $p['pct'] }}%</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </main>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function () {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;

            const labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            const revenue = [320000, 450000, 380000, 620000, 510000, 780000, 490000];
            const orders = [4, 6, 5, 9, 7, 11, 7];

            new Chart(ctx, {
                data: {
                    labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Pendapatan (Rp)',
                            data: revenue,
                            backgroundColor: 'rgba(61,186,126,.18)',
                            borderColor: '#3dba7e',
                            borderWidth: 2,
                            borderRadius: 6,
                            yAxisID: 'y',
                        },
                        {
                            type: 'line',
                            label: 'Jumlah Pesanan',
                            data: orders,
                            borderColor: '#e8c97e',
                            backgroundColor: 'rgba(232,201,126,.12)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#e8c97e',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Nunito', size: 11, weight: '700' }, boxWidth: 12, padding: 12 }
                        },
                        tooltip: {
                            backgroundColor: '#0f2419',
                            titleFont: { family: 'Nunito', size: 12 },
                            bodyFont: { family: 'Nunito', size: 11 },
                            callbacks: {
                                label: ctx => ctx.dataset.type === 'bar'
                                    ? ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                                    : ' ' + ctx.parsed.y + ' pesanan'
                            }
                        }
                    },
                    scales: {
                        y: {
                            position: 'left',
                            grid: { color: '#f0f5f2' },
                            ticks: {
                                font: { family: 'Nunito', size: 10 },
                                callback: v => 'Rp ' + (v / 1000).toFixed(0) + 'k'
                            }
                        },
                        y1: {
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { font: { family: 'Nunito', size: 10 }, stepSize: 1 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Nunito', size: 11, weight: '700' } }
                        }
                    }
                }
            });
        })();
    </script>
@endpush