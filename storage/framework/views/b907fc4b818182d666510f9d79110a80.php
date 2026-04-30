
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <style>
        /* ---- Google Font ---- */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap');

        :root {
            --primary-dark: #1e293b;
            --primary-blue: #3b82f6;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --bg-body: #f8fafc;
            --card-border: #e2e8f0;

            --navy: #0f172a;

        }

        .hero-section {
            background: linear-gradient(135deg, var(--navy) 0%, #16213e 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 28px 34px;
            color: white;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(177, 0, 0, .25) 0%, transparent 70%);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            pointer-events: none;
            bottom: -50px;
            left: 25%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
        }

        .keuangan-wrap {
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 28px 24px;
            background: #f8fafc;
            min-height: 100vh;
        }

        /* ---- PAGE HEADER ---- */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
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

        .page-subtitle {
            font-size: 1.2rem;
            color: #ffffff;
            margin-top: 4px;
            font-weight: 900;
            letter-spacing: 1.1px;
        }

        .header-sub {
            font-size: .85rem;
            color: rgba(255, 255, 255, .5);
            margin: 0;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }

        /* ---- FILTER TABS ---- */
        .filter-tabs {
            position: relative;
            z-index: 10;
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 4px;
            gap: 2px;
            width: fit-content;
        }

        .filter-tab {
            padding: 7px 18px;
            border-radius: 9px;
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
            margin: 0 auto;
        }

        .filter-tab:hover {
            background: #f1f5f9;
            color: #334155;
            text-decoration: none;
        }

        .filter-tab.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25);
        }

        /* ---- SUMMARY CARDS ---- */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        @media (max-width: 900px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        .summary-card {
            border-radius: 18px;
            padding: 24px 22px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        /* Saldo - Dark Navy */
        .card-saldo {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.3);
        }

        .card-saldo::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .card-saldo::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
        }

        /* Pemasukan - Emerald */
        .card-pemasukan {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);
            box-shadow: 0 6px 24px rgba(6, 78, 59, 0.3);
        }

        .card-pemasukan::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -30px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Pengeluaran - Rose/Red */
        .card-pengeluaran {
            background: linear-gradient(135deg, #881337 0%, #9f1239 60%, #be123c 100%);
            box-shadow: 0 6px 24px rgba(136, 19, 55, 0.3);
        }

        .card-pengeluaran::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -30px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .card-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 1.1rem;
            color: #fff;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(4px);
        }

        .card-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .card-amount {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.65rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .card-amount.negative {
            color: #fca5a5;
        }

        .card-meta {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 8px;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .card-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        /* ---- CHART AREA ---- */
        .chart-container {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            margin-bottom: 28px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }

        .chart-period-label {
            font-size: 0.78rem;
            color: #94a3b8;
            font-weight: 500;
            background: #f8fafc;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        /* ---- HISTORY TABLE ---- */
        .history-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
        }

        .history-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            gap: 12px;
        }

        .history-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-count {
            font-size: 0.75rem;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Table Styling */
        .fin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .fin-table thead th {
            padding: 12px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .fin-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
        }

        .fin-table tbody tr:last-child {
            border-bottom: none;
        }

        .fin-table tbody tr:hover {
            background: #fafafa;
        }

        .fin-table tbody td {
            padding: 15px 20px;
            font-size: 0.875rem;
            color: #334155;
            vertical-align: middle;
        }

        /* Modal Tambah Keuangan */
        .btn-tambah-transaksi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #B10000 0%, #8B0000 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
            text-decoration: none;
        }

        .btn-tambah-transaksi:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(177, 0, 0, .3);
            color: #fff;
        }

        .btn-tambah-transaksi i {
            font-size: 0.9rem;
        }

        /* Modal Overlay */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        /* Modal Box */
        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.2);
            animation: modalIn 0.25s ease;
            position: relative;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: background 0.15s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .modal-subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 24px;
        }

        /* Tipe Toggle */
        .tipe-toggle {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 4px;
        }

        .tipe-btn {
            flex: 1;
            padding: 10px;
            border-radius: 9px;
            border: none;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tipe-btn.active-masuk {
            background: #d1fae5;
            color: #065f46;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.15);
        }

        .tipe-btn.active-keluar {
            background: #ffe4e6;
            color: #9f1239;
            box-shadow: 0 2px 8px rgba(225, 29, 72, 0.15);
        }

        /* Form Fields */
        .modal-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .modal-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.88rem;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            background: #fafafa;
        }

        .modal-input:focus {
            border-color: #0f172a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .modal-input-group {
            display: flex;
            align-items: center;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            background: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .modal-input-group:focus-within {
            border-color: #0f172a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .modal-input-group span {
            padding: 11px 14px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            background: #f1f5f9;
            border-right: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        .modal-input-group input {
            flex: 1;
            padding: 11px 14px;
            border: none;
            outline: none;
            font-size: 0.88rem;
            color: #1e293b;
            background: transparent;
        }

        .modal-form-group {
            margin-bottom: 16px;
        }

        /* Submit Button */
        .btn-submit-modal {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit-modal.masuk {
            background: linear-gradient(135deg, #065f46, #059669);
            color: #fff;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        }

        .btn-submit-modal.keluar {
            background: linear-gradient(135deg, #9f1239, #e11d48);
            color: #fff;
            box-shadow: 0 4px 14px rgba(225, 29, 72, 0.3);
        }

        .btn-submit-modal:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        /* Tipe Badge */
        .tipe-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .tipe-badge.pemasukan {
            background: #d1fae5;
            color: #065f46;
        }

        .tipe-badge.pengeluaran {
            background: #ffe4e6;
            color: #9f1239;
        }

        /* Nominal */
        .nominal-pemasukan {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 0.9rem;
            color: #059669;
        }

        .nominal-pengeluaran {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 0.9rem;
            color: #e11d48;
        }

        /* Deskripsi */
        .desc-main {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.875rem;
            margin-bottom: 2px;
        }

        .desc-sub {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e2e8f0;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive table */
        .table-scroll {
            overflow-x: auto;
        }

        /* Saldo positif/negatif warna */
        .saldo-positif {
            color: #6ee7b7;
        }

        .saldo-negatif {
            color: #fca5a5;
        }

        /* Animate on load */
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

        .animate-up {
            animation: fadeUp 0.4s ease both;
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.1s;
        }

        .delay-3 {
            animation-delay: 0.15s;
        }

        .delay-4 {
            animation-delay: 0.2s;
        }

        .delay-5 {
            animation-delay: 0.25s;
        }

        .card-filter-cetak {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .filter-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-select-finance {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            color: #0f172a;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .custom-select-finance:focus {
            outline: none;
            border-color: #3b82f6;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-cet-pdf {
            background: linear-gradient(135deg, #B10000 0%, #8B0000 100%);
            /* Warna merah elegan */
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 10px;
            font-weight: 700;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cet-pdf:hover {
            background: #8B0000;
            box-shadow: 0 4px 12px rgba(128, 0, 0, 0.3);
        }
    </style>

    <div class="keuangan-wrap">

        
        <div class="hero-section">
            <div class="page-header animate-up d-flex flex-wrap justify-content-between align-items-center">

                <div>
                    <h1 class="page-title">Keuangan</h1>
                    <p class="page-subtitle">Financial Transaction <?php echo e($labelPeriode); ?></p>
                    <span class="header-sub">Kelola transaksi dengan mudah dengan filter Harian, Mingguan, Bulanan dan Tahunan</span>
                </div>

                <button class="btn-tambah-transaksi" onclick="openModalKeuangan()">
                    <i class="fa-solid fa-plus"></i> Tambah Transaksi
                </button>

                <div style="flex-basis: 100%" class="d-flex justify-content-center mt-4">
                    <div class="filter-tabs">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['harian' => 'Harian', 'mingguan' => 'Mingguan', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <a href="<?php echo e(route('keuangan.index', ['periode' => $key])); ?>"
                                class="filter-tab <?php echo e($periode === $key ? 'active' : ''); ?>">
                                <?php echo e($label); ?>

                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="cards-grid">

            
            <div class="summary-card card-saldo animate-up delay-1">
                <div class="card-icon-wrap"><i class="fa-solid fa-scale-balanced"></i></div>
                <div class="card-label">Saldo Bersih</div>
                <div class="card-amount <?php echo e($saldo < 0 ? 'negative' : ''); ?>">
                    <?php echo e($saldo < 0 ? '-' : ''); ?>Rp <?php echo e(number_format(abs($saldo), 0, ',', '.')); ?>

                </div>
                <div class="card-meta">Pemasukan - Pengeluaran pada periode ini</div>
                <div class="card-badge">
                    <i class="fa-solid fa-circle-dot"
                        style="font-size:0.6rem; color: <?php echo e($saldo >= 0 ? '#6ee7b7' : '#fca5a5'); ?>;"></i>
                    <?php echo e($saldo >= 0 ? 'Surplus' : 'Defisit'); ?>

                </div>
            </div>

            
            <div class="summary-card card-pemasukan animate-up delay-2">
                <div class="card-icon-wrap"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <div class="card-label">Total Pemasukan</div>
                <div class="card-amount">Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></div>
                <div class="card-meta">Dari hasil service kendaraan</div>
                <div class="card-badge">
                    <i class="fa-solid fa-wrench" style="font-size:0.65rem;"></i>
                    <?php echo e($jumlahTransaksiService); ?> transaksi service
                </div>
            </div>

            
            <div class="summary-card card-pengeluaran animate-up delay-3">
                <div class="card-icon-wrap"><i class="fa-solid fa-arrow-trend-down"></i></div>
                <div class="card-label">Total Pengeluaran</div>
                <div class="card-amount">Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></div>
                <div class="card-meta">Estimasi nilai stok sparepart</div>
                <div class="card-badge">
                    <i class="fa-solid fa-boxes-stacked" style="font-size:0.65rem;"></i>
                    <?php echo e($jumlahItemInventory); ?> item inventory
                </div>
            </div>
        </div>

        <div class="card-filter-cetak mb-4">
            <form action="<?php echo e(route('keuangan.cetak')); ?>" method="GET" target="_blank">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label> Mode Laporan</label>
                        <select name="periode" id="periodeSelect" class="custom-select-finance"
                            onchange="toggleFilterFields()">
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan" selected>Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="custom">Rentang Tanggal</option>
                        </select>
                    </div>

                    <div class="filter-group" id="bulanField">
                        <label>Bulan</label>
                        <select name="bulan" class="custom-select-finance">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(date('m') == $m ? 'selected' : ''); ?>>
                                    <?php echo e(Carbon\Carbon::create(null, $m, 1)->translatedFormat('F')); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="filter-group" id="tahunField">
                        <label>Tahun</label>
                        <select name="tahun" class="custom-select-finance">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(date('Y') - 3, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($y); ?>" <?php echo e(date('Y') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="filter-group d-none" id="mingguField">
                        <label>Minggu Ke</label>
                        <select name="minggu" class="custom-select-finance">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo e($i); ?>">Minggu <?php echo e($i); ?></option> <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <div class="filter-group d-none" id="customField">
                        <label>Rentang Tanggal</label>
                        <div class="d-flex gap-2">
                            <input type="date" name="start_date" class="custom-select-finance">
                            <input type="date" name="end_date" class="custom-select-finance">
                        </div>
                    </div>

                    <div class="filter-group d-flex align-items-end">
                        <button type="submit" class="btn-cet-pdf">
                            <i class="fa-solid fa-file-pdf"></i> Generate Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="chart-container animate-up delay-4">
    <div class="chart-header">
        <span class="chart-title">
            <i class="fa-solid fa-chart-area me-2" style="color:#0f172a;"></i>
            Grafik Keuangan
        </span>
        <span class="chart-period-label"><?php echo e($labelPeriode); ?></span>
    </div>
 
    
    <div class="d-flex flex-wrap gap-3 mb-4" id="chartLegendToggles">
 
        
        <label class="chart-toggle-label" for="togglePemasukan">
            <input type="checkbox" id="togglePemasukan" checked>
            <span class="toggle-dot" style="background:#059669;"></span>
            <span class="toggle-text">Pemasukan</span>
        </label>
 
        
        <label class="chart-toggle-label" for="togglePengeluaran">
            <input type="checkbox" id="togglePengeluaran" checked>
            <span class="toggle-dot" style="background:#e11d48;"></span>
            <span class="toggle-text">Pengeluaran</span>
        </label>
 
    </div>
 
    <canvas id="keuanganChart" height="80"></canvas>
</div>
 
<style>
/* ── Chart Toggle Checkbox Styling ── */
.chart-toggle-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 6px 14px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.82rem;
    font-weight: 600;
    color: #334155;
    user-select: none;
    transition: background 0.18s, border-color 0.18s, box-shadow 0.18s;
}
 
.chart-toggle-label:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}
 
.chart-toggle-label input[type="checkbox"] {
    display: none; /* sembunyikan native checkbox */
}
 
.chart-toggle-label .toggle-dot {
    width: 12px;
    height: 12px;
    border-radius: 3px;
    flex-shrink: 0;
    transition: opacity 0.2s;
}
 
/* Saat checkbox TIDAK dicentang → abu-abu */
.chart-toggle-label input:not(:checked) ~ .toggle-dot {
    opacity: 0.25;
}
 
.chart-toggle-label input:not(:checked) ~ .toggle-text {
    color: #94a3b8;
    text-decoration: line-through;
}
 
/* Saat dicentang → tampilkan border berwarna */
.chart-toggle-label:has(#togglePemasukan:checked)   { border-color: #059669; background: rgba(5,150,105,.07); }
.chart-toggle-label:has(#togglePengeluaran:checked) { border-color: #e11d48; background: rgba(225,29,72,.06); }
</style>

        
        <div class="history-card animate-up delay-5">
            <div class="history-header">
                <div class="history-title">
                    <i class="fa-solid fa-clock-rotate-left" style="color:#64748b;"></i>
                    Riwayat Transaksi
                    <span class="history-count"><?php echo e($historyTransaksi->count()); ?> entri</span>
                </div>
                <span style="font-size:0.78rem; color:#94a3b8; font-weight:500;">
                    <i class="fa-regular fa-calendar me-1"></i><?php echo e($labelPeriode); ?>

                </span>
            </div>

            <div class="table-scroll">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($historyTransaksi->isEmpty()): ?>
                    <div class="empty-state">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>Belum ada transaksi pada periode ini.</p>
                    </div>
                <?php else: ?>
                    <table class="fin-table">
                        <thead>
                            <tr>
                                <th style="width:40px; text-align:center;">No</th>
                                <th>Tanggal & Waktu</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                                <th>Info Tambahan</th>
                                <th style="text-align:right;">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $historyTransaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr>
                                    
                                    <td style="text-align:center; color:#cbd5e1; font-weight:600;"><?php echo e($i + 1); ?></td>

                                    
                                    <td>
                                        <div style="font-weight:600; color:#1e293b; font-size:0.85rem;">
                                            <?php echo e(\Carbon\Carbon::parse($transaksi['tanggal'])->translatedFormat('d M Y')); ?>

                                        </div>
                                        <div style="font-size:0.75rem; color:#94a3b8;">
                                            <?php echo e(\Carbon\Carbon::parse($transaksi['tanggal'])->format('H:i')); ?> WIB
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <span class="tipe-badge <?php echo e($transaksi['tipe']); ?>">
                                            <i class="fa-solid <?php echo e($transaksi['icon']); ?>" style="font-size:0.7rem;"></i>
                                            <?php echo e(ucfirst($transaksi['tipe'])); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <div class="desc-main"><?php echo e($transaksi['deskripsi']); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaksi['tipe'] === 'pemasukan' && $transaksi['mekanik'] !== '-'): ?>
                                            <div class="desc-sub">
                                                <i class="fa-solid fa-user-tie" style="font-size:0.65rem;"></i>
                                                <?php echo e($transaksi['mekanik']); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    
                                    <td>
                                        <div class="desc-sub" style="font-size:0.8rem; color:#64748b;">
                                            <?php echo e($transaksi['sub_info']); ?>

                                        </div>
                                    </td>

                                    
                                    <td style="text-align:right;">
                                        <span class="nominal-<?php echo e($transaksi['tipe']); ?>">
                                            <?php echo e($transaksi['tipe'] === 'pemasukan' ? '+' : '-'); ?>

                                            Rp <?php echo e(number_format($transaksi['nominal'], 0, ',', '.')); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>

                        
                        <tfoot>
                            <tr style="background:#f8fafc; border-top: 2px solid #e2e8f0;">
                                <td colspan="5" style="padding: 14px 20px; font-weight:700; color:#0f172a; font-size:0.875rem;">
                                    Saldo Bersih Periode Ini
                                </td>
                                <td style="padding: 14px 20px; text-align:right;">
                                    <span
                                        style="font-family:'JetBrains Mono',monospace; font-size:1rem; font-weight:800; color: <?php echo e($saldo >= 0 ? '#059669' : '#e11d48'); ?>;">
                                        <?php echo e($saldo < 0 ? '-' : '+'); ?>

                                        Rp <?php echo e(number_format(abs($saldo), 0, ',', '.')); ?>

                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="modal-overlay" id="modalTambahTransaksi" onclick="handleOverlayClick(event)">
            <div class="modal-box">

                
                <button class="modal-close" onclick="closeModalKeuangan()" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                
                <div class="modal-title"><i class="fa-solid fa-money-bill-transfer me-2" style="color:#0f172a;"></i>Tambah
                    Transaksi</div>
                <div class="modal-subtitle">Catat pemasukan atau pengeluaran secara manual</div>

                
                <form method="POST" action="<?php echo e(route('keuangan.store')); ?>" id="formTambahTransaksi">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="periode" value="<?php echo e($periode); ?>">
                    <input type="hidden" name="tipe" id="inputTipe" value="pemasukan">

                    
                    <div class="tipe-toggle">
                        <button type="button" class="tipe-btn active-masuk" id="btnMasuk" onclick="setTipe('pemasukan')">
                            <i class="fa-solid fa-arrow-trend-up"></i> Pemasukan
                        </button>
                        <button type="button" class="tipe-btn" id="btnKeluar" onclick="setTipe('pengeluaran')">
                            <i class="fa-solid fa-arrow-trend-down"></i> Pengeluaran
                        </button>
                    </div>

                    
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputJudul">Judul Transaksi</label>
                        <input type="text" id="inputJudul" name="judul" class="modal-input"
                            placeholder="cth: Dana BOS Jurusan, Gaji Karyawan..." required autocomplete="off">
                    </div>

                    
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputNominalView">Nominal</label>
                        <div class="modal-input-group">
                            <span>Rp</span>
                            <input type="text" id="inputNominalView" placeholder="0" autocomplete="off"
                                oninput="formatNominal(this)" required>
                        </div>
                        <input type="hidden" id="inputNominal" name="nominal">
                    </div>

                    
                    <div class="modal-form-group">
                        <label class="modal-label" for="inputKeterangan">Keterangan <span
                                style="color:#94a3b8;font-weight:500;text-transform:none;">(opsional)</span></label>
                        <textarea id="inputKeterangan" name="keterangan" class="modal-input" rows="2"
                            placeholder="Tambahkan catatan jika perlu..." style="resize:none;"></textarea>
                    </div>

                    
                    <button type="submit" class="btn-submit-modal masuk" id="btnSubmitModal">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span id="submitLabel">Simpan Pemasukan</span>
                    </button>
                </form>

            </div>
        </div>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels      = <?php echo json_encode($chartData['labels'], 15, 512) ?>;
    const dataPemasukan   = <?php echo json_encode($chartData['pemasukan'], 15, 512) ?>;
    const dataPengeluaran = <?php echo json_encode($chartData['pengeluaran'], 15, 512) ?>;
 
    const ctx = document.getElementById('keuanganChart').getContext('2d');
 
    // ── Gradients ──
    const gGreen = ctx.createLinearGradient(0, 0, 0, 250);
    gGreen.addColorStop(0, 'rgba(5,150,105,.22)');
    gGreen.addColorStop(1, 'rgba(5,150,105,.00)');
 
    const gRed = ctx.createLinearGradient(0, 0, 0, 250);
    gRed.addColorStop(0, 'rgba(225,29,72,.18)');
    gRed.addColorStop(1, 'rgba(225,29,72,.00)');
 
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: dataPemasukan,
                    borderColor: '#059669',
                    backgroundColor: gGreen,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#059669',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.42,
                    fill: true,
                },
                {
                    label: 'Pengeluaran',
                    data: dataPengeluaran,
                    borderColor: '#e11d48',
                    backgroundColor: gRed,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#e11d48',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.42,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false }, // pakai custom checkbox kita sendiri
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 14,
                    cornerRadius: 10,
                    callbacks: {
                        label: function (context) {
                            const val = context.raw;
                            const prefix = val < 0 ? '-' : '';
                            return ` ${context.dataset.label}: ${prefix}Rp ${new Intl.NumberFormat('id-ID').format(Math.abs(val))}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                    },
                    border: { display: false }
                },
                y: {
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: 'JetBrains Mono', size: 10 },
                        callback: function (val) {
                            if (val < 0) return '-Rp ' + formatShort(Math.abs(val));
                            return 'Rp ' + formatShort(val);
                        }
                    },
                    border: { display: false }
                }
            }
        }
    });
 
    function formatShort(val) {
        if (val >= 1_000_000) return (val / 1_000_000).toFixed(1) + 'jt';
        if (val >= 1_000)     return (val / 1_000).toFixed(0) + 'rb';
        return val;
    }
 
    // ── Toggle Checkbox Logic ──
    const toggleMap = {
        togglePemasukan:   0,
        togglePengeluaran: 1
    };
 
    Object.entries(toggleMap).forEach(([checkboxId, datasetIndex]) => {
        const checkbox = document.getElementById(checkboxId);
        if (!checkbox) return;
 
        checkbox.addEventListener('change', function () {
            const meta = chart.getDatasetMeta(datasetIndex);
            meta.hidden = !this.checked;
            chart.update();
        });
    });
});
</script>



    <script>
        // â”€â”€ Open / Close Modal â”€â”€
        function openModalKeuangan() {
            document.getElementById('modalTambahTransaksi').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('inputJudul').focus(), 100);
        }

        function closeModalKeuangan() {
            document.getElementById('modalTambahTransaksi').classList.remove('active');
            document.body.style.overflow = '';
            // Reset form
            document.getElementById('formTambahTransaksi').reset();
            document.getElementById('inputNominal').value = '';
            setTipe('pemasukan');
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('modalTambahTransaksi')) {
                closeModalKeuangan();
            }
        }

        // Tutup modal dengan Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModalKeuangan();
        });

        // â”€â”€ Toggle Tipe Pemasukan / Pengeluaran â”€â”€
        function setTipe(tipe) {
            const btnMasuk = document.getElementById('btnMasuk');
            const btnKeluar = document.getElementById('btnKeluar');
            const btnSubmit = document.getElementById('btnSubmitModal');
            const submitLabel = document.getElementById('submitLabel');

            document.getElementById('inputTipe').value = tipe;

            if (tipe === 'pemasukan') {
                btnMasuk.className = 'tipe-btn active-masuk';
                btnKeluar.className = 'tipe-btn';
                btnSubmit.className = 'btn-submit-modal masuk';
                submitLabel.textContent = 'Simpan Pemasukan';
            } else {
                btnMasuk.className = 'tipe-btn';
                btnKeluar.className = 'tipe-btn active-keluar';
                btnSubmit.className = 'btn-submit-modal keluar';
                submitLabel.textContent = 'Simpan Pengeluaran';
            }
        }

        function toggleFilterFields() {
            const p = document.getElementById('periodeSelect').value;

            // Sembunyikan semua field dinamis dulu
            document.getElementById('mingguField').classList.add('d-none');
            document.getElementById('bulanField').classList.add('d-none');
            document.getElementById('tahunField').classList.add('d-none');
            document.getElementById('customField').classList.add('d-none');

            // Tampilkan berdasarkan pilihan
            if (p === 'mingguan') {
                document.getElementById('mingguField').classList.remove('d-none');
                document.getElementById('bulanField').classList.remove('d-none');
                document.getElementById('tahunField').classList.remove('d-none');
            } else if (p === 'bulanan') {
                document.getElementById('bulanField').classList.remove('d-none');
                document.getElementById('tahunField').classList.remove('d-none');
            } else if (p === 'tahunan') {
                document.getElementById('tahunField').classList.remove('d-none');
            } else if (p === 'custom') {
                document.getElementById('customField').classList.remove('d-none');
            }
        }

        // Jalankan saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', toggleFilterFields);

        // â”€â”€ Format Nominal Rupiah â”€â”€
        function formatNominal(el) {
            let angka = el.value.replace(/[^0-9]/g, '');
            document.getElementById('inputNominal').value = angka;
            el.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
        }

        // â”€â”€ Validasi sebelum submit â”€â”€
        document.getElementById('formTambahTransaksi').addEventListener('submit', function (e) {
            const nominal = document.getElementById('inputNominal').value;
            if (!nominal || parseInt(nominal) < 1) {
                e.preventDefault();
                document.getElementById('inputNominalView').style.borderColor = '#e11d48';
                document.getElementById('inputNominalView').focus();
            }
        });

        // â”€â”€ Auto-buka modal jika ada validasi error dari server â”€â”€
        <?php if($errors->any()): ?>
            document.addEventListener('DOMContentLoaded', () => openModalKeuangan());
        <?php endif; ?>

        // â”€â”€ Auto-close success message â”€â”€
        <?php if(session('success')): ?>
            setTimeout(() => {
                const alert = document.querySelector('.alert-success');
                if (alert) alert.style.opacity = '0';
            }, 3000);
        <?php endif; ?>
    </script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Downloads\upj_tsm_k9\resources\views/keuangan/index.blade.php ENDPATH**/ ?>