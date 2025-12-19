@extends('layouts.app')

@section('content')
    {{-- Notifikasi --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">


    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Spare-Part</h2>
            <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Inventory as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                <td>{{ $data->jumlah_barang }}</td>
                                <td>Rp{{ number_format($data->harga_barang, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    {{-- <span>ID yang dikirim: {{ $data->id ?? 'DATA KOSONG' }}</span> --}}
                                    <a href="{{ route('inventory.edit', $data->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('inventory.destroy', $data->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"
        integrity="sha256-5oyRx5pR3Tpi4tN9pTtnN5czAU1ElI2sUbaRQsxjAEY=" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                new Notify({
                    status: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'right top'
                });
            @endif

            @if (Session::has('error'))
                new Notify({
                    status: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                    effect: 'slide',
                    speed: 300,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 5000,
                    position: 'right top'
                });
            @endif
        });
    </script>
@endsection
