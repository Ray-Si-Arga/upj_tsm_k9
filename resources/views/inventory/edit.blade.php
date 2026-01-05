@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-label-custom {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .form-control-custom {
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 12px;
        }

        .form-control-custom:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control-custom {
            border-color: #ffc107;
            /* Warna Warning untuk Edit */
        }

        .input-group:focus-within .input-group-text i {
            color: #ffc107;
        }

        .btn-modern {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card card-modern bg-white">
                    <div class="card-body p-5">

                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark">{{ __('Edit Barang') }}</h3>
                            <p class="text-muted small">Perbarui data inventory bengkel.</p>
                        </div>

                        <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Nama Barang --}}
                            <div class="mb-4">
                                <label for="nama_barang" class="form-label-custom">{{ __('Nama Barang') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box text-muted"></i></span>
                                    <input id="nama_barang" type="text"
                                        class="form-control form-control-custom @error('nama_barang') is-invalid @enderror"
                                        name="nama_barang" value="{{ old('nama_barang', $inventory->nama_barang) }}"
                                        required autocomplete="nama_barang" autofocus>
                                </div>
                                @error('nama_barang')
                                    <small class="text-danger mt-1 d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>

                            {{-- Jumlah Barang --}}
                            <div class="mb-4">
                                <label for="jumlah_barang" class="form-label-custom">{{ __('Stok Saat Ini') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group text-muted"></i></span>
                                    <input id="jumlah_barang" type="number"
                                        class="form-control form-control-custom @error('jumlah_barang') is-invalid @enderror"
                                        name="jumlah_barang" value="{{ old('jumlah_barang', $inventory->jumlah_barang) }}"
                                        required autocomplete="jumlah_barang" min="0">
                                </div>
                                @error('jumlah_barang')
                                    <small class="text-danger mt-1 d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>

                            {{-- Harga Barang --}}
                            <div class="mb-4">
                                <label for="harga_barang_view" class="form-label-custom">{{ __('Harga Satuan') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold text-muted" style="font-size: 0.9rem;">Rp</span>

                                    <input id="harga_barang_view" type="text"
                                        class="form-control form-control-custom @error('harga_barang') is-invalid @enderror"
                                        value="{{ number_format($inventory->harga_barang, 0, ',', '.') }}"
                                        autocomplete="off" required>

                                    <input type="hidden" id="harga_barang" name="harga_barang"
                                        value="{{ $inventory->harga_barang }}">
                                </div>
                                @error('harga_barang')
                                    <small class="text-danger mt-1 d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-warning btn-modern shadow-sm text-white">
                                    <i class="fas fa-save me-2"></i> {{ __('Simpan Perubahan') }}
                                </button>
                                <a href="{{ route('inventory.index') }}" class="btn btn-light btn-modern text-muted">
                                    {{ __('Batal') }}
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewInput = document.getElementById('harga_barang_view');
            const realInput = document.getElementById('harga_barang');

            // Logic Format Rupiah
            viewInput.addEventListener('input', function() {
                let angka = this.value.replace(/[^0-9]/g, '');
                realInput.value = angka;
                this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    </script>
@endsection
