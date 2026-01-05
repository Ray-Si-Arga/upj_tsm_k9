@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-primary">Input Layanan / Paket Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('layanan.store') }}" method="POST">
                            @csrf

                            {{-- Nama Layanan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Layanan</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Contoh: Paket Service Ringan" required>
                            </div>

                            {{-- Tipe (Paket / Non Paket) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe Layanan</label>
                                <select name="type" id="typeSelect" class="form-select" required
                                    onchange="toggleDescription()">
                                    <option value="non_paket">Layanan Satuan (Non Paket)</option>
                                    <option value="paket">Paket Spesial (Bundling)</option>
                                </select>
                                <div class="form-text">Jika pilih 'Paket', Anda wajib mengisi deskripsi.</div>
                            </div>

                            {{-- Harga --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>

                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="price_display" class="form-control" placeholder="0" required
                                        onkeyup="formatRupiah(this)">
                                </div>
                                <input type="hidden" name="price" id="price_actual">
                            </div>

                            {{-- Deskripsi (Awalnya disembunyikan pakai d-none, muncul jika Paket dipilih) --}}
                            <div class="mb-4 d-none" id="descriptionBox">
                                <label class="form-label fw-bold">Deskripsi Paket</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Jelaskan apa saja yang didapat pelanggan dalam paket ini..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('layanan.index') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan Layanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDescription() {
            var type = document.getElementById('typeSelect').value;
            var box = document.getElementById('descriptionBox');

            if (type === 'paket') {
                box.classList.remove('d-none'); // Munculkan kotak deskripsi
            } else {
                box.classList.add('d-none'); // Sembunyikan
            }
        }

        function formatRupiah(element) {
            // 1. Ambil value dari input tampilan
            let value = element.value;

            // 2. Hapus semua karakter selain angka (biar jadi angka murni)
            let number_string = value.replace(/[^,\d]/g, '').toString();

            // 3. Simpan angka murni ke input hidden (untuk dikirim ke server)
            document.getElementById('price_actual').value = number_string;

            // 4. Format tampilan jadi ada titiknya (Ribuan Indonesia)
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            // 5. Kembalikan tampilan yang sudah diformat ke input text
            element.value = rupiah;
        }
    </script>
@endsection
