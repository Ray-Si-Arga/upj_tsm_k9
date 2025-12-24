<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Honda Service - Dashboard</title>

    {{-- Favicon --}}
    <link
        href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAARQrEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEREREAEREREBEREAABEREAAREAAAAREAABEQAAABEQAAERERERERAAAREREREREAABEREREREQAAERAAAAERAAAREAAAAREAARERAAARERAREREQAREREQAAAAAAAAAAAAAAAAAAAAD//wAA//8AAP//AAABgAAAg8EAAMfjAADH4wAAwAMAAMADAADAAwAAx+MAAMfjAACDwQAAAYAAAP//AAD//wAA"
        rel="icon" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

    <style>
        .high-quality-image {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: high-quality;
            /* image-rendering: pixelated; */
            -ms-interpolation-mode: nearest-neighbor;
        }

        /* Custom animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Custom gradient */
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Catatan: Semua CSS yang berhubungan dengan .star-rating, .testimonial-slide telah dihapus. */
    </style>
</head>

<body class="gradient-bg min-h-screen">
    {{-- Navbar Modern --}}
    <nav class="glass fixed w-full z-50 top-0 start-0 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/honda.webp') }}" class="h-10 w-auto" alt="Honda Logo">
                    <span class="text-xl font-bold text-red-500">Honda Service</span>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Home</a>
                    <a href="#about"
                        class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Tentang</a>
                    <a href="#services"
                        class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Layanan</a>
                    {{-- Tautan Testimoni Dihapus --}}
                    <a href="#contact"
                        class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Kontak</a>
                </div>

                {{-- Auth Button --}}
                <div class="flex items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-red-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 shadow-md">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 shadow-md flex items-center">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </a>
                        @endauth
                    @endif

                    {{-- Mobile menu button --}}
                    <button id="mobile-menu-button" class="md:hidden ml-4 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden hidden glass border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-rose-700 font-medium">Home</a>
                <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-rose-700 font-medium">Tentang</a>
                <a href="#services" class="block px-3 py-2 text-gray-700 hover:text-rose-700 font-medium">Layanan</a>
                {{-- Tautan Testimoni Dihapus --}}
                <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-rose-700 font-medium">Kontak</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-12 px-4 md:px-8  mx-auto">
        <section id="home" class="py-12 md:py-20 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" id="about">
                {{-- Text Content --}}
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                        Layanan Servis <span class="text-red-700">Terbaik</span> untuk Kendaraan Honda Anda
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Kami menyediakan berbagai layanan servis kendaraan Honda dengan teknisi berpengalaman dan
                        peralatan terbaru untuk menjaga performa optimal kendaraan Anda.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-calendar-check mr-2"></i> Jadwalkan Servis
                            </a>
                        @endauth
                        <a href="#services"
                            class="border border-red-600 text-red-600 hover:bg-white-50 px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i> Lihat Layanan
                        </a>
                    </div>
                </div>

                {{-- Gambar --}}
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <div class="relative h-80 md:h-96 bg-gray-100">
                            {{-- Ganti dengan path gambar yang benar --}}
                            <img id="slider-image" src="{{ asset('images\gambar_smk.webp') }}" alt="Honda Service"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Fitur section --}}
        <section id="services" class="py-12 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Unggulan Kami</h2>
                <p class="text-lg text-gray-600  mx-auto">Kami menyediakan berbagai layanan untuk
                    menjaga performa kendaraan Honda Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-gear text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Servis Berkala</h3>
                    <p class="text-gray-600">Layanan rutin untuk menjaga performa dan keawetan kendaraan Anda</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Perbaikan Mesin</h3>
                    <p class="text-gray-600">Diagnosis dan perbaikan masalah mesin oleh teknisi berpengalaman</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-fan text-amber-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Service AC</h3>
                    <p class="text-gray-600">Perawatan dan perbaikan sistem AC untuk kenyamanan berkendara</p>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Kelistrikan</h3>
                    <p class="text-gray-600">Perbaikan dan pemeliharaan sistem kelistrikan kendaraan</p>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-12">
        <div class=" px-4 sm:px-12 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        {{-- <img src="{{ asset('images/honda.webp') }}" class="h-8" alt="Honda Logo"> --}}
                        <span class="text-xl font-bold text-white">Honda Service</span>
                    </div>
                    <p class="text-gray-400">Layanan servis terpercaya untuk kendaraan Honda Anda dengan teknisi
                        berpengalaman dan peralatan terbaru.</p>
                </div>

                {{-- Tautan cepat footer --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors">Layanan</a>
                        </li>
                        {{-- Tautan Testimoni Dihapus --}}
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Kontak</a>
                        </li>
                    </ul>
                </div>

                {{-- layanan footer --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Servis
                                Berkala</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Perbaikan
                                Mesin</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Ganti Oli</a>
                        </li>
                        <li><a href="" class="text-gray-400 hover:text-white transition-colors">Service AC</a>
                        </li>
                    </ul>
                </div>

                {{-- Kontak footer --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4" id="contact">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            {{-- Ganti dengan link Google Maps yang benar --}}
                            <a href="https://maps.app.goo.gl/m4q7kribgzw3UUC56" class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-3"></i>Kedungkandang, Kota Malang
                            </a>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-phone mr-3"></i> (034) 1727998
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-envelope mr-3"></i> info@hondaservice.com
                        </li>
                    </ul>
                </div>
            </div>

            {{-- C Copyright --}}
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>© 2023 Honda Service. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika JavaScript untuk Testimoni dan Slider TELAH DIHAPUS SEPENUHNYA.
            // Hanya menyisakan logika umum seperti Mobile Menu (jika ada)

            // Logika untuk Mobile Menu
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"
        integrity="sha256-5oyRx5pR3Tpi4tN9pTtnN5czAU1ElI2sUbaRQsxjAEY=" crossorigin="anonymous"></script>

    {{-- Notifikasi (Dibiarkan untuk kebutuhan Laravel/Blade) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'info',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'right top'
                });
            @endif

            @if (Session::has('error'))
                new Notify({
                    status: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 5000,
                    position: 'right top'
                });
            @endif
        });
    </script>
</body>

</html>
