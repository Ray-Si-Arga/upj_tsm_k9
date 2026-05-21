
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =========================================
                                                               TOKENS
                                                            ========================================= */
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --navy: #0f172a;
            --navy-mid: #1e293b;
            --emerald: #064e3b;
            --emerald-mid: #047857;
            --amber: #78350f;
            --amber-mid: #b45309;
            --red-soft: rgba(177, 0, 0, .09);
            --red-border: rgba(177, 0, 0, .18);
            --navy: #0b1120;
            --navy-mid: #14213d;
            --navy-soft: #1d2e4a;

            --bg: #f1f5fb;
            --surface: #ffffff;
            --border: #e4eaf3;
            --ink: #0f172a;
            --muted: #64748b;
            --subtle: #94a3b8;

            --blue-soft: rgba(29, 78, 216, .07);
            --blue: #1d4ed8;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        .page-wrap {
            padding: 2rem 2rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ============================
                    PAGE HEADER 
            ===============================*/
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 34px;
            color: white;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 70%);
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 25%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
        }

        .header-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(177, 0, 0, .35);
            border: 1px solid rgba(177, 0, 0, .5);
            color: #fca5a5;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 1.65rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.5px;
            margin: 0 0 4px;
            position: relative;
            z-index: 1;
        }

        .header-sub {
            font-size: .82rem;
            color: rgba(255, 255, 255, .5);
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        .header-actions {
            position: relative;
            z-index: 1;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--honda-red);
            color: #fff;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: .83rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s, transform .18s, box-shadow .18s;
            box-shadow: 0 4px 14px rgba(177, 0, 0, .3);
            position: relative;
            z-index: 1;
        }

        .btn-add:hover {
            background: var(--honda-red-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(177, 0, 0, .4);
            color: #fff;
        }

        /* ==============================
                        SUMMARY CARDS
                ============================== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .summary-card {
            border-radius: 16px;
            padding: 20px 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, .14);
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .card-total {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            box-shadow: 0 6px 24px rgba(15, 23, 42, .28);
        }

        .card-pending {
            background: linear-gradient(135deg, #78350f 0%, var(--amber-mid) 100%);
            box-shadow: 0 6px 24px rgba(120, 53, 15, .28);
        }

        .card-progress {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            box-shadow: 0 6px 24px rgba(30, 58, 138, .28);
        }

        .card-done {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-mid) 100%);
            box-shadow: 0 6px 24px rgba(6, 78, 59, .28);
        }

        .card-upcoming {
            background: linear-gradient(135deg, #4c0519 0%, var(--honda-red) 100%);
            box-shadow: 0 6px 24px rgba(177, 0, 0, .28);
        }

        .card-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .card-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .58);
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .card-amount {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
            position: relative;
            z-index: 1;
        }

        .card-meta {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, .5);
            margin-top: 6px;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        /* ==============================
                                       SEARCH + FILTER BAR
                                    ============================== */
        .toolbar {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 16px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .04);
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 360px;
        }

        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .search-wrap input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.88rem;
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-wrap input:focus {
            border-color: var(--honda-red);
            box-shadow: 0 0 0 3px rgba(177, 0, 0, .1);
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--border);
            background: #fff;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }

        .filter-tab:hover,
        .filter-tab.active {
            background: var(--honda-red);
            color: #fff;
            border-color: var(--honda-red);
        }

        .filter-tab.active-warn {
            background: #fef3c7;
            color: #92400e;
            border-color: #fcd34d;
        }

        /* ==============================
                                       TABLE CARD
                                    ============================== */
        .table-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
        }

        .table-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-count {
            font-size: 0.72rem;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Scrollable table */
        .table-scroll {
            overflow-x: auto;
        }

        /* Table itself */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inv-table thead th {
            padding: 12px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .inv-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s;
        }

        .inv-table tbody tr:last-child {
            border-bottom: none;
        }

        .inv-table tbody tr:hover {
            background: #fafafa;
        }

        .inv-table tbody td {
            padding: 15px 20px;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        /* Row number */
        .row-num {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
        }

        /* Item name */
        .item-name {
            font-weight: 700;
            color: var(--text);
        }

        /* Stock badge */
        .stok-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .stok-ok {
            background: #d1fae5;
            color: #065f46;
        }

        .stok-tipis {
            background: #ffe4e6;
            color: #9f1239;
        }

        .stok-warn {
            background: #fef3c7;
            color: #92400e;
        }

        /* Price */
        .price-cell {
            white-space: nowrap;
        }

        .price-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }

        .price-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #94a3b8;
            min-width: 28px;
        }

        .price-val {
            font-family: 'Consolas', monospace;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .price-beli {
            background: #fef2f2;
            color: #b91c1c;
        }

        .price-jual {
            background: #f0fdf4;
            color: #15803d;
        }

        /* Laba cell */
        .laba-per {
            font-family: 'Consolas', monospace;
            font-weight: 700;
            color: #1d4ed8;
            font-size: 0.85rem;
        }

        .laba-total {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Action buttons */
        .btn-act {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all .18s;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .btn-act:hover {
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .btn-edit:hover {
            background: #2563eb;
            color: #fff;
        }

        .btn-hapus {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .btn-hapus:hover {
            background: #dc2626;
            color: #fff;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e2e8f0;
            margin-bottom: 14px;
            display: block;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* ==============================
                                       MOBILE CARDS
                                    ============================== */
        .mobile-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 18px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        }

        .mobile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        /* =========================================
                                                               ANIMATIONS
                                                            ========================================= */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .au {
            animation: fadeUp .4s ease both;
        }

        .d1 {
            animation-delay: .05s;
        }

        .d2 {
            animation-delay: .10s;
        }

        .d3 {
            animation-delay: .15s;
        }

        .d4 {
            animation-delay: .20s;
        }

        /* =========================================
                        RESPONSIVE
        ========================================= */
        @media (max-width: 768px) {
            .page-wrap {
                padding: 1.25rem 1rem 3rem;
            }

            .banner-pills {
                display: none;
            }

            .banner-title {
                font-size: 1.3rem;
            }

            .col-alamat {
                display: none;
            }
        }
    </style>

    <main class="page-wrap">

        
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <div class="header-eyebrow">
                    Administrator
                </div>
                <h1 class="header-title">Akun</h1>
                <p class="header-sub">Kelola Akun Pengguna Dan Akun Administrator yang Terdaftar Sistem</p>
            </div>
            <div class="header-actions">
                <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </button>
            </div>
        </div>

        
        <div class="cards-grid">
            <div class="summary-card card-total au d1">
                <div class="card-icon-wrap"><i class="fas fa-users"></i></div>
                <div class="card-label">Total Customer</div>
                <div class="card-amount"><?php echo e($totalCustomers); ?></div>
            </div>
            <div class="summary-card card-progress au d2">
                <div class="card-icon-wrap"><i class="fas fa-user-plus"></i></div>
                <div class="card-label">Customer Baru</div>
                <div class="card-amount"><?php echo e($newCustomers); ?></div>
            </div>
            <div class="summary-card card-upcoming au d3">
                <div class="card-icon-wrap"><i class="fas fa-user-shield"></i></div>
                <div class="card-label">Total Admin</div>
                <div class="card-amount"><?php echo e($totalAdmins); ?></div>
            </div>
            <div class="summary-card card-pending au d4">
                <div class="card-icon-wrap"><i class="fas fa-shield-alt"></i></div>
                <div class="card-label">Admin Baru</div>
                <div class="card-amount"><?php echo e($newAdmins); ?></div>
            </div>
        </div>

        
        <div class="toolbar au d2">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('search-bar', ['placeholder' => 'Cari nama, email, atau no telepon...']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1022909177-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
        </div>

        
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('customer-table');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1022909177-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>

    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\customers\index.blade.php ENDPATH**/ ?>