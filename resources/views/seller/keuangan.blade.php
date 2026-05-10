<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan – SEARA</title>
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
            --purple-soft: #f5f3ff;
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

        /* Layout */
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

        .page-header-right {
            display: flex;
            gap: 10px;
            align-items: center
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

        /* ── STATS BAR ── */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md)
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            border-radius: 0 var(--r) var(--r) 0
        }

        .stat-card.green::after {
            background: linear-gradient(180deg, var(--green-mid), var(--green-dark))
        }

        .stat-card.blue::after {
            background: linear-gradient(180deg, #60a5fa, var(--blue))
        }

        .stat-card.yellow::after {
            background: linear-gradient(180deg, #fde68a, #f59e0b)
        }

        .stat-card.purple::after {
            background: linear-gradient(180deg, #a78bfa, var(--purple))
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            margin-bottom: 12px
        }

        .stat-icon.green {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        .stat-icon.blue {
            background: var(--blue-soft);
            color: var(--blue)
        }

        .stat-icon.yellow {
            background: var(--yellow-soft);
            color: #b45309
        }

        .stat-icon.purple {
            background: var(--purple-soft);
            color: var(--purple)
        }

        .stat-label {
            font-size: 10px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 4px
        }

        .stat-value {
            font-size: 20px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1.2
        }

        .stat-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 3px
        }

        .stat-sub.up {
            color: #16a34a
        }

        .stat-sub.down {
            color: #dc2626
        }

        /* ── PERIOD FILTER ── */
        .period-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap
        }

        .period-btn {
            padding: 7px 16px;
            border-radius: 20px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--text-mid);
            cursor: pointer;
            transition: all .18s
        }

        .period-btn:hover {
            border-color: var(--green-main);
            color: var(--green-dark)
        }

        .period-btn.active {
            background: var(--green-main);
            color: white;
            border-color: var(--green-main);
            box-shadow: 0 3px 10px rgba(45, 134, 83, .25)
        }

        .period-sep {
            color: var(--border);
            font-size: 18px
        }

        .filter-select {
            padding: 7px 12px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: var(--text-mid);
            background: white;
            outline: none;
            cursor: pointer;
            transition: border-color .18s
        }

        .filter-select:focus {
            border-color: var(--green-main)
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 7px 14px;
            min-width: 200px
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

        /* ── REVENUE CHART CARD ── */
        .chart-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 20px;
            margin-bottom: 20px
        }

        .chart-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px
        }

        .chart-card-head h3 {
            font-size: 15px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .chart-legend {
            display: flex;
            gap: 14px
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted)
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        .chart-wrap {
            position: relative;
            height: 160px;
            display: flex;
            align-items: flex-end;
            gap: 6px;
            padding-bottom: 24px
        }

        .chart-bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            position: relative
        }

        .chart-bar {
            width: 100%;
            border-radius: 6px 6px 0 0;
            transition: opacity .2s;
            cursor: pointer;
            position: relative;
            min-height: 4px
        }

        .chart-bar:hover {
            opacity: .8
        }

        .chart-bar.income {
            background: linear-gradient(180deg, var(--green-mid), var(--green-main))
        }

        .chart-bar.orders {
            background: linear-gradient(180deg, #60a5fa, var(--blue));
            width: 60%;
            margin: 0 auto
        }

        .chart-label {
            position: absolute;
            bottom: -20px;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            white-space: nowrap;
            transform: translateX(-50%);
            left: 50%
        }

        .chart-tooltip {
            position: absolute;
            background: var(--text-dark);
            color: white;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            pointer-events: none;
            white-space: nowrap;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity .18s;
            z-index: 10
        }

        .chart-bar-group:hover .chart-tooltip {
            opacity: 1
        }

        .chart-y-labels {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none
        }

        .chart-y-label {
            font-size: 9px;
            font-weight: 700;
            color: var(--text-muted)
        }

        /* ── BANK CARD ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
            margin-bottom: 20px
        }

        .bank-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 20px
        }

        .bank-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px
        }

        .bank-card-head h3 {
            font-size: 15px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .bank-display {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 60%, var(--green-mid) 100%);
            border-radius: 14px;
            padding: 20px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 14px
        }

        .bank-display::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, .07);
            border-radius: 50%
        }

        .bank-display::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%
        }

        .bank-name-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 12px
        }

        .bank-account-num {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: 3px;
            margin-bottom: 6px
        }

        .bank-account-name {
            font-size: 13px;
            font-weight: 700;
            opacity: .85
        }

        .bank-balance-label {
            font-size: 10px;
            font-weight: 700;
            opacity: .6;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-top: 12px;
            margin-bottom: 4px
        }

        .bank-balance-val {
            font-size: 22px;
            font-weight: 900
        }

        .bank-actions {
            display: flex;
            gap: 8px
        }

        .bank-action-btn {
            flex: 1;
            padding: 9px;
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px
        }

        .bank-action-btn.primary {
            background: linear-gradient(135deg, var(--green-mid), var(--green-main));
            color: white;
            box-shadow: 0 4px 12px rgba(61, 186, 126, .25)
        }

        .bank-action-btn.primary:hover {
            transform: translateY(-1px)
        }

        .bank-action-btn.secondary {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        .bank-action-btn.secondary:hover {
            background: #bbf7d0
        }

        /* Income summary inside 2-col */
        .income-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 20px
        }

        .income-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px
        }

        .income-card-head h3 {
            font-size: 15px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .income-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border)
        }

        .income-row:last-child {
            border-bottom: none;
            padding-bottom: 0
        }

        .income-row-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .income-row-label i {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0
        }

        .income-dot-green {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        .income-dot-blue {
            background: var(--blue-soft);
            color: var(--blue)
        }

        .income-dot-yellow {
            background: var(--yellow-soft);
            color: #b45309
        }

        .income-dot-red {
            background: #fef2f2;
            color: #dc2626
        }

        .income-row-val {
            font-size: 14px;
            font-weight: 900;
            color: var(--text-dark)
        }

        .income-total-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--green-pale);
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 12px
        }

        .income-total-label {
            font-size: 13px;
            font-weight: 800;
            color: var(--green-dark)
        }

        .income-total-val {
            font-size: 16px;
            font-weight: 900;
            color: var(--green-dark)
        }

        /* ── TRANSACTION TABLE ── */
        .table-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden
        }

        .table-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border)
        }

        .table-card-head h3 {
            font-size: 15px;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        thead tr {
            background: var(--green-pale)
        }

        thead th {
            padding: 11px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 900;
            color: var(--green-dark);
            text-transform: uppercase;
            letter-spacing: .7px;
            white-space: nowrap
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .14s
        }

        tbody tr:last-child {
            border-bottom: none
        }

        tbody tr:hover {
            background: #fafcfa
        }

        tbody td {
            padding: 13px 16px;
            font-size: 13px;
            color: var(--text-dark);
            font-weight: 600;
            vertical-align: middle
        }

        .order-num {
            font-weight: 900;
            color: var(--green-dark);
            font-size: 12px;
            letter-spacing: .5px
        }

        .buyer-info {
            display: flex;
            flex-direction: column;
            gap: 1px
        }

        .buyer-name {
            font-weight: 800;
            font-size: 13px;
            color: var(--text-dark)
        }

        .buyer-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted)
        }

        .product-list {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
            max-width: 180px
        }

        .product-list span {
            display: block;
            line-height: 1.5
        }

        .amount-cell {
            font-size: 14px;
            font-weight: 900;
            color: var(--text-dark)
        }

        .amount-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted)
        }

        .date-cell {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid)
        }

        /* Status badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap
        }

        .badge-delivered {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0
        }

        .badge-processing {
            background: var(--blue-soft);
            color: var(--blue);
            border: 1px solid #bfdbfe
        }

        .badge-shipped {
            background: var(--purple-soft);
            color: var(--purple);
            border: 1px solid #ddd6fe
        }

        .badge-paid {
            background: var(--yellow-soft);
            color: #b45309;
            border: 1px solid #fde68a
        }

        .badge-pending {
            background: #fef9c3;
            color: #92400e;
            border: 1px solid #fde68a
        }

        .badge-cancelled {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca
        }

        .badge-refunded {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb
        }

        /* Payment method badge */
        .pay-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            background: var(--green-pale);
            color: var(--green-dark)
        }

        /* Action buttons in table */
        .tbl-btn {
            padding: 5px 12px;
            border-radius: 7px;
            font-family: 'Nunito', sans-serif;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: all .18s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none
        }

        .tbl-btn.view {
            background: var(--green-pale);
            color: var(--green-dark)
        }

        .tbl-btn.view:hover {
            background: #bbf7d0
        }

        .tbl-btn.invoice {
            background: var(--blue-soft);
            color: var(--blue)
        }

        .tbl-btn.invoice:hover {
            background: #bfdbfe
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px
        }

        .empty-state i {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 14px;
            display: block
        }

        .empty-state h3 {
            font-size: 16px;
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
            padding: 16px 20px;
            border-top: 1px solid var(--border)
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

        /* ── MODAL TARIK DANA ── */
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
            max-width: 480px;
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
            padding: 22px
        }

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
        .form-select {
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
        .form-select:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(45, 134, 83, .1)
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 3px
        }

        .modal-foot {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            background: #fafcfa
        }

        .withdrawal-info {
            background: var(--green-pale);
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 14px
        }

        .withdrawal-info-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px
        }

        .withdrawal-info-row:last-child {
            margin-bottom: 0;
            font-weight: 900;
            font-size: 14px;
            color: var(--green-dark)
        }

        .withdrawal-info-label {
            font-weight: 700;
            color: var(--text-mid)
        }

        .withdrawal-info-val {
            font-weight: 800;
            color: var(--text-dark)
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

        .anim-4 {
            animation: fadeUp .45s .21s ease both
        }

        @media(max-width:1024px) {
            .two-col {
                grid-template-columns: 1fr
            }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr)
            }
        }

        @media(max-width:768px) {
            .seller-main {
                padding: 16px
            }

            .stats-bar {
                grid-template-columns: 1fr 1fr
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
                    <h1>Keuangan <i class="fa-solid fa-coins" style="font-size:22px;color:var(--yellow)"></i></h1>
                    <p>Pantau pendapatan, transaksi, dan kelola penarikan dana toko Anda.</p>
                </div>
                <div class="page-header-right">
                    <a href="{{ route('seller.keuangan.export') }}?{{ http_build_query(request()->query()) }}"
                        class="btn-outline">
                        <i class="fa-solid fa-file-excel"></i> Export CSV
                    </a>
                    <button class="btn-green" onclick="openWithdrawalModal()">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Tarik Dana
                    </button>
                </div>
            </div>

            <!-- ── STATS BAR ── -->
            <div class="stats-bar anim-2">
                <!-- Total Pendapatan -->
                <div class="stat-card green">
                    <div class="stat-icon green"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-sub up">
                        <i class="fa-solid fa-arrow-up"></i>
                        {{ $sellerProfile->total_transaksi ?? 0 }} transaksi selesai
                    </div>
                </div>

                <!-- Bulan Ini -->
                <div class="stat-card blue">
                    <div class="stat-icon blue"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-label">Pendapatan Bulan Ini</div>
                    <div class="stat-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                    <div class="stat-sub">{{ $pesananBulanIni }} pesanan selesai</div>
                </div>

                <!-- Dana Dapat Dicairkan -->
                <div class="stat-card yellow">
                    <div class="stat-icon yellow"><i class="fa-solid fa-wallet"></i></div>
                    <div class="stat-label">Dapat Dicairkan</div>
                    <div class="stat-value">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</div>
                    <div class="stat-sub">{{ $pesananMenungguCair }} pesanan diproses</div>
                </div>

                <!-- Rata-rata Order -->
                <div class="stat-card purple">
                    <div class="stat-icon purple"><i class="fa-solid fa-chart-line"></i></div>
                    <div class="stat-label">Rata-rata per Order</div>
                    <div class="stat-value">Rp {{ number_format($rataRataOrder, 0, ',', '.') }}</div>
                    <div class="stat-sub">{{ $totalPesananSelesai }} order selesai</div>
                </div>
            </div>

            <!-- ── REVENUE CHART ── -->
            <div class="chart-card anim-3">
                <div class="chart-card-head">
                    <h3>
                        <i class="fa-solid fa-chart-area" style="color:var(--green-main)"></i>
                        Grafik Pendapatan 7 Hari Terakhir
                    </h3>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--green-main)"></div>
                            Pendapatan
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--blue)"></div>
                            Pesanan
                        </div>
                    </div>
                </div>

                @php
                    // $chartData = array of ['label'=>'Senin', 'income'=>150000, 'orders'=>3]
                    $maxIncome = collect($chartData)->max('income') ?: 1;
                @endphp

                <div class="chart-wrap" id="chartWrap">
                    @foreach($chartData as $day)
                        @php $heightPct = max(4, round(($day['income'] / $maxIncome) * 100)); @endphp
                        <div class="chart-bar-group">
                            <div class="chart-tooltip">
                                Rp {{ number_format($day['income'], 0, ',', '.') }}<br>{{ $day['orders'] }} pesanan
                            </div>
                            <div class="chart-bar income" style="height:{{ $heightPct }}%"></div>
                            <span class="chart-label">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ── 2-COLUMN: INCOME SUMMARY + BANK CARD ── -->
            <div class="two-col anim-3">

                <!-- Income Summary -->
                <div class="income-card">
                    <div class="income-card-head">
                        <h3>
                            <i class="fa-solid fa-receipt" style="color:var(--green-main)"></i>
                            Ringkasan Pendapatan
                        </h3>
                        <select class="filter-select" id="summaryPeriod" onchange="changeSummaryPeriod(this.value)"
                            style="font-size:12px;padding:5px 10px">
                            <option value="bulan_ini" {{ request('period', 'bulan_ini') === 'bulan_ini' ? 'selected' : '' }}>
                                Bulan Ini</option>
                            <option value="bulan_lalu" {{ request('period') === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu
                            </option>
                            <option value="tahun_ini" {{ request('period') === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini
                            </option>
                            <option value="semua" {{ request('period') === 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                        </select>
                    </div>

                    <div class="income-row">
                        <div class="income-row-label">
                            <i class="fa-solid fa-check income-dot-green"
                                style="background:var(--green-pale);color:var(--green-dark)"></i>
                            Pesanan Selesai (Delivered)
                        </div>
                        <div class="income-row-val">Rp {{ number_format($summaryDelivered, 0, ',', '.') }}</div>
                    </div>
                    <div class="income-row">
                        <div class="income-row-label">
                            <i class="fa-solid fa-truck income-dot-blue"
                                style="background:var(--blue-soft);color:var(--blue)"></i>
                            Dalam Pengiriman (Shipped)
                        </div>
                        <div class="income-row-val">Rp {{ number_format($summaryShipped, 0, ',', '.') }}</div>
                    </div>
                    <div class="income-row">
                        <div class="income-row-label">
                            <i class="fa-solid fa-clock income-dot-yellow"
                                style="background:var(--yellow-soft);color:#b45309"></i>
                            Diproses (Processing)
                        </div>
                        <div class="income-row-val">Rp {{ number_format($summaryProcessing, 0, ',', '.') }}</div>
                    </div>
                    <div class="income-row">
                        <div class="income-row-label">
                            <i class="fa-solid fa-ban"
                                style="background:#fef2f2;color:#dc2626;width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0"></i>
                            Dibatalkan / Refund
                        </div>
                        <div class="income-row-val" style="color:#dc2626">- Rp
                            {{ number_format($summaryCancelled, 0, ',', '.') }}</div>
                    </div>

                    <div class="income-total-row">
                        <div class="income-total-label"><i class="fa-solid fa-coins"></i> Total Bersih Periode Ini</div>
                        <div class="income-total-val">Rp
                            {{ number_format($summaryDelivered - $summaryCancelled, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Bank Card -->
                <div class="bank-card">
                    <div class="bank-card-head">
                        <h3>
                            <i class="fa-solid fa-building-columns" style="color:var(--green-main)"></i>
                            Rekening Toko
                        </h3>
                        <a href="{{ route('seller.profile.edit') }}" class="tbl-btn view" style="font-size:11px">
                            <i class="fa-solid fa-pen"></i> Ubah
                        </a>
                    </div>

                    <div class="bank-display">
                        <div class="bank-name-badge">
                            <i class="fa-solid fa-building-columns"></i>
                            {{ $sellerProfile->nama_bank ?? 'Nama Bank' }}
                        </div>
                        <div class="bank-account-num">
                            {{ chunk_split($sellerProfile->no_rekening ?? '0000000000', 4, ' ') }}
                        </div>
                        <div class="bank-account-name">
                            {{ $sellerProfile->atas_nama_rekening ?? 'Nama Pemilik' }}
                        </div>
                        <div class="bank-balance-label">Saldo Dapat Dicairkan</div>
                        <div class="bank-balance-val">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</div>
                    </div>

                    <div class="bank-actions">
                        <button class="bank-action-btn primary" onclick="openWithdrawalModal()">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Tarik Dana
                        </button>
                        <a href="{{ route('seller.keuangan.riwayat') }}" class="bank-action-btn secondary">
                            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
                        </a>
                    </div>
                </div>
            </div>

            <!-- ── JADWAL PANEN MENDATANG (Integrasi) ── -->
            @if($jadwalMendatang->count() > 0)
            <div class="table-card anim-4" style="margin-bottom:20px">
                <div class="table-card-head">
                    <h3>
                        <i class="fa-solid fa-seedling" style="color:var(--green-main)"></i>
                        Estimasi Panen Mendatang
                        <span style="background:var(--green-pale);color:var(--green-dark);font-size:11px;padding:2px 9px;border-radius:20px;font-weight:800">
                            {{ $jadwalMendatang->count() }} jadwal
                        </span>
                    </h3>
                    <a href="{{ route('seller.jadwal.index') }}" style="font-size:13px;color:var(--green-main);font-weight:700;text-decoration:none">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div style="padding:0 20px 16px;display:flex;flex-wrap:wrap;gap:12px">
                    @foreach($jadwalMendatang as $jadwal)
                    @php $info = $jadwal->status_info; $sisaHari = $jadwal->sisa_hari; @endphp
                    <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:10px;padding:14px 16px;min-width:200px;flex:1">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                            <span style="font-size:18px">{{ $info['icon'] }}</span>
                            <span style="font-weight:800;font-size:14px;color:var(--text-dark)">{{ $jadwal->nama_tanaman }}</span>
                        </div>
                        <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px">
                            <i class="fa-regular fa-calendar"></i>
                            Panen: {{ $jadwal->estimasi_panen->format('d M Y') }}
                        </div>
                        @if($jadwal->estimasi_kuantitas)
                        <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px">
                            <i class="fa-solid fa-scale-balanced"></i>
                            Est. {{ number_format($jadwal->estimasi_kuantitas, 0, ',', '.') }} {{ $jadwal->satuan ?? 'kg' }}
                        </div>
                        @endif
                        <span style="background:{{ $info['bg'] }};color:{{ $info['color'] }};font-size:11px;padding:2px 8px;border-radius:20px;font-weight:700">
                            {{ $sisaHari <= 0 ? 'Sudah lewat' : ($sisaHari === 1 ? 'Besok' : $sisaHari . ' hari lagi') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ── RIWAYAT PENARIKAN TERBARU (Integrasi) ── -->
            @if($riwayatWithdrawal->count() > 0)
            <div class="table-card anim-4" style="margin-bottom:20px">
                <div class="table-card-head">
                    <h3>
                        <i class="fa-solid fa-money-bill-transfer" style="color:var(--green-main)"></i>
                        Penarikan Dana Terbaru
                    </h3>
                    <a href="{{ route('seller.keuangan.riwayat') }}" style="font-size:13px;color:var(--green-main);font-weight:700;text-decoration:none">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <div style="overflow-x:auto">
                <table style="width:100%;border-collapse:collapse;font-size:13px">
                    <thead>
                        <tr style="border-bottom:1.5px solid var(--border)">
                            <th style="padding:10px 16px;text-align:left;color:var(--text-muted);font-weight:700">Tanggal</th>
                            <th style="padding:10px 16px;text-align:left;color:var(--text-muted);font-weight:700">Jumlah</th>
                            <th style="padding:10px 16px;text-align:left;color:var(--text-muted);font-weight:700">Diterima</th>
                            <th style="padding:10px 16px;text-align:left;color:var(--text-muted);font-weight:700">Bank</th>
                            <th style="padding:10px 16px;text-align:left;color:var(--text-muted);font-weight:700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatWithdrawal as $wd)
                        <tr style="border-bottom:1px solid var(--border)">
                            <td style="padding:10px 16px;color:var(--text-mid)">{{ $wd->created_at->format('d/m/Y') }}</td>
                            <td style="padding:10px 16px;font-weight:700;color:var(--text-dark)">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</td>
                            <td style="padding:10px 16px;color:var(--green-main);font-weight:700">Rp {{ number_format($wd->diterima, 0, ',', '.') }}</td>
                            <td style="padding:10px 16px;color:var(--text-mid)">{{ $wd->nama_bank ?? '-' }}</td>
                            <td style="padding:10px 16px">
                                <span style="background:{{ $wd->status_color }}22;color:{{ $wd->status_color }};font-size:11px;padding:3px 10px;border-radius:20px;font-weight:700">
                                    {{ $wd->status_label }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            @endif

            <!-- ── TRANSACTION TABLE ── -->
            <div class="table-card anim-4">
                <div class="table-card-head">
                    <h3>
                        <i class="fa-solid fa-list-check" style="color:var(--green-main)"></i>
                        Riwayat Transaksi
                        <span
                            style="background:var(--green-pale);color:var(--green-dark);font-size:11px;padding:2px 9px;border-radius:20px;font-weight:800">
                            {{ $orders->total() }}
                        </span>
                    </h3>
                    <div style="display:flex;gap:8px;align-items:center">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="tableSearch" placeholder="Cari no. order / pembeli..."
                                oninput="filterTable()">
                        </div>
                        <select class="filter-select" id="statusFilter" onchange="applyFilters()">
                            <option value="">Semua Status</option>
                            <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>
                                Menunggu Bayar</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refund</option>
                        </select>
                        <select class="filter-select" id="periodFilter" onchange="applyFilters()">
                            <option value="">Semua Waktu</option>
                            <option value="hari_ini" {{ request('period') === 'hari_ini' ? 'selected' : '' }}>Hari Ini
                            </option>
                            <option value="7_hari" {{ request('period') === '7_hari' ? 'selected' : '' }}>7 Hari Terakhir
                            </option>
                            <option value="bulan_ini" {{ request('period') === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini
                            </option>
                            <option value="bulan_lalu" {{ request('period') === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu
                            </option>
                        </select>
                    </div>
                </div>

                @if($orders->isEmpty())
                    <div class="empty-state">
                        <i class="fa-solid fa-receipt"></i>
                        <h3>Belum ada transaksi</h3>
                        <p>Transaksi dari pembeli akan muncul di sini setelah ada pesanan masuk.</p>
                    </div>
                @else
                    <div style="overflow-x:auto">
                        <table id="transactionTable">
                            <thead>
                                <tr>
                                    <th>No. Order</th>
                                    <th>Pembeli</th>
                                    <th>Produk</th>
                                    <th>Metode Bayar</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $statusLabel = [
                                            'pending_payment' => ['label' => 'Menunggu Bayar', 'class' => 'badge-pending', 'icon' => 'fa-clock'],
                                            'paid' => ['label' => 'Sudah Dibayar', 'class' => 'badge-paid', 'icon' => 'fa-circle-check'],
                                            'processing' => ['label' => 'Diproses', 'class' => 'badge-processing', 'icon' => 'fa-gear'],
                                            'shipped' => ['label' => 'Dikirim', 'class' => 'badge-shipped', 'icon' => 'fa-truck'],
                                            'delivered' => ['label' => 'Selesai', 'class' => 'badge-delivered', 'icon' => 'fa-box-open'],
                                            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'badge-cancelled', 'icon' => 'fa-ban'],
                                            'refunded' => ['label' => 'Refund', 'class' => 'badge-refunded', 'icon' => 'fa-rotate-left'],
                                        ][$order->status] ?? ['label' => $order->status, 'class' => 'badge-pending', 'icon' => 'fa-question'];
                                    @endphp
                                    <tr data-order="{{ strtolower($order->order_number) }}"
                                        data-buyer="{{ strtolower($order->buyer->nama_lengkap ?? '') }}">
                                        <td>
                                            <div class="order-num">{{ $order->order_number }}</div>
                                            <div style="font-size:10px;color:var(--text-muted);font-weight:600;margin-top:2px">
                                                {{ $order->items->count() }} item
                                            </div>
                                        </td>
                                        <td>
                                            <div class="buyer-info">
                                                <div class="buyer-name">{{ $order->buyer->nama_lengkap ?? 'Pembeli' }}</div>
                                                <div class="buyer-sub">{{ $order->city ?? '-' }}, {{ $order->province ?? '-' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-list">
                                                @foreach($order->items->where('seller_user_id', Auth::id())->take(2) as $item)
                                                    <span>{{ $item->product_name }} ×{{ $item->quantity }}</span>
                                                @endforeach
                                                @if($order->items->where('seller_user_id', Auth::id())->count() > 2)
                                                    <span
                                                        style="color:var(--text-muted)">+{{ $order->items->where('seller_user_id', Auth::id())->count() - 2 }}
                                                        lainnya</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->payment_method)
                                                <span class="pay-badge">
                                                    <i class="fa-solid fa-credit-card"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                </span>
                                            @else
                                                <span style="color:var(--text-muted);font-size:12px">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="amount-cell">Rp
                                                {{ number_format($order->items->where('seller_user_id', Auth::id())->sum('subtotal'), 0, ',', '.') }}
                                            </div>
                                            @if($order->shipping_cost > 0)
                                                <div class="amount-sub">+ Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                                    ongkir</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $statusLabel['class'] }}">
                                                <i class="fa-solid {{ $statusLabel['icon'] }}"></i>
                                                {{ $statusLabel['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="date-cell">
                                                {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMM YYYY') }}</div>
                                            <div style="font-size:10px;color:var(--text-muted);font-weight:600">
                                                {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('HH:mm') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display:flex;gap:5px;flex-wrap:wrap">
                                                <a href="{{ route('seller.orders.show', $order->id) }}" class="tbl-btn view">
                                                    <i class="fa-solid fa-eye"></i> Detail
                                                </a>
                                                @if(in_array($order->status, ['delivered', 'shipped', 'processing']))
                                                    <a href="{{ route('seller.keuangan.invoice', $order->id) }}"
                                                        class="tbl-btn invoice" target="_blank">
                                                        <i class="fa-solid fa-file-invoice"></i> Invoice
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                        <div class="pagination-wrap">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </main>
    </div>

    <!-- ══ MODAL TARIK DANA ══ -->
    <div class="modal-overlay" id="withdrawalOverlay" onclick="closeWithdrawalOnBg(event)">
        <div class="modal">
            <div class="modal-head">
                <h2>
                    <i class="fa-solid fa-arrow-right-from-bracket" style="color:var(--green-main)"></i>
                    Tarik Dana
                </h2>
                <button class="modal-close" onclick="closeWithdrawalModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form method="POST" action="{{ route('seller.keuangan.withdraw') }}">
                @csrf
                <div class="modal-body">

                    <div class="withdrawal-info">
                        <div class="withdrawal-info-row">
                            <span class="withdrawal-info-label">Bank Tujuan</span>
                            <span class="withdrawal-info-val">{{ $sellerProfile->nama_bank ?? '-' }}</span>
                        </div>
                        <div class="withdrawal-info-row">
                            <span class="withdrawal-info-label">No. Rekening</span>
                            <span class="withdrawal-info-val">{{ $sellerProfile->no_rekening ?? '-' }}</span>
                        </div>
                        <div class="withdrawal-info-row">
                            <span class="withdrawal-info-label">Atas Nama</span>
                            <span class="withdrawal-info-val">{{ $sellerProfile->atas_nama_rekening ?? '-' }}</span>
                        </div>
                        <div class="withdrawal-info-row">
                            <span class="withdrawal-info-label">Saldo Tersedia</span>
                            <span class="withdrawal-info-val" style="color:var(--green-dark)">
                                Rp {{ number_format($saldoTersedia, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Penarikan (Rp) <span class="req">*</span></label>
                        <input type="number" name="jumlah" id="withdrawAmount" class="form-input"
                            placeholder="cth: 500000" min="50000" max="{{ $saldoTersedia }}" step="1000" required
                            oninput="updateWithdrawPreview()">
                        <div class="form-hint">Minimum penarikan: Rp 50.000 &bull; Biaya admin: Rp 2.500</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" name="catatan" class="form-input" placeholder="Catatan penarikan...">
                    </div>

                    <div id="withdrawPreview"
                        style="display:none;background:var(--green-pale);border-radius:10px;padding:12px 14px;">
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
                            <span style="font-weight:700;color:var(--text-mid)">Jumlah ditarik</span>
                            <span style="font-weight:800" id="prevAmount">—</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
                            <span style="font-weight:700;color:var(--text-mid)">Biaya admin</span>
                            <span style="font-weight:800;color:var(--accent)">- Rp 2.500</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;font-size:14px;font-weight:900;color:var(--green-dark);border-top:1px solid #bbf7d0;padding-top:8px;margin-top:4px">
                            <span>Diterima</span>
                            <span id="prevReceived">—</span>
                        </div>
                    </div>

                </div>
                <div class="modal-foot">
                    <button type="button" class="btn-outline" onclick="closeWithdrawalModal()">Batal</button>
                    <button type="submit" class="btn-green">
                        <i class="fa-solid fa-paper-plane"></i> Ajukan Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i> <span id="toastMsg">Berhasil!</span></div>

    <script>
        // ── Withdrawal modal ──
        function openWithdrawalModal() {
            document.getElementById('withdrawalOverlay').classList.add('open');
        }
        function closeWithdrawalModal() {
            document.getElementById('withdrawalOverlay').classList.remove('open');
        }
        function closeWithdrawalOnBg(e) {
            if (e.target.id === 'withdrawalOverlay') closeWithdrawalModal();
        }

        // ── Withdraw preview ──
        function updateWithdrawPreview() {
            const val = parseFloat(document.getElementById('withdrawAmount').value) || 0;
            const preview = document.getElementById('withdrawPreview');
            if (val >= 50000) {
                preview.style.display = 'block';
                document.getElementById('prevAmount').textContent = 'Rp ' + val.toLocaleString('id-ID');
                document.getElementById('prevReceived').textContent = 'Rp ' + (val - 2500).toLocaleString('id-ID');
            } else {
                preview.style.display = 'none';
            }
        }

        // ── Filter table client-side by search ──
        function filterTable() {
            const q = document.getElementById('tableSearch').value.toLowerCase();
            document.querySelectorAll('#transactionTable tbody tr').forEach(row => {
                const order = row.dataset.order || '';
                const buyer = row.dataset.buyer || '';
                row.style.display = (!q || order.includes(q) || buyer.includes(q)) ? '' : 'none';
            });
        }

        // ── Apply server-side filters (reload with params) ──
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const period = document.getElementById('periodFilter').value;
            const url = new URL(window.location.href);
            if (status) url.searchParams.set('status', status);
            else url.searchParams.delete('status');
            if (period) url.searchParams.set('period', period);
            else url.searchParams.delete('period');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        // ── Summary period change ──
        function changeSummaryPeriod(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('period', val);
            url.searchParams.delete('page');
            window.location.href = url.toString();
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

        // ── Toast helper ──
        function showToast(msg, isError = false) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.className = 'toast' + (isError ? ' error' : '');
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3500);
        }

        // ── Animate bars on load ──
        document.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.chart-bar');
            bars.forEach((bar, i) => {
                const target = bar.style.height;
                bar.style.height = '0%';
                setTimeout(() => {
                    bar.style.transition = 'height .6s ease';
                    bar.style.height = target;
                }, 100 + i * 60);
            });
        });
    </script>

</body>

</html>