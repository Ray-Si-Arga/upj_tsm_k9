@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --honda-red: #B10000;
            --honda-red-dark: #8B0000;
            --honda-red-soft: rgba(177, 0, 0, 0.08);
            --brand-secondary: #FF7A45;
            --brand-secondary-hover: #e6602e;
            --bg-body: #f4f7f9;
            --bg-card: #ffffff;
            --text-main: #2d3748;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* ===== CARD ===== */
        .card-modern {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(to right, var(--honda-red-soft), transparent);
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--honda-red);
            font-size: 1.05rem;
        }

        .section-header i {
            color: var(--honda-red);
            font-size: 1.2rem;
        }

        /* ===== FORM FIELDS ===== */
        .form-label-custom {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background: #f8fafc;
            border-color: var(--border-color);
            color: #718096;
        }

        .form-control,
        .form-select {
            border-color: var(--border-color);
            padding: 0.72rem 1rem;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--honda-red);
            box-shadow: 0 0 0 3px rgba(177, 0, 0, 0.1);
        }

        /* ===== SERVICE CARD CHECKBOX ===== */
        .service-card-label {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 1.1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s;
            position: relative;
        }

        .service-card-label:hover {
            border-color: #fca5a5;
            transform: translateY(-2px);
        }

        .btn-check:checked + .service-card-label {
            border-color: var(--honda-red);
            background-color: #fff5f5;
            box-shadow: 0 8px 20px rgba(177, 0, 0, 0.12);
        }

        .check-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--honda-red);
            font-size: 1.1rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s;
        }

        .btn-check:checked + .service-card-label .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        .desc-full  { display: none; color: var(--text-main); font-size: 0.88rem; margin-top: 0.5rem; line-height: 1.5; }
        .desc-short { display: block; }

        .btn-check:checked + .service-card-label .desc-short { display: none; }
        .btn-check:checked + .service-card-label .desc-full  { display: block !important; animation: fadeInDown 0.4s ease forwards; }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== CATEGORY DIVIDER ===== */
        .category-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.25rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.88rem;
        }

        .category-divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin-left: 1rem;
            border-radius: 2px;
        }

        /* ===== SUMMARY BOX ===== */
        .summary-box {
            background: linear-gradient(135deg, var(--honda-red) 0%, var(--honda-red-dark) 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(177, 0, 0, 0.22);
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 1.25rem 0;
            max-height: 280px;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.92rem;
        }

        .badge-price {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.82rem;
            white-space: nowrap;
        }

        .btn-submit {
            background: white;
            color: var(--honda-red);
            width: 100%;
            padding: 0.9rem;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            font-size: 1rem;
        }

        .btn-submit:hover {
            background: #f8f8f8;
            transform: translateY(-2px);
            color: var(--honda-red-dark);
        }

        /* ===== PAGE HEADER ===== */
        .page-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--honda-red-soft);
            border: 1px solid rgba(177, 0, 0, 0.15);
            color: var(--honda-red);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        /* ===== INFO BOX ===== */
        .info-box-red {
            background: #fff5f5;
            border: 1px solid rgba(177, 0, 0, 0.2);
            border-left: 4px solid var(--honda-red);
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 0.88rem;
            color: #7f1d1d;
            margin-bottom: 1.5rem;
        }

        /* ===== STICKY SIDEBAR ===== */
        @media (min-width: 992px) {
            .sticky-desktop { position: sticky; top: 20px; }
        }

        /* ===== ESTIMASI DURATION ===== */
        .estimasi-box {
            background: #f9fafb;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
    </style>

    <main class="py-5">
        <div class="container-xl">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4 animate__animated animate__fadeIn">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="page-header-badge">
                        <i class="fas fa-user-plus"></i> Booking Walk-In
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Booking Manual oleh Admin</h4>
                    <p class="text-muted small mb-0">Untuk pelanggan yang datang langsung ke bengkel.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light border fw-semibold">
                    <i class="fas fa-arrow-left me-2 text-muted"></i>Kembali
                </a>
            </div>

            {{-- Info Antrean --}}
            <div class="info-box-red">
                <i class="fas fa-circle-info mt-1"></i>
                <div>
                    <strong>Info Antrian Hari Ini:</strong>
                    Saat ini ada <strong>{{ $todayactive }}</strong> antrian aktif. Slot terbatas <strong>2 motor/jam</strong> — booking akan ditolak otomatis jika slot penuh.
                </div>
            </div>

            <form method="POST" action="{{ route('booking.storeWalkIn') }}" id="bookingForm">
                @csrf

                <div class="row g-4 align-items-start">

                    {{-- ============================== --}}
                    {{-- KOLOM KIRI: Data Pelanggan     --}}
                    {{-- ============================== --}}
                    <div class="col-lg-4">
                        <div class="sticky-desktop">

                            {{-- Card Data Pelanggan --}}
                            <div class="card-modern mb-4">
                                <div class="section-header">
                                    <i class="fas fa-id-card"></i>
                                    <span>Data Pelanggan</span>
                                </div>
                                <div class="card-body p-4">

                                    {{-- Pilih Pelanggan (dropdown user terdaftar) --}}
                                    <div class="mb-3">
                                        <label class="form-label-custom">Nama Pelanggan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <select name="user_id" id="userSelect" class="form-select" required
                                                    onchange="fillUserData(this)">
                                                <option value="" data-wa="" data-name="">-- Pilih Pelanggan --</option>
                                                @foreach ($customers as $customer)
                                                    <option
                                                        value="{{ $customer->id }}"
                                                        data-name="{{ $customer->name }}"
                                                        data-wa="{{ $customer->phone ?? '' }}"
                                                        {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Hidden input untuk customer_name (dibaca controller) --}}
                                        <input type="hidden" name="customer_name" id="customerNameHidden"
                                               value="{{ old('customer_name') }}">
                                        <div class="form-text small text-muted mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pelanggan harus sudah terdaftar untuk booking walk-in.
                                        </div>
                                    </div>

                                    {{-- WhatsApp --}}
                                    <div class="mb-3">
                                        <label class="form-label-custom">WhatsApp / HP
                                            <small class="text-muted fw-normal normal-case">(Opsional)</small>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text text-success"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" name="customer_whatsapp" id="customerWa"
                                                   class="form-control" placeholder="08xxxxxxxxxx"
                                                   value="{{ old('customer_whatsapp') }}">
                                        </div>
                                    </div>

                                    {{-- Jenis Motor & Plat Nomor --}}
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <label class="form-label-custom">Jenis Motor <span class="text-danger">*</span></label>
                                            <select class="form-select" name="vehicle_type" required>
                                                <option value="" disabled {{ old('vehicle_type') ? '' : 'selected' }}>Pilih...</option>
                                                <option value="bebek" {{ old('vehicle_type') == 'bebek' ? 'selected' : '' }}>Bebek</option>
                                                <option value="sport" {{ old('vehicle_type') == 'sport' ? 'selected' : '' }}>Sport</option>
                                                <option value="matic" {{ old('vehicle_type') == 'matic' ? 'selected' : '' }}>Matic</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom">Plat Nomor <span class="text-danger">*</span></label>
                                            <input type="text" name="plate_number"
                                                   class="form-control text-uppercase fw-medium"
                                                   placeholder="N **** **" required
                                                   value="{{ old('plate_number') }}">
                                        </div>
                                    </div>

                                    {{-- Tanggal & Jam Booking --}}
                                    <div class="mb-3">
                                        <label class="form-label-custom">Tanggal & Jam Booking <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-day text-danger"></i></span>
                                            <input type="datetime-local" name="booking_date" class="form-control" required
                                                   value="{{ old('booking_date', now()->format('Y-m-d\TH:i')) }}">
                                        </div>
                                        <div class="form-text small text-danger mt-1">
                                            <i class="fas fa-info-circle me-1"></i> Slot terbatas 2 motor/jam.
                                        </div>
                                    </div>

                                    {{-- Keluhan --}}
                                    <div class="mb-3">
                                        <label class="form-label-custom">Keluhan / Catatan</label>
                                        <textarea name="complaint" class="form-control" rows="3"
                                                  placeholder="Contoh: Rem bunyi, Bocor alus, Rantai soak...">{{ old('complaint') }}</textarea>
                                    </div>

                                    {{-- Estimasi Durasi --}}
                                    <div class="estimasi-box">
                                        <label class="form-label-custom mb-2">
                                            Estimasi Durasi <small class="text-muted fw-normal">(Opsional)</small>
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <input type="number" name="estimation_hours" class="form-control"
                                                           placeholder="0" min="0"
                                                           value="{{ old('estimation_hours') }}">
                                                    <span class="input-group-text bg-white text-muted small">Jam</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <input type="number" name="estimation_minutes" class="form-control"
                                                           placeholder="0" min="0" max="59"
                                                           value="{{ old('estimation_minutes') }}">
                                                    <span class="input-group-text bg-white text-muted small">Menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- [DESKTOP ONLY] Ringkasan Pesanan --}}
                            <div class="d-none d-lg-block">
                                <div class="summary-box">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-receipt me-3"></i> Ringkasan Pesanan
                                    </h5>

                                    <div class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                        <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                        <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                    </div>

                                    <ul class="summary-list" style="display: none;"></ul>

                                    <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                        <div class="d-flex justify-content-between align-items-end mb-4">
                                            <span class="small text-uppercase opacity-75">Total Estimasi</span>
                                            <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span></div>
                                        </div>

                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-check-circle me-2"></i> Simpan Booking
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ============================== --}}
                    {{-- KOLOM KANAN: Pilih Layanan     --}}
                    {{-- ============================== --}}
                    <div class="col-lg-8">
                        <div class="card-modern mb-4">
                            <div class="section-header justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-tools"></i>
                                    <span>Pilih Layanan Servis</span>
                                </div>
                                <span class="badge bg-light text-dark fw-normal border">
                                    <i class="fas fa-check-double me-1"></i> Multi-select
                                </span>
                            </div>

                            <div class="card-body p-4 p-md-5">

                                @error('service_ids')
                                    <div class="alert alert-danger py-2 small mb-3">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror

                                {{-- Paket Spesial --}}
                                <div class="category-divider">
                                    <span class="text-danger"><i class="fas fa-star me-2"></i>Paket Spesial</span>
                                </div>
                                <div class="row g-4 mb-5 align-items-start">
                                    @foreach ($services->where('type', 'paket') as $paket)
                                        <div class="col-md-6">
                                            <input type="checkbox" class="btn-check service-checkbox"
                                                   name="service_ids[]"
                                                   id="service_{{ $paket->id }}"
                                                   value="{{ $paket->id }}"
                                                   data-name="{{ $paket->name }}"
                                                   data-price="{{ $paket->price }}"
                                                   {{ in_array($paket->id, old('service_ids', [])) ? 'checked' : '' }}>

                                            <label class="service-card-label h-100" for="service_{{ $paket->id }}">
                                                <div class="d-flex justify-content-between align-items-start w-100 mb-2">
                                                    <h6 class="fw-bold text-dark mb-0 fs-6">{{ $paket->name }}</h6>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mb-3">
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                                        Rp {{ number_format($paket->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                                <div class="text-muted small border-top pt-3 mt-auto">
                                                    <span class="desc-short">{{ Str::limit($paket->description, 60, '...') }}</span>
                                                    <span class="desc-full">{{ $paket->description }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Layanan Regular --}}
                                <div class="category-divider">
                                    <span class="text-primary"><i class="fas fa-wrench me-2"></i>Layanan Regular</span>
                                </div>
                                <div class="row g-3">
                                    @foreach ($services->where('type', 'non_paket') as $layanan)
                                        <div class="col-md-4 col-sm-6">
                                            <input type="checkbox" class="btn-check service-checkbox"
                                                   name="service_ids[]"
                                                   id="service_{{ $layanan->id }}"
                                                   value="{{ $layanan->id }}"
                                                   data-name="{{ $layanan->name }}"
                                                   data-price="{{ $layanan->price }}"
                                                   {{ in_array($layanan->id, old('service_ids', [])) ? 'checked' : '' }}>

                                            <label class="service-card-label" for="service_{{ $layanan->id }}">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="fw-bold text-dark small">{{ $layanan->name }}</div>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </div>
                                                <div class="mt-auto pt-2">
                                                    <span class="fw-bold text-secondary">
                                                        Rp {{ number_format($layanan->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        {{-- [MOBILE ONLY] Ringkasan Pesanan --}}
                        <div class="d-block d-lg-none">
                            <div class="summary-box">
                                <h5 class="fw-bold mb-4 d-flex align-items-center">
                                    <i class="fas fa-receipt me-3"></i> Ringkasan Pesanan
                                </h5>

                                <div class="empty-state text-center py-4 border border-dashed border-light rounded-3 bg-white bg-opacity-10">
                                    <i class="fas fa-shopping-basket fs-3 mb-2 opacity-50"></i>
                                    <p class="small mb-0 opacity-75">Belum ada layanan dipilih.</p>
                                </div>

                                <ul class="summary-list" style="display: none;"></ul>

                                <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                                    <div class="d-flex justify-content-between align-items-end mb-4">
                                        <span class="small text-uppercase opacity-75">Total Estimasi</span>
                                        <div class="fs-2 fw-bold lh-1">Rp <span class="total-price-display">0</span></div>
                                    </div>

                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-check-circle me-2"></i> Simpan Booking
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // =============================================
        // Auto-fill WA saat pilih pelanggan
        // =============================================
        function fillUserData(select) {
            const opt = select.options[select.selectedIndex];
            const wa   = opt.getAttribute('data-wa')   || '';
            const name = opt.getAttribute('data-name') || '';

            document.getElementById('customerWa').value          = wa;
            document.getElementById('customerNameHidden').value  = name;
        }

        // Jalankan saat halaman pertama kali load (untuk old() value)
        document.addEventListener('DOMContentLoaded', function () {
            const sel = document.getElementById('userSelect');
            if (sel && sel.value) fillUserData(sel);
        });

        // =============================================
        // Live Summary Calculator
        // =============================================
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes          = document.querySelectorAll('.service-checkbox');
            const summaryLists        = document.querySelectorAll('.summary-list');
            const totalPriceDisplays  = document.querySelectorAll('.total-price-display');
            const emptyStates         = document.querySelectorAll('.empty-state');

            const fmt = (n) => new Intl.NumberFormat('id-ID').format(n);

            const updateSummary = () => {
                let total = 0, html = '', count = 0;

                checkboxes.forEach(chk => {
                    if (chk.checked) {
                        count++;
                        const name  = chk.getAttribute('data-name');
                        const price = parseFloat(chk.getAttribute('data-price'));
                        total += price;
                        html  += `
                            <li class="summary-item animate__animated animate__fadeInRight animate__faster">
                                <div><i class="fas fa-check text-white-50 me-2 small"></i><span>${name}</span></div>
                                <span class="badge-price">Rp ${fmt(price)}</span>
                            </li>`;
                    }
                });

                summaryLists.forEach(l => {
                    l.innerHTML    = html;
                    l.style.display = count > 0 ? 'block' : 'none';
                });
                totalPriceDisplays.forEach(d => d.innerText = fmt(total));
                emptyStates.forEach(s => s.style.display = count > 0 ? 'none' : 'block');
            };

            checkboxes.forEach(chk => chk.addEventListener('change', updateSummary));

            // Trigger jika ada old() checked saat back dari validasi
            updateSummary();
        });
    </script>
@endsection