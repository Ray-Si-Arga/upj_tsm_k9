@extends('layouts.app')

@section('title', 'Registrasi Pengguna Baru')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            padding: 25px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label-custom {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.15);
            border-color: #198754;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }

        .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .form-select {
            border-radius: 10px;
        }

        .btn-toggle-password {
            border-left: none;
            border-radius: 0 10px 10px 0;
            background-color: white;
            cursor: pointer;
            color: #6c757d;
            border: 1px solid #ced4da;
            z-index: 5;
        }

        input[type="password"],
        input[type="text"].password-shown {
            border-right: none;
            border-radius: 0;
        }

        .btn-modern {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-modern:active {
            transform: scale(0.98);
        }
    </style>

    <main class="py-4">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3" style="max-width: 800px; margin: 0 auto;">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-circle fs-4 me-2"></i>
                        <h6 class="mb-0 fw-bold">Terjadi Kesalahan</h6>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="form-card">
                    <div class="form-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white bg-opacity-25 p-2 rounded-3">
                                <i class="fas fa-user-plus fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Registrasi Pengguna</h5>
                                <small class="opacity-75">Tambahkan Staff atau Customer Baru</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">

                            {{-- 1. Nama Lengkap --}}
                            <div class="col-md-6">
                                <label class="form-label-custom">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            {{-- 2. Email --}}
                            <div class="col-md-6">
                                <label class="form-label-custom">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="contoh@email.com"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Role (Hak Akses)</label>
                                {{-- Tambahkan ID="roleSelect" dan onchange --}}
                                <select name="role" id="roleSelect" class="form-select" required
                                    onchange="toggleWhatsapp()">
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>👤 Customer
                                        (Pelanggan)</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>🛠️ Admin
                                        (Staff/Mekanik)</option>
                                </select>
                            </div>

                            {{-- Input WhatsApp (Awalnya Tersembunyi) --}}
                            <div class="col-md-12" id="whatsappField" style="display: none;">
                                <label class="form-label-custom">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white"><i
                                            class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx"
                                        value="{{ old('phone') }}">
                                </div>
                                <small class="text-muted">*Wajib diisi untuk Customer</small>
                            </div>

                            {{-- ... Input Password di bawahnya ... --}}

                            {{-- 3. Nomor WhatsApp (INPUT BIASA) --}}
                            {{-- <div class="col-md-6">
                                <label class="form-label-custom">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text text-success"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx"
                                        value="{{ old('phone') }}" required>
                                </div>
                            </div> --}}

                            {{-- 4. Role --}}
                           

                            <hr class="text-muted my-2 opacity-25">

                            {{-- 5. Password --}}
                            <div class="col-md-6">
                                <label class="form-label-custom">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Minimal 8 karakter" required>
                                    <button class="btn btn-toggle-password" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Ulangi password" required>
                                    <button class="btn btn-toggle-password" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn btn-light btn-modern text-secondary border">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-modern px-5 shadow">
                                <i class="fas fa-save me-2"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupToggle(buttonId, inputId) {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                button.addEventListener('click', function() {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';

                    if (isPassword) {
                        input.classList.add('password-shown');
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.classList.remove('password-shown');
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }
            setupToggle('togglePassword', 'password');
            setupToggle('togglePasswordConfirm', 'password_confirmation');
        });
    </script>
    <script>
        // Fungsi untuk menampilkan/menyembunyikan input WhatsApp
        function toggleWhatsapp() {
            const roleSelect = document.getElementById('roleSelect');
            const whatsappField = document.getElementById('whatsappField');

            if (roleSelect.value === 'customer') {
                whatsappField.style.display = 'block'; // Munculkan
                // Animasi halus (opsional)
                whatsappField.classList.add('animate__animated', 'animate__fadeIn');
            } else {
                whatsappField.style.display = 'none'; // Sembunyikan
            }
        }

        // Jalankan saat halaman dimuat (untuk handle old input jika validasi gagal)
        document.addEventListener('DOMContentLoaded', function() {
            toggleWhatsapp();
        });
    </script>
@endsection
