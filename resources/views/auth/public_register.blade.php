<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Honda Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body {
            background: url('/images/bg.webp') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .register-title {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            background: #B10000; /* Honda Red */
            border: none;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: #8B0000;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2 class="register-title">Daftar Akun</h2>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger" style="background: rgba(220, 53, 69, 0.8); border: none; color: white;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.register.post') }}" method="POST">
            @csrf
            
            {{-- Nama --}}
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ old('name') }}">
            </div>

            {{-- Email --}}
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
            </div>

            {{-- No HP / WA --}}
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                <input type="text" name="phone" class="form-control" placeholder="No. WhatsApp" required value="{{ old('phone') }}">
            </div>

            {{-- Password --}}
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
            </div>

            {{-- Hidden Role: Otomatis jadi Customer --}}
            <input type="hidden" name="role" value="customer">

            <button type="submit" class="btn btn-primary btn-register">Buat Akun</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
        </div>
    </div>

</body>
</html>