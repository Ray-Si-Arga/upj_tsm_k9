@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Kelola Layanan & Paket</h3>
        <a href="{{ route('layanan.create') }}" class="btn btn-primary rounded-pill shadow">
            <i class="fas fa-plus me-2"></i>Tambah Layanan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Nama Layanan</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Deskripsi (Khusus Paket)</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td class="px-4 fw-bold">{{ $service->name }}</td>
                        <td class="px-4">
                            @if($service->type == 'paket')
                                <span class="badge bg-danger">Paket Spesial</span>
                            @else
                                <span class="badge bg-secondary">Satuan</span>
                            @endif
                        </td>
                        <td class="px-4">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                        <td class="px-4 text-muted small">{{ Str::limit($service->description ?? '-', 50) }}</td>
                        <td class="px-4 text-center">
                            <a href="{{ route('layanan.edit', $service->id) }}" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('layanan.destroy', $service->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus layanan ini?')"><i class="fas fa-trash"></i></button>
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