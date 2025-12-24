<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Honda Service</title>
    {{-- Remix Icon (Diperlukan untuk ikon ri-*) --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style: none;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        body {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa url('/images/bg.webp') center/cover no-repeat;
            transition: background-color 0.5s ease;
        }

        .content {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, .08);
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(13px);
            padding: 30px 35px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .2);
        }

        .content h2 {
            font-size: 38px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 55px;
            margin: 24px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .25);
            border-radius: 30px;
            padding: 0 45px 0 20px;
            font-size: 16px;
            transition: border .3s;
        }

        .input-box input:focus {
            border-color: #fff;
        }

        input::placeholder {
            color: #ddd;
            font-size: 16px;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            font-size: 18px;
            cursor: pointer;
        }

        /* Style untuk Remember Me */
        .remember-box {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-left: 10px;
        }

        .remember-box input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
            accent-color: #fff;
            /* Warna checkbox saat dicentang */
        }

        .remember-box label {
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .alert-danger {
            background: rgba(220, 53, 69, .85);
            color: #fff;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 16px;
        }

        .btnn {
            width: 100%;
            height: 48px;
            background: #fff;
            color: #0a2862;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin: 10px 0 24px;
            transition: opacity .3s;
        }

        .btnn:hover {
            opacity: .85;
        }

        .text-center {
            text-align: center;
            font-size: 14px;
        }

        .text-center a {
            color: #fff;
            text-decoration: underline;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="content">
        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <h2>Login</h2>

            <div class="input-box">
                <input type="text" name="login" id="login" placeholder="Nama Atau Email" required autofocus>
                <i class="ri-user-fill"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="ri-eye-off-fill" id="togglePassword"></i>
            </div>

            {{-- Fitur Ingatkan Saya --}}
            <div class="remember-box">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingatkan Saya</label>
            </div>

            <button type="submit" class="btnn">Masuk</button>

            <p class="text-center">
                Belum punya akun? <a href="{{ route('public.register') }}">Daftar Sekarang</a>
            </p>
        </form>
    </div>

    <script>
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
