<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Honda Service</title>
    {{-- Remix Icon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 90vh;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background-image: url('{{ asset("images/cbr.webp") }}');
            background-size: cover;
            background-position: bottom;
            background-repeat: no-repeat;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0;
            position: relative;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .logo {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .logo h1 {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .logo span {
            font-size: 14px;
            letter-spacing: 2px;
            opacity: 0.9;
        }

        .motor-image {
            display: none;
        }

        .motor-image img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
        }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
        }

        .form-wrapper {
            width: 100%;
            max-width: 360px;
        }

        .form-wrapper h2 {
            font-size: 32px;
            font-weight: 700;
            color: #b30000;
            margin-bottom: 24px;
        }

        .input-box {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 1px solid #f0f0f0;
            background: #fdfdfd;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s;

            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            border: 1px solid #f0f0f0;

            position: relative;
            z-index: 1;
        }

        /* Update bagian ini di login.blade.php */
        .input-box input:focus {
            background: #fff;
            /* transform: translateY(-2px); <--- Hapus atau komentari baris ini */
            box-shadow: 0 10px 20px rgba(179, 0, 0, 0.05);
            outline: none;
            /* Tambahkan ini agar tidak ada garis biru default browser */
            border-color: #b30000;
            /* Opsional: beri warna border sedikit merah saat diklik */
        }

        .input-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #b30000;
            font-size: 18px;
            z-index: 2;
            transition: all;
        }

        .input-box input:focus+i {
            color: #ff0000;
        }

        /* Update bagian ini di login.blade.php */
        #togglePassword {
            position: absolute;
            left: auto;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #b30000;
            font-size: 18px;
            z-index: 3;
            transition: color 0.3s;
        }

        #togglePassword:hover {
            color: #8b0000;
        }

        .remember-box {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding-left: 5px;
        }

        .remember-box input {
            margin-right: 10px;
            accent-color: #b30000;
            transform: scale(1.2);
        }

        .remember-box label {
            color: #333;
            font-size: 14px;
        }

        .btnn {
            width: 100%;
            padding: 14px;
            background: #b30000;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(179, 0, 0, 0.2);
        }

        .btnn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(179, 0, 0, 0.3);
        }

        .text-center {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .text-center a {
            color: #b30000;
            text-decoration: underline;
            font-weight: 600;
        }

        .alert-danger {
            background: #ffe6e6;
            border: 1px solid #b30000;
            color: #b30000;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .right-panel {
            position: relative;
            overflow: hidden;
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(179, 0, 0, 0.03) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-wrapper>* {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        /* Berikan delay agar muncul bergantian */
        .form-wrapper h2 {
            animation-delay: 0.1s;
        }

        .form-wrapper .input-box:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-wrapper .input-box:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-wrapper .btnn {
            animation-delay: 0.4s;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .right-panel::before {
            content: "";
            position: absolute;
            top: -120px;
            right: -120px;
            width: 450px;
            height: 450px;
            /* Opasitas dinaikkan ke 0.1 (10%) agar lebih kelihatan */
            background: radial-gradient(circle, rgba(179, 0, 0, 0.1) 0%, rgba(179, 0, 0, 0.05) 40%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        /* Lingkaran Bawah: Lebih tegas */
        .right-panel::after {
            content: "";
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 550px;
            height: 550px;
            /* Menggunakan opasitas yang lebih kuat di pusatnya */
            background: radial-gradient(circle, rgba(179, 0, 0, 0.12) 0%, rgba(179, 0, 0, 0.06) 40%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .form-wrapper {
            position: relative;
            z-index: 1;
            /* Pastikan form berada di atas dekorasi */
            width: 100%;
            max-width: 360px;
            z-index: 5;
        }

        /* Update CSS di login.blade.php */

        @media (max-width: 768px) {
            body {
                padding: 20px;
                background: #000;
            }

            .login-container {
                flex-direction: column;
                height: auto;
                min-height: 90vh;
                background: transparent;
                /* Container utama jadi transparan */
                box-shadow: none;
            }

            .left-panel {
                position: fixed;
                /* Gambar motor mengunci di belakang */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                /* Berada di paling belakang sebagai BG */
                border-radius: 0;
            }

            .left-panel::before {
                background: rgba(0, 0, 0, 0.6);
            }

            .right-panel {
                background: transparent;
                /* Panel form jadi transparan agar BG motor kelihatan */
                padding: 30px 20px;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .form-wrapper {
                background: rgba(255, 255, 255, 0.9);
                /* Form diberi background putih transparan (Glassmorphism) */
                padding: 30px;
                border-radius: 24px;
                backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                width: 100%;
            }

            /* Hilangkan bulatan dekorasi di mobile agar tidak mengganggu background motor */
            .right-panel::before,
            .right-panel::after {
                display: none;
            }

            .logo {
                margin-bottom: 30px;
                position: relative;
                top: 20px;
            }
        }

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
    </style>
</head>

<body>

    {{-- Loading --}}
    <div id="loading-screen">
        <img src="{{ asset('images/honda.webp') }}" class="loader-logo" alt="Honda Logo">
        <div class="progress-container">
            <div class="progress-text">MEMUAT <span id="load-perc">0</span>%</div>
            <div class="progress-bar-bg">
                <div id="progress-bar-fill"></div>
            </div>
            <div class="loading-status" id="load-status">Menghubungkan...</div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="login-container">
        </div>
    </div>

    {{-- Logo login --}}
    <div class="login-container">
        {{-- KIRI: LOGO --}}
        <div class="left-panel">
            <div class="logo">
                <h1>HONDA</h1>
                <span>The Power of Dreams</span>
            </div>
        </div>

        {{-- Login --}}
        {{-- KANAN: FORM LOGIN --}}
        <div class="right-panel">
            <div class="form-wrapper">
                @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <h2>Welcome Back</h2>
                    <div class="input-box">
                        <i class="ri-user-fill"></i>
                        <input type="text" name="login" id="login" placeholder="Nama Atau Email" required autofocus>
                    </div>

                    <div class="input-box">
                        <i class="ri-lock-fill"></i>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <i class="ri-eye-off-fill" id="togglePassword"></i>
                    </div>

                    <div class="remember-box">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btnn">Masuk</button>

                    <p class="text-center">
                        Belum punya akun? <a href="{{ route('public.register') }}">Daftar Sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const loadingScreen = document.getElementById('loading-screen');
            const mainWrapper = document.getElementById('main-wrapper');
            const progressBar = document.getElementById('progress-bar-fill');
            const progressText = document.getElementById('load-perc');
            const statusText = document.getElementById('load-status');

            // Hanya kumpulkan aset yang benar-benar ada di halaman login
            const criticalAssets = [
                "{{ asset('images/honda.webp') }}",
                "{{ asset('images/cbr.webp') }}" // Gambar motor CBR sebagai background
            ];

            let loadedCount = 0;
            const totalToLoad = criticalAssets.length;

            async function startFastPreload() {
                if (totalToLoad === 0) return finishLoading();

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

                finishLoading();
            }

            function updateProgress() {
                loadedCount++;
                const percentage = Math.round((loadedCount / totalToLoad) * 100);
                if (progressBar) progressBar.style.width = percentage + '%';
                if (progressText) progressText.innerText = percentage;
                if (percentage > 50 && statusText) statusText.innerText = "Menyiapkan...";
            }

            function finishLoading() {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        if (statusText) statusText.innerText = "Siap";
                        if (mainWrapper) mainWrapper.classList.add('is-ready');

                        setTimeout(() => {
                            if (loadingScreen) {
                                loadingScreen.style.opacity = "0";
                                setTimeout(() => {
                                    loadingScreen.style.display = "none";
                                }, 400);
                            }
                        }, 200);
                    });
                });
            }

            startFastPreload();

            // Fallback jika ada kendala koneksi
            setTimeout(() => {
                if (loadingScreen && loadingScreen.style.display !== "none") finishLoading();
            }, 5000);
        })();

        // Script Toggle Password tetap di bawah
        const input = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');
        toggle.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            toggle.classList.toggle('ri-eye-off-fill', !isPassword);
            toggle.classList.toggle('ri-eye-fill', isPassword);
        });
    </script>
</body>

</html>