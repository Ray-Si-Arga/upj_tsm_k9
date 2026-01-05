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
        padding: 20px 22px;
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
        background: #ef4444;
        color: white;
    }

    /* --- KHUSUS HP (Mobile Fix) --- */
    @media (max-width: 991px) {

        .sidebar-header{
            justify-content: flex-end;
            padding: 25px 55px;
        }

        .sidebar-logout {
            /* SOLUSI: Tambahkan padding bawah yang SANGAT BESAR khusus di HP.
               Ini akan memaksa tombol logout naik ke atas sejauh 100px dari bawah layar.
               Jadi walaupun ada address bar Google, tombol tetap terlihat. */
            padding-bottom: 70px !important;
        }
    }
</style>

<button id="sidebar-toggle" style="display: none;"><i class="fa-solid fa-bars"></i></button>

<aside class="sidebar-container" id="sidebar">

    <div class="sidebar-header">
        {{-- <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('/images/honda.png') }}" alt="Honda">
            </a>
        </div> --}}
        <div class="sidebar-brand">
            <span class="brand-title">Honda Service</span>
            <span class="user-name">Hai, {{ Str::limit(Auth::user()->name ?? 'Guest', 15) }}</span>
        </div>
    </div>

    <div class="sidebar-content">
        <ul class="sidebar-menu">

            {{-- Khusus Admin --}}
            @if (auth()->check() && auth()->user()->role === 'admin')
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-house"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>
            @else
                <li class="sidebar-menu-item">
                    <a href="{{ route('pelanggan.dashboard') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-house"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('pelanggan.service') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pelanggan.service') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                        <span>Service</span>
                    </a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
                <li class="sidebar-menu-item">
                    <a href="{{ route('booking.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('booking.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        <span>Booking</span>
                        @php $pendingCount = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                        @if ($pendingCount > 0)
                            <span class="sidebar-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('customers.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-users"></i></div>
                        <span>Akun Customers</span>
                    </a>
                </li>

                <li class="sidebar-divider"></li>
                <li class="sidebar-label">Gudang</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('inventory.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-box"></i></div>
                        <span>Inventory</span>
                    </a>
                </li>

                <li class="sidebar-label">Layanan</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('layanan.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <span>Paket & Layanan</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('advisor.create') }}"
                        class="sidebar-menu-link {{ request()->routeIs('advisor.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-file-signature"></i></div>
                        <span>Form Keluhan</span>
                    </a>
                </li>

                <li class="sidebar-divider"></li>
                <li class="sidebar-label">Administrator</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.register') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.register') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon"><i class="fa-solid fa-user-plus"></i></div>
                        <span>Registrasi</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="sidebar-logout">
        <a class="logout-btn" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
            @csrf
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const toggleIcon = toggleBtn.querySelector('i');
        const mainContent = document.querySelector('main'); // Asumsi konten utama dibungkus tag <main>

        // Fungsi Toggle Sidebar Mobile
        function toggleSidebar() {
            sidebar.classList.toggle('active');

            // Ubah icon tombol toggle
            if (sidebar.classList.contains('active')) {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-xmark');
                document.body.classList.add('sidebar-open');
            } else {
                toggleIcon.classList.remove('fa-xmark');
                toggleIcon.classList.add('fa-bars');
                document.body.classList.remove('sidebar-open');
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        // Tutup sidebar jika klik di luar sidebar (pada mobile)
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    toggleSidebar();
                }
            }
        });

        // Set Active Class (Fallback JS jika Blade request()->routeIs() meleset di beberapa kasus)
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.sidebar-menu-link');
        menuLinks.forEach(link => {
            if (link.getAttribute('href') === window.location.href) {
                link.classList.add('active');
            }
        });
    });
</script>
