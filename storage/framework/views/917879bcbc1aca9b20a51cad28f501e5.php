<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Honda Service</title>
    
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

        /* --- LOADING SCREEN CSS --- */

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
            transition: opacity 0.6s ease-in-out, visibility 0.6s;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        #main-wrapper.is-ready {
            opacity: 1 !important;
            visibility: visible !important;
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

        /* --- LAYOUT CSS --- */
        .register-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 90vh;
            background: white;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* TUKAR POSISI: Form di Kiri, Gambar di Kanan */
            flex-direction: row;
        }

        /* Form di Sisi Kiri */
        .left-panel-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        /* Gambar di Sisi Kanan */
        .right-panel-image {
            flex: 1;
            background-image: url('<?php echo e(asset("images/cbr-1000rr.webp")); ?>');
            background-size: cover;
            background-position: bottom 1px center;
            background-repeat: no-repeat;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .right-panel-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        /* Bulatan Dekoratif di Panel Form (Kiri) */
        .left-panel-form::before {
            content: "";
            position: absolute;
            top: -120px;
            left: -120px;
            /* Di kiri atas */
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(179, 0, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .left-panel-form::after {
            content: "";
            position: absolute;
            bottom: -150px;
            right: -150px;
            /* Di kanan bawah */
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(179, 0, 0, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .form-wrapper {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 380px;
        }

        .form-wrapper h2 {
            color: #b30000;
        }

        .logo-text {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .logo-text h1 {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: 4px;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        p.welcome-text {
            color: #b30000;
            margin-bottom: 30px;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
        }

        .input-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #b30000;
            font-size: 18px;
            z-index: 2;
        }

        .input-box input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            font-size: 15px;
            transition: all 0.3s;
        }

        .input-box input:focus {
            border-color: #b30000;
            box-shadow: 0 10px 20px rgba(179, 0, 0, 0.05);
            outline: none;
        }

        #togglePassword,
        #toggleConfirmPassword {
            left: auto;
            right: 20px;
            cursor: pointer;
            color: #b30000;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: #b30000;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(179, 0, 0, 0.2);
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #8b0000;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #b30000;
            text-decoration: none;
            font-weight: 600;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding: 20px;
                background: #000;
                /* Dasar hitam agar gambar motor lebih kontras */
            }

            .register-container {
                flex-direction: column;
                height: auto;
                min-height: 90vh;
                background: transparent;
                box-shadow: none;
            }

            .right-panel-image {
                position: fixed;
                /* Gambar motor mengunci di background */
                inset: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                border-radius: 0;
            }

            .left-panel-form {
                background: transparent;
                /* Panel utama transparan */
                padding: 20px 10px;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* EFEK GLASS PADA FORM */
            .form-wrapper {
                background: rgba(255, 255, 255, 0.85);
                /* Putih transparan */
                padding: 35px 25px;
                border-radius: 28px;

                /* Kunci Efek Glassmorphism */
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                /* Support Safari */

                border: 1px solid rgba(255, 255, 255, 0.3);
                /* Border tipis agar terlihat seperti kaca */
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 400px;
            }

            /* Sembunyikan bulatan dekorasi agar tidak bertabrakan dengan gambar motor */
            .left-panel-form::before,
            .left-panel-form::after {
                display: none;
            }

            .logo-text {
                margin-bottom: 20px;
                position: relative;
            }
        }
    </style>
</head>

<body>
    
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


    
    <div id="main-wrapper">
        <div class="register-container">
            <div class="left-panel-form">
                <div class="form-wrapper">
                    <h2>Daftar Akun</h2>
                    <p class="welcome-text">Mulai pengalaman servis terbaik Anda.</p>

                    <form action="<?php echo e(route('public.register.post')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        
                        <div class="input-box">
                            <i class="ri-user-fill"></i>
                            <input type="text" name="name" placeholder="Nama Lengkap" value="<?php echo e(old('name')); ?>" required autofocus>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: red; font-size: 12px; margin-top: 5px">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="input-box">
                            <i class="ri-mail-fill"></i>
                            <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: red; font-size: 12px; margin-top: 5px">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="input-box">
                            <i class="ri-phone-fill"></i>
                            <input type="tel" name="phone" placeholder="Nomor Telepon" value="<?php echo e(old('phone')); ?>" required>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: red; font-size: 12px; margin-top: 5px">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        
                        <div class="input-box">
                            <i class="ri-lock-fill"></i>
                            <input type="password" name="password" id="password" placeholder="Password"  required>
                            <i class="ri-eye-off-fill" id="togglePassword"></i>
                        </div>

                        <div class="input-box">
                            <i class="ri-check-double-line"></i>
                            <input type="password" name="password_confirmation" id="confirm_password"
                                placeholder="Konfirmasi Password" required>
                            <i class="ri-eye-off-fill" id="toggleConfirmPassword"></i>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #b30000; font-size: 12px; margin-top: 5px">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <input type="hidden" name="role" value="customer">
                        <button type="submit" class="btn-register">Buat Akun Sekarang</button>
                    </form>

                    <div class="login-link">
                        Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Masuk</a>
                    </div>
                </div>
            </div>

            <div class="right-panel-image">
                <div class="logo-text">
                    <h1>HONDA</h1>
                    <p>The Power of Dreams</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ganti blok script loading kamu dengan ini
        (function () {
            const loadingScreen = document.getElementById('loading-screen');
            const mainWrapper = document.getElementById('main-wrapper');
            const progressBar = document.getElementById('progress-bar-fill');
            const progressText = document.getElementById('load-perc');
            const statusText = document.getElementById('load-status');
            const hasErrors = <?php echo e($errors->any() ? 'true' : 'false'); ?>;

            // Hanya kumpulkan aset yang benar-benar ada di halaman login
            const criticalAssets = [
                "<?php echo e(asset('images/honda.webp')); ?>",
                "<?php echo e(asset('images/cbr.webp')); ?>" // Gambar motor CBR sebagai background
            ];

            let loadedCount = 0;
            const totalToLoad = criticalAssets.length;

            async function startFastPreload() {
                if (hasErrors) {
                    if(mainWrapper) mainWrapper.classList.add('is-ready');
                    if(loadingScreen) loadingScreen.style.display = 'none';
                    return;
                }

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

        // Toggle Password
        const setupToggle = (inputId, toggleId) => {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);
            toggle.addEventListener('click', () => {
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                toggle.classList.toggle('ri-eye-off-fill', !isPass);
                toggle.classList.toggle('ri-eye-fill', isPass);
            });
        };
        setupToggle('password', 'togglePassword');
        setupToggle('confirm_password', 'toggleConfirmPassword');
    </script>
</body>

</html><?php /**PATH D:\Dokumen Sekolah 12\PKL\TSM\upj_tsm_k9\resources\views\auth\public_register.blade.php ENDPATH**/ ?>