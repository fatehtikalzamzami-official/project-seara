m
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk – SEARA</title>
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
            padding: 0
        }

        body {
            background: var(--bg);
            font-family: 'Nunito', sans-serif;
            color: var(--text-dark)
        }

        .seller-wrap {
            display: flex;
            min-height: 100vh
        }

        .seller-main {
            flex: 1;
            padding: 24px;
            overflow-x: hidden
        }

        /* Page Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px
        }

        .page-header-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark)
        }

        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 600
        }

        /* Buttons */
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
            text-decoration: none
        }

        .btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(61, 186, 126, .3)
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
            text-decoration: none
        }

        .btn-outline:hover {
            border-color: var(--green-main);
            color: var(--green-dark)
        }

        /* Alert */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--green-dark)
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b
        }

        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 22px
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 16px 18px;
            cursor: pointer;
            transition: all .2s
        }

        .stat-card:hover {
            border-color: var(--green-main);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm)
        }

        .stat-card.active-filter {
            border-color: var(--green-main);
            background: var(--green-pale)
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
            color: #b45309
        }

        .stat-icon.blue {
            background: var(--blue-soft);
            color: var(--blue)
        }

        .stat-icon.green {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        .stat-icon.purple {
            background: #f5f3ff;
            color: #6d28d9
        }

        .stat-icon.orange {
            background: var(--accent-soft);
            color: var(--accent)
        }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 3px
        }

        .stat-value {
            font-size: 20px;
            font-weight: 900;
            color: var(--text-dark)
        }

        /* Filter Bar */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            flex-wrap: wrap
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
            max-width: 320px
        }

        .search-box input {
            border: none;
            outline: none;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-dark);
            background: transparent;
            width: 100%
        }

        .search-box i {
            color: var(--text-muted);
            font-size: 13px
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
            cursor: pointer
        }

        .filter-select:focus {
            border-color: var(--green-main)
        }

        /* Status Tab Pills */
        .status-tabs {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 18px
        }

        .status-tab {
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--text-mid);
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: 5px
        }

        .status-tab:hover {
            border-color: var(--green-main);
            color: var(--green-dark)
        }

        .status-tab.active {
            background: var(--green-main);
            color: white;
            border-color: var(--green-main)
        }

        .status-tab .tab-count {
            background: rgba(255, 255, 255, .25);
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 12px
        }

        .status-tab:not(.active) .tab-count {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        /* Orders List */
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        /* Order Card */
        .order-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden;
            transition: all .2s
        }

        .order-card:hover {
            box-shadow: var(--shadow-md);
            border-color: #c5ddd0
        }

        .order-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #fafcfa
        }

        .order-head-left {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .order-number {
            font-size: 13px;
            font-weight: 900;
            color: var(--text-dark)
        }

        .order-date {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px
        }

        .order-head-right {
            display: flex;
            align-items: center;
            gap: 10px
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800
        }

        .status-badge.pending_payment {
            background: #fef3c7;
            color: #92400e
        }

        .status-badge.paid {
            background: #dbeafe;
            color: #1e40af
        }

        .status-badge.processing {
            background: #e0f2fe;
            color: #0369a1
        }

        .status-badge.shipped {
            background: #f5f3ff;
            color: #5b21b6
        }

        .status-badge.delivered {
            background: #dcfce7;
            color: #166534
        }

        .status-badge.cancelled {
            background: #fee2e2;
            color: #991b1b
        }

        .status-badge.refunded {
            background: #f3f4f6;
            color: #374151
        }

        .order-card-body {
            padding: 16px 18px
        }

        /* Buyer Info */
        .buyer-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px dashed var(--border)
        }

        .buyer-ava {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 900;
            color: white;
            flex-shrink: 0
        }

        .buyer-info {
            flex: 1
        }

        .buyer-name {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark)
        }

        .buyer-phone {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px
        }

        .buyer-address {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
            max-width: 420px
        }

        .buyer-chat-btn {
            padding: 7px 12px;
            background: var(--green-pale);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            color: var(--green-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all .18s
        }

        .buyer-chat-btn:hover {
            background: #bbf7d0;
            border-color: var(--green-main)
        }

        /* Order Items */
        .order-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 14px
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            background: var(--bg);
            border-radius: 10px
        }

        .oi-thumb {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--green-pale), #d1fae5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            overflow: hidden;
            position: relative
        }

        .oi-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0
        }

        .oi-info {
            flex: 1
        }

        .oi-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 2px
        }

        .oi-meta {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .oi-offer-badge {
            font-size: 10px;
            background: #fef3c7;
            color: #92400e;
            padding: 1px 6px;
            border-radius: 10px;
            font-weight: 800
        }

        .oi-price {
            text-align: right;
            flex-shrink: 0
        }

        .oi-price-unit {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600
        }

        .oi-price-total {
            font-size: 14px;
            font-weight: 900;
            color: var(--green-dark)
        }

        /* Order Footer */
        .order-card-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            border-top: 1px solid var(--border);
            background: #fafcfa;
            flex-wrap: wrap;
            gap: 10px
        }

        .order-total-wrap {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .order-total-item {
            text-align: right
        }

        .order-total-label {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .order-total-val {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-mid)
        }

        .order-grand {
            font-size: 16px;
            font-weight: 900;
            color: var(--green-dark)
        }

        .order-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap
        }

        .oa-btn {
            padding: 8px 14px;
            border-radius: 9px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all .2s
        }

        .oa-btn.process {
            background: linear-gradient(135deg, var(--green-mid), var(--green-main));
            color: white;
            box-shadow: 0 3px 10px rgba(61, 186, 126, .2)
        }

        .oa-btn.process:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(61, 186, 126, .3)
        }

        .oa-btn.ship {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            color: white;
            box-shadow: 0 3px 10px rgba(109, 40, 217, .2)
        }

        .oa-btn.ship:hover {
            transform: translateY(-1px)
        }

        .oa-btn.detail {
            background: var(--blue-soft);
            color: var(--blue)
        }

        .oa-btn.detail:hover {
            background: #dbeafe
        }

        .oa-btn.reject {
            background: #fef2f2;
            color: #b91c1c
        }

        .oa-btn.reject:hover {
            background: #fecaca
        }

        .oa-btn.print {
            background: #f3f4f6;
            color: #374151
        }

        .oa-btn.print:hover {
            background: #e5e7eb
        }

        /* Payment Proof Indicator */
        .proof-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            background: #dcfce7;
            color: #166534;
            cursor: pointer;
            transition: all .18s
        }

        .proof-chip:hover {
            background: #bbf7d0
        }

        .proof-chip.none {
            background: #fee2e2;
            color: #991b1b;
            cursor: default
        }

        /* Notes */
        .buyer-notes {
            font-size: 12px;
            color: var(--text-mid);
            font-weight: 600;
            background: var(--yellow-soft);
            border-left: 3px solid var(--yellow);
            border-radius: 0 8px 8px 0;
            padding: 8px 12px;
            margin-top: 10px;
            display: flex;
            align-items: flex-start;
            gap: 6px
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--r);
            border: 1px solid var(--border)
        }

        .empty-state i {
            font-size: 52px;
            color: var(--border);
            margin-bottom: 14px;
            display: block
        }

        .empty-state h3 {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-mid);
            margin-bottom: 6px
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 22px
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
            transition: all .18s
        }

        .pagination-wrap a:hover {
            border-color: var(--green-main);
            color: var(--green-dark)
        }

        .pagination-wrap span.active-page {
            background: var(--green-main);
            color: white;
            border-color: var(--green-main)
        }

        /* Modal Overlay */
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
            transition: opacity .25s
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto
        }

        .modal {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            transform: translateY(20px);
            transition: transform .25s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18)
        }

        .modal-overlay.open .modal {
            transform: translateY(0)
        }

        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border)
        }

        .modal-head h2 {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: var(--text-muted);
            padding: 4px;
            border-radius: 6px;
            transition: color .18s
        }

        .modal-close:hover {
            color: var(--text-dark)
        }

        .modal-body {
            padding: 22px;
            max-height: 70vh;
            overflow-y: auto
        }

        .modal-foot {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            background: #fafcfa
        }

        /* Detail Modal */
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13px
        }

        .detail-row:last-child {
            border-bottom: none
        }

        .detail-row .dl {
            font-weight: 700;
            color: var(--text-muted);
            font-size: 12px
        }

        .detail-row .dr {
            font-weight: 800;
            color: var(--text-dark);
            text-align: right;
            max-width: 60%
        }

        /* Resi Input */
        .form-group {
            margin-bottom: 14px
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: var(--text-mid);
            margin-bottom: 5px
        }

        .form-label .req {
            color: var(--accent)
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
            transition: border-color .2s
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(45, 134, 83, .1)
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 3px
        }

        /* Payment proof image */
        .proof-img-wrap {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
            margin-top: 10px
        }

        .proof-img-wrap img {
            width: 100%;
            max-height: 320px;
            object-fit: contain;
            display: block;
            background: #f9fafb
        }

        /* Toast */
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
            z-index: 9999
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1
        }

        .toast.error {
            background: #b91c1c
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
            animation: fadeUp .45s ease both
        }

        .anim-2 {
            animation: fadeUp .45s .07s ease both
        }

        .anim-3 {
            animation: fadeUp .45s .14s ease both
        }

        @media(max-width:768px) {
            .seller-sidebar {
                display: none
            }

            .seller-main {
                padding: 16px
            }

            .stats-bar {
                grid-template-columns: repeat(3, 1fr)
            }

            .order-card-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px
            }

            .order-card-foot {
                flex-direction: column;
                align-items: flex-start
            }

            .buyer-row {
                flex-direction: column;
                align-items: flex-start
            }
        }
    </style>
