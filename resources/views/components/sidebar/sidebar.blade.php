<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    /* Sidebar Modern dengan Glass Morphism */
    .sidebar-container {
        width: 280px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        height: 100vh;
        padding: 20px 0;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 0 15px;
    }

    .sidebar-header {
        padding: 0 15px 25px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-logo {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .sidebar-logo:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .sidebar-logo img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .sidebar-logo-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #B10000;
        flex: 1;
    }

    .sidebar-user-info {
        font-size: 0.85rem;
        color: #666;
        margin-top: 2px;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .sidebar-menu-item {
        margin-bottom: 8px;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        color: #555;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .sidebar-menu-link:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: #B10000;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .sidebar-menu-link:hover {
        color: #B10000;
        background: rgba(177, 0, 0, 0.08);
        transform: translateX(5px);
    }

    .sidebar-menu-link:hover:before {
        transform: scaleY(1);
    }

    .sidebar-menu-link.active {
        color: #B10000;
        background: rgba(177, 0, 0, 0.12);
        font-weight: 600;
    }

    .sidebar-menu-link.active:before {
        transform: scaleY(1);
    }

    .sidebar-menu-icon {
        margin-right: 14px;
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .sidebar-menu-link:hover .sidebar-menu-icon {
        transform: scale(1.1);
    }

    .sidebar-menu-text {
        font-size: 0.95rem;
        font-weight: 500;
        flex: 1;
    }

    .sidebar-menu-badge {
        margin-left: auto;
        color: white;
        font-size: 0.7rem;
        padding: 6px 10px;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(177, 0, 0, 0.3);
        animation: pulse 2s infinite;
        min-width: 24px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #B10000 0%, #8B0000 100%);
    }

    .sidebar-menu-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(177, 0, 0, 0.4);
    }

    /* Badge untuk Customer NEW (Hijau) */
    .new-customer-badge {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        animation: newPulse 1.5s infinite;
        font-size: 0.65rem;
        padding: 6px 10px;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .customer-badge-hidden {
        opacity: 0;
        transform: scale(0);
        display: none !important;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(177, 0, 0, 0.4);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(177, 0, 0, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(177, 0, 0, 0);
        }
    }

    @keyframes newPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.2);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            transform: scale(1);
        }
    }

    .sidebar-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
        margin: 20px 0;
    }

    .sidebar-label {
        padding: 12px 16px 8px;
        font-size: 0.75rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* Toggle Button Modern */
    .sidebar-toggle-btn {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1001;
    }

    .sidebar-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 1);
    }

    .sidebar-toggle-btn span {
        display: block;
        width: 22px;
        height: 2px;
        background: #333;
        position: relative;
        transition: all 0.3s ease;
    }

    .sidebar-toggle-btn span:before,
    .sidebar-toggle-btn span:after {
        content: '';
        position: absolute;
        width: 22px;
        height: 2px;
        background: #333;
        transition: all 0.3s ease;
    }

    .sidebar-toggle-btn span:before {
        top: -6px;
    }

    .sidebar-toggle-btn span:after {
        top: 6px;
    }

    .sidebar-toggle-btn.active span {
        background: transparent;
    }

    .sidebar-toggle-btn.active span:before {
        transform: rotate(45deg);
        top: 0;
    }

    .sidebar-toggle-btn.active span:after {
        transform: rotate(-45deg);
        top: 0;
    }

    /* Logout Section Modern */
    .sidebar-logout {
        padding: 15px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        margin-top: auto;
        flex-shrink: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
        position: relative;
        overflow: hidden;
    }

    .logout-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .logout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4);
    }

    .logout-btn:hover:before {
        left: 100%;
    }

    .logout-icon {
        margin-right: 10px;
        font-size: 1rem;
    }

    /* Main Content */
    .main-content-with-sidebar {
        margin-left: 280px;
        padding: 20px;
        transition: margin-left 0.3s ease;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    /* Scrollbar Styling */
    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-content::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 3px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(177, 0, 0, 0.3);
        border-radius: 3px;
    }

    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(177, 0, 0, 0.5);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar-container {
            width: 260px;
        }

        .main-content-with-sidebar {
            margin-left: 260px;
        }
    }

    @media (max-width: 768px) {
        .sidebar-container {
            transform: translateX(-100%);
            width: 280px;
        }

        .sidebar-container.active {
            transform: translateX(0);
            box-shadow: 0 0 0 100vmax rgba(0, 0, 0, 0.5);
        }

        .main-content-with-sidebar {
            margin-left: 0;
            padding: 70px 15px 15px;
        }

        .sidebar-toggle-btn {
            display: flex;
        }

        .sidebar-toggle-btn.active {
            left: 300px;
        }
    }

    /* Animation for sidebar items */
    .sidebar-menu-item {
        opacity: 0;
        transform: translateX(-20px);
        animation: slideInLeft 0.5s ease forwards;
    }

    .sidebar-menu-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .sidebar-menu-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .sidebar-menu-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .sidebar-menu-item:nth-child(4) {
        animation-delay: 0.4s;
    }

    .sidebar-menu-item:nth-child(5) {
        animation-delay: 0.5s;
    }

    .sidebar-menu-item:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<!-- Sidebar Structure -->
