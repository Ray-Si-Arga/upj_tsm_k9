@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        /* Modern & Soft UI */
        body {
            background-color: #f4f6f9;
            /* Background lembut */
        }

        .form-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            /* Shadow halus */
            background: white;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .form-header-title {
            background-color: #2c3e50;
            /* Navy Professional - Tidak menyilaukan */
            color: #ffffff;
            padding: 15px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .section-label {
            color: #2c3e50;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
        }

        .form-label-custom {
            font-weight: 600;
            color: #5a6268;
            /* Abu tua, bukan hitam pekat */
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1);
            /* Fokus warna navy pudar */
        }

        /* Styling Input Readonly (Auto-filled) */
        .input-readonly {
            background-color: #eef2f7 !important;
            /* Biru sangat muda */
            color: #495057;
            border: 1px solid #dae0e5;
            font-weight: 600;
        }

        /* Khusus area booking */
        .booking-selector-area {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 25px;
            border-left: 5px solid #0d6efd;
        }

        /* Tombol */
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>

    <main class="py-4">
        <div class="container">

            {{-- HEADER HALAMAN --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Service Advisor Dashboard</h4>
                    <p class="text-muted small mb-0">Formulir penerimaan unit dan pengecekan kendaraan.</p>
                </div>
                <div class="text-end text-muted small">
                    <i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('advisor.store') }}" method="POST">
                @csrf

                {{-- PILIH BOOKING --}}
                <div class="booking-selector-area">
                    <label class="form-label fw-bold text-primary mb-2">Pilih Antrian / Booking Pelanggan</label>
                    <select name="booking_id" id="bookingSelect" class="form-select form-select-lg" required
                        onchange="handleBookingChange()">
                        <option value="" data-complaint="" data-queue="" data-date="" data-plate="" data-type=""
                            data-name="" data-phone="">
                            -- Pilih Customer dari Antrian --
                        </option>
                        @foreach ($bookings as $data)
                            <option value="{{ $data->id }}" data-complaint="{{ $data->complaint }}"
                                data-queue="{{ $data->queue_number }}"
                                data-date="{{ \Carbon\Carbon::parse($data->booking_date)->format('d M Y') }}"
                                data-plate="{{ strtoupper($data->plate_number) }}" data-type="{{ $data->vehicle_type }}"
                                data-name="{{ $data->customer_name }}" data-phone="{{ $data->customer_whatsapp }}">
                                No. {{ $data->queue_number }} - {{ $data->customer_name }} ({{ $data->vehicle_type }})
                            </option>
                        @endforeach
                    </select>

                    {{-- Alert Keluhan (Menyatu dengan dropdown agar rapi) --}}
                    <div class="mt-3 p-3 rounded-3 bg-light border border-warning"
                        style="border-left-width: 4px !important;">
                        <div class="d-flex">
                            <i class="fas fa-comment-dots text-warning mt-1 me-3 fs-5"></i>
                            <div>
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Keluhan
                                    Konsumen</small>
                                <p class="mb-0 text-dark fw-bold fst-italic" id="complaintText">Silakan pilih pelanggan
                                    terlebih dahulu.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 1: DATA PELANGGAN --}}
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-user-friends me-2"></i> Data Pelanggan (Pembawa & Pemilik)
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-5">
                            {{-- KIRI: Pembawa --}}
                            <div class="col-md-6" style="border-right: 1px dashed #dee2e6;">
                                <div class="section-label text-primary">Data Pembawa (Saat Ini)</div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pembawa</label>
                                        <input type="text" name="carrier_name" id="carrier_name" class="form-control"
                                            required placeholder="Nama orang yang datang...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="carrier_phone" id="carrier_phone" class="form-control"
                                            required placeholder="08xxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Hubungan</label>
                                        <select name="relationship" class="form-select">
                                            <option value="Pemilik Sendiri">Pemilik Sendiri</option>
                                            <option value="Keluarga">Keluarga</option>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat Domisili</label>
                                        <input type="text" name="carrier_address" id="carrier_address"
                                            class="form-control" placeholder="Alamat saat ini">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Kel/Kec</label>
                                        <input type="text" name="carrier_area" id="carrier_area" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN: Pemilik --}}
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-label text-success mb-0">Data Pemilik</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="copyDataCheck"
                                            onchange="copyCarrierToOwner()">
                                        <label class="form-check-label small" for="copyDataCheck">Sama dengan
                                            Pembawa</label>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pemilik</label>
                                        <input type="text" name="owner_name" id="owner_name" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="owner_phone" id="owner_phone" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Sumber Unit</label>
                                        <div class="d-flex gap-3 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dYes" value="1">
                                                <label class="form-check-label small" for="dYes">Dealer Ini</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dNo" value="0" checked>
                                                <label class="form-check-label small" for="dNo">Luar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat Domisili</label>
                                        <input type="text" name="owner_address" id="owner_address"
                                            class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Kel/Kec</label>
                                        <input type="text" name="owner_area" id="owner_area" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: DATA KENDARAAN --}}
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-motorcycle me-2"></i> Data Kendaraan
                    </div>
                    <div class="card-body p-4">
                        {{-- Baris 1: Readonly Data --}}
                        <div class="p-3 mb-4 rounded-3" style="background-color: #f8f9fa;">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label-custom">No. Antrian</label>
                                    <input type="text" id="displayQueue" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Tgl Booking</label>
                                    <input type="text" id="displayDate" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">No. Polisi</label>
                                    <input type="text" id="displayPlate" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Tipe Motor</label>
                                    <input type="text" id="displayType" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                            </div>
                        </div>

                        {{-- Baris 2: Input Manual --}}
                        <div class="section-label">Pengecekan Fisik</div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label-custom text-danger">Kilometer (KM) *</label>
                                <input type="text" id="odometer_display" class="form-control fw-bold"
                                    placeholder="Cth: 15.000" required style="border-color: #dee2e6;">
                                <input type="hidden" name="odometer" id="odometer_real">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Tahun</label>
                                <input type="number" name="vehicle_year" class="form-control" placeholder="20xx">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">No. Mesin</label>
                                <input type="text" name="engine_number" class="form-control" placeholder="Opsional">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">No. Rangka</label>
                                <input type="text" name="chassis_number" class="form-control" placeholder="Opsional">
                            </div>
                        </div>

                        <div class="section-label mt-4">Data Pribadi</div>
                        <div class="row g-3">
                            
                            {{-- Alasan Ke ahass --}}
                            <div class="col-md-4">
                                <label class="form-label-custom">Alasan Ke Ahass</label>
                                <select name="visit_reason" class="form-control">
                                    <option value="">Silahkan Pilih</option>
                                    <option value="inisiatif_sendiri">Inisiatif Sendiri</option>
                                    <option value="sms_reminder">SMS Reminder</option>
                                    <option value="telp_reminder">Telp Reminder</option>
                                    <option value="sticker_reminder">Sticker Reminder</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-4">
                                <label class="form-label-custom">Email</label>
                                <input type="email" name="customer_email" class="form-control">
                            </div>

                            {{-- Sosmed --}}
                            <div class="col-md-4">
                                <label class="form-label-custom">Sosmed</label>
                                <input type="text" name="customer_social" class="form-control"
                                    placeholder="@instagram">
                            </div>

                            {{-- Tambahan advisor --}}
                            <div class="section-label mt-4 text-danger">Tambahan Advisor</div>
                            <div class="col-md-4 border-danger">
                                <label class="form-label-custom">Nama Mekanik</label>
                                <input type="text" name="nama_mekanik" class="form-control" required
                                    placeholder="Nama mekanik yang menangani">
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom">Catatan Advisor</label>
                                <textarea name="advisor_notes" class="form-control" rows="2" placeholder="Catatan tambahan untuk mekanik..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: SPAREPART (Jika diperlukan, tambahkan logika tabel sparepart disini seperti file lama Anda) --}}
                {{-- Untuk saat ini saya hide dulu agar fokus ke perbaikan UI --}}

                <div class="d-grid mt-5 mb-5">
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-save me-2"></i> Simpan Data & Cetak Invoice
                    </button>
                </div>

            </form>
        </div>
    </main>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
        // ... (Script Notify Anda Tetap Sama) ...
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('print_invoice_id'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: 'Invoice didownload...',
                    effect: 'slide',
                    autotimeout: 4000
                });
                setTimeout(() => {
                    window.location.href = "{{ route('advisor.print', session('print_invoice_id')) }}";
                }, 1000);
            @endif
            @if (session('success') && !session('print_invoice_id'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    effect: 'slide',
                    autotimeout: 3000
                });
            @endif
        });

        // Format Ribuan Odometer
        const display = document.getElementById('odometer_display');
        const real = document.getElementById('odometer_real');
        display.addEventListener('input', function() {
            let angka = this.value.replace(/\D/g, '');
            this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            real.value = angka;
        });

        // Copy Data Pembawa -> Pemilik
        function copyCarrierToOwner() {
            if (document.getElementById('copyDataCheck').checked) {
                document.getElementById('owner_name').value = document.getElementById('carrier_name').value;
                document.getElementById('owner_address').value = document.getElementById('carrier_address').value;
                document.getElementById('owner_area').value = document.getElementById('carrier_area').value;
                document.getElementById('owner_phone').value = document.getElementById('carrier_phone').value;
            } else {
                ['owner_name', 'owner_address', 'owner_area', 'owner_phone'].forEach(id => document.getElementById(id)
                    .value = '');
            }
        }

        // Handle Change Booking
        function handleBookingChange() {
            var select = document.getElementById('bookingSelect');
            var selectedOption = select.options[select.selectedIndex];

            // 1. Keluhan
            var complaint = selectedOption.getAttribute('data-complaint');
            var text = document.getElementById('complaintText');
            if (select.value === "") text.innerText = "Silakan pilih pelanggan terlebih dahulu.";
            else if (complaint && complaint.trim() !== "") text.innerText = '"' + complaint + '"';
            else text.innerText = "Tidak ada complaint dari pelanggan.";

            // 2. Info Kendaraan (Readonly)
            document.getElementById('displayQueue').value = selectedOption.getAttribute('data-queue') || '-';
            document.getElementById('displayDate').value = selectedOption.getAttribute('data-date') || '-';
            document.getElementById('displayPlate').value = selectedOption.getAttribute('data-plate') || '-';
            document.getElementById('displayType').value = selectedOption.getAttribute('data-type') || '-';

            // 3. Info Pembawa (Auto-fill)
            document.getElementById('carrier_name').value = selectedOption.getAttribute('data-name') || '';
            document.getElementById('carrier_phone').value = selectedOption.getAttribute('data-phone') || '';
        }
    </script>
@endsection
