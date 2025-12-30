@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --brand-primary: #2A6E7F;
            --brand-primary-dark: #1D4F5D;
            --brand-secondary: #FF7A45;
            --brand-secondary-dark: #E55A25;
            --brand-light: #F0F8FA;
            --brand-soft: #E8F4F8;
            --border-soft: #D1E3E8;
            --text-primary: #2C3E50;
            --text-secondary: #546E7A;
            --text-light: #78909C;
            --background-light: #F9FDFE;
            --success: #4CAF50;
            --warning: #FF9800;
            --danger: #F44336;
        }

        body {
            background-color: var(--background-light);
            color: var(--text-primary);
        }

        /* Card */
        .form-service-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(42, 110, 127, 0.1);
            background: linear-gradient(135deg, #ffffff 0%, var(--brand-light) 100%);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .form-service-card:hover {
            transform: translateY(-5px);
        }

        /* Header */
        .form-header {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-dark));
            padding: 40px 32px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-secondary), var(--brand-secondary-dark));
        }

        .form-header h3 {
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 1.05rem;
        }

        /* Labels */
        .form-label-custom {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
            margin-bottom: 8px;
            display: block;
        }

        /* Input Groups */
        .input-group {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .input-group:focus-within {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(42, 110, 127, 0.1);
        }

        .input-group-text {
            background: linear-gradient(135deg, var(--brand-soft), #ffffff);
            color: var(--brand-primary);
            border: 2px solid var(--border-soft);
            border-right: none;
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid var(--border-soft);
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            background-color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(42, 110, 127, 0.15);
            color: var(--text-primary);
        }

        .form-control[readonly] {
            background-color: var(--brand-light);
            color: var(--text-secondary);
        }

        /* Alert */
        .alert-custom {
            background: linear-gradient(135deg, var(--brand-soft), white);
            border: 2px solid var(--brand-primary);
            border-left: 6px solid var(--brand-secondary);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 20px;
        }

        .alert-custom i {
            color: var(--brand-secondary);
        }

        .badge-queue {
            background: linear-gradient(135deg, var(--brand-secondary), var(--brand-secondary-dark));
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 20px;
        }

        /* Service Buttons */
        .btn-service {
            border: 2px solid var(--border-soft);
            background: white;
            color: var(--text-primary);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-service:hover {
            border-color: var(--brand-primary);
            background: var(--brand-soft);
            color: var(--brand-primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(42, 110, 127, 0.15);
        }

        .btn-service i {
            color: var(--brand-secondary);
            transition: all 0.3s ease;
        }

        .btn-service:hover i {
            color: var(--brand-primary);
            transform: scale(1.1);
        }

        .btn-service small {
            background: var(--brand-light);
            color: var(--brand-primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-check:checked+.btn-service {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-dark));
            color: white;
            border-color: var(--brand-primary);
            transform: scale(1.02);
        }

        .btn-check:checked+.btn-service i {
            color: white;
        }

        .btn-check:checked+.btn-service small {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, var(--brand-secondary), var(--brand-secondary-dark));
            border: none;
            border-radius: 50px;
            padding: 18px 40px;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(255, 122, 69, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--brand-secondary-dark), #D44A1A);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 122, 69, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* Form Text */
        .form-text {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-top: 8px;
        }

        /* Error Messages */
        .alert-danger {
            background: linear-gradient(135deg, #FFEBEE, white);
            border: 2px solid var(--danger);
            border-left: 6px solid var(--danger);
            color: var(--danger);
            border-radius: 12px;
        }

        /* Animation for radio buttons */
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

        .col-md-6 {
            animation: fadeIn 0.5s ease forwards;
        }

        .col-md-6:nth-child(2) {
            animation-delay: 0.1s;
        }

        .col-md-6:nth-child(3) {
            animation-delay: 0.2s;
        }

        .col-md-6:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-service-card">
                        <div class="form-header">
                            <h3 class="fw-bold mb-2"><i class="fas fa-screwdriver-wrench me-3"></i>Booking Service</h3>
                            <p class="mb-0">Dapatkan nomor antrian servis kendaraan Anda di sini.</p>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            {{-- Info Antrian --}}
                            <div class="alert alert-custom d-flex align-items-center rounded-3 mb-4" role="alert">
                                <i class="fas fa-users me-4 fs-3"></i>
                                <div>
                                    <strong class="d-block mb-1">Info Antrian</strong>
                                    <span class="text-muted">Saat ini terdapat</span>
                                    <span class="badge-queue mx-2">{{ $todayActive }}</span>
                                    <span class="text-muted">kendaraan dalam antrian hari ini.</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('booking.store') }}">
                                @csrf

                                <div class="row g-4">
                                    {{-- Nama (Readonly) --}}
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nama Pemilik</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="customer_name" class="form-control"
                                                value="{{ $user->name }}" readonly>
                                        </div>
                                    </div>

                                    {{-- WhatsApp --}}
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nomor WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" name="customer_whatsapp" class="form-control"
                                                value="{{ $user->phone ?? old('customer_whatsapp') }}"
                                                placeholder="08xxxxxxxxxx" required>
                                        </div>
                                    </div>

                                    {{-- Kendaraan --}}
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Jenis Motor</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-motorcycle"></i></span>
                                            <input type="text" name="vehicle_type" class="form-control"
                                                placeholder="Contoh: Vario 150, Beat" value="{{ old('vehicle_type') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Plat Nomor --}}
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Plat Nomor</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            <input type="text" name="plate_number" class="form-control text-uppercase"
                                                placeholder="B 1234 XYZ" value="{{ old('plate_number') }}" required>
                                        </div>
                                    </div>

                                    {{-- Tanggal Booking --}}
                                    <div class="col-md-12">
                                        <label class="form-label-custom">Rencana Tanggal & Jam Servis</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="datetime-local" name="booking_date" class="form-control"
                                                value="{{ old('booking_date') }}" required>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Slot terbatas. Jika jam penuh, Anda akan diminta memilih jam lain.
                                        </div>
                                    </div>

                                    {{-- Jenis Layanan --}}
                                    <div class="col-md-12">
                                        <label class="form-label-custom">Pilih Layanan</label>
                                        <div class="row g-3">
                                            @foreach ($services as $service)
                                                <div class="col-md-6">
                                                    <input type="radio" class="btn-check" name="service_id"
                                                        id="service_{{ $service->id }}" value="{{ $service->id }}"
                                                        required>
                                                    <label
                                                        class="btn btn-service w-100 text-start p-3 rounded-3 d-flex align-items-center justify-content-between"
                                                        for="service_{{ $service->id }}">
                                                        <span>
                                                            <i class="fas fa-tools me-3"></i>
                                                            <strong>{{ $service->name }}</strong>
                                                        </span>
                                                        <small class="fw-bold">Pilih</small>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <button type="submit" class="btn btn-submit btn-lg">
                                        <i class="fas fa-paper-plane me-3"></i> Ambil Antrian Sekarang
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
