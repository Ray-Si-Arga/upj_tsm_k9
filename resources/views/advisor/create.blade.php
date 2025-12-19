@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Form Keluhan & Service Advisor</h4>
                {{-- Tombol menuju Riwayat --}}
                <a href="{{ route('advisor.index') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat
                </a>
            </div>
            <div class="card-body">

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- PERUBAHAN 1: Tambahkan onsubmit="handleFormSubmit()" --}}
                <form action="{{ route('advisor.store') }}" method="POST" onsubmit="handleFormSubmit()">
                    @csrf

                    <div class="row">
                        {{-- Kolom Kiri: Data Booking --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Booking Customer</label>
                                <select name="booking_id" class="form-select" required>
                                    <option value="">-- Pilih Antrian --</option>
                                    @foreach ($bookings as $booking)
                                        <option value="{{ $booking->id }}">
                                            {{ $booking->queue_number }} - {{ $booking->customer_name }}
                                            ({{ $booking->vehicle_type }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Input Nama Mekanik --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Mekanik / Montir</label>
                                <input type="text" name="nama_mekanik" class="form-control"
                                    placeholder="Siapa yang mengerjakan?" required>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Catatan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keluhan Customer</label>
                                <textarea name="customer_complaint" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Admin/Advisor</label>
                                <textarea name="advisor_notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Bagian Sparepart Dinamis --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold">Pemakaian Sparepart (Otomatis Potong Stok)</h5>
                            <button type="button" class="btn btn-success btn-sm" onclick="addSparepartRow()">
                                <i class="bi bi-plus-circle"></i> Tambah Barang
                            </button>
                        </div>

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">Nama Barang (Stok Tersedia)</th>
                                    <th width="15%">Qty</th>
                                    <th width="30%">Harga Satuan (Rp)</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sparepartTableBody">
                                {{-- Baris akan ditambahkan lewat Javascript --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol Simpan --}}
                    <button type="submit" id="btnSubmit" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-printer"></i> Simpan & Cetak Invoice
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Data inventory
        const inventoryData = @json($spareparts);
        const rupiahFormatter = new Intl.NumberFormat('id-ID');

        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah Controller mengirimkan ID untuk dicetak?
            @if (session('print_invoice_id'))
                // Ambil URL untuk download PDF
                const printUrl = "{{ route('advisor.print', session('print_invoice_id')) }}";

                // Trigger download otomatis
                window.location.href = printUrl;
            @endif
        });

        // --- FUNGSI BARU: Refresh Halaman setelah Submit ---
        function handleFormSubmit() {
            // 1. Kita beri delay sedikit (misal 3 detik) agar proses download di server sempat dimulai
            // 2. Lalu kita arahkan browser kembali ke halaman create (Refresh bersih)

            setTimeout(function() {
                // Mengarahkan ulang ke URL create (ini akan mereset form menjadi kosong)
                window.location.href = "{{ route('advisor.create') }}";

                // Opsional: Tampilkan alert kecil jika mau
                // alert('Data disimpan. Halaman akan dimuat ulang.');
            }, 3000); // 3000 ms = 3 detik
        }

        // --- Fungsi Logika Sparepart (Sama seperti sebelumnya) ---
        function addSparepartRow() {
            const tableBody = document.getElementById('sparepartTableBody');
            const rowId = Date.now();

            let options = '<option value="">-- Pilih Barang --</option>';
            inventoryData.forEach(item => {
                options += `<option value="${item.id}">${item.nama_barang} (Stok: ${item.jumlah_barang})</option>`;
            });

            const row = `
            <tr id="row-${rowId}">
                <td>
                    <select name="parts_id[]" class="form-select parts-select" required onchange="updatePrice(this, '${rowId}')">
                        ${options}
                    </select>
                </td>
                <td>
                    <input type="number" name="parts_qty[]" class="form-control" value="1" min="1" required>
                </td>
                <td>
                    <input type="hidden" name="parts_price[]" id="price-raw-${rowId}">
                    <input type="text" id="price-display-${rowId}" class="form-control bg-light" placeholder="Otomatis" readonly required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow('row-${rowId}')">Hapus</button>
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
        }
    </script>
@endsection
