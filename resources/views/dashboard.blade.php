<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Honda Service - Dashboard</title>

    <!-- Modern CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* Star rating */
        .star-rating {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 2px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            color: #d1d5db;
            transition: color 0.2s;
            font-size: 1.5rem;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #fbbf24;
        }

        .star-rating input:checked+label {
            color: #f59e0b;
        }
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
                    <span class="text-xl font-bold text-rose-700">Honda Service</span>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">Home</a>
                    <a href="#about"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">Tentang</a>
                    <a href="#services"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">Layanan</a>
                    <a href="#testimonials"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">Testimoni</a>
                    <a href="#contact"
                        class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">Kontak</a>
                </div>

                {{-- Auth Button --}}
                <div class="flex items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 shadow-md">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 shadow-md flex items-center">
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
                <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Tentang</a>
                <a href="#services" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Layanan</a>
                <a href="#testimonials"
                    class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Testimoni</a>
                <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Kontak</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-20 px-4 md:px-8 max-w-7xl mx-auto">
        <section id="home" class="py-12 md:py-20 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" id="about">
                {{-- Text Content --}}
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                        Layanan Servis <span class="text-rose-700">Terbaik</span> untuk Kendaraan Honda Anda
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Kami menyediakan berbagai layanan servis kendaraan Honda dengan teknisi berpengalaman dan
                        peralatan terbaru untuk menjaga performa optimal kendaraan Anda.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-calendar-check mr-2"></i> Jadwalkan Servis
                            </a>
                        @endauth
                        <a href="#services"
                            class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i> Lihat Layanan
                        </a>
                    </div>
                </div>

                {{-- Gambar slider --}}
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <div class="relative h-80 md:h-96 bg-gray-100">
                            <img id="slider-image" src="{{ asset('images/gambar(1).jpg') }}" alt="Honda Service"
                                class="high-quality-image w-full h-full object-cover transition-all duration-500 ease-in-out">

                            {{-- Navigasi panah --}}
                            {{-- <button id="prev-btn"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-md transition-all duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="next-btn"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-md transition-all duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </button> --}}

                            {{-- Navigasi dot --}}
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-all duration-200"
                                    data-index="0"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-all duration-200"
                                    data-index="1"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-all duration-200"
                                    data-index="2"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-all duration-200"
                                    data-index="3"></button>
                                <button
                                    class="slider-dot w-3 h-3 rounded-full bg-white/70 hover:bg-white transition-all duration-200"
                                    data-index="4"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Fitur section --}}
        <section id="services" class="py-16 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Unggulan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai layanan komprehensif untuk
                    menjaga performa kendaraan Honda Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-gear text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Servis Berkala</h3>
                    <p class="text-gray-600">Layanan rutin untuk menjaga performa dan keawetan kendaraan Anda</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Perbaikan Mesin</h3>
                    <p class="text-gray-600">Diagnosis dan perbaikan masalah mesin oleh teknisi berpengalaman</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-fan text-amber-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Service AC</h3>
                    <p class="text-gray-600">Perawatan dan perbaikan sistem AC untuk kenyamanan berkendara</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Kelistrikan</h3>
                    <p class="text-gray-600">Perbaikan dan pemeliharaan sistem kelistrikan kendaraan</p>
                </div>
            </div>
        </section>

        {{-- Testimoni --}}
        <section id="testimonials" class="py-16 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Apa Kata Pelanggan Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Lihat pengalaman langsung dari pelanggan yang telah
                    menggunakan layanan kami</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                {{-- Testimoni List --}}
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Testimoni Pelanggan</h3>

                    <div id="testimonials-container" class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                        {{-- Testimonial items will be loaded here --}}
                    </div>
                </div>

                {{-- Testimoni form --}}
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Beri Testimoni Anda</h3>

                    <form id="testimonial-form" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Masukkan nama Anda">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Masukkan email Anda">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5">★</label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4">★</label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3">★</label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2">★</label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1">★</label>
                            </div>
                        </div>

                        <div>
                            <label for="comment"
                                class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                            <textarea id="comment" name="comment" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                placeholder="Bagikan pengalaman Anda menggunakan layanan kami..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Testimoni
                        </button>
                    </form>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">Statistik Kepuasan Pelanggan</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2" id="total-testimonials">0</div>
                        <div class="text-gray-600">Total Testimoni</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2" id="average-rating">0.0</div>
                        <div class="text-gray-600">Rating Rata-rata</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600 mb-2" id="five-star-count">0</div>
                        <div class="text-gray-600">Bintang 5</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-rose-600 mb-2" id="recommendation-rate">0%</div>
                        <div class="text-gray-600">Rekomendasi</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Hero Section --}}
        <section class="py-16 animate-fade-in" style="animation-delay: 0.4s;">
            <div class="bg-gradient-to-r from-blue-600 to-rose-700 rounded-2xl p-8 md:p-12 text-white text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap untuk Servis Kendaraan Anda?</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto">Jadwalkan servis kendaraan Honda Anda sekarang dan dapatkan
                    pengalaman servis terbaik dengan garansi resmi</p>

                {{-- Login pada hero section --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-transparent border border-white hover:bg-white/10 px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <li><a href="#testimonials"
                                class="text-gray-400 hover:text-white transition-colors">Testimoni</a></li>
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

            {{-- <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 Honda Service. All rights reserved.</p>
            </div> --}}
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Image slider functionality
            const images = [
                '{{ asset('images/gambar(1).webp') }}',
                '{{ asset('images/gambar(2).webp') }}',
                '{{ asset('images/gambar(3).webp') }}',
                '{{ asset('images/gambar(4).webp') }}',
                '{{ asset('images/gambar(5).webp') }}',
                '{{ asset('images/gambar(6).webp') }}'
            ];

            const sliderImage = document.getElementById('slider-image');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentIndex = 0;
            let slideInterval;

            function showImage(index) {
                // Fade out current image
                sliderImage.style.opacity = '0';

                setTimeout(() => {
                    sliderImage.src = images[index];
                    sliderImage.alt = `Honda Service ${index + 1}`;

                    // Fade in new image
                    setTimeout(() => {
                        sliderImage.style.opacity = '1';
                    }, 50);
                }, 500);

                // Update active dot
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('bg-white/70');
                        dot.classList.add('bg-white');
                        dot.classList.add('w-4');
                    } else {
                        dot.classList.add('bg-white/70');
                        dot.classList.remove('bg-white');
                        dot.classList.remove('w-4');
                    }
                });

                currentIndex = index;
            }

            function nextImage() {
                const nextIndex = (currentIndex + 1) % images.length;
                showImage(nextIndex);
            }

            function prevImage() {
                const prevIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(prevIndex);
            }

            // Start automatic slideshow (change every 5 seconds)
            function startSlideshow() {
                slideInterval = setInterval(nextImage, 6000);
            }

            // Initialize
            showImage(0);
            startSlideshow();

            // Add click events to dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    showImage(index);
                    startSlideshow();
                });
            });

            // Add click events to navigation buttons
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    prevImage();
                    startSlideshow();
                });

                nextBtn.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    nextImage();
                    startSlideshow();
                });
            }

            // Pause on hover
            if (sliderImage && sliderImage.parentElement) {
                sliderImage.parentElement.addEventListener('mouseenter', () => {
                    clearInterval(slideInterval);
                });

                sliderImage.parentElement.addEventListener('mouseleave', () => {
                    startSlideshow();
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }

                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Testimonials functionality
            const testimonialsContainer = document.getElementById('testimonials-container');
            const testimonialForm = document.getElementById('testimonial-form');
            let testimonials = JSON.parse(localStorage.getItem('hondaTestimonials')) || [];

            // Sample testimonials for initial display
            if (testimonials.length === 0) {
                testimonials = [{
                        id: 1,
                        name: "Budi Santoso",
                        email: "budi.santoso@email.com",
                        rating: 5,
                        comment: "Pelayanan sangat memuaskan! Teknisi sangat profesional dan harga terjangkau. Mobil Honda Civic saya kembali seperti baru setelah servis di sini.",
                        date: "2023-10-15"
                    },
                    {
                        id: 2,
                        name: "Sari Dewi",
                        email: "sari.dewi@email.com",
                        rating: 4,
                        comment: "Proses servis cepat dan efisien. Staff sangat ramah dan menjelaskan setiap perbaikan dengan detail. Recommended!",
                        date: "2023-11-02"
                    },
                    {
                        id: 3,
                        name: "Ahmad Rizki",
                        email: "ahmad.rizki@email.com",
                        rating: 5,
                        comment: "Sudah 3 tahun servis di sini, selalu puas dengan hasilnya. Sparepart original dan garansi jelas. Terima kasih Honda Service!",
                        date: "2023-11-20"
                    }
                ];
                localStorage.setItem('hondaTestimonials', JSON.stringify(testimonials));
            }

            // Render testimonials
            function renderTestimonials() {
                testimonialsContainer.innerHTML = '';

                testimonials.sort((a, b) => new Date(b.date) - new Date(a.date))
                    .forEach(testimonial => {
                        const testimonialElement = document.createElement('div');
                        testimonialElement.className =
                            'bg-white rounded-xl p-6 shadow-lg border border-gray-100';
                        testimonialElement.innerHTML = `
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-semibold text-gray-800">${testimonial.name}</h4>
                                    <p class="text-sm text-gray-500">${new Date(testimonial.date).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div class="flex text-amber-500">
                                    ${'★'.repeat(testimonial.rating)}${'☆'.repeat(5 - testimonial.rating)}
                                </div>
                            </div>
                            <p class="text-gray-600">${testimonial.comment}</p>
                        `;
                        testimonialsContainer.appendChild(testimonialElement);
                    });

                updateStatistics();
            }

            // Update statistics
            function updateStatistics() {
                const totalTestimonials = testimonials.length;
                const averageRating = totalTestimonials > 0 ?
                    (testimonials.reduce((sum, t) => sum + t.rating, 0) / totalTestimonials).toFixed(1) :
                    '0.0';
                const fiveStarCount = testimonials.filter(t => t.rating === 5).length;
                const recommendationRate = totalTestimonials > 0 ?
                    Math.round((testimonials.filter(t => t.rating >= 4).length / totalTestimonials) * 100) :
                    0;

                document.getElementById('total-testimonials').textContent = totalTestimonials;
                document.getElementById('average-rating').textContent = averageRating;
                document.getElementById('five-star-count').textContent = fiveStarCount;
                document.getElementById('recommendation-rate').textContent = `${recommendationRate}%`;
            }

            // Handle form submission
            testimonialForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const name = formData.get('name');
                const email = formData.get('email');
                const rating = parseInt(formData.get('rating'));
                const comment = formData.get('comment');

                if (!rating) {
                    alert('Silakan beri rating terlebih dahulu');
                    return;
                }

                const newTestimonial = {
                    id: Date.now(),
                    name,
                    email,
                    rating,
                    comment,
                    date: new Date().toISOString().split('T')[0]
                };

                testimonials.push(newTestimonial);
                localStorage.setItem('hondaTestimonials', JSON.stringify(testimonials));

                renderTestimonials();
                testimonialForm.reset();

                // Reset star rating
                document.querySelectorAll('input[name="rating"]').forEach(radio => {
                    radio.checked = false;
                });

                // Show success notification
                if (typeof Notify !== 'undefined') {
                    new Notify({
                        status: 'success',
                        title: 'Berhasil',
                        text: 'Testimoni Anda telah berhasil dikirim!',
                        effect: 'slide',
                        speed: 300,
                        showCloseButton: true,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'right top'
                    });
                }
            });

            // Initialize testimonials
            renderTestimonials();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"
        integrity="sha256-5oyRx5pR3Tpi4tN9pTtnN5czAU1ElI2sUbaRQsxjAEY=" crossorigin="anonymous"></script>

    {{-- Notifikasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'success',
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
