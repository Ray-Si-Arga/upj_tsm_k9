@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* Modern & Soft UI */
        body {
            background-color: #f4f6f9;
        }

        .form-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            background: white;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .form-header-title {
            background-color: #2c3e50;
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
        }

        .input-readonly {
            background-color: #eef2f7 !important;
            color: #495057;
            border: 1px solid #dae0e5;
            font-weight: 600;
        }

        .booking-selector-area {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 25px;
            border-left: 5px solid #0d6efd;
        }

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

        /* Tambahan agar dropdown Tom Select tidak terpotong di dalam tabel */
    .table-responsive {
        overflow: visible !important;
    }
    .ts-dropdown {
        z-index: 9999;
    }
    .ts-control {
        border-radius: 8px;
        padding: 8px 12px;
    }

        /* RESPONSIF KHUSUS */
        @media (max-width: 768px) {
            .form-header-title {
                font-size: 1rem;
                padding: 12px 15px;
            }

            .form-card {
                margin-bottom: 15px;
            }

            /* Garis putus-putus di tengah dihilangkan saat mobile agar rapi */
            .border-end-md {
                border-right: none !important;
                border-bottom: 1px dashed #dee2e6;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }

        @media (min-width: 769px) {
            .border-end-md {
                border-right: 1px dashed #dee2e6;
            }
        }
    </style>

    <main class="py-4">
        <div class="container">

            {{-- HEADER HALAMAN --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Service Advisor</h4>
                    <p class="text-muted small mb-0 d-none d-md-block">Formulir penerimaan unit dan pengecekan kendaraan.</p>
                </div>
                <div class="text-end text-muted small">
                    <i class="far fa-calendar-alt me-1"></i> {{ date('d M Y') }}
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
                    <label class="form-label fw-bold text-primary mb-2">Pilih Antrian / Booking</label>
                    <select name="booking_id" id="bookingSelect" class="form-select form-select-lg" required onchange="handleBookingChange()">
    <option value="" data-complaint="" data-queue="" data-date="" data-plate="" data-type="" data-name="" data-phone="">
        -- Pilih Customer --
    </option>
    @foreach ($bookings as $data)
        <option
            value="{{ $data->id }}"
            data-complaint="{{ $data->complaint }}"
            data-queue="{{ $data->queue_number }}"
            data-date="{{ \Carbon\Carbon::parse($data->booking_date)->format('d M Y') }}"
            data-plate="{{ strtoupper($data->plate_number) }}"
            data-type="{{ $data->vehicle_type }}"
            data-name="{{ $data->customer_name }}"
            data-phone="{{ $data->customer_whatsapp }}"
            data-services='@json($data->services->map(fn($s) => ["name" => $s->name, "price" => (int) $s->price]))'>
            No. {{ $data->queue_number }} - {{ $data->customer_name }} ({{ strtoupper($data->plate_number) }})
        </option>
    @endforeach
</select>

                    <div class="mt-3 p-3 rounded-3 bg-light border border-warning"
                        style="border-left-width: 4px !important;">
                        <div class="d-flex">
                            <i class="fas fa-comment-dots text-warning mt-1 me-3 fs-5"></i>
                            <div>
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Keluhan</small>
                                <p class="mb-0 text-dark fw-bold fst-italic" id="complaintText">Silakan pilih pelanggan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 1: DATA PELANGGAN --}}
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-user-friends me-2"></i> Data Pelanggan
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            {{-- KIRI: Pembawa --}}
                            {{-- Class col-12 col-md-6 artinya: HP full width, Laptop setengah --}}
                            <div class="col-12 col-md-6 border-end-md">
                                <div class="section-label text-primary">Data Pembawa (Saat Ini)</div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pembawa</label>
                                        <input type="text" name="carrier_name" id="carrier_name" class="form-control"
                                            required placeholder="Nama...">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="carrier_phone" id="carrier_phone" class="form-control"
                                            required placeholder="08xxx">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Hubungan</label>
                                        <select name="relationship" class="form-select">
                                            <option value="Pemilik Sendiri">Pemilik</option>
                                            <option value="Keluarga">Keluarga</option>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat</label>
                                        <input type="text" name="carrier_address" id="carrier_address"
                                            class="form-control" placeholder="Domisili">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Kel/Kec</label>
                                        <input type="text" name="carrier_area" id="carrier_area" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN: Pemilik --}}
                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-label text-success mb-0">Data Pemilik (STNK)</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="copyDataCheck"
                                            onchange="copyCarrierToOwner()">
                                        <label class="form-check-label small" for="copyDataCheck">Sama Dengan Pembawa</label>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pemilik</label>
                                        <input type="text" name="owner_name" id="owner_name" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="owner_phone" id="owner_phone" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Dari Dealer Sendiri</label>
                                        <div class="d-flex gap-2 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dYes" value="1">
                                                <label class="form-check-label small" for="dYes">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_own_dealer"
                                                    id="dNo" value="0" checked>
                                                <label class="form-check-label small" for="dNo">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat</label>
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
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Antrian</label>
                                    <input type="text" id="displayQueue" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Tgl Booking</label>
                                    <input type="text" id="displayDate" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">No. Polisi</label>
                                    <input type="text" id="displayPlate" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label-custom">Tipe Motor</label>
                                    <input type="text" id="displayType" class="form-control input-readonly" readonly
                                        placeholder="-">
                                </div>
                            </div>
                        </div>

                        {{-- Baris 2: Input Manual --}}
                        <div class="section-label">Pengecekan Fisik</div>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom text-danger">KM (Saat ini)*</label>
                                <input type="text" id="odometer_display" class="form-control fw-bold"
                                    placeholder="Cth: 15.000" required style="border-color: #dee2e6;">
                                <input type="hidden" name="odometer" id="odometer_real">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">Tahun</label>
                                <input type="number" name="vehicle_year" class="form-control" placeholder="20xx">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">No. Mesin</label>
                                <input type="text" name="engine_number" class="form-control" placeholder="Opsional">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label-custom">No. Rangka</label>
                                <input type="text" name="chassis_number" class="form-control" placeholder="Opsional">
                            </div>

                            <!-- {{-- INDIKATOR BENSIN (RESPONSIVE FLEX WRAP) --}}
                            <div class="col-12 mt-3">
                                <label class="form-label-custom mb-2">Indikator Bensin</label>
                                {{-- flex-wrap agar tombol turun ke bawah di HP kecil --}}
                                <div class="d-flex flex-wrap gap-2 align-items-center p-2 rounded-3 bg-light border">
                                    <span class="fw-bold small me-2">E</span>

                                    {{-- flex-grow-1 agar tombol mengisi ruang --}}
                                    <input type="radio" class="btn-check" name="fuel_level" id="fuel0"
                                        value="0" required>
                                    <label class="btn btn-outline-danger btn-sm flex-grow-1" for="fuel0"
                                        style="height: 10px;"></label>

                                    <input type="radio" class="btn-check" name="fuel_level" id="fuel25"
                                        value="25">
                                    <label class="btn btn-outline-warning btn-sm flex-grow-1" for="fuel25"
                                        style="height: 15px;"></label>

                                    <input type="radio" class="btn-check" name="fuel_level" id="fuel50"
                                        value="50">
                                    <label class="btn btn-outline-warning btn-sm flex-grow-1" for="fuel50"
                                        style="height: 20px;"></label>

                                    <input type="radio" class="btn-check" name="fuel_level" id="fuel75"
                                        value="75">
                                    <label class="btn btn-outline-success btn-sm flex-grow-1" for="fuel75"
                                        style="height: 25px;"></label>

                                    <input type="radio" class="btn-check" name="fuel_level" id="fuel100"
                                        value="100">
                                    <label class="btn btn-outline-success btn-sm flex-grow-1" for="fuel100"
                                        style="height: 30px;"></label>

                                    <span class="fw-bold small ms-2">F</span>
                                </div>
                                <div class="text-center small text-muted mt-1 fw-bold" id="fuel_label">Pilih Level</div>
                            </div> -->
                        </div>

                        <div class="section-label mt-4">Data Tambahan</div>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Alasan Ke Ahass</label>
                                <select name="visit_reason" class="form-control">
                                    <option value="">Pilih...</option>
                                    <option value="Inisiatif Sendiri">Inisiatif Sendiri</option>
                                    <option value="SMS Reminder">SMS Reminder</option>
                                    <option value="Telp Reminder">Telp Reminder</option>
                                    <option value="Sticker Reminder">Sticker Reminder</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Email</label>
                                <input type="email" name="customer_email" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label-custom">Sosmed</label>
                                <input type="text" name="customer_social" class="form-control" placeholder="@ig">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label-custom text-danger fw-bold">Nama Mekanik*</label>
                                <input type="text" name="nama_mekanik" class="form-control border-danger" required
                                    placeholder="Wajib diisi">
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom">Catatan SA</label>
                                <textarea name="advisor_notes" class="form-control" rows="2" placeholder="Catatan fisik motor..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: PERSETUJUAN --}}
                <div class="form-card">
                    <div class="form-header-title bg-warning text-dark">
                        <i class="fas fa-handshake me-2"></i> Persetujuan
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 border-end-md">
                                <label class="form-label-custom fw-bold">Pekerjaan Tambahan:</label>
                                <div class="d-flex flex-column gap-2 mt-1">
                                    <div class="form-check p-3 border rounded bg-light position-relative">
                                        <input class="form-check-input" type="radio" name="pkb_approval"
                                            id="approval_call" value="hubungi" checked>
                                        <label class="form-check-label w-100 stretched-link" for="approval_call">
                                            <i class="fas fa-phone-alt me-2 text-primary"></i> Konfirmasi / Telp
                                        </label>
                                    </div>
                                    <div class="form-check p-3 border rounded bg-light position-relative">
                                        <input class="form-check-input" type="radio" name="pkb_approval"
                                            id="approval_direct" value="langsung">
                                        <label class="form-check-label w-100 stretched-link" for="approval_direct">
                                            <i class="fas fa-tools me-2 text-success"></i> Langsung Kerja
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label-custom fw-bold">Part Bekas:</label>
                                <div class="d-flex gap-2 mt-1">
                                    <div
                                        class="form-check flex-fill p-3 border rounded bg-light text-center position-relative">
                                        <input class="form-check-input float-none me-1" type="radio"
                                            name="part_bekas_dibawa" id="part_yes" value="1">
                                        <label class="form-check-label fw-bold stretched-link"
                                            for="part_yes">DIBAWA</label>
                                    </div>
                                    <div
                                        class="form-check flex-fill p-3 border rounded bg-light text-center position-relative">
                                        <input class="form-check-input float-none me-1" type="radio"
                                            name="part_bekas_dibawa" id="part_no" value="0" checked>
                                        <label class="form-check-label fw-bold stretched-link"
                                            for="part_no">DITINGGAL</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: DAFTAR PEKERJAAN --}}
