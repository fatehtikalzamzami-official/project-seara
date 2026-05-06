<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual – SEARA</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- STEP 2: Tambah Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
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

        /* ─── LAYOUT ─── */
        .seller-wrap {
            display: flex;
            min-height: 100vh;
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
            height: 100vh;
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

        /* STEP 3: sidebar-item dengan ikon <i> */
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

        /* Ikon FA di sidebar */
        .sidebar-item .si-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--green-pale);
            flex-shrink: 0;
            transition: background .18s;
            font-size: 14px;
            color: var(--green-dark);
        }

        .sidebar-item:hover .si-icon,
        .sidebar-item.active .si-icon {
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

        /* Sidebar profile card */
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

        /* ─── MAIN ─── */
        .seller-main {
            flex: 1;
            padding: 24px;
            overflow-x: hidden;
        }

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

        /* Stat cards */
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

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            margin-bottom: 14px;
        }

        .stat-icon.green {
            background: var(--green-pale);
            color: var(--green-dark);
        }

        .stat-icon.orange {
            background: var(--accent-soft);
            color: var(--accent);
        }

        .stat-icon.blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
            color: #b45309;
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

        /* Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
            margin-bottom: 16px;
        }

        /* Card */
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

        /* Chart */
        .chart-wrap {
            position: relative;
            height: 220px;
            margin-top: 4px;
        }

        /* Quick actions */
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
            font-size: 15px;
            flex-shrink: 0;
        }

        /* Order table */
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

        /* Top products */
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

        /* Harvest list */
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

        /* Income card */
        .income-card {
            background: linear-gradient(135deg, var(--green-dark) 0%, #1e6641 60%, #246b4a 100%);
            border-radius: var(--r);
            padding: 22px;
            position: relative;
            overflow: hidden;
            margin-bottom: 14px;
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

        /* Alert */
        .alert-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .alert-banner.warning {
            background: var(--yellow-soft);
            border: 1px solid #fde68a;
        }

        .alert-banner.info {
            background: var(--blue-soft);
            border: 1px solid #bfdbfe;
        }

        .alert-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            opacity: .5;
            padding: 2px;
        }

        .alert-close:hover {
            opacity: 1;
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

        .alert-banner-text small {
            display: block;
            font-size: 11px;
            font-weight: 600;
            opacity: .75;
            margin-top: 1px;
        }

        /* Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
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

        .anim-4 {
            animation: fadeUp .45s .21s ease both;
        }

        /* ═══════════════════════════════════════
   STEP 4: HALAMAN PROFIL TOKO
═══════════════════════════════════════ */
        .page-view {
            display: none;
        }

        .page-view.active {
            display: block;
        }

        /* Form profil toko */
        .profil-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 20px;
            align-items: start;
        }

        .profil-photo-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 24px;
            text-align: center;
        }

        .profil-avatar-wrap {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green-dark), #1e6641);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 900;
            color: white;
            margin: 0 auto 14px;
            position: relative;
            cursor: pointer;
        }

        .profil-avatar-wrap .edit-overlay {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(0, 0, 0, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .2s;
            font-size: 18px;
            color: white;
        }

        .profil-avatar-wrap:hover .edit-overlay {
            opacity: 1;
        }

        .profil-shop-name {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 3px;
        }

        .profil-shop-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 16px;
        }

        .profil-badges {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .badge-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            background: var(--green-pale);
            font-size: 12px;
            font-weight: 700;
            color: var(--green-dark);
        }

        .badge-item i {
            font-size: 14px;
        }

        .profil-form-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 0;
            overflow: hidden;
        }

        .form-section-head {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-head i {
            color: var(--green-main);
            font-size: 15px;
        }

        .form-body {
            padding: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
            letter-spacing: .3px;
        }

        .form-label .req {
            color: var(--accent);
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 10px 13px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-dark);
            background: white;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(45, 134, 83, .1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 90px;
            line-height: 1.55;
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        /* Jam operasional */
        .jam-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f5f2;
        }

        .jam-row:last-child {
            border-bottom: none;
        }

        .jam-day {
            width: 90px;
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
        }

        .jam-toggle {
            position: relative;
            width: 38px;
            height: 21px;
            flex-shrink: 0;
        }

        .jam-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .jam-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            border-radius: 21px;
            background: #d1d5db;
            transition: background .2s;
        }

        .jam-slider::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            left: 3px;
            bottom: 3px;
            border-radius: 50%;
            background: white;
            transition: transform .2s;
        }

        .jam-toggle input:checked+.jam-slider {
            background: var(--green-mid);
        }

        .jam-toggle input:checked+.jam-slider::before {
            transform: translateX(17px);
        }

        .jam-times {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        .jam-input {
            padding: 5px 8px;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            color: var(--text-dark);
            background: white;
            outline: none;
            width: 76px;
        }

        .jam-input:focus {
            border-color: var(--green-main);
        }

        .jam-sep {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 700;
        }

        /* Stats mini */
        .mini-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .mini-stat {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .mini-stat-icon {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .mini-stat-val {
            font-size: 20px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1;
        }

        .mini-stat-lbl {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
            margin-top: 3px;
        }

        /* Tombol simpan */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #fafcfa;
        }

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

        /* ─── BACK TO BUYER BUTTON ─── */
        .back-buyer-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: white;
            text-decoration: none;
            cursor: pointer;
            transition: all .22s;
            position: relative;
            overflow: hidden;
        }

        .back-buyer-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--green-pale), #d1fae5);
            opacity: 0;
            transition: opacity .22s;
        }

        .back-buyer-btn:hover {
            border-color: var(--green-main);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .back-buyer-btn:hover::before {
            opacity: 1;
        }

        .back-buyer-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
            background: var(--green-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: var(--green-dark);
            position: relative;
            z-index: 1;
            transition: background .22s;
        }

        .back-buyer-btn:hover .back-buyer-icon {
            background: #bbf7d0;
        }

        .back-buyer-text {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .back-buyer-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .back-buyer-sub {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 1px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .back-buyer-tag {
            font-size: 13px;
            color: var(--text-muted);
            position: relative;
            z-index: 1;
            transition: color .22s;
        }

        .back-buyer-btn:hover .back-buyer-tag {
            color: var(--green-main);
        }

        /* Responsive */
        @media(max-width:1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .profil-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:768px) {
            .seller-sidebar {
                display: none;
            }

            .seller-main {
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .mini-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="seller-wrap">

        <!-- ══ SIDEBAR ══ -->
        <aside class="seller-sidebar">

            <!-- Profile card -->
            <div class="sidebar-profile">
                <div class="sp-ava">BU</div>
                <div class="sp-name">Budi Santoso</div>
                <div class="sp-role">⭐ Petani Terverifikasi</div>
                <div class="sp-stats">
                    <div class="sp-stat"><strong>12</strong><span>Produk</span></div>
                    <div class="sp-stat"><strong>24</strong><span>Pesanan</span></div>
                    <div class="sp-stat"><strong>4.9</strong><span>Rating</span></div>
                </div>
            </div>

            <!-- Tombol balik ke buyer dashboard -->
            <div style="padding:0 16px 14px;">
                <a href="/" class="back-buyer-btn">
                    <span class="back-buyer-icon"><i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i></span>
                    <span class="back-buyer-text">
                        <span class="back-buyer-label">Kembali ke Marketplace</span>
                        <span class="back-buyer-sub">Mode Pembeli</span>
                    </span>
                    <i class="fa-solid fa-store-slash back-buyer-tag" aria-hidden="true"></i>
                </a>
            </div>

            <!-- Menu Utama -->
            <!-- STEP 3: Semua emoji diganti <i class="fa-..."> -->
            <div class="sidebar-section">
                <span class="sidebar-label">Utama</span>
                <button class="sidebar-item active" onclick="showPage('dashboard', this)">
                    <span class="si-icon"><i class="fa-solid fa-house-chimney" aria-hidden="true"></i></span>
                    Dashboard
                </button>
                <button class="sidebar-item" onclick="showPage('pesanan', this)">
                    <span class="si-icon"><i class="fa-solid fa-box" aria-hidden="true"></i></span>
                    Pesanan Masuk
                    <span class="sidebar-badge">3</span>
                </button>
                <button class="sidebar-item" onclick="showPage('chat', this)">
                    <span class="si-icon"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i></span>
                    Pesan Chat
                    <span class="sidebar-badge">5</span>
                </button>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Kelola</span>
                <button class="sidebar-item" onclick="showPage('produk', this)">
                    <span class="si-icon"><i class="fa-solid fa-wheat-awn" aria-hidden="true"></i></span>
                    Produk Saya
                </button>
                <button class="sidebar-item" onclick="showPage('panen', this)">
                    <span class="si-icon"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
                    Jadwal Panen
                </button>
                <button class="sidebar-item" onclick="showPage('laporan', this)">
                    <span class="si-icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></span>
                    Laporan Penjualan
                </button>
                <button class="sidebar-item" onclick="showPage('keuangan', this)">
                    <span class="si-icon"><i class="fa-solid fa-wallet" aria-hidden="true"></i></span>
                    Keuangan
                </button>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-section">
                <span class="sidebar-label">Akun</span>
                <!-- STEP 4: Profil Toko mengarah ke halaman profilToko -->
                <button class="sidebar-item" onclick="showPage('profilToko', this)">
                    <span class="si-icon"><i class="fa-solid fa-store" aria-hidden="true"></i></span>
                    Profil Toko
                </button>
                <button class="sidebar-item" onclick="showPage('pengaturan', this)">
                    <span class="si-icon"><i class="fa-solid fa-gear" aria-hidden="true"></i></span>
                    Pengaturan
                </button>
            </div>
        </aside>

        <!-- ══ MAIN ══ -->
        <main class="seller-main">

            <!-- ─────────────────────────── PAGE: DASHBOARD ─────────────────────────── -->
            <div id="page-dashboard" class="page-view active">

                <div class="alert-banner warning anim-1" id="alertStok">
                    <div class="alert-banner-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="alert-banner-text">
                        3 produk stok hampir habis!
                        <small>Segera perbarui stok untuk menghindari kehilangan pesanan.</small>
                    </div>
                    <a href="#" style="font-size:12px;font-weight:800;color:#92400e;margin-right:10px;">Perbarui</a>
                    <button class="alert-close" onclick="this.closest('.alert-banner').remove()">✕</button>
                </div>

                <div class="alert-banner info anim-1">
                    <div class="alert-banner-icon"><i class="fa-solid fa-seedling"></i></div>
                    <div class="alert-banner-text">
                        Panen hari ini: <strong>Tomat Merah 50kg</strong> siap dijual!
                        <small>Klik untuk langsung listing produk panen hari ini.</small>
                    </div>
                    <a href="#" style="font-size:12px;font-weight:800;color:#1e40af;margin-right:10px;">Listing
                        Sekarang</a>
                    <button class="alert-close" onclick="this.closest('.alert-banner').remove()">✕</button>
                </div>

                <div class="page-header anim-2">
                    <div class="page-header-left">
                        <h1>Dashboard Penjual 🌾</h1>
                        <p>Selamat datang kembali, Budi! Ini ringkasan tokomu hari ini.</p>
                    </div>
                    <div class="page-header-right">
                        <a href="#" class="btn-outline"><i class="fa-solid fa-download"></i> Unduh Laporan</a>
                        <a href="#" class="btn-green"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
                    </div>
                </div>

                <!-- Stat Cards -->
                <div class="stats-grid anim-2">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fa-solid fa-coins"></i></div>
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-value">Rp 4.850.000</div>
                        <div class="stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i> 18% <span
                                class="stat-trend">vs bulan lalu</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fa-solid fa-box-open"></i></div>
                        <div class="stat-label">Pesanan Masuk</div>
                        <div class="stat-value">24</div>
                        <div class="stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i> 5 <span
                                class="stat-trend">minggu ini</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="fa-solid fa-leaf"></i></div>
                        <div class="stat-label">Produk Aktif</div>
                        <div class="stat-value">12</div>
                        <div class="stat-delta down"><i class="fa-solid fa-arrow-trend-down"></i> 2 <span
                                class="stat-trend">stok habis</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon yellow"><i class="fa-solid fa-star"></i></div>
                        <div class="stat-label">Rating Toko</div>
                        <div class="stat-value">4.9</div>
                        <div class="stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i> 0.1 <span
                                class="stat-trend">dari 127 ulasan</span></div>
                    </div>
                </div>

                <!-- Income + Quick actions -->
                <div class="content-grid anim-3">
                    <div>
                        <div class="income-card">
                            <div class="income-label">Pendapatan Bulan Ini</div>
                            <div class="income-value">Rp 4.850.000</div>
                            <div class="income-sub">dari 24 pesanan selesai</div>
                            <div class="income-change"><i class="fa-solid fa-arrow-trend-up"></i> 18% lebih tinggi dari
                                bulan lalu</div>
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
                        <div class="card">
                            <div class="card-head">
                                <h3><span class="dot"></span> Grafik Penjualan 7 Hari</h3>
                                <a href="#" class="card-action">Lihat detail →</a>
                            </div>
                            <div class="card-body">
                                <div class="chart-wrap"><canvas id="salesChart"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card" style="margin-bottom:14px;">
                            <div class="card-head">
                                <h3><span class="dot"></span> Aksi Cepat</h3>
                            </div>
                            <div class="quick-actions">
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#f0fdf4;color:var(--green-dark)"><i
                                            class="fa-solid fa-seedling"></i></span> Tambah Produk</a>
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#fff7ed;color:#c2570a"><i
                                            class="fa-solid fa-calendar-plus"></i></span> Jadwal Panen</a>
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#eff6ff;color:#1d4ed8"><i
                                            class="fa-solid fa-cubes"></i></span> Kelola Stok</a>
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#fef9c3;color:#92400e"><i
                                            class="fa-solid fa-money-bill-wave"></i></span> Tarik Dana</a>
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#fdf2f8;color:#9d174d"><i
                                            class="fa-solid fa-camera"></i></span> Update Foto</a>
                                <a href="#" class="qa-btn"><span class="qa-icon"
                                        style="background:#f0fdf4;color:var(--green-dark)"><i
                                            class="fa-solid fa-gift"></i></span> Buat Promo</a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-head">
                                <h3><span class="dot"></span> Jadwal Panen</h3>
                                <a href="#" class="card-action">Semua →</a>
                            </div>
                            <div class="harvest-list">
                                <div class="harvest-item">
                                    <div class="harvest-date"><span class="hd-day">07</span><span
                                            class="hd-mon">Mei</span></div>
                                    <div class="harvest-info">
                                        <div class="harvest-info-name">Tomat Merah</div>
                                        <div class="harvest-info-sub">Grade A · 50 kg siap</div>
                                    </div>
                                    <div class="harvest-urgency today"></div>
                                    <div class="harvest-stock">
                                        <div class="harvest-stock-val">50 kg</div>
                                        <div class="harvest-stock-lbl">siap</div>
                                    </div>
                                </div>
                                <div class="harvest-item">
                                    <div class="harvest-date"><span class="hd-day">09</span><span
                                            class="hd-mon">Mei</span></div>
                                    <div class="harvest-info">
                                        <div class="harvest-info-name">Bayam Organik</div>
                                        <div class="harvest-info-sub">Segar · 30 ikat</div>
                                    </div>
                                    <div class="harvest-urgency soon"></div>
                                    <div class="harvest-stock">
                                        <div class="harvest-stock-val">30 ikat</div>
                                        <div class="harvest-stock-lbl">siap</div>
                                    </div>
                                </div>
                                <div class="harvest-item">
                                    <div class="harvest-date"><span class="hd-day">12</span><span
                                            class="hd-mon">Mei</span></div>
                                    <div class="harvest-info">
                                        <div class="harvest-info-name">Cabai Merah</div>
                                        <div class="harvest-info-sub">Pedas · 20 kg</div>
                                    </div>
                                    <div class="harvest-urgency ok"></div>
                                    <div class="harvest-stock">
                                        <div class="harvest-stock-val">20 kg</div>
                                        <div class="harvest-stock-lbl">siap</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders + Top Products -->
                <div class="content-grid anim-4">
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
                                    <tr>
                                        <td><span class="order-id">#SR-2841</span></td>
                                        <td>
                                            <div class="order-product">Tomat Merah 2kg</div>
                                        </td>
                                        <td><span class="order-buyer">Andi S.</span></td>
                                        <td><span class="order-amount">Rp 18.000</span></td>
                                        <td><span class="status-pill baru">Baru</span></td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="order-id">#SR-2840</span></td>
                                        <td>
                                            <div class="order-product">Bayam Organik 1 ikat</div>
                                        </td>
                                        <td><span class="order-buyer">Siti R.</span></td>
                                        <td><span class="order-amount">Rp 8.500</span></td>
                                        <td><span class="status-pill proses">Diproses</span></td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="order-id">#SR-2839</span></td>
                                        <td>
                                            <div class="order-product">Cabai Merah 500gr</div>
                                        </td>
                                        <td><span class="order-buyer">Budi H.</span></td>
                                        <td><span class="order-amount">Rp 12.000</span></td>
                                        <td><span class="status-pill kirim">Dikirim</span></td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="order-id">#SR-2838</span></td>
                                        <td>
                                            <div class="order-product">Wortel 1kg</div>
                                        </td>
                                        <td><span class="order-buyer">Dewi M.</span></td>
                                        <td><span class="order-amount">Rp 9.000</span></td>
                                        <td><span class="status-pill selesai">Selesai</span></td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="order-id">#SR-2837</span></td>
                                        <td>
                                            <div class="order-product">Kangkung 2 ikat</div>
                                        </td>
                                        <td><span class="order-buyer">Rudi P.</span></td>
                                        <td><span class="order-amount">Rp 6.000</span></td>
                                        <td><span class="status-pill selesai">Selesai</span></td>
                                        <td><a href="#" class="card-action" style="font-size:11px;">Detail</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h3><span class="dot"></span> Produk Terlaris</h3>
                            <a href="#" class="card-action">Kelola →</a>
                        </div>
                        <div class="card-body">
                            <div class="prod-row">
                                <div class="prod-rank gold">🥇</div>
                                <div class="prod-thumb">🍅</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">Tomat Merah Grade A</div>
                                    <div class="prod-info-sub">48 terjual bulan ini</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:100%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">Rp 432k</div>
                                    <div class="prod-rev-pcs">100%</div>
                                </div>
                            </div>
                            <div class="prod-row">
                                <div class="prod-rank silver">🥈</div>
                                <div class="prod-thumb">🥬</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">Bayam Organik Segar</div>
                                    <div class="prod-info-sub">35 terjual bulan ini</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:72%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">Rp 297k</div>
                                    <div class="prod-rev-pcs">72%</div>
                                </div>
                            </div>
                            <div class="prod-row">
                                <div class="prod-rank bronze">🥉</div>
                                <div class="prod-thumb">🌶️</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">Cabai Merah Keriting</div>
                                    <div class="prod-info-sub">28 terjual bulan ini</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:58%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">Rp 336k</div>
                                    <div class="prod-rev-pcs">58%</div>
                                </div>
                            </div>
                            <div class="prod-row">
                                <div class="prod-rank">4</div>
                                <div class="prod-thumb">🥕</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">Wortel Lokal 1kg</div>
                                    <div class="prod-info-sub">21 terjual bulan ini</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:44%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">Rp 189k</div>
                                    <div class="prod-rev-pcs">44%</div>
                                </div>
                            </div>
                            <div class="prod-row">
                                <div class="prod-rank">5</div>
                                <div class="prod-thumb">🧅</div>
                                <div class="prod-info">
                                    <div class="prod-info-name">Bawang Merah Brebes</div>
                                    <div class="prod-info-sub">16 terjual bulan ini</div>
                                    <div class="prod-bar-wrap">
                                        <div class="prod-bar" style="width:33%"></div>
                                    </div>
                                </div>
                                <div class="prod-rev">
                                    <div class="prod-rev-val">Rp 224k</div>
                                    <div class="prod-rev-pcs">33%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /page-dashboard -->


            <!-- ═══════════════════════════════════════
         PAGE: PROFIL TOKO (STEP 4)
    ═══════════════════════════════════════ -->
            <div id="page-profilToko" class="page-view">

                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Profil Toko <i class="fa-solid fa-store" style="font-size:22px;color:var(--green-main)"></i>
                        </h1>
                        <p>Kelola informasi toko dan tampilan yang dilihat pembeli.</p>
                    </div>
                    <div class="page-header-right">
                        <a href="#" class="btn-outline"><i class="fa-solid fa-eye"></i> Pratinjau Toko</a>
                        <button class="btn-green" onclick="simpanProfil()"><i class="fa-solid fa-floppy-disk"></i>
                            Simpan Perubahan</button>
                    </div>
                </div>

                <!-- Mini stats toko -->
                <div class="mini-stats anim-2">
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="color:var(--green-main)"><i class="fa-solid fa-star"></i>
                        </div>
                        <div class="mini-stat-val">4.9</div>
                        <div class="mini-stat-lbl">Rating Rata-rata</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="color:var(--blue)"><i class="fa-solid fa-users"></i></div>
                        <div class="mini-stat-val">342</div>
                        <div class="mini-stat-lbl">Total Pembeli</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="color:var(--accent)"><i class="fa-solid fa-heart"></i></div>
                        <div class="mini-stat-val">127</div>
                        <div class="mini-stat-lbl">Difavoritkan</div>
                    </div>
                </div>

                <div class="profil-grid anim-3">

                    <!-- Kiri: foto & badge -->
                    <div>
                        <div class="profil-photo-card" style="margin-bottom:14px;">
                            <div class="profil-avatar-wrap" title="Klik untuk ubah foto">
                                BU
                                <div class="edit-overlay"><i class="fa-solid fa-camera"></i></div>
                            </div>
                            <div class="profil-shop-name">Tani Segar Nusantara</div>
                            <div class="profil-shop-sub">Bergabung sejak Januari 2024</div>
                            <div class="profil-badges">
                                <div class="badge-item"><i class="fa-solid fa-shield-halved"
                                        style="color:var(--green-main)"></i> Penjual Terverifikasi</div>
                                <div class="badge-item"><i class="fa-solid fa-medal" style="color:#f5a623"></i> Top
                                    Seller Bulan Ini</div>
                                <div class="badge-item"><i class="fa-solid fa-truck-fast" style="color:var(--blue)"></i>
                                    Pengiriman Cepat</div>
                            </div>
                        </div>

                        <!-- Upload foto toko -->
                        <div class="profil-photo-card">
                            <div class="form-section-head"
                                style="margin:-0 -0 12px;padding:0 0 12px;border-bottom:1px solid var(--border)">
                                <i class="fa-solid fa-image"></i> Foto Toko
                            </div>
                            <div style="border:2px dashed var(--border);border-radius:10px;padding:20px;text-align:center;cursor:pointer;transition:border-color .2s"
                                onmouseover="this.style.borderColor='var(--green-main)'"
                                onmouseout="this.style.borderColor='var(--border)'">
                                <i class="fa-solid fa-cloud-arrow-up"
                                    style="font-size:28px;color:var(--text-muted);margin-bottom:8px;display:block"></i>
                                <div style="font-size:13px;font-weight:700;color:var(--text-mid)">Unggah Foto Toko</div>
                                <div style="font-size:11px;color:var(--text-muted);margin-top:3px">PNG, JPG, maks. 5MB ·
                                    Rasio 16:9</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan: form -->
                    <div>
                        <!-- Informasi Dasar -->
                        <div class="profil-form-card" style="margin-bottom:14px;">
                            <div class="form-section-head">
                                <i class="fa-solid fa-circle-info"></i> Informasi Dasar
                            </div>
                            <div class="form-body">
                                <div class="form-row full">
                                    <div class="form-group">
                                        <label class="form-label">Nama Toko <span class="req">*</span></label>
                                        <input class="form-input" type="text" value="Tani Segar Nusantara"
                                            placeholder="Nama toko Anda">
                                        <span class="form-hint">Nama ini ditampilkan kepada pembeli di seluruh
                                            marketplace.</span>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Kategori Utama <span class="req">*</span></label>
                                        <select class="form-select">
                                            <option selected>Sayuran & Buah</option>
                                            <option>Rempah & Bumbu</option>
                                            <option>Beras & Palawija</option>
                                            <option>Produk Olahan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kota / Kabupaten</label>
                                        <input class="form-input" type="text" value="Pangkalpinang, Babel"
                                            placeholder="Lokasi toko">
                                    </div>
                                </div>
                                <div class="form-row full">
                                    <div class="form-group">
                                        <label class="form-label">Deskripsi Toko</label>
                                        <textarea class="form-textarea"
                                            placeholder="Ceritakan tentang toko dan produk Anda...">Tani Segar Nusantara menyediakan sayuran organik segar langsung dari kebun. Kami berkomitmen menghadirkan produk berkualitas tinggi dengan harga petani untuk konsumen Indonesia.</textarea>
                                        <span class="form-hint">Maks. 500 karakter. Deskripsi yang baik meningkatkan
                                            kepercayaan pembeli.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kontak & Sosial -->
                        <div class="profil-form-card" style="margin-bottom:14px;">
                            <div class="form-section-head">
                                <i class="fa-solid fa-address-book"></i> Kontak & Media Sosial
                            </div>
                            <div class="form-body">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label"><i class="fa-solid fa-phone"
                                                style="color:var(--green-main)"></i> Nomor WhatsApp</label>
                                        <input class="form-input" type="text" value="+62 812-3456-7890"
                                            placeholder="08xx-xxxx-xxxx">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><i class="fa-solid fa-envelope"
                                                style="color:var(--green-main)"></i> Email Toko</label>
                                        <input class="form-input" type="email" value="tani.segar@email.com"
                                            placeholder="email@contoh.com">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label"><i class="fa-brands fa-instagram"
                                                style="color:#e1306c"></i> Instagram</label>
                                        <input class="form-input" type="text" value="@tanisegar.id"
                                            placeholder="@username">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><i class="fa-brands fa-tiktok"
                                                style="color:#010101"></i> TikTok</label>
                                        <input class="form-input" type="text" value="" placeholder="@username">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="profil-form-card">
                            <div class="form-section-head">
                                <i class="fa-solid fa-clock"></i> Jam Operasional
                            </div>
                            <div class="form-body" style="padding-bottom:4px;">
                                <div id="jam-operasional">
                                    <!-- JS renders jam rows -->
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="btn-outline" type="button">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </button>
                                <button class="btn-green" type="button" onclick="simpanProfil()">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /page-profilToko -->


            <!-- Placeholder pages -->
            <div id="page-pesanan" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Pesanan Masuk <i class="fa-solid fa-box-open"
                                style="font-size:20px;color:var(--green-main)"></i></h1>
                        <p>Kelola semua pesanan yang masuk ke toko Anda.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-box"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman pesanan
                    masuk akan ditampilkan di sini.</div>
            </div>
            <div id="page-chat" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Pesan Chat <i class="fa-solid fa-comment-dots"
                                style="font-size:20px;color:var(--green-main)"></i></h1>
                        <p>Balas pertanyaan dari pembeli.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-comments"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman pesan
                    chat akan ditampilkan di sini.</div>
            </div>
            <div id="page-produk" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Produk Saya <i class="fa-solid fa-wheat-awn"
                                style="font-size:20px;color:var(--green-main)"></i></h1>
                        <p>Kelola semua produk yang Anda jual.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-box-archive"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman produk
                    akan ditampilkan di sini.</div>
            </div>
            <div id="page-panen" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Jadwal Panen <i class="fa-solid fa-calendar-days"
                                style="font-size:20px;color:var(--green-main)"></i></h1>
                        <p>Atur dan pantau jadwal panen Anda.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-regular fa-calendar"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman jadwal
                    panen akan ditampilkan di sini.</div>
            </div>
            <div id="page-laporan" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Laporan Penjualan <i class="fa-solid fa-chart-line"
                                style="font-size:20px;color:var(--green-main)"></i></h1>
                        <p>Analisis performa penjualan Anda.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-chart-bar"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman laporan
                    akan ditampilkan di sini.</div>
            </div>
            <div id="page-keuangan" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Keuangan <i class="fa-solid fa-wallet" style="font-size:20px;color:var(--green-main)"></i>
                        </h1>
                        <p>Pantau saldo dan riwayat transaksi keuangan.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-sack-dollar"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman keuangan
                    akan ditampilkan di sini.</div>
            </div>
            <div id="page-pengaturan" class="page-view">
                <div class="page-header anim-1">
                    <div class="page-header-left">
                        <h1>Pengaturan <i class="fa-solid fa-gear" style="font-size:20px;color:var(--green-main)"></i>
                        </h1>
                        <p>Konfigurasi preferensi akun dan toko.</p>
                    </div>
                </div>
                <div class="card anim-2" style="padding:40px;text-align:center;color:var(--text-muted)"><i
                        class="fa-solid fa-sliders"
                        style="font-size:48px;margin-bottom:12px;display:block;color:var(--border)"></i>Halaman
                    pengaturan akan ditampilkan di sini.</div>
            </div>

        </main>
    </div>

    <!-- Toast notifikasi -->
    <div class="toast" id="toast">
        <i class="fa-solid fa-circle-check"></i>
        Profil toko berhasil disimpan!
    </div>

    <script>
        // ─── STEP 4: Tab navigation ───
        function showPage(pageId, clickedEl) {
            document.querySelectorAll('.page-view').forEach(p => p.classList.remove('active'));
            document.getElementById('page-' + pageId).classList.add('active');
            document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
            if (clickedEl) clickedEl.classList.add('active');

            // Re-init chart jika kembali ke dashboard
            if (pageId === 'dashboard') initChart();
        }

        // ─── Jam Operasional ───
        const days = [
            { name: 'Senin', open: true, from: '07:00', to: '17:00' },
            { name: 'Selasa', open: true, from: '07:00', to: '17:00' },
            { name: 'Rabu', open: true, from: '07:00', to: '17:00' },
            { name: 'Kamis', open: true, from: '07:00', to: '17:00' },
            { name: 'Jumat', open: true, from: '07:00', to: '15:00' },
            { name: 'Sabtu', open: true, from: '08:00', to: '13:00' },
            { name: 'Minggu', open: false, from: '', to: '' },
        ];
        function renderJam() {
            const wrap = document.getElementById('jam-operasional');
            if (!wrap) return;
            wrap.innerHTML = days.map((d, i) => `
    <div class="jam-row">
      <div class="jam-day">${d.name}</div>
      <label class="jam-toggle">
        <input type="checkbox" ${d.open ? 'checked' : ''} onchange="toggleJam(${i},this)">
        <span class="jam-slider"></span>
      </label>
      <div class="jam-times" id="times-${i}" style="${d.open ? '' : 'opacity:.35;pointer-events:none'}">
        <input class="jam-input" type="time" value="${d.from}">
        <span class="jam-sep">–</span>
        <input class="jam-input" type="time" value="${d.to}">
      </div>
    </div>
  `).join('');
        }
        function toggleJam(i, el) {
            days[i].open = el.checked;
            const times = document.getElementById('times-' + i);
            times.style.opacity = el.checked ? '1' : '.35';
            times.style.pointerEvents = el.checked ? 'auto' : 'none';
        }
        renderJam();

        // ─── Toast simpan ───
        function simpanProfil() {
            const t = document.getElementById('toast');
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        // ─── Chart.js ───
        let chartInstance = null;
        function initChart() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;
            if (chartInstance) { chartInstance.destroy(); chartInstance = null; }
            chartInstance = new Chart(ctx, {
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [
                        {
                            type: 'bar', label: 'Pendapatan (Rp)',
                            data: [320000, 450000, 380000, 620000, 510000, 780000, 490000],
                            backgroundColor: 'rgba(61,186,126,.18)',
                            borderColor: '#3dba7e', borderWidth: 2, borderRadius: 6, yAxisID: 'y'
                        },
                        {
                            type: 'line', label: 'Jumlah Pesanan',
                            data: [4, 6, 5, 9, 7, 11, 7],
                            borderColor: '#e8c97e', backgroundColor: 'rgba(232,201,126,.12)',
                            borderWidth: 2.5, tension: 0.4, fill: true,
                            pointBackgroundColor: '#e8c97e', pointRadius: 4, pointHoverRadius: 6, yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: 'Nunito', size: 11, weight: '700' }, boxWidth: 12, padding: 12 } },
                        tooltip: {
                            backgroundColor: '#0f2419',
                            titleFont: { family: 'Nunito', size: 12 },
                            bodyFont: { family: 'Nunito', size: 11 },
                            callbacks: { label: c => c.dataset.type === 'bar' ? ' Rp ' + c.parsed.y.toLocaleString('id-ID') : ' ' + c.parsed.y + ' pesanan' }
                        }
                    },
                    scales: {
                        y: { position: 'left', grid: { color: '#f0f5f2' }, ticks: { font: { family: 'Nunito', size: 10 }, callback: v => 'Rp ' + (v / 1000).toFixed(0) + 'k' } },
                        y1: { position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { family: 'Nunito', size: 10 }, stepSize: 1 } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 11, weight: '700' } } }
                    }
                }
            });
        }
        initChart();
    </script>
</body>

</html>