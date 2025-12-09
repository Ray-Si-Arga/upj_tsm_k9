{{-- @extends('layouts.app')

@section('title', 'Register')

@section('content') --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style: none;
            border: none;
            outline: none;
            font-family: Poppins, sans-serif;
            color: #fff
        }

        body {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/images/bg.webp') center/cover no-repeat;
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
            border-color: #fff
        }

        input::placeholder {
            color: #fff;
            font-size: 16px
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            font-size: 18px;
            cursor: pointer;
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
            padding-left: 16px
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
            margin: 16px 0 24px;
            transition: opacity .3s;
        }

        .btnn:hover {
            opacity: .85
        }

        .text-center {
            text-align: center;
            font-size: 14px
        }

        .text-center a {
            color: #fff;
            text-decoration: underline
        }
    </style>

    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <h2>Register</h2>

            <div class="input-box">
                <input type="text" name="name" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}"
                    required>
                <i class="ri-user-fill"></i>
            </div>

            <div class="input-box">
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"
                    required>
                <i class="ri-mail-fill"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required
                    autocomplete="new-password">
                <i class="ri-eye-off-fill toggle-password" id="togglePassword"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Konfirmasi Password" required autocomplete="new-password">
                <i class="ri-eye-off-fill toggle-password" id="togglePasswordConfirm"></i>
            </div>

            <button type="submit" class="btnn">Register</button>

            {{-- <p class="text-center">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p> --}}
        </form>
    </div>

    <script>
        // toggle password & confirm
        ['togglePassword', 'togglePasswordConfirm'].forEach(id => {
            document.getElementById(id).addEventListener('click', function() {
                const target = id === 'togglePassword' ? 'password' : 'password_confirmation';
                const input = document.getElementById(target);
                const isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                this.classList.toggle('ri-eye-off-fill', !isPwd);
                this.classList.toggle('ri-eye-fill', isPwd);
            });
        });
    </script>
{{-- @endsection --}}
