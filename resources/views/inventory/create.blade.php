@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Custom CSS untuk mempercantik UI */
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
            border-color: #0d6efd;
            /* Warna Primary Bootstrap */
        }

        .input-group:focus-within .input-group-text i {
            color: #0d6efd;
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
                            <h3 class="fw-bold text-dark">{{ __('Tambah Barang') }}</h3>
                            <p class="text-muted small">Isi formulir di bawah untuk menambah inventory.</p>
                        </div>

                        <form method="POST" action="{{ route('inventory.store') }}">
                            @csrf

                            {{-- Nama barang --}}
                            <div class="mb-4">
                                <label for="nama_barang" class="form-label-custom">{{ __('Nama Barang') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-box text-muted"></i></span>
                                    <input id="nama_barang" type="text"
                                        class="form-control form-control-custom @error('nama_barang') is-invalid @enderror"
                                        name="nama_barang" value="{{ old('nama_barang') }}"
                                        placeholder="Contoh: Laptop Asus" required autofocus>
                                </div>
                                @error('nama_barang')
                                    <small class="text-danger mt-1 d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>

                            {{-- Jumlah barang --}}
                            <div class="mb-4">
                                <label for="jumlah_barang" class="form-label-custom">{{ __('Stok Awal') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group text-muted"></i></span>
                                    <input id="jumlah_barang" type="number"
                                        class="form-control form-control-custom @error('jumlah_barang') is-invalid @enderror"
                                        name="jumlah_barang" placeholder="0" min="0" required>
                                </div>
                                @error('jumlah_barang')
                                    <small class="text-danger mt-1 d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>

                            {{-- Harga Beli --}}
                            <div class="mb-4">
                                <label for="harga_beli_view" class="form-label-custom">{{ __('Harga Beli') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold text-muted">Rp</span>
                                    <input id="harga_beli_view" type="text" class="form-control form-control-custom" placeholder="0" autocomplete="off" required>
                                    <input id="harga_beli" type="hidden" name="harga_beli">
                                </div>
                            </div>

                            {{-- Harga Jual --}}
                            <div class="mb-4">
                                <label for="harga_jual_view" class="form-label-custom">{{ __('Harga Jual') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold text-muted">Rp</span>
                                    <input id="harga_jual_view" type="text" class="form-control form-control-custom" placeholder="0" autocomplete="off" required>
                                    <input id="harga_jual" type="hidden" name="harga_jual">
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-modern shadow-sm">
                                    <i class="fas fa-save me-2"></i> {{ __('Simpan Data') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-light btn-modern text-muted">
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
            function setupMask(viewId, hiddenId) {
                const viewInput = document.getElementById(viewId);
                const realInput = document.getElementById(hiddenId);

                viewInput.addEventListener('input', function() {
                    let angka = this.value.replace(/[^0-9]/g, '');
                    realInput.value = angka;
                    this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
                });
            }

            setupMask('harga_beli_view', 'harga_beli');
            setupMask('harga_jual_view', 'harga_jual');
        });
    </script>
@endsection