<div class="form-card">
    <div class="form-header-title">
        <i class="fas fa-tools me-2"></i> Daftar Pekerjaan
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" id="jobTable" style="min-width: 400px;">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 45%">Jenis Pekerjaan</th>
                        <th style="width: 35%">Estimasi Biaya</th>
                        <th style="width: 20%">x</th>
                    </tr>
                </thead>
                <tbody id="jobListBody"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="p-2">
                            <button type="button" class="btn btn-outline-primary btn-sm fw-bold w-100" onclick="addJobRow()">
                                <i class="fas fa-plus me-1"></i> Tambah Pekerjaan
                            </button>
                        </td>
                    </tr>
                    <tr class="fw-bold bg-light">
                        <td class="text-end">Total Pekerjaan</td>
                        <td colspan="2" class="text-primary text-end px-3" id="totalJobCost">Rp 0</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="emptyJobState" class="text-center py-4 text-muted border rounded mt-0 bg-light" style="border-top: none !important;">
            <p class="small mb-0">Belum ada pekerjaan. Pilih pelanggan atau tambah manual.</p>
        </div>
    </div>
</div>

                {{-- CARD 5: SPAREPART --}}
                <div class="form-card mt-4">
                    <div class="form-header-title" style="background-color: #198754;">
                        <i class="fas fa-boxes me-2"></i> Sparepart
                    </div>
                    <div class="card-body p-4">
                        {{-- Tambahkan table-responsive --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" id="sparepartTable"
                                style="min-width: 500px;">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 40%">Barang</th>
                                        <th style="width: 15%">Qty</th>
                                        <th style="width: 20%">Harga</th>
                                        <th style="width: 20%">Subtotal</th>
                                        <th style="width: 5%">x</th>
                                    </tr>
                                </thead>
                                <tbody id="sparepartTableBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="p-2">
                                            <button type="button" class="btn btn-outline-success btn-sm fw-bold w-100"
                                                onclick="addSparepartRow()">
                                                <i class="fas fa-plus me-1"></i> Tambah Barang
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-end">Total Part</td>
                                        <td colspan="2" class="text-success text-end px-3" id="totalPartDisplay">Rp 0
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="emptyPartState" class="text-center py-4 text-muted border rounded mt-0 bg-light"
                            style="border-top: none !important;">
                            <p class="small mb-0">Belum ada sparepart.</p>
                        </div>
                    </div>
                </div>

               <div class="d-grid mt-5 mb-5">
    <button type="submit" class="btn btn-primary-custom btn-lg shadow">
        <i class="fas fa-save me-2"></i> SIMPAN DATA
    </button>
</div>

            </form>
        </div>
    </main>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
    <script>
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

        // Odometer Logic
        const display = document.getElementById('odometer_display');
        const real = document.getElementById('odometer_real');
        display.addEventListener('input', function() {
            let angka = this.value.replace(/\D/g, '');
            this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            real.value = angka;
        });

        // Copy Pembawa -> Pemilik
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

        // Indikator Bensin Label
        //document.querySelectorAll('input[name="fuel_level"]').forEach(radio => {
        //    radio.addEventListener('change', function() {
        //        var label = document.getElementById('fuel_label');
        //        if (this.value == '0') label.innerText = "Kosong (Empty)";
        //        if (this.value == '25') label.innerText = "1/4 Tangki";
        //        if (this.value == '50') label.innerText = "Setengah (1/2)";
        //        if (this.value == '75') label.innerText = "3/4 Tangki";
        //        if (this.value == '100') label.innerText = "Penuh (Full)";
        //    });
        //});

        // Handle Change Booking
        function handleBookingChange() {
    const select = document.getElementById('bookingSelect');
    const selectedOption = select.options[select.selectedIndex];

    if (!selectedOption.value) {
        // Reset semua field jika tidak ada yang dipilih
        document.getElementById('complaintText').innerText = 'Pilih pelanggan atau tambah manual.';
        document.getElementById('displayQueue').value = '-';
        document.getElementById('displayDate').value = '-';
        document.getElementById('displayPlate').value = '-';
        document.getElementById('displayType').value = '-';
        document.getElementById('carrier_name').value = '';
        document.getElementById('carrier_phone').value = '';

        // Kosongkan tabel pekerjaan
        document.getElementById('jobListBody').innerHTML = '';
        jobRowIdx = 0;
        
        document.getElementById('emptyJobState').style.display = 'block';
        calcJobTotal();
        return;
    }

    // Isi complaint
    const complaint = selectedOption.getAttribute('data-complaint');
    const text = document.getElementById('complaintText');
    if (!complaint || complaint.trim() === '') {
        text.innerText = 'Tidak ada complaint.';
    } else {
        text.innerText = '"' + complaint + '"';
    }

    document.getElementById('displayQueue').value = selectedOption.getAttribute('data-queue') || '-';
    document.getElementById('displayDate').value  = selectedOption.getAttribute('data-date')  || '-';
    document.getElementById('displayPlate').value = selectedOption.getAttribute('data-plate') || '-';
    document.getElementById('displayType').value  = selectedOption.getAttribute('data-type')  || '-';
    document.getElementById('carrier_name').value = selectedOption.getAttribute('data-name')  || '';
    document.getElementById('carrier_phone').value= selectedOption.getAttribute('data-phone') || '';

    // =============================================
    // POPULATE DAFTAR PEKERJAAN (PERBAIKAN UTAMA)
    // =============================================
    const servicesRaw = selectedOption.getAttribute('data-services');
    const tbody = document.getElementById('jobListBody');

    tbody.innerHTML = '';
    jobRowIdx = 0;

    if (servicesRaw) {
        try {
            const services = JSON.parse(servicesRaw);
            if (Array.isArray(services) && services.length > 0) {
                services.forEach((svc) => {
                    // Pastikan price adalah integer bersih
                    const price = parseInt(svc.price) || 0;
                    addJobRow(svc.name || '', price);
                });
            }
        } catch (e) {
            console.error('Gagal parse data-services:', e);
        }
    }

    document.getElementById('emptyJobState').style.display =
        tbody.children.length === 0 ? 'block' : 'none';

    calcJobTotal();
}

        // JOB LOGIC
let jobRowIdx = 0;
const servicesData = @json($services ?? []);

function fillJobPrice(rowId, val) {
    const svc = servicesData.find(s => s.name === val);
    const row = document.getElementById(rowId);
    if (!row) return;

    const displayInput = row.querySelector('.job-price-display');
    const rawInput     = row.querySelector('.job-price-raw');

    if (svc && svc.price) {
        // Ada di database → isi harga otomatis
        displayInput.value = new Intl.NumberFormat('id-ID').format(svc.price);
        rawInput.value     = svc.price;
    } else {
        // Custom / tidak ada di DB → biarkan user isi manual, jangan timpa nilai lama
        // Hanya kosongkan jika memang belum ada isi (kasus pilih lalu ganti ke custom)
        if (!rawInput.value || rawInput.value === '0') {
            displayInput.value = '';
            rawInput.value     = 0;
        }
    }
    calcJobTotal();
}

// ─── Fungsi utama addJobRow — GANTI yang lama dengan ini ─────────────────────
function addJobRow(name = '', price = 0) {
    document.getElementById('emptyJobState').style.display = 'none';
    const tbody    = document.getElementById('jobListBody');
    const rowId    = `job-row-${jobRowIdx}`;
    const selectId = `job-select-${jobRowIdx}`;

    // Harga awal: dari parameter (misal dipopulate dari booking)
    const priceFormatted = price ? new Intl.NumberFormat('id-ID').format(price) : '';

    // Buat opsi dari servicesData (database layanan)
    let optionsHtml = '<option value="">Pilih / Ketik Pekerjaan...</option>';
    servicesData.forEach(svc => {
        optionsHtml += `<option value="${svc.name}">${svc.name}</option>`;
    });

    const rowHtml = `
        <tr id="${rowId}">
            <td>
                <select name="jobs_name[]" id="${selectId}" class="form-select form-select-sm" required>
                    ${optionsHtml}
                </select>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control form-control-sm job-price-display text-end"
                        placeholder="0" value="${priceFormatted}"
                        oninput="syncJobPrice('${rowId}', this)"
                        onkeyup="syncJobPrice('${rowId}', this)">
                    <input type="hidden" name="jobs_price[]" class="job-price-raw" value="${price}">
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeJobRow('${rowId}')">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>`;

    tbody.insertAdjacentHTML('beforeend', rowHtml);

    // Inisialisasi Tom Select dengan fitur "CREATE: TRUE"
    const ts = new TomSelect(`#${selectId}`, {
        create: true, // INI KUNCINYA: Mengizinkan input teks bebas jika tidak ada di saran!
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Pilih / Ketik baru...",
        createOnBlur: true // Jika user ngetik lalu klik di luar, otomatis dianggap sebagai input
    });

    // Jika parameter 'name' terisi (contoh: dipanggil otomatis dari Booking)
    if (name) {
        ts.addOption({value: name, text: name}); // Tambahkan ke opsi secara on-the-fly jika belum ada
        ts.setValue(name); // Set nilainya
    }

    jobRowIdx++;
    calcJobTotal();
}

function syncJobPrice(rowId, input) {
    let angka = input.value.replace(/\D/g, '');
    input.value = angka ? new Intl.NumberFormat('id-ID').format(parseInt(angka)) : '';
    const row = document.getElementById(rowId);
    row.querySelector('.job-price-raw').value = angka || 0;
    calcJobTotal();
}

function removeJobRow(rowId) {
    document.getElementById(rowId).remove();
    calcJobTotal();
    if (document.getElementById('jobListBody').children.length === 0) {
        document.getElementById('emptyJobState').style.display = 'block';
    }
}

function calcJobTotal() {
    let total = 0;
    document.querySelectorAll('.job-price-raw').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    document.getElementById('totalJobCost').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
}

        // SPAREPART LOGIC
        const inventoryData = @json($spareparts);
        let rowIdx = 0;

        function addSparepartRow() {
            document.getElementById('emptyPartState').style.display = 'none';
            const tableBody = document.getElementById('sparepartTableBody');
            const rowId = `row-${rowIdx}`;
            const selectId = `select-${rowId}`; // Buat ID unik untuk Tom Select

            let optionsHtml = '<option value="">Cari & Pilih Barang...</option>';
            inventoryData.forEach(item => {
                optionsHtml +=
                    `<option value="${item.id}" data-price="${item.harga_jual}">${item.nama_barang} (Stok: ${item.jumlah_barang})</option>`;
            });

            // Perhatikan penghapusan onchange inline, dan penambahan id="${selectId}"
            const rowHtml = `
                <tr id="${rowId}">
                    <td style="min-width: 250px;">
                        <select name="parts_id[]" id="${selectId}" class="form-select form-select-sm" required>${optionsHtml}</select>
                    </td>
                    <td style="min-width: 70px;">
                        <input type="number" name="parts_qty[]" class="form-control form-control-sm text-center" value="1" min="1" onchange="calcSub('${rowId}')" onkeyup="calcSub('${rowId}')" required>
                    </td>
                    <td style="min-width: 100px;">
                        <input type="text" class="form-control form-control-sm bg-light text-end part-price-display" readonly value="0">
                        <input type="hidden" name="parts_price[]" class="part-price-raw" value="0">
                    </td>
                    <td style="min-width: 100px;">
                        <input type="text" class="form-control form-control-sm bg-light text-end fw-bold part-subtotal-display" readonly value="0">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removePart('${rowId}')"><i class="fas fa-times"></i></button>
                    </td>
                </tr>`;
            
            tableBody.insertAdjacentHTML('beforeend', rowHtml);

            // Inisialisasi Tom Select SETELAH elemen dirender di layar
            new TomSelect(`#${selectId}`, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Ketik nama barang...",
                onChange: function(value) {
                    // Memicu perhitungan harga secara otomatis ketika barang dipilih
                    const selectElement = document.getElementById(selectId);
                    updatePartPrice(selectElement, rowId);
                }
            });

            rowIdx++;
        }

        function updatePartPrice(select, rowId) {
            const price = select.options[select.selectedIndex].getAttribute('data-price') || 0;
            const row = document.getElementById(rowId);
            row.querySelector('.part-price-raw').value = price;
            row.querySelector('.part-price-display').value = new Intl.NumberFormat('id-ID').format(price);
            calcSub(rowId);
        }

        function calcSub(rowId) {
            const row = document.getElementById(rowId);
            const qty = row.querySelector('input[name="parts_qty[]"]').value || 0;
            const price = row.querySelector('.part-price-raw').value || 0;
            row.querySelector('.part-subtotal-display').value = new Intl.NumberFormat('id-ID').format(qty * price);
            calcTotal();
        }

        function removePart(rowId) {
            document.getElementById(rowId).remove();
            calcTotal();
            if (document.getElementById('sparepartTableBody').children.length === 0) {
                document.getElementById('emptyPartState').style.display = 'block';
            }
        }

        function calcTotal() {
            let total = 0;
            document.querySelectorAll('.part-price-raw').forEach((priceInput) => {
                const row = priceInput.closest('tr');
                const qty = row.querySelector('input[name="parts_qty[]"]').value || 0;
                total += (priceInput.value * qty);
            });
            document.getElementById('totalPartDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
@endsection