<aside class="sidebar-container" id="sidebar">
    <!-- Content Area (bisa scroll) -->
    <div class="sidebar-content">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('/images/honda.png') }}" alt="Honda Logo">
                </a>
            </div>
            <div>
                <div class="sidebar-logo-text">Honda Service</div>
                <div class="sidebar-user-info">{{ Auth::User()->name }}</div>
            </div>
        </div>

        <ul class="sidebar-menu">
            {{-- Dashboard --}}
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="sidebar-menu-icon">
                        <i class="fa-solid fa-house"></i>
                    </i>
                    <span class="sidebar-menu-text">Dashboard</span>
                </a>
            </li>

            {{-- Booking --}}
            <li class="sidebar-menu-item">
                <a href="{{ route('booking.index') }}"
                    class="sidebar-menu-link {{ request()->routeIs('booking.*') ? 'active' : '' }}">
                    <i class="sidebar-menu-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </i>
                    <span class="sidebar-menu-text">Booking</span>
                    @php
                        $pendingCount = \App\Models\Booking::where('status', 'pending')->count();
                    @endphp

                    @if ($pendingCount > 0)
                        <span class="sidebar-menu-badge">
                            {{ $pendingCount }} Pending
                        </span>
                    @endif
                </a>
            </li>

            {{-- Customers --}}
            <li class="sidebar-menu-item">
                <a href="{{ route('customers.index') }}"
                    class="sidebar-menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                    id="customers-menu-link">
                    <i class="sidebar-menu-icon">
                        <i class="fa-solid fa-users"></i>
                    </i>
                    <span class="sidebar-menu-text">Customers</span>
                </a>
            </li>

            {{-- Registrasi --}}
            <li class="sidebar-divider"></li>
            <li class="sidebar-label">Buat Akun Baru</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('register') }}"
                    class="sidebar-menu-link {{ request()->routeIs('register') ? 'active' : '' }}">
                    <i class="sidebar-menu-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </i>
                    <span class="sidebar-menu-text">Registrasi</span>
                </a>
            </li>

            {{-- Advisor --}}
            <li class="sidebar-divider"></li>
            <li class="sidebar-label">Advisor</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('advisor.create') }}"
                    class="sidebar-menu-link {{ request()->routeIs('advisor.*') ? 'active' : '' }}">
                    <i class="sidebar-menu-icon">
                        <i class="fa-solid fa-user-secret"></i>
                    </i>
                    <span class="sidebar-menu-text">Create Advisor</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Logout Section -->
    <div class="sidebar-logout">
        <a class="logout-btn" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="logout-icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </i>
            Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
            @csrf
        </form>
    </div>
</aside>

<!-- Toggle Button (Hanya untuk mobile) -->
<button class="sidebar-toggle-btn" id="sidebar-toggle">
    <span></span>
</button>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerBadge = document.getElementById('customer-badge');
        const customersLink = document.getElementById('customers-menu-link');

        // If badge still exists and should be hidden
        if (customerBadge && (sessionStorage.getItem('customersVisited') || window.customerBadgeHidden)) {
            customerBadge.remove(); // Remove from DOM completely
        }

        if (customersLink) {
            customersLink.addEventListener('click', function() {
                // Remove badge immediately
                const badge = document.getElementById('customer-badge');
                if (badge) badge.remove();

                // Set storage
                sessionStorage.setItem('customersVisited', 'true');
            });
        }

        // Enhanced Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const mainContent = document.querySelector('.main-content-with-sidebar');

        function handleResize() {
            if (window.innerWidth > 768) {
                sidebar.classList.add('active');
                toggleBtn.style.display = 'none';
                toggleBtn.classList.remove('active');
                if (mainContent) mainContent.style.marginLeft = '280px';
            } else {
                sidebar.classList.remove('active');
                toggleBtn.style.display = 'flex';
                if (mainContent) mainContent.style.marginLeft = '0';
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                toggleBtn.classList.toggle('active');

                if (window.innerWidth <= 768) {
                    if (mainContent) {
                        mainContent.style.marginLeft = sidebar.classList.contains('active') ? '0' : '0';
                    }
                }
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                    toggleBtn.classList.remove('active');
                }
            }
        });

        window.addEventListener('resize', handleResize);
        handleResize();

        // Add active class based on current URL
        function setActiveMenu() {
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.sidebar-menu-link');

            menuLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        }

        setActiveMenu();
    });
</script>
