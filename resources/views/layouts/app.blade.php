<!DOCTYPE html>
<html>

<head>
    <title>Booking Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
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
                padding: 20px;
                padding-top: 80px;
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

    <button id="customSidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div>
        @include('components.sidebar.sidebar')

        <main class="main-content" id="main-content">
            <div class="container-fluid py-3">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kita ambil elemen berdasarkan ID yang benar
            const toggleBtn = document.getElementById('customSidebarToggle');
            const sidebar = document.getElementById('sidebar'); // ID sidebar bawaan komponen
            const overlay = document.getElementById('sidebarOverlay');
            const icon = toggleBtn.querySelector('i');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');

                // Ubah ikon
                if (sidebar.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                } else {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
