<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Honda Service - Dashboard</title>

    
    <link href="<?php echo e(asset('images/honda.ico')); ?>" rel="icon" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- CRITICAL LOADING CSS --- */
        #loading-screen {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* Transisi dipercepat untuk feel yang lebih responsif */
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #main-wrapper {
            opacity: 0;
            visibility: hidden;
            /* Transisi muncul dipercepat */
            transition: opacity 0.4s ease-in-out;
        }

        #main-wrapper.is-ready {
            opacity: 1;
            visibility: visible;
        }

        .loader-logo {
            width: 80px;
            margin-bottom: 2rem;
            animation: pulseLogo 1.5s infinite ease-in-out;
        }

        @keyframes pulseLogo {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(0.92);
            }
        }

        .progress-container {
            width: 240px;
            text-align: center;
        }

        .progress-text {
            font-family: sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }

        .progress-bar-bg {
            height: 4px;
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 999px;
            overflow: hidden;
        }

        #progress-bar-fill {
            height: 100%;
            width: 0%;
            background-color: #ef4444;
            border-radius: 999px;
            /* Transisi bar dipercepat agar terasa lebih 'snappy' */
            transition: width 0.2s ease-out;
        }

        .loading-status {
            margin-top: 0.75rem;
            font-size: 0.75rem;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* --- PAGE STYLES --- */
        .glass {
            background: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        @keyframes infiniteScroll {
            from {
                transform: translate3d(0, 0, 0);
            }

            to {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .carousel-track {
            display: flex;
            width: max-content;
            animation: infiniteScroll 50s linear infinite;
            will-change: transform;
        }

        .carousel-container:hover .carousel-track {
            animation-play-state: paused;
        }

        .carousel-card {
            width: 300px;
            flex-shrink: 0;
            margin-right: 12px;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen">
    <!-- Modern Loading Screen -->
    <div id="loading-screen">
        <img src="<?php echo e(asset('images/honda.webp')); ?>" class="loader-logo" alt="Honda Logo">
        <div class="progress-container">
            <div class="progress-text">MEMUAT <span id="load-perc">0</span>%</div>
            <div class="progress-bar-bg">
                <div id="progress-bar-fill"></div>
            </div>
            <div class="loading-status" id="load-status">Menghubungkan...</div>
        </div>
    </div>

    <!-- Wrapper untuk seluruh konten -->
    <div id="main-wrapper">
        
        <nav class="glass fixed w-full z-50 top-0 start-0 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-3">
                        <img src="<?php echo e(asset('images/honda.webp')); ?>" class="h-10 w-auto" alt="Honda Logo">
                        <span class="text-lg md:text-xl font-bold text-red-500">Honda Service</span>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home"
                            class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Home</a>
                        <a href="#about"
                            class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Tentang</a>
                        <a href="#services"
                            class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Layanan</a>
                        <a href="#contact"
                            class="text-gray-700 hover:text-rose-700 font-medium transition-colors duration-200">Kontak</a>
                    </div>

                    <div class="flex items-center">
                        <a href="<?php echo e(route('login')); ?>"
                            class="bg-red-600 hover:bg-red-700 text-white text-[14px] md:text-sm px-4 py-2 md:px-5 md:py-2 rounded-lg font-medium transition-colors duration-200 shadow-md flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="pt-16 lg:pt-1">
            <section id="home" class="relative py-16 md:py-32 rounded-b-3xl overflow-hidden bg-cover bg-center"
                style="background-image: url('<?php echo e(asset('images/gambar_smk.webp')); ?>');">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center px-8 md:px-16" id="about">
                    <div class="space-y-6">
                        <h1 class="text-3xl md:text-6xl font-bold text-white leading-tight">
                            Layanan Servis <span class="text-red-500">Terbaik</span> untuk Kendaraan Honda Anda
                        </h1>
                        <p class="text-[15px] md:text-[20px] text-gray-200 leading-relaxed max-w-xl">
                            Kami menyediakan berbagai layanan servis kendaraan Honda dengan teknisi berpengalaman dan
                            peralatan terbaru.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(url('/dashboard')); ?>"
                                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg flex items-center justify-center">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Saya
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>"
                                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-check mr-2"></i> Jadwalkan Servis
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <a href="#services"
                                class="border border-white text-white hover:bg-white/10 px-8 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-list mr-2"></i> Lihat Layanan
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="services" class="py-12">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Unggulan Kami</h2>
                    <p class="text-md md:text-lg text-gray-600 mx-auto">Kami menyediakan berbagai layanan untuk menjaga
                        performa kendaraan Honda Anda</p>
                </div>
                <div class="carousel-container relative w-full overflow-hidden">
                    <div id="services-track" class="carousel-track flex gap-6 px-4">
                        <!-- Cards will be injected by JS -->
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-12">
            <div class=" px-4 sm:px-12 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            
                            <span class="text-xl font-bold text-white">Honda Service</span>
                        </div>
                        <p class="text-gray-400">Layanan servis terpercaya untuk kendaraan Honda Anda dengan teknisi
                            berpengalaman dan peralatan terbaru.</p>
                    </div>

                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2">
                            <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Tentang
                                    Kami</a></li>
                            <li><a href="#services" class="text-gray-400 hover:text-white transition-colors">Layanan</a>
                            </li>
                            
                            <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Kontak</a>
                            </li>
                        </ul>
                    </div>

                    
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

                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>© Bengkel SMK 9 Malang. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        /**
         * OPTIMIZED LOADING LOGIC
         * Fokus pada kecepatan eksekusi tanpa mengorbankan rendering visual.
         */
        (function () {
            const loadingScreen = document.getElementById('loading-screen');
            const mainWrapper = document.getElementById('main-wrapper');
            const progressBar = document.getElementById('progress-bar-fill');
            const progressText = document.getElementById('load-perc');
            const statusText = document.getElementById('load-status');

            const imgBase = "<?php echo e(asset('images')); ?>/";
            const servicesData = [
                { img: 'IMG-20230816-WA0129.webp', title: 'Servis Berkala', desc: 'Layanan rutin untuk menjaga performa.' },
                { img: 'siswa-honda.webp', title: 'Perbaikan Mesin', desc: 'Diagnosis dan perbaikan masalah mesin.' },
                { img: 'service-ac.webp', title: 'Service AC', desc: 'Perawatan sistem AC kendaraan.' },
                { img: 'listrik.webp', title: 'Kelistrikan', desc: 'Pemeliharaan sistem kelistrikan.' },
                { img: 'sip.webp', title: 'Harga Terjangkau', desc: 'Layanan berkualitas dengan biaya bersahabat.' },
                { img: 'suku_cadang.webp', title: 'Suku Cadang Asli', desc: 'Menggunakan suku cadang resmi Honda.' },
            ];

            // 1. Segera render carousel agar elemen siap di DOM
            const track = document.getElementById('services-track');
            if (track) {
                const createCard = (data) => `
                    <div class="carousel-card relative overflow-hidden rounded-xl p-6 shadow-lg min-h-[250px] flex flex-col justify-end group">
                        <div class="absolute inset-0 z-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                             style="background-image: url('${imgBase}${data.img}');">
                        </div>
                        <div class="absolute inset-0 z-10 bg-black/40 transition-colors duration-500"></div>
                        <div class="relative z-20">
                            <h3 class="text-xl font-semibold text-white mb-2">${data.title}</h3>
                            <p class="text-gray-100 text-sm">${data.desc}</p>
                        </div>
                    </div>
                `;
                track.innerHTML = servicesData.map(s => createCard(s)).join('') + servicesData.map(s => createCard(s)).join('');
            }

            // 2. Kumpulkan aset krusial saja (Hero image & Logo)
            const criticalAssets = [
                "<?php echo e(asset('images/honda.webp')); ?>",
                "<?php echo e(asset('images/gambar_smk.webp')); ?>"
            ];

            let loadedCount = 0;
            const totalToLoad = criticalAssets.length;

            async function startFastPreload() {
                if (totalToLoad === 0) return finishLoading();

                // Gunakan Promise.all untuk eksekusi paralel maksimal
                await Promise.all(criticalAssets.map(src => {
                    return new Promise((resolve) => {
                        const img = new Image();
                        img.onload = async () => {
                            try {
                                if ('decode' in img) await img.decode();
                                updateProgress();
                                resolve();
                            } catch (e) {
                                updateProgress();
                                resolve();
                            }
                        };
                        img.onerror = () => {
                            updateProgress();
                            resolve();
                        };
                        img.src = src;
                    });
                }));

                // Setelah aset krusial selesai, langsung selesaikan
                finishLoading();
            }

            function updateProgress() {
                loadedCount++;
                const percentage = Math.round((loadedCount / totalToLoad) * 100);
                progressBar.style.width = percentage + '%';
                progressText.innerText = percentage;
                if (percentage > 50) statusText.innerText = "Menyiapkan...";
            }

            function finishLoading() {
                // Gunakan requestAnimationFrame ganda untuk memastikan cat pertama selesai
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        statusText.innerText = "Siap";
                        mainWrapper.classList.add('is-ready');

                        // Jeda minimal agar transisi terasa halus (dikurangi dari 800ms ke 200ms)
                        setTimeout(() => {
                            loadingScreen.style.opacity = "0";
                            setTimeout(() => {
                                loadingScreen.style.display = "none";
                            }, 400);
                        }, 200);
                    });
                });
            }

            // Jalankan Preload
            startFastPreload();

            // Fallback Keamanan (dikurangi ke 10 detik)
            setTimeout(() => {
                if (loadingScreen.style.display !== "none") finishLoading();
            }, 10000);
        })();
    </script>
</body>

</html><?php /**PATH D:\Dokumen Sekolah 12\PKL\upj_tsm_k9\resources\views/welcome.blade.php ENDPATH**/ ?>