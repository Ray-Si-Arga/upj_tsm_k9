@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- HEADER: Flex column di HP, Flex row di Laptop --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <h3 class="fw-bold text-dark m-0">Kelola Layanan & Paket</h3>
            <a href="{{ route('layanan.create') }}" class="btn btn-primary rounded-pill shadow w-100 w-md-auto">
                <i class="fas fa-plus me-2"></i>Tambah Layanan Baru
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        {{-- TAMPILAN DESKTOP / TABLET (Tabel) --}}
        {{-- Hanya muncul di layar medium ke atas (d-none d-md-block) --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
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
                        @foreach ($services as $service)
                            <tr>
                                <td class="px-4 fw-bold">{{ $service->name }}</td>
                                <td class="px-4">
                                    @if ($service->type == 'paket')
                                        <span class="badge bg-danger rounded-pill">Paket Spesial</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Satuan</span>
                                    @endif
                                </td>
                                <td class="px-4">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                <td class="px-4 text-muted small">{{ Str::limit($service->description ?? '-', 50) }}</td>
                                <td class="px-4 text-center">
                                    <a href="{{ route('layanan.edit', $service->id) }}"
                                        class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('layanan.destroy', $service->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus layanan ini?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAMPILAN MOBILE (Card List) --}}
        {{-- Hanya muncul di layar kecil (d-md-none) --}}
        <div class="d-md-none">
            @foreach ($services as $service)
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        {{-- Baris 1: Nama & Badge --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0">{{ $service->name }}</h5>
                            @if ($service->type == 'paket')
                                <span class="badge bg-danger rounded-pill">Paket</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Satuan</span>
                            @endif
                        </div>

                        {{-- Baris 2: Harga --}}
                        <h4 class="fw-bold text-primary mb-3">Rp {{ number_format($service->price, 0, ',', '.') }}</h4>

                        {{-- Baris 3: Deskripsi --}}
                        <div class="bg-light p-3 rounded-3 mb-3">
                            <small class="text-muted d-block fw-bold mb-1">Deskripsi:</small>
                            <p class="text-secondary small mb-0 fst-italic">
                                {{ $service->description ?? 'Tidak ada deskripsi' }}
                            </p>
                        </div>

                        {{-- Baris 4: Tombol Aksi (Full Width) --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('layanan.edit', $service->id) }}"
                                class="btn btn-outline-warning flex-fill fw-bold">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('layanan.destroy', $service->id) }}" method="POST" class="flex-fill">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger w-100 fw-bold"
                                    onclick="return confirm('Hapus layanan ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- State jika kosong di mobile --}}
            @if ($services->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                    <p>Belum ada data layanan.</p>
                </div>
            @endif
        </div>

    </div>
@endsection
