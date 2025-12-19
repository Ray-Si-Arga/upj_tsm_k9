@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        .form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            padding: 20px 25px;
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
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border-color: #0d6efd;
        }

        /* Table Styling */
        .table-custom th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 10px 15px;
        }

        .price-display {
            background-color: #f1f3f5;
            border: none;
            font-family: 'Consolas', monospace;
            font-weight: bold;
            color: #212529;
        }

        .btn-modern {
            padding: 10px 20px;
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

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('advisor.store') }}" method="POST">
                @csrf

                {{-- CARD 1: Informasi Utama --}}
                <div class="form-card mb-4">
                    <div class="form-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white bg-opacity-25 p-2 rounded-3">
                                <i class="fas fa-screwdriver-wrench fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Service Advisor</h5>
                                <small class="opacity-75">Formulir Pengecekan & Keluhan</small>
                            </div>
                        </div>
                        <a href="{{ route('advisor.index') }}" class="btn btn-light btn-sm fw-bold text-primary shadow-sm">
                            <i class="fas fa-history me-1"></i> Riwayat Service
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6 border-end-md">
                                <h6 class="text-primary fw-bold mb-3"><i class="fas fa-motorcycle me-2"></i>Data Kendaraan
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label-custom">Pilih Booking / Antrian</label>
                                    <select name="booking_id" class="form-select" required>
                                        <option value="">-- Pilih Customer dari Antrian --</option>
                                        @foreach ($bookings as $booking)
                                            <option value="{{ $booking->id }}">
                                                No. {{ $booking->queue_number }} - {{ $booking->customer_name }}
                                                ({{ $booking->vehicle_type }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-muted">Hanya menampilkan booking status 'Approved'.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label-custom">Nama Mekanik</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i
                                                class="fas fa-user-gear"></i></span>
                                        <input type="text" name="nama_mekanik" class="form-control"
                                            placeholder="Nama mekanik yang bertugas" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6 ps-md-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="fas fa-clipboard-list me-2"></i>Catatan
                                    Service</h6>

                                <div class="mb-3">
                                    <label class="form-label-custom">Keluhan Konsumen</label>
                                    <textarea name="customer_complaint" class="form-control" rows="2"
                                        placeholder="Contoh: Rem bunyi cit-cit, tarikan berat..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Analisa Advisor / Mekanik</label>
                                    <textarea name="advisor_notes" class="form-control" rows="2" placeholder="Catatan teknis perbaikan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: Sparepart --}}
                <div class="form-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="text-primary fw-bold mb-1"><i class="fas fa-boxes-stacked me-2"></i>Penggunaan
                                    Sparepart</h6>
                                <p class="text-muted small mb-0">Stok akan berkurang otomatis saat disimpan.</p>
                            </div>
                            <button type="button" class="btn btn-success btn-sm btn-modern" onclick="addSparepartRow()">
                                <i class="fas fa-plus me-1"></i> Tambah Barang
                            </button>
                        </div>

                        <div class="table-responsive rounded-3 border">
                            <table class="table table-custom mb-0 w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40%;">Nama Barang</th>
                                        <th style="width: 15%;">Jumlah</th>
                                        <th style="width: 35%;">Harga Satuan</th>
                                        <th style="width: 10%;" class="text-center">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody id="sparepartTableBody">
                                    {{-- Row dinamis masuk sini --}}
                                </tbody>
                            </table>
                        </div>

                        <div id="emptyState" class="text-center py-4 text-muted">
                            <i class="fas fa-basket-shopping mb-2 opacity-50"></i>
                            <p class="small mb-0">Belum ada sparepart yang ditambahkan.</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg btn-modern py-3 shadow-lg">
                        <i class="fas fa-save me-2"></i> Simpan Transaksi & Cetak Invoice
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>

    <script>
        // Data inventory dari Controller
        const inventoryData = @json($spareparts);
        const rupiahFormatter = new Intl.NumberFormat('id-ID');

        // Logic Download Otomatis (Session Based)
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('print_invoice_id'))
                new Notify({
                    status: 'success',
                    title: 'Transaksi Berhasil',
                    text: 'Invoice sedang didownload...',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 4000,
                    position: 'right top'
                });

                // Download PDF
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
                    speed: 300,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'right top'
                });
            @endif
        });

        // --- Logic Sparepart ---
        function addSparepartRow() {
            const tableBody = document.getElementById('sparepartTableBody');
            const emptyState = document.getElementById('emptyState');
            const rowId = Date.now();

            // Sembunyikan pesan kosong
            if (emptyState) emptyState.style.display = 'none';

            let options = '<option value="">-- Pilih Barang --</option>';
            inventoryData.forEach(item => {
                // Disable item jika stok 0 (Opsional, tapi bagus untuk UI)
                let disabled = item.jumlah_barang <= 0 ? 'disabled' : '';
                let label = item.jumlah_barang <= 0 ? `${item.nama_barang} (Habis)` :
                    `${item.nama_barang} (Stok: ${item.jumlah_barang})`;
                options += `<option value="${item.id}" ${disabled}>${label}</option>`;
            });

            const row = `
                <tr id="row-${rowId}" class="animate__animated animate__fadeIn">
                    <td>
                        <select name="parts_id[]" class="form-select" required onchange="updatePrice(this, '${rowId}')">
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="parts_qty[]" class="form-control text-center" value="1" min="1" required>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="hidden" name="parts_price[]" id="price-raw-${rowId}">
                            <input type="text" id="price-display-${rowId}" class="form-control price-display border-start-0" placeholder="0" readonly required>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeRow('row-${rowId}')" title="Hapus Baris">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        }

        function updatePrice(selectElement, rowId) {
            const selectedId = selectElement.value;
            const rawInput = document.getElementById(`price-raw-${rowId}`);
            const displayInput = document.getElementById(`price-display-${rowId}`);
            const selectedItem = inventoryData.find(item => item.id == selectedId);

            if (selectedItem) {
                rawInput.value = selectedItem.harga_barang;
                displayInput.value = rupiahFormatter.format(selectedItem.harga_barang);
            } else {
                rawInput.value = '';
                displayInput.value = '';
            }
        }

        function removeRow(rowId) {
            document.getElementById(rowId).remove();

            // Cek jika tabel kosong, tampilkan empty state lagi
            const tableBody = document.getElementById('sparepartTableBody');
            if (tableBody.children.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
            }
        }
    </script>
@endsection
