<!DOCTYPE html>
<html>

<head>
    <title>Booking Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --sidebar-width: 280px;
            --sidebar-bg: rgba(255, 255, 255, 0.95);
            --bg-color: #f3f4f6;
        }

        /* --- Sidebar Container (FIXED LAYOUT) --- */
        .sidebar-container {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            /* Tinggi standar */
            height: 100vh;
            /* Fallback canggih untuk HP (menghindari ketutup address bar) */
            height: 100dvh;

            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;

            display: flex;
            flex-direction: column;

            border-right: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* --- Header Section (Diam di Atas) --- */
        .sidebar-header {
            flex-shrink: 0;
            padding: 20px 32px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .sidebar-logo {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .sidebar-logo img {
            width: 28px;
            height: auto;
        }

        .sidebar-brand {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--honda-red);
            line-height: 1.2;
            white-space: nowrap;
        }

        .user-name {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        /* --- Menu Section (Bisa Scroll) --- */
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* Menu Styling */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 700;
            margin: 20px 10px 8px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: #475569;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-weight: 500;
            margin-bottom: 4px;
            font-size: 16px;
        }

        .sidebar-menu-link:hover {
            background-color: var(--honda-red-soft);
            color: var(--honda-red);
            transform: translateX(2px);
        }

        .sidebar-menu-link.active {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(177, 0, 0, 0.2);
        }

        .sidebar-menu-icon {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            margin-left: auto;
        }

        .sidebar-menu-link.active .sidebar-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .sidebar-menu-link:not(.active) .sidebar-badge {
            background: #fff1f2;
            color: var(--honda-red);
        }

        .sidebar-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 10px 0;
        }

        /* --- Logout Section --- */
        .sidebar-logout {
            flex-shrink: 0;
            padding: 15px 20px;
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);

            /* Default untuk Laptop */
            padding-bottom: 20px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            border: 1px solid #fee2e2;
            background: #fffafa;
            color: #ef4444;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            gap: 8px;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
        }

        .app-content-wrapper {
            width: 100%;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            box-sizing: border-box;
        }

        /* --- KHUSUS HP (Mobile Fix) --- */
        @media (max-width: 991px) {
            .sidebar-header {
                justify-content: flex-end;
                padding: 25px 55px;
            }

            .sidebar-logout {
                padding-bottom: 70px !important;
                color: #b30000;
            }
        }

        /* 1. RESET & DASAR */
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* Kita sembunyikan tombol toggle bawaan dari komponen sidebar
           agar tidak ada 2 tombol yang muncul */
        #sidebar-toggle {
            display: none !important;
        }

        /* =================================================================
           MODE LAPTOP & PC (Layar > 992px)
           Target ID #sidebar karena lebih kuat daripada class .sidebar-container
           ================================================================= */
        @media (min-width: 992px) {

            /* Sidebar Paksa Muncul & Fixed */
            #sidebar {
                width: 250px !important;
                /* Timpa lebar bawaan 280px */
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1000;
                transform: translateX(0) !important;
                visibility: visible !important;
                box-shadow: none !important;
                border-right: 1px solid #e9ecef;
            }

            /* Konten Geser Kanan */
            #main-content {
                margin-left: 250px !important;
                width: calc(100% - 250px) !important;
                padding: 30px;
                min-height: 100vh;
                transition: margin-left 0.3s ease;
            }

            /* Sembunyikan tombol toggle custom kita di laptop */
            #customSidebarToggle {
                display: none !important;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }

        /* =================================================================
           MODE TABLET & HP (Layar < 991.98px)
           Ini mengatasi masalah rasio 778-991px
           ================================================================= */
        @media (max-width: 991.98px) {

            /* Sidebar Paksa Sembunyi ke Kiri */
            #sidebar {
                width: 250px !important;
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1050;

                /* KUNCI: Lempar keluar layar */
                transform: translateX(-100%) !important;
                visibility: hidden !important;

                transition: transform 0.3s ease, visibility 0.3s !important;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1) !important;
            }

            /* Class Active untuk memunculkan Sidebar */
            #sidebar.active {
                transform: translateX(0) !important;
                visibility: visible !important;
            }

            /* Konten Full Width */
            #main-content {
                margin-left: 0 !important;
                width: 100% !important;
                /* padding: 20px; */
                padding-top: 30px;
                /* Jarak agar tidak ketutup tombol */
            }

            /* Tombol Toggle Custom Muncul */
            #customSidebarToggle {
                display: block !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1060;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: white;
                border: none;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                color: #333;
                font-size: 1.2rem;
            }

            /* Overlay Gelap */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>

</head>

