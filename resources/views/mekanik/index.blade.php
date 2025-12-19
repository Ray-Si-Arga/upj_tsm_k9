@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Mekanik</h2>
            <a href="{{ route('mekanik.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Data Mekanik
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mekanik</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mekanik as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data->nama_mekanik }}</td>
                                <td class="text-center">
                                    {{-- <span>ID yang dikirim: {{ $data->id ?? 'DATA KOSONG' }}</span> --}}
                                    <a href="{{ route('mekanik.edit', $data->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('mekanik.destroy', $data->id) }}" method="POST" class="d-inline">
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
@endsection
