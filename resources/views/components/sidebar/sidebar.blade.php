<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    :root {
        --honda-red: #B10000;
        --honda-red-dark: #8B0000;
        --honda-red-soft: rgba(177, 0, 0, 0.08);
        --sidebar-width: 280px;
        --sidebar-bg: rgba(255, 255, 255, 0.92);
        --bg-color: #f3f4f6;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-color);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        /* Mencegah scroll horizontal */
    }

    .main-content-with-sidebar {
        min-height: 100vh;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    /* --- Sidebar Container --- */
    .sidebar-container {
        width: var(--sidebar-width);
        background: var(--sidebar-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.05);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255, 255, 255, 0.4);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* --- Header Section --- */
    .sidebar-header {
        padding: 25px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0));
    }

    .sidebar-logo {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .sidebar-logo:hover {
        transform: scale(1.05) rotate(-5deg);
    }

    .sidebar-logo img {
        width: 32px;
        height: auto;
    }

    .sidebar-brand {
        display: flex;
        flex-direction: column;
    }

    .brand-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--honda-red);
        letter-spacing: -0.5px;
        line-height: 1.2;
    }

    .user-name {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }

    /* --- Menu Section --- */
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 10px 15px;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #94a3b8;
        font-weight: 700;
        margin: 20px 10px 10px;
    }

    .sidebar-menu-item {
        margin-bottom: 5px;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #475569;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.2s ease;
        position: relative;
        font-weight: 500;
    }

    /* Hover Effect */
    .sidebar-menu-link:hover {
        background-color: var(--honda-red-soft);
        color: var(--honda-red);
        transform: translateX(3px);
    }

    /* Active State */
    .sidebar-menu-link.active {
        background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(177, 0, 0, 0.25);
    }

    .sidebar-menu-icon {
        width: 24px;
        margin-right: 12px;
        font-size: 1.1rem;
        display: flex;
        justify-content: center;
        transition: transform 0.2s;
    }

    .sidebar-menu-link:hover .sidebar-menu-icon {
        transform: scale(1.1);
    }

    /* Badge Styling */
    .sidebar-badge {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 700;
        margin-left: auto;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar-menu-link.active .sidebar-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .sidebar-menu-link:not(.active) .sidebar-badge {
        background: #fff1f2;
        color: var(--honda-red);
        border: 1px solid rgba(177, 0, 0, 0.1);
    }

    /* Divider */
    .sidebar-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.06), transparent);
        margin: 15px 0;
    }

    /* --- Logout Section --- */
    .sidebar-logout {
        padding: 20px;
        background: rgba(248, 250, 252, 0.5);
        border-top: 1px solid rgba(0, 0, 0, 0.03);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px;
        border: 1px solid #fee2e2;
        background: white;
        color: #ef4444;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        gap: 8px;
    }

    .logout-btn:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
    }

    /* --- Scrollbar Customization --- */
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

    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* --- Mobile Responsive --- */
    .sidebar-toggle-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1100;
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: none;
        display: none;
        /* Hidden by default on desktop */
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sidebar-toggle-btn i {
        font-size: 1.2rem;
        color: #333;
    }

    /* Tampilan Desktop (Layar Besar) */
    @media (min-width: 769px) {
        .main-content-with-sidebar {
            margin-left: var(--sidebar-width);
            /* Geser konten agar tidak tertutup sidebar */
            width: calc(100% - var(--sidebar-width));
        }
    }

    /* Tampilan Mobile (HP/Tablet) */
    @media (max-width: 768px) {
        .main-content-with-sidebar {
            margin-left: 0;
            width: 100%;
            padding-top: 60px;
            /* Beri jarak atas untuk tombol toggle sidebar */
        }

        .sidebar-container {
            transform: translateX(-100%);
        }

        .sidebar-container.active {
            transform: translateX(0);
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
            /* Backdrop dim effect */
        }

        .sidebar-toggle-btn {
            display: flex;
        }

        /* Adjust main content margin when sidebar is present */
        body.sidebar-open {
            overflow: hidden;
            /* Prevent scrolling when sidebar is open on mobile */
        }
    }
</style>

<button class="sidebar-toggle-btn" id="sidebar-toggle">
    <i class="fa-solid fa-bars"></i>
</button>

<aside class="sidebar-container" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('/images/honda.png') }}" alt="Honda">
            </a>
        </div>
        <div class="sidebar-brand">
            <span class="brand-title">Honda Service</span>
            <span class="user-name">Hai, {{ Str::limit(Auth::user()->name, 15) }}</span>
        </div>
    </div>

    <div class="sidebar-content">
        <ul class="sidebar-menu">

            {{-- Khusus Admin --}}
            @if (auth()->check() && auth()->user()->role === 'admin')
                {{-- Dashboard --}}
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>
            @else
                {{-- Pelanggan Dashboard --}}
                <li class="sidebar-menu-item">
                    <a href="{{ route('pelanggan.dashboard') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Pelanggan Service --}}
                <li class="sidebar-menu-item">
                    <a href="{{ route('pelanggan.service') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pelanggan.service') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <span>Service</span>
                    </a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
                {{-- Booking --}}
                <li class="sidebar-menu-item">
                    <a href="{{ route('booking.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('booking.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <span>Booking</span>

                        @php
                            $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <span class="sidebar-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                {{-- Customers --}}
                <li class="sidebar-menu-item">
                    <a href="{{ route('customers.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                        id="customers-menu-link">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <span>Akun Customers</span>
                    </a>
                </li>

                {{-- ///////////////// --}}
                {{-- - Jangan Dihapus --}}
                {{-- //////////////// --}}

                {{-- SECTION: INVENTORY --}}
                {{-- <li class="sidebar-divider"></li>
                <li class="sidebar-label">Gudang</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('inventory.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <span>Inventory</span>
                    </a>
                </li> --}}

                {{-- SECTION: ADVISOR --}}
                <li class="sidebar-label">Layanan</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('advisor.create') }}"
                        class="sidebar-menu-link {{ request()->routeIs('advisor.*') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <span>Form Keluhan</span>
                    </a>
                </li>

                {{-- SECTION: ADMIN --}}
                <li class="sidebar-divider"></li>
                <li class="sidebar-label">Administrator</li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.register') }}"
                        class="sidebar-menu-link {{ request()->routeIs('admin.register') ? 'active' : '' }}">
                        <div class="sidebar-menu-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <span>Registrasi</span>
                    </a>
                </li>

                {{-- Mekanik --}}
                {{-- <li class="sidebar-menu-item">
                <a href="{{ route('admin.register') }}"
                    class="sidebar-menu-link {{ request()->routeIs('admin.register') ? 'active' : '' }}">
                    <div class="sidebar-menu-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span>Registrasi</span>
                </a>
            </li> --}}
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
