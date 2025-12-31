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

        /* Card Modern */
        .card-modern {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(42, 110, 127, 0.08);
            background: white;
            overflow: hidden;
            height: 100%;
        }

        /* Header Style */
        .section-header {
            background: var(--brand-soft);
            color: var(--brand-primary);
            padding: 20px 25px;
            font-weight: 700;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
        }

        .section-header i {
            margin-right: 12px;
            font-size: 1.2rem;
            color: var(--brand-secondary);
        }

        /* Input Styling */
        .form-label-custom {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid var(--border-soft);
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(42, 110, 127, 0.1);
        }

        .input-group-text {
            background-color: white;
            border: 2px solid var(--border-soft);
            border-right: none;
            color: var(--brand-secondary);
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        /* Service Cards (Selectable) */
        .service-card-label {
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid var(--border-soft);
            border-radius: 15px;
            overflow: hidden;
            display: block;
            height: 100%;
            background: white;
        }

        .service-card-label:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-color: var(--brand-primary);
        }

        /* CHECKBOX LOGIC (Multi Select) */
        .btn-check:checked+.service-card-label {
            border-color: var(--brand-secondary);
            background-color: #fff9f5;
            /* Orange muda */
            box-shadow: 0 5px 20px rgba(255, 122, 69, 0.2);
        }

        .btn-check:checked+.service-card-label .check-icon {
            display: inline-block !important;
            color: var(--brand-secondary);
        }

        /* Summary Box (Sticky) */
        .summary-box {
            background: var(--brand-primary-dark);
            color: white;
            border-radius: 20px;
            padding: 25px;
            position: sticky;
            top: 20px;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 15px 0;
            max-height: 200px;
            overflow-y: auto;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .total-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--brand-secondary);
        }

        .btn-submit {
            background: var(--brand-secondary);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: var(--brand-secondary-dark);
            transform: translateY(-2px);
        }
    </style>

    <main class="py-4">
        <div class="container-fluid px-4"> {{-- Gunakan fluid agar landscape/lebar --}}

            {{-- Error Alerts --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
                @csrf

                <div class="row g-4">

                    {{-- KOLOM KIRI: DATA DIRI & RINGKASAN HARGA --}}
                    <div class="col-lg-4">
                        <div class="card-modern h-auto mb-4">
                            <div class="section-header">
                                <i class="fas fa-user-circle"></i> Data Pelanggan & Kendaraan
                            </div>
                            <div class="card-body p-4">
                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label class="form-label-custom">Nama Pemilik</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="customer_name" class="form-control bg-light"
                                            value="{{ $user->name }}" readonly>
                                    </div>
                                </div>

                                {{-- WA --}}
                                <div class="mb-3">
                                    <label class="form-label-custom">WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" name="customer_whatsapp" class="form-control"
                                            value="{{ $user->phone }}" placeholder="08xxx" required>
                                    </div>
                                </div>

                                {{-- Motor --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label-custom">Jenis Motor</label>
                                        <select class="form-control" name="vehicle_type">
                                            <option value="">Pilihan</option>
                                            <option value="bebek">Bebek</option>
                                            <option value="sport">Sport</option>
                                            <option value="matic">Matic</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Plat Nomor</label>
                                        <input type="text" name="plate_number" class="form-control text-uppercase"
                                            placeholder="B 1234 XYZ" required>
                                    </div>
                                </div>

                                {{-- Keluhan --}}
                                <div class="mb-3">
                                    <label class="form-label-custom">Keluhan / Catatan</label>
                                    <textarea name="complaint" class="form-control" rows="3"
                                        placeholder="Contoh: Rem depan bunyi, tarikan berat, lampu sen mati..."></textarea>
                                    <div class="form-text small text-muted">
                                        <i class="fas fa-info-circle me-1"></i> Ceritakan kondisi motor Anda agar mekanik
                                        lebih paham.
                                    </div>
                                </div>

                                {{-- Tanggal --}}
                                <div class="mb-3">
                                    <label class="form-label-custom">Rencana Booking</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="datetime-local" name="booking_date" class="form-control" required>
                                    </div>
                                    <div class="form-text small text-danger"><i class="fas fa-exclamation-circle"></i> Slot
                                        terbatas.</div>
                                </div>
                            </div>
                        </div>

                        {{-- RINGKASAN & TOTAL (STICKY) --}}
                        <div class="summary-box shadow">
                            <h5 class="fw-bold mb-3"><i class="fas fa-receipt me-2"></i>Ringkasan Pesanan</h5>
                            <div id="empty-state" class="text-white-50 small fst-italic">Belum ada layanan yang dipilih.
                            </div>

                            {{-- Daftar Item yang Dipilih (Generated by JS) --}}
                            <ul class="summary-list" id="summary-list"></ul>

                            <hr class="border-white opacity-25">

                            <div class="d-flex justify-content-between align-items-end mb-3">
                                <span class="small opacity-75">Total Estimasi</span>
                                <div class="total-price">Rp <span id="total-price-display">0</span></div>
                            </div>

                            <button type="submit" class="btn btn-submit shadow-lg">
                                <i class="fas fa-paper-plane me-2"></i> Booking Sekarang
                            </button>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: PILIHAN LAYANAN (GRID) --}}
                    <div class="col-lg-8">
                        <div class="card-modern">
                            <div class="section-header justify-content-between">
                                <div><i class="fas fa-th-large"></i> Pilih Layanan</div>
                                <small class="fw-normal text-muted"><i class="fas fa-info-circle"></i> Anda bisa memilih
                                    lebih dari satu.</small>
                            </div>

                            <div class="card-body p-4">

                                {{-- 1. PAKET SPESIAL --}}
                                <h6 class="fw-bold text-dark mb-3 ps-2 border-start border-4 border-danger">
                                    &nbsp; Paket Spesial (Hemat)
                                </h6>
                                <div class="row g-3 mb-5">
                                    @foreach ($services->where('type', 'paket') as $paket)
                                        <div class="col-md-6">
                                            {{-- Ubah RADIO menjadi CHECKBOX agar bisa pilih banyak --}}
                                            {{-- name="service_ids[]" mengirim array ke controller --}}
                                            <input type="checkbox" class="btn-check service-checkbox" name="service_ids[]"
                                                id="service_{{ $paket->id }}" value="{{ $paket->id }}"
                                                data-name="{{ $paket->name }}" data-price="{{ $paket->price }}">

                                            <label class="service-card-label p-3 h-100 position-relative"
                                                for="service_{{ $paket->id }}">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="fw-bold text-dark mb-0">{{ $paket->name }}</h6>
                                                    <span class="badge bg-danger">Rp
                                                        {{ number_format($paket->price, 0, ',', '.') }}</span>
                                                </div>
                                                <p class="small text-muted mb-0">{{ $paket->description }}</p>

                                                {{-- Icon Centang (Hidden by default) --}}
                                                <div class="check-icon position-absolute bottom-0 end-0 p-3"
                                                    style="display: none;">
                                                    <i class="fas fa-check-circle fa-lg"></i>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                    @if ($services->where('type', 'paket')->isEmpty())
                                        <div class="col-12">
                                            <div class="alert alert-light">Tidak ada paket tersedia.</div>
                                        </div>
                                    @endif
                                </div>


                                {{-- 2. LAYANAN SATUAN --}}
                                <h6 class="fw-bold text-dark mb-3 ps-2 border-start border-4 border-secondary">
                                    &nbsp; Layanan Satuan / Regular
                                </h6>
                                <div class="row g-3">
                                    @foreach ($services->where('type', 'non_paket') as $layanan)
                                        <div class="col-md-4 col-sm-6">
                                            <input type="checkbox" class="btn-check service-checkbox"
                                                name="service_ids[]" id="service_{{ $layanan->id }}"
                                                value="{{ $layanan->id }}" data-name="{{ $layanan->name }}"
                                                data-price="{{ $layanan->price }}">

                                            <label
                                                class="service-card-label p-3 d-flex flex-column justify-content-between h-100 position-relative"
                                                for="service_{{ $layanan->id }}">
                                                <div class="fw-bold text-dark mb-1">{{ $layanan->name }}</div>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span class="fw-bold text-secondary">Rp
                                                        {{ number_format($layanan->price, 0, ',', '.') }}</span>
                                                </div>

                                                <div class="check-icon position-absolute bottom-0 end-0 p-2"
                                                    style="display: none;">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                    @if ($services->where('type', 'non_paket')->isEmpty())
                                        <div class="col-12">
                                            <div class="alert alert-light">Layanan satuan kosong.</div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>

    {{-- SCRIPT CALCULATOR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.service-checkbox');
            const summaryList = document.getElementById('summary-list');
            const totalPriceDisplay = document.getElementById('total-price-display');
            const emptyState = document.getElementById('empty-state');

            // Fungsi Format Rupiah
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID').format(number);
            };

            // Fungsi Update Ringkasan
            const updateSummary = () => {
                let total = 0;
                let html = '';
                let count = 0;

                checkboxes.forEach(chk => {
                    if (chk.checked) {
                        count++;
                        const name = chk.getAttribute('data-name');
                        const price = parseFloat(chk.getAttribute('data-price'));
                        total += price;

                        html += `
                            <li class="summary-item animate__animated animate__fadeInRight">
                                <span>${name}</span>
                                <span class="fw-bold">Rp ${formatRupiah(price)}</span>
                            </li>
                        `;
                    }
                });

                // Update DOM
                summaryList.innerHTML = html;
                totalPriceDisplay.innerText = formatRupiah(total);

                // Toggle Empty State
                if (count > 0) {
                    emptyState.style.display = 'none';
                } else {
                    emptyState.style.display = 'block';
                }
            };

            // Event Listener tiap checkbox
            checkboxes.forEach(chk => {
                chk.addEventListener('change', updateSummary);
            });
        });
    </script>
@endsection