<body>

    
    <button id="sidebar-toggle" style="display: none;"><i class="fa-solid fa-bars"></i></button>
    <aside class="sidebar-container" id="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-brand">
                <span class="brand-title">Honda Service</span>
                <span class="user-name">Hai, <?php echo e(Str::limit(Auth::user()->name ?? 'Guest', 15)); ?></span>
            </div>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-menu">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-house"></i></div>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-divider"></li>
                    <li class="sidebar-label">Operasional</li>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('inventory.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('inventory.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-box"></i></div>
                            <span>Inventory</span>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('keuangan.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('keuangan.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-wallet"></i></div>
                            <span>Keuangan</span>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.jadwal')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('admin.jadwal') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-calendar-alt"></i></div>
                            <span>Jadwal</span>
                        </a>
                    </li>


                    <li class="sidebar-divider"></li>
                    <!-- <li class="sidebar-label">Gudang</li> !-->
                    <li class="sidebar-label">Layanan</li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('booking.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('booking.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <span>Booking</span>
                            <?php $pendingCount = \App\Models\Booking::where('status', 'pending')->count(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingCount > 0): ?>
                                <span class="sidebar-badge"><?php echo e($pendingCount); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('advisor.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('advisor.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-file-signature"></i></div>
                            <span>Advisor</span>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('layanan.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('layanan.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                            <span>Paket & Layanan</span>
                        </a>
                    </li>

                    <li class="sidebar-divider"></li>
                    <li class="sidebar-label">Administrator</li>

                    

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('customers.index')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('customers.*') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-users"></i></div>
                            <span>Akun</span>
                        </a>
                    </li>


                    
                <?php else: ?>
                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('pelanggan.dashboard')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('pelanggan.dashboard') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-house"></i></div>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('pelanggan.service')); ?>"
                            class="sidebar-menu-link <?php echo e(request()->routeIs('pelanggan.service') ? 'active' : ''); ?>">
                            <div class="sidebar-menu-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                            <span>Service</span>
                        </a>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>

        <div class="sidebar-logout">
            
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
    <?php echo csrf_field(); ?>
    <button type="submit" class="logout-btn">
        <i class="fas fa-right-from-bracket me-2"></i>Logout
    </button>
</form>

        </div>
    </aside>


    
    <button id="customSidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div>
        <main class="main-content" id="main-content">
            <div class="app-content-wrapper">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Ambil semua elemen yang terlibat
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('customSidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            const icon = toggleBtn ? toggleBtn.querySelector('i') : null;

            // 2. Fungsi Utama untuk MENUTUP semuanya
            function closeSidebar() {
                if (sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');

                    if (overlay) overlay.classList.remove('active');

                    if (icon) {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    }

                    document.body.classList.remove('sidebar-open');
                }
            }

            // 3. Fungsi untuk TOGGLE (Buka/Tutup)
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                if (overlay) overlay.classList.toggle('active');

                if (icon) {
                    if (sidebar.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-xmark');
                        document.body.classList.add('sidebar-open');
                    } else {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            }

            // 4. Event Listener Klik Tombol Toggle
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // 5. Event Listener Klik di Overlay (Bayangan Gelap)
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // 6. SOLUSI UTAMAMU: Tutup saat Scroll Main Content
            // Kita pantau pergerakan scroll di level window
            window.addEventListener('scroll', function () {
                if (window.innerWidth <= 991 && sidebar.classList.contains('active')) {
                    closeSidebar();
                }
            }, { passive: true });

            // 7. Tambahan: Klik di area Main Content juga menutup sidebar
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.addEventListener('click', function () {
                    if (window.innerWidth <= 991) {
                        closeSidebar();
                    }
                });
            }

            // 8. Logika Active Menu (Bawaanmu)
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.sidebar-menu-link');
            menuLinks.forEach(link => {
                if (link.getAttribute('href') === window.location.href) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    <script>
/**
 * ANTI DOUBLE SUBMIT — Global
 * Berlaku otomatis untuk SEMUA form di seluruh aplikasi.
 * Tidak perlu ubah blade lain satu-persatu.
 */
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('form').forEach(function (form) {

        form.addEventListener('submit', function (e) {

            // Cari tombol submit yang aktif di form ini
            const submitBtns = form.querySelectorAll('button[type="submit"], input[type="submit"]');

            // Jika form sudah pernah di-submit sebelumnya, blokir
            if (form.dataset.submitting === 'true') {
                e.preventDefault();
                return false;
            }

            // Tandai form sedang diproses
            form.dataset.submitting = 'true';

            submitBtns.forEach(function (btn) {
                // Simpan teks asli tombol untuk dikembalikan jika gagal
                btn.dataset.originalHtml = btn.innerHTML;
                btn.dataset.originalText = btn.textContent.trim();

                // Tampilkan loading state
                btn.disabled = true;
                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
                    'Memproses...';
                btn.style.opacity = '0.75';
                btn.style.cursor  = 'not-allowed';
            });

            // Fallback keamanan: reset tombol setelah 15 detik
            // (jika server timeout atau koneksi putus, tombol tidak terkunci selamanya)
            setTimeout(function () {
                if (form.dataset.submitting === 'true') {
                    resetForm(form, submitBtns);
                }
            }, 15000);
        });
    });

    /**
     * Reset form ke kondisi awal
     * Dipanggil saat timeout atau jika ada error validasi Laravel (halaman di-reload)
     */
    function resetForm(form, btns) {
        form.dataset.submitting = 'false';
        btns.forEach(function (btn) {
            btn.disabled  = false;
            btn.innerHTML = btn.dataset.originalHtml || btn.dataset.originalText || 'Submit';
            btn.style.opacity = '';
            btn.style.cursor  = '';
        });
    }

    // Jika Laravel redirect balik karena validasi error,
    // pastikan tombol tidak dalam kondisi disabled (page sudah baru)
    window.addEventListener('pageshow', function (e) {
        // pageshow dengan persisted=true artinya halaman dari browser cache (back button)
        if (e.persisted) {
            document.querySelectorAll('form').forEach(function (form) {
                form.dataset.submitting = 'false';
                form.querySelectorAll('button[type="submit"]').forEach(function (btn) {
                    btn.disabled  = false;
                    btn.innerHTML = btn.dataset.originalHtml || btn.innerHTML;
                    btn.style.opacity = '';
                    btn.style.cursor  = '';
                });
            });
        }
    });

});
</script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH /home/hakuuu/Desktop/project/upj_tsm_k9/resources/views/layouts/app.blade.php ENDPATH**/ ?>