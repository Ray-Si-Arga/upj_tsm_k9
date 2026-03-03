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
            border-left: 5px solid #ffc107;
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

        @media (max-width: 768px) {
            .form-header-title {
                font-size: 1rem;
                padding: 12px 15px;
            }
            .form-card {
                margin-bottom: 15px;
            }
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
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Edit Service Advisor</h4>
                    <p class="text-muted small mb-0 d-none d-md-block">Memperbarui data pengecekan kendaraan.</p>
                </div>
                <div class="text-end">
                    <a href="{{ route('advisor.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('advisor.update', $advisor->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFO BOOKING (READ ONLY) --}}
                <div class="booking-selector-area">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold text-warning mb-1">Data Antrian #{{ $advisor->booking->queue_number }}</h6>
                            <p class="mb-0 text-dark">
                                <strong>{{ $advisor->booking->customer_name }}</strong> ({{ strtoupper($advisor->booking->plate_number) }}) - {{ $advisor->booking->vehicle_type }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <span class="badge bg-light text-dark border">{{ \Carbon\Carbon::parse($advisor->booking->booking_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-3 p-3 rounded-3 bg-light border border-warning" style="border-left-width: 4px !important;">
                        <div class="d-flex">
                            <i class="fas fa-comment-dots text-warning mt-1 me-3 fs-5"></i>
                            <div>
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">Keluhan Awal</small>
                                <p class="mb-0 text-dark fw-bold fst-italic">"{{ $advisor->booking->complaint ?? 'Tidak ada keluhan.' }}"</p>
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
                            <div class="col-12 col-md-6 border-end-md">
                                <div class="section-label text-primary">Data Pembawa</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pembawa</label>
                                        <input type="text" name="carrier_name" value="{{ $advisor->carrier_name }}" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">No. HP</label>
                                        <input type="text" name="carrier_phone" value="{{ $advisor->carrier_phone }}" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label-custom">Hubungan</label>
                                        <select name="relationship" class="form-select">
                                            <option value="Pemilik Sendiri" {{ $advisor->relationship == 'Pemilik Sendiri' ? 'selected' : '' }}>Pemilik</option>
                                            <option value="Keluarga" {{ $advisor->relationship == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                                            <option value="Karyawan" {{ $advisor->relationship == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                            <option value="Lainnya" {{ $advisor->relationship == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat</label>
                                        <input type="text" name="carrier_address" value="{{ $advisor->carrier_address }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="section-label text-success">Data Pemilik</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-custom">Nama Pemilik</label>
                                        <input type="text" name="owner_name" value="{{ $advisor->owner_name }}" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">No. HP Pemilik</label>
                                        <input type="text" name="owner_phone" value="{{ $advisor->owner_phone }}" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom">Alamat Pemilik</label>
                                        <input type="text" name="owner_address" value="{{ $advisor->owner_address }}" class="form-control">
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
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label-custom">Odometer (KM)</label>
                                <input type="text" id="odometer_display" class="form-control fw-bold text-primary" value="{{ number_format($advisor->odometer, 0, ',', '.') }}" required>
                                <input type="hidden" name="odometer" id="odometer_real" value="{{ $advisor->odometer }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Tahun Kendaraan</label>
                                <input type="number" name="vehicle_year" value="{{ $advisor->vehicle_year }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">No. Mesin</label>
                                <input type="text" name="engine_number" value="{{ $advisor->engine_number }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">No. Rangka</label>
                                <input type="text" name="chassis_number" value="{{ $advisor->chassis_number }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: PENGECEKAN --}}
                <div class="form-card">
                    <div class="form-header-title">
                        <i class="fas fa-clipboard-check me-2"></i> Hasil Pengecekan
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label-custom">Nama Mekanik</label>
                                <input type="text" name="nama_mekanik" value="{{ $advisor->nama_mekanik }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Level Bahan Bakar</label>
                                <div class="d-flex gap-3 mt-2">
                                    @foreach(['0' => 'E', '25' => '1/4', '50' => '1/2', '75' => '3/4', '100' => 'F'] as $val => $lbl)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="fuel_level" value="{{ $val }}" id="fuel_{{ $val }}" {{ $advisor->fuel_level == $val ? 'checked' : '' }}>
                                            <label class="form-check-label" for="fuel_{{ $val }}">{{ $lbl }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Keluhan Konsumen</label>
                                <textarea name="customer_complaint" class="form-control" rows="2">{{ $advisor->customer_complaint }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Catatan Advisor</label>
                                <textarea name="advisor_notes" class="form-control" rows="2">{{ $advisor->advisor_notes }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Persetujuan PKB</label>
                                <select name="pkb_approval" class="form-select">
                                    <option value="Ya" {{ $advisor->pkb_approval == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $advisor->pkb_approval == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Part Bekas Dibawa?</label>
                                <select name="part_bekas_dibawa" class="form-select">
                                    <option value="Ya" {{ $advisor->part_bekas_dibawa == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $advisor->part_bekas_dibawa == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: DAFTAR PEKERJAAN --}}
                <div class="form-card">
                    <div class="form-header-title" style="background-color: #0d6efd;">
                        <i class="fas fa-tools me-2"></i> Daftar Pekerjaan (Jasa)
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" id="jobTable">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 65%">Nama Pekerjaan</th>
                                        <th style="width: 30%">Biaya (Rp)</th>
                                        <th style="width: 5%">x</th>
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
                    </div>
                </div>

                {{-- CARD 5: SPAREPART --}}
                <div class="form-card mt-4">
                    <div class="form-header-title" style="background-color: #198754;">
                        <i class="fas fa-boxes me-2"></i> Sparepart
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" id="sparepartTable">
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
                                            <button type="button" class="btn btn-outline-success btn-sm fw-bold w-100" onclick="addSparepartRow()">
                                                <i class="fas fa-plus me-1"></i> Tambah Barang
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-end">Total Part</td>
                                        <td colspan="2" class="text-success text-end px-3" id="totalPartDisplay">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-5 mb-5">
                    <button type="submit" class="btn btn-primary-custom btn-lg shadow">
                        <i class="fas fa-save me-2"></i> PERBARUI DATA
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        const servicesData = @json($services);
        const sparepartsData = @json($spareparts);
        const existingJobs = @json($advisor->jobs);
        const existingParts = @json($advisor->spareparts);

        let jobRowIdx = 0;
        let partRowIdx = 0;

        document.addEventListener("DOMContentLoaded", function() {
            // Odometer Logic
            const display = document.getElementById('odometer_display');
            const real = document.getElementById('odometer_real');
            display.addEventListener('input', function() {
                let angka = this.value.replace(/\D/g, '');
                this.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                real.value = angka;
            });

            // Load Existing Jobs
            if (Array.isArray(existingJobs)) {
                existingJobs.forEach(job => addJobRow(job.name, job.price));
            }

            // Load Existing Parts
            if (Array.isArray(existingParts)) {
                existingParts.forEach(part => addSparepartRow(part.id, part.qty, part.price));
            }

            calcJobTotal();
            calcPartTotal();
        });

        function addJobRow(name = '', price = 0) {
            const tbody = document.getElementById('jobListBody');
            const rowId = `job-row-${jobRowIdx}`;
            const selectId = `job-select-${jobRowIdx}`;
            const priceFormatted = price ? new Intl.NumberFormat('id-ID').format(price) : '';

            let optionsHtml = '<option value="">Pilih / Ketik Pekerjaan...</option>';
            servicesData.forEach(svc => {
                optionsHtml += `<option value="${svc.name}" ${svc.name === name ? 'selected' : ''}>${svc.name}</option>`;
            });

            const rowHtml = `
                <tr id="${rowId}">
                    <td>
                        <select name="jobs_name[]" id="${selectId}" class="form-select form-select-sm" required>
                            ${optionsHtml}
                            ${name && !servicesData.find(s => s.name === name) ? `<option value="${name}" selected>${name}</option>` : ''}
                        </select>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control form-control-sm job-price-display text-end"
                                placeholder="0" value="${priceFormatted}"
                                oninput="syncJobPrice('${rowId}', this)">
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

            new TomSelect(`#${selectId}`, {
                create: true,
                onChange: function(val) {
                    const svc = servicesData.find(s => s.name === val);
                    if (svc) {
                        const row = document.getElementById(rowId);
                        const displayInput = row.querySelector('.job-price-display');
                        const rawInput = row.querySelector('.job-price-raw');
                        displayInput.value = new Intl.NumberFormat('id-ID').format(svc.price);
                        rawInput.value = svc.price;
                        calcJobTotal();
                    }
                }
            });

            jobRowIdx++;
        }

        function syncJobPrice(rowId, input) {
            let val = input.value.replace(/\D/g, '');
            input.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            document.getElementById(rowId).querySelector('.job-price-raw').value = val;
            calcJobTotal();
        }

        function removeJobRow(id) {
            document.getElementById(id).remove();
            calcJobTotal();
        }

        function calcJobTotal() {
            let total = 0;
            document.querySelectorAll('.job-price-raw').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('totalJobCost').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        function addSparepartRow(id = '', qty = 1, price = 0) {
            const tbody = document.getElementById('sparepartTableBody');
            const rowId = `part-row-${partRowIdx}`;
            const selectId = `part-select-${partRowIdx}`;
            const subtotal = qty * price;

            let optionsHtml = '<option value="">Pilih Barang...</option>';
            sparepartsData.forEach(p => {
                optionsHtml += `<option value="${p.id}" data-price="${p.harga_jual}" ${p.id == id ? 'selected' : ''}>${p.nama_barang} (Stok: ${p.jumlah_barang})</option>`;
            });

            const rowHtml = `
                <tr id="${rowId}">
                    <td>
                        <select name="parts_id[]" id="${selectId}" class="form-select form-select-sm" required>
                            ${optionsHtml}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="parts_qty[]" class="form-control form-control-sm part-qty" 
                            value="${qty}" min="1" oninput="updatePartRow('${rowId}')">
                    </td>
                    <td class="text-end">
                        <span class="part-price-text">Rp ${new Intl.NumberFormat('id-ID').format(price)}</span>
                        <input type="hidden" class="part-price-raw" value="${price}">
                    </td>
                    <td class="text-end fw-bold">
                        <span class="part-subtotal-text">Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}</span>
                        <input type="hidden" class="part-subtotal-raw" value="${subtotal}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removePartRow('${rowId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>`;

            tbody.insertAdjacentHTML('beforeend', rowHtml);

            new TomSelect(`#${selectId}`, {
                onChange: function(val) {
                    const option = this.options[val];
                    if (option) {
                        const price = parseInt(option.price);
                        const row = document.getElementById(rowId);
                        row.querySelector('.part-price-raw').value = price;
                        row.querySelector('.part-price-text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                        updatePartRow(rowId);
                    }
                }
            });

            partRowIdx++;
        }

        function updatePartRow(rowId) {
            const row = document.getElementById(rowId);
            const qty = parseInt(row.querySelector('.part-qty').value) || 0;
            const price = parseInt(row.querySelector('.part-price-raw').value) || 0;
            const subtotal = qty * price;
            row.querySelector('.part-subtotal-raw').value = subtotal;
            row.querySelector('.part-subtotal-text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            calcPartTotal();
        }

        function removePartRow(id) {
            document.getElementById(id).remove();
            calcPartTotal();
        }

        function calcPartTotal() {
            let total = 0;
            document.querySelectorAll('.part-subtotal-raw').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('totalPartDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
@endsection
