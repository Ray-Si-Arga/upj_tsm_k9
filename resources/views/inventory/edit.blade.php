@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Data</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Nama Barang --}}
                            <div class="form-group row mb-3">
                                <label for="nama_barang"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="nama_barang" type="text" class="form-control" name="nama_barang"
                                        value="{{ $inventory->nama_barang }}" required autocomplete="nama_barang" autofocus>

                                    @error('nama_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jumlah barang --}}
                            <div class="form-group row mb-3">
                                <label for="jumlah_barang" class="col-md-4 col-form-label text-md-right">Jumlah
                                    Barang</label>

                                <div class="col-md-6">
                                    <input id="jumlah_barang" type="number" class="form-control"
                                        value="{{ $inventory->jumlah_barang }}" name="jumlah_barang" required
                                        autocomplete="jumlah_barang" min="0">

                                    @error('jumlah_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Harga barang --}}
                            <div class="form-group row mb-3">
                                <label for="harga_barang_view" class="col-md-4 col-form-label text-md-right">
                                    Harga Barang
                                </label>

                                <div class="col-md-6">
                                    <!-- Input tampilan -->
                                    <input id="harga_barang_view" type="text" class="form-control"
                                        value="{{ number_format($inventory->harga_barang, 0, ',', '.') }}" required
                                        autocomplete="off">

                                    <!-- Input asli -->
                                    <input type="hidden" id="harga_barang" name="harga_barang"
                                        value="{{ $inventory->harga_barang }}">

                                    @error('harga_barang')
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Simpan Data
                                    </button>
                                </div>
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

            viewInput.addEventListener('input', function() {
                let angka = this.value.replace(/[^0-9]/g, '');
                realInput.value = angka;
                this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    </script>
@endsection