</head>

<body>

    <div class="seller-wrap">

        <!-- ══ SIDEBAR ══ -->
        @include('partials.seller_sidebar')

        <!-- ══ MAIN ══ -->
        <main class="seller-main">

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

            <!-- Page Header -->
            <div class="page-header anim-1">
                <div class="page-header-left">
                    <h1>Pesanan Masuk <i class="fa-solid fa-box-open"
                            style="font-size:22px;color:var(--green-main)"></i></h1>
                    <p>Kelola dan proses semua pesanan dari pembeli Anda.</p>
                </div>
                <div style="display:flex;gap:10px">
                    <button class="btn-outline" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                    <a href="{{ route('seller.laporan.index') }}" class="btn-green">
                        <i class="fa-solid fa-chart-line"></i> Lihat Laporan
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar anim-2">
                <div class="stat-card" onclick="filterByStatus('')" id="stat-all">
                    <div class="stat-icon green"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="stat-label">Semua Pesanan</div>
                    <div class="stat-value">{{ $orders->total() }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('pending_payment')" id="stat-pending">
                    <div class="stat-icon yellow"><i class="fa-solid fa-clock"></i></div>
                    <div class="stat-label">Menunggu Bayar</div>
                    <div class="stat-value">{{ $counts['pending_payment'] ?? 0 }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('paid')" id="stat-paid">
                    <div class="stat-icon blue"><i class="fa-solid fa-credit-card"></i></div>
                    <div class="stat-label">Sudah Dibayar</div>
                    <div class="stat-value">{{ $counts['paid'] ?? 0 }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('processing')" id="stat-processing">
                    <div class="stat-icon purple"><i class="fa-solid fa-gear"></i></div>
                    <div class="stat-label">Diproses</div>
                    <div class="stat-value">{{ $counts['processing'] ?? 0 }}</div>
                </div>
                <div class="stat-card" onclick="filterByStatus('shipped')" id="stat-shipped">
                    <div class="stat-icon orange"><i class="fa-solid fa-truck-fast"></i></div>
                    <div class="stat-label">Dikirim</div>
                    <div class="stat-value">{{ $counts['shipped'] ?? 0 }}</div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar anim-2">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Cari no. pesanan / pembeli..."
                        oninput="filterOrders()">
                </div>
                <select class="filter-select" id="filterPayment" onchange="filterOrders()">
                    <option value="">Semua Pembayaran</option>
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="cod">COD</option>
                    <option value="e-wallet">E-Wallet</option>
                </select>
                <select class="filter-select" id="sortOrder" onchange="filterOrders()">
                    <option value="terbaru">Terbaru</option>
                    <option value="terlama">Terlama</option>
                    <option value="total_desc">Total Tertinggi</option>
                </select>
            </div>

            <!-- Status Tab Pills -->
            <div class="status-tabs anim-2">
                <button class="status-tab active" data-status="" onclick="setStatusTab(this, '')">
                    <i class="fa-solid fa-border-all"></i> Semua
                    <span class="tab-count">{{ $orders->total() }}</span>
                </button>
                <button class="status-tab" data-status="pending_payment"
                    onclick="setStatusTab(this, 'pending_payment')">
                    <i class="fa-solid fa-hourglass-half"></i> Menunggu Bayar
                    <span class="tab-count">{{ $counts['pending_payment'] ?? 0 }}</span>
                </button>
                <button class="status-tab" data-status="paid" onclick="setStatusTab(this, 'paid')">
                    <i class="fa-solid fa-circle-check"></i> Dibayar
                    <span class="tab-count">{{ $counts['paid'] ?? 0 }}</span>
                </button>
                <button class="status-tab" data-status="processing" onclick="setStatusTab(this, 'processing')">
                    <i class="fa-solid fa-gear fa-spin"></i> Diproses
                    <span class="tab-count">{{ $counts['processing'] ?? 0 }}</span>
                </button>
                <button class="status-tab" data-status="shipped" onclick="setStatusTab(this, 'shipped')">
                    <i class="fa-solid fa-truck-fast"></i> Dikirim
                    <span class="tab-count">{{ $counts['shipped'] ?? 0 }}</span>
                </button>
                <button class="status-tab" data-status="delivered" onclick="setStatusTab(this, 'delivered')">
                    <i class="fa-solid fa-box-open"></i> Selesai
                    <span class="tab-count">{{ $counts['delivered'] ?? 0 }}</span>
                </button>
                <button class="status-tab" data-status="cancelled" onclick="setStatusTab(this, 'cancelled')">
                    <i class="fa-solid fa-xmark"></i> Dibatalkan
                    <span class="tab-count">{{ $counts['cancelled'] ?? 0 }}</span>
                </button>
            </div>

            <!-- Orders List -->
            @if($orders->isEmpty())
                <div class="empty-state anim-3">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>Belum ada pesanan masuk</h3>
                    <p>Pesanan dari pembeli akan muncul di sini setelah mereka melakukan transaksi.</p>
                </div>
            @else
                <div class="orders-list anim-3" id="ordersList">
                    @foreach($orders as $order)
                        @php
                            $statusLabel = [
                                'pending_payment' => 'Menunggu Bayar',
                                'paid' => 'Sudah Dibayar',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                'refunded' => 'Direfund',
                            ][$order->status] ?? $order->status;

                            $statusIcon = [
                                'pending_payment' => 'fa-hourglass-half',
                                'paid' => 'fa-credit-card',
                                'processing' => 'fa-gear',
                                'shipped' => 'fa-truck-fast',
                                'delivered' => 'fa-box-open',
                                'cancelled' => 'fa-xmark',
                                'refunded' => 'fa-rotate-left',
                            ][$order->status] ?? 'fa-circle';

                            // Items milik seller ini saja
                            $myItems = $order->items->where('seller_user_id', auth()->id());
                            $mySubtotal = $myItems->sum('subtotal');
                        @endphp

                        <div class="order-card" data-status="{{ $order->status }}"
                            data-search="{{ strtolower($order->order_number . ' ' . $order->recipient_name) }}"
                            data-payment="{{ $order->payment_method }}">

                            <!-- Card Head -->
                            <div class="order-card-head">
                                <div class="order-head-left">
                                    <div>
                                        <div class="order-number">
                                            <i class="fa-solid fa-hashtag" style="color:var(--text-muted);font-size:11px"></i>
                                            {{ $order->order_number }}
                                        </div>
                                        <div class="order-date" style="margin-top:3px">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMM YYYY, HH:mm') }}
                                        </div>
                                    </div>

                                    @if($order->payment_method)
                                        <span
                                            style="font-size:11px;background:var(--bg);border:1px solid var(--border);padding:3px 9px;border-radius:20px;font-weight:700;color:var(--text-mid);display:flex;align-items:center;gap:4px">
                                            <i class="fa-solid fa-credit-card" style="font-size:10px"></i>
                                            {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="order-head-right">
                                    @if($order->payment_proof)
                                        <span class="proof-chip"
                                            onclick="viewProof('{{ asset('storage/' . $order->payment_proof) }}', '{{ $order->order_number }}')">
                                            <i class="fa-solid fa-image"></i> Bukti Bayar
                                        </span>
                                    @else
                                        <span class="proof-chip none"><i class="fa-solid fa-ban"></i> Belum Ada Bukti</span>
                                    @endif

                                    <span class="status-badge {{ $order->status }}">
                                        <i class="fa-solid {{ $statusIcon }}"></i>
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="order-card-body">

                                <!-- Buyer Info -->
                                <div class="buyer-row">
                                    <div class="buyer-ava">{{ strtoupper(substr($order->recipient_name, 0, 2)) }}</div>
                                    <div class="buyer-info">
                                        <div class="buyer-name">{{ $order->recipient_name }}</div>
                                        <div class="buyer-phone">
                                            <i class="fa-solid fa-phone" style="font-size:10px"></i>
                                            {{ $order->recipient_phone }}
                                        </div>
                                        <div class="buyer-address">
                                            <i class="fa-solid fa-location-dot" style="font-size:10px;flex-shrink:0"></i>
                                            {{ Str::limit($order->shipping_address . ($order->city ? ', ' . $order->city : '') . ($order->province ? ', ' . $order->province : ''), 80) }}
                                        </div>
                                    </div>
                                    @if($order->buyer)
                                        <a href="{{ route('seller.chat.index', ['buyer_id' => $order->buyer_id]) }}"
                                            class="buyer-chat-btn">
                                            <i class="fa-solid fa-comment-dots"></i> Chat Pembeli
                                        </a>
                                    @endif
                                </div>

                                <!-- Order Items -->
                                <div class="order-items">
                                    @foreach($myItems as $item)
                                        @php
                                            $emoji = match (true) {
                                                str_contains(strtolower($item->product_name), 'tomat') => '🍅',
                                                str_contains(strtolower($item->product_name), 'cabai') => '🌶️',
                                                str_contains(strtolower($item->product_name), 'bayam') => '🥬',
                                                str_contains(strtolower($item->product_name), 'wortel') => '🥕',
                                                str_contains(strtolower($item->product_name), 'mangga') => '🥭',
                                                str_contains(strtolower($item->product_name), 'jahe') => '🫚',
                                                str_contains(strtolower($item->product_name), 'kopi') => '☕',
                                                default => '🌱'
                                            };
                                            $harvest = $item->harvest;
                                            $photo = $harvest?->product?->photo;
                                        @endphp
                                        <div class="order-item">
                                            <div class="oi-thumb">
                                                @if($photo)
                                                    <img src="{{ asset('storage/' . $photo) }}" alt="{{ $item->product_name }}">
                                                @else
                                                    {{ $emoji }}
                                                @endif
                                            </div>
                                            <div class="oi-info">
                                                <div class="oi-name">{{ $item->product_name }}</div>
                                                <div class="oi-meta">
                                                    <span><i class="fa-solid fa-cubes" style="font-size:10px"></i>
                                                        {{ $item->quantity }} {{ $item->product_unit }}</span>
                                                    <span>Rp {{ number_format($item->price_per_unit, 0, ',', '.') }} /
                                                        {{ $item->product_unit }}</span>
                                                    @if($item->is_offer_price)
                                                        <span class="oi-offer-badge"><i class="fa-solid fa-tag"></i> Harga Nego</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="oi-price">
                                                <div class="oi-price-unit">Subtotal</div>
                                                <div class="oi-price-total">Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if($order->buyer_notes)
                                    <div class="buyer-notes">
                                        <i class="fa-solid fa-note-sticky"
                                            style="color:var(--yellow);flex-shrink:0;margin-top:1px"></i>
                                        <span><strong>Catatan Pembeli:</strong> {{ $order->buyer_notes }}</span>
                                    </div>
                                @endif

                            </div>

                            <!-- Card Footer -->
                            <div class="order-card-foot">
                                <div class="order-total-wrap">
                                    <div class="order-total-item">
                                        <div class="order-total-label">Ongkir</div>
                                        <div class="order-total-val">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    @if($order->discount_amount > 0)
                                        <div class="order-total-item">
                                            <div class="order-total-label">Diskon</div>
                                            <div class="order-total-val" style="color:var(--accent)">- Rp
                                                {{ number_format($order->discount_amount, 0, ',', '.') }}</div>
                                        </div>
                                    @endif
                                    <div class="order-total-item">
                                        <div class="order-total-label">Total Produk Saya</div>
                                        <div class="order-grand">Rp {{ number_format($mySubtotal, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="order-actions">
                                    <!-- Detail -->
                                    <button class="oa-btn detail" onclick="openDetail({{ $order->id }})">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <!-- Print -->
                                    <button class="oa-btn print" onclick="printOrder('{{ $order->order_number }}')">
                                        <i class="fa-solid fa-print"></i>
                                    </button>

                                    @if($order->status === 'paid')
                                        <!-- Proses -->
                                        <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}"
                                            style="display:inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <button type="submit" class="oa-btn process">
                                                <i class="fa-solid fa-gear"></i> Proses Pesanan
                                            </button>
                                        </form>
                                        <!-- Tolak -->
                                        <button class="oa-btn reject"
                                            onclick="openReject({{ $order->id }}, '{{ $order->order_number }}')">
                                            <i class="fa-solid fa-xmark"></i> Tolak
                                        </button>
                                    @elseif($order->status === 'processing')
                                        <!-- Kirim -->
                                        <button class="oa-btn ship"
                                            onclick="openShipModal({{ $order->id }}, '{{ $order->order_number }}')">
                                            <i class="fa-solid fa-truck-fast"></i> Kirim Sekarang
                                        </button>
                                    @elseif($order->status === 'pending_payment')
                                        <span
                                            style="font-size:12px;color:var(--text-muted);font-weight:600;display:flex;align-items:center;gap:5px">
                                            <i class="fa-solid fa-hourglass-half" style="color:var(--yellow)"></i>
                                            Menunggu konfirmasi pembayaran
                                        </span>
                                    @elseif($order->status === 'shipped')
                                        <span
                                            style="font-size:12px;color:#6d28d9;font-weight:700;display:flex;align-items:center;gap:5px;background:#f5f3ff;padding:6px 12px;border-radius:8px">
                                            <i class="fa-solid fa-truck-fast"></i>
                                            Sedang dalam pengiriman
                                        </span>
                                    @elseif($order->status === 'delivered')
                                        <span
                                            style="font-size:12px;color:var(--green-dark);font-weight:700;display:flex;align-items:center;gap:5px;background:var(--green-pale);padding:6px 12px;border-radius:8px">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Pesanan selesai
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="pagination-wrap">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif

        </main>
    </div>

    <!-- ══ MODAL DETAIL PESANAN ══ -->
    <div class="modal-overlay" id="detailOverlay" onclick="closeDetailOnBg(event)">
        <div class="modal" style="max-width:560px">
            <div class="modal-head">
                <h2><i class="fa-solid fa-receipt" style="color:var(--green-main)"></i> Detail Pesanan</h2>
                <button class="modal-close" onclick="closeDetail()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" id="detailBody">
                <div style="text-align:center;padding:30px;color:var(--text-muted)">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;margin-bottom:10px;display:block"></i>
                    Memuat detail...
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-outline" onclick="closeDetail()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ══ MODAL KIRIM (RESI) ══ -->
    <div class="modal-overlay" id="shipOverlay" onclick="closeShipOnBg(event)">
        <div class="modal" style="max-width:440px">
            <div class="modal-head">
                <h2><i class="fa-solid fa-truck-fast" style="color:#6d28d9"></i> Input Nomor Resi</h2>
                <button class="modal-close" onclick="closeShip()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="shipForm" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="shipped">
                <div class="modal-body">
                    <p style="font-size:13px;font-weight:600;color:var(--text-mid);margin-bottom:16px">
                        Masukkan nomor resi untuk pesanan <strong id="shipOrderNumber"></strong>.
                    </p>
                    <div class="form-group">
                        <label class="form-label">Ekspedisi <span class="req">*</span></label>
                        <select name="kurir" class="form-select" required>
                            <option value="">-- Pilih Ekspedisi --</option>
                            <option value="JNE">JNE</option>
                            <option value="J&T">J&T Express</option>
                            <option value="SiCepat">SiCepat</option>
                            <option value="Anteraja">Anteraja</option>
                            <option value="Pos Indonesia">Pos Indonesia</option>
                            <option value="Ninja Xpress">Ninja Xpress</option>
                            <option value="GoSend">GoSend</option>
                            <option value="GrabExpress">GrabExpress</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Resi <span class="req">*</span></label>
                        <input type="text" name="nomor_resi" class="form-input" placeholder="cth: JNE1234567890"
                            required>
                        <span class="form-hint">Pastikan nomor resi sudah benar sebelum menyimpan.</span>
                    </div>
                </div>
                <div class="modal-foot">
                    <button type="button" class="btn-outline" onclick="closeShip()">Batal</button>
                    <button type="submit" class="btn-green"><i class="fa-solid fa-paper-plane"></i> Kirim
                        Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ MODAL TOLAK PESANAN ══ -->
    <div class="modal-overlay" id="rejectOverlay" onclick="closeRejectOnBg(event)">
        <div class="modal" style="max-width:420px">
            <div class="modal-head">
                <h2><i class="fa-solid fa-ban" style="color:#b91c1c"></i> Tolak Pesanan</h2>
                <button class="modal-close" onclick="closeReject()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <div class="modal-body">
                    <p style="font-size:13px;font-weight:600;color:var(--text-mid);margin-bottom:14px">
                        Apakah Anda yakin ingin menolak pesanan <strong id="rejectOrderNumber"></strong>?
                    </p>
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan <span class="req">*</span></label>
                        <textarea name="cancel_reason" class="form-input" style="min-height:80px;resize:vertical"
                            placeholder="Jelaskan alasan penolakan kepada pembeli..." required></textarea>
                    </div>
                </div>
                <div class="modal-foot">
                    <button type="button" class="btn-outline" onclick="closeReject()">Batal</button>
                    <button type="submit"
                        style="padding:9px 18px;background:#b91c1c;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;color:white;cursor:pointer;display:flex;align-items:center;gap:6px">
                        <i class="fa-solid fa-xmark"></i> Tolak Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ MODAL BUKTI BAYAR ══ -->
    <div class="modal-overlay" id="proofOverlay" onclick="closeProofOnBg(event)">
        <div class="modal" style="max-width:460px">
            <div class="modal-head">
                <h2><i class="fa-solid fa-image" style="color:var(--blue)"></i> Bukti Pembayaran</h2>
                <button class="modal-close" onclick="closeProof()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" style="padding:16px">
                <p id="proofOrderLabel"
                    style="font-size:12px;color:var(--text-muted);font-weight:700;margin-bottom:8px"></p>
                <div class="proof-img-wrap">
                    <img id="proofImg" src="" alt="Bukti Pembayaran">
                </div>
                <div style="margin-top:12px;display:flex;gap:8px">
                    <a id="proofDownload" href="" download class="btn-outline" style="flex:1;justify-content:center">
                        <i class="fa-solid fa-download"></i> Unduh
                    </a>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-outline" onclick="closeProof()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i> <span id="toastMsg">Berhasil!</span></div>

    <script>
        // ── Order data for detail modal ──
        const ordersData = @json($orders->items());

        // ── Status Tabs ──
        let activeStatus = '';
        function setStatusTab(el, status) {
            document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            activeStatus = status;
            filterOrders();
        }
        function filterByStatus(status) {
            const tab = document.querySelector(`.status-tab[data-status="${status}"]`);
            if (tab) setStatusTab(tab, status);
        }

        // ── Filter Orders ──
        function filterOrders() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const pay = document.getElementById('filterPayment').value;
            document.querySelectorAll('#ordersList .order-card').forEach(card => {
                const s = card.dataset.status;
                const srch = card.dataset.search;
                const pmnt = card.dataset.payment;
                const show = (!activeStatus || s === activeStatus)
                    && (!q || srch.includes(q))
                    && (!pay || pmnt === pay);
                card.style.display = show ? '' : 'none';
            });
        }

        // ── Detail Modal ──
        function openDetail(orderId) {
            document.getElementById('detailOverlay').classList.add('open');
            const order = ordersData.find(o => o.id == orderId);
            if (!order) return;

            const statusLabel = {
                pending_payment: 'Menunggu Bayar', paid: 'Sudah Dibayar',
                processing: 'Diproses', shipped: 'Dikirim',
                delivered: 'Selesai', cancelled: 'Dibatalkan', refunded: 'Direfund'
            };

            const html = `
        <div class="detail-row"><span class="dl">No. Pesanan</span><span class="dr" style="font-family:monospace">${order.order_number}</span></div>
        <div class="detail-row"><span class="dl">Status</span><span class="dr"><span class="status-badge ${order.status}">${statusLabel[order.status] || order.status}</span></span></div>
        <div class="detail-row"><span class="dl">Tanggal Pesan</span><span class="dr">${new Date(order.created_at).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span></div>
        ${order.paid_at ? `<div class="detail-row"><span class="dl">Dibayar Pada</span><span class="dr">${new Date(order.paid_at).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span></div>` : ''}
        <div class="detail-row"><span class="dl">Penerima</span><span class="dr">${order.recipient_name}</span></div>
        <div class="detail-row"><span class="dl">No. Telepon</span><span class="dr">${order.recipient_phone}</span></div>
        <div class="detail-row"><span class="dl">Alamat Pengiriman</span><span class="dr">${order.shipping_address}${order.city ? ', ' + order.city : ''}${order.province ? ', ' + order.province : ''}${order.postal_code ? ' ' + order.postal_code : ''}</span></div>
        <div class="detail-row"><span class="dl">Metode Bayar</span><span class="dr">${order.payment_method ? order.payment_method.replace('_', ' ').toUpperCase() : '-'}</span></div>
        <div class="detail-row"><span class="dl">Subtotal Produk</span><span class="dr">Rp ${Number(order.subtotal).toLocaleString('id-ID')}</span></div>
        <div class="detail-row"><span class="dl">Ongkos Kirim</span><span class="dr">Rp ${Number(order.shipping_cost).toLocaleString('id-ID')}</span></div>
        ${order.discount_amount > 0 ? `<div class="detail-row"><span class="dl">Diskon</span><span class="dr" style="color:var(--accent)">- Rp ${Number(order.discount_amount).toLocaleString('id-ID')}</span></div>` : ''}
        <div class="detail-row" style="font-size:14px"><span class="dl" style="font-weight:800;color:var(--text-dark)">Total Pembayaran</span><span class="dr" style="font-size:16px;font-weight:900;color:var(--green-dark)">Rp ${Number(order.total_amount).toLocaleString('id-ID')}</span></div>
        ${order.buyer_notes ? `<div class="detail-row"><span class="dl">Catatan Pembeli</span><span class="dr">${order.buyer_notes}</span></div>` : ''}
        ${order.cancel_reason ? `<div class="detail-row"><span class="dl">Alasan Batal</span><span class="dr" style="color:#b91c1c">${order.cancel_reason}</span></div>` : ''}
    `;
            document.getElementById('detailBody').innerHTML = html;
        }
        function closeDetail() { document.getElementById('detailOverlay').classList.remove('open'); }
        function closeDetailOnBg(e) { if (e.target.id === 'detailOverlay') closeDetail(); }

        // ── Ship Modal ──
        function openShipModal(id, orderNum) {
            document.getElementById('shipOrderNumber').textContent = orderNum;
            document.getElementById('shipForm').action = `/seller/pesanan/${id}/status`;
            document.getElementById('shipOverlay').classList.add('open');
        }
        function closeShip() { document.getElementById('shipOverlay').classList.remove('open'); }
        function closeShipOnBg(e) { if (e.target.id === 'shipOverlay') closeShip(); }

        // ── Reject Modal ──
        function openReject(id, orderNum) {
            document.getElementById('rejectOrderNumber').textContent = orderNum;
            document.getElementById('rejectForm').action = `/seller/pesanan/${id}/status`;
            document.getElementById('rejectOverlay').classList.add('open');
        }
        function closeReject() { document.getElementById('rejectOverlay').classList.remove('open'); }
        function closeRejectOnBg(e) { if (e.target.id === 'rejectOverlay') closeReject(); }

        // ── Proof Modal ──
        function viewProof(url, orderNum) {
            document.getElementById('proofImg').src = url;
            document.getElementById('proofDownload').href = url;
            document.getElementById('proofOrderLabel').textContent = 'Bukti pembayaran untuk pesanan #' + orderNum;
            document.getElementById('proofOverlay').classList.add('open');
        }
        function closeProof() { document.getElementById('proofOverlay').classList.remove('open'); }
        function closeProofOnBg(e) { if (e.target.id === 'proofOverlay') closeProof(); }

        // ── Print ──
        function printOrder(orderNum) {
            window.open(`/seller/pesanan/${orderNum}/print`, '_blank');
        }

        // ── Toast ──
        function showToast(msg, isError = false) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.toggle('error', isError);
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ── Auto dismiss alert ──
        @if(session('success') || session('error'))
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(el => {
                    el.style.transition = 'opacity .5s';
                    el.style.opacity = '0';
                });
            }, 4000);
        @endif

        // ── Highlight new orders ──
        document.querySelectorAll('.order-card[data-status="paid"]').forEach(card => {
            card.style.borderLeft = '3px solid var(--blue)';
        });
    </script>

</body>

</html>