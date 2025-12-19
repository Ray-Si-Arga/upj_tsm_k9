@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tambah Nama Mekanik') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('mekanik.store') }}">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="nama_mekanik"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama Mekanik') }}</label>

                                <div class="col-md-6">
                                    <input id="nama_mekanik" type="text"
                                        class="form-control @error('nama_mekanik') is-invalid @enderror" name="nama_mekanik"
                                        value="{{ old('nama_mekanik') }}" required autocomplete="nama_mekanik" autofocus>

                                    @error('nama_barang')
                                        <span class="invalid-feedback" role="alert">
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
@endsection
