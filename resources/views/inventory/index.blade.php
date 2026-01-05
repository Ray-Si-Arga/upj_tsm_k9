@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
        /* STYLE UNTUK DESKTOP (TABEL) */
        .card-inventory {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-header {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }

        .price-tag {
            font-family: 'Consolas', 'Monaco', monospace;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .stock-badge {
            min-width: 60px;
        }
    </style>

    <main class="py-4">
        <div class="container">

            {{-- HEADER: Flex Column di HP, Flex Row di Laptop --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div class="text-center text-md-start">
                    <h2 class="fw-bold text-dark mb-1">Daftar Spare-Part</h2>
                    <p class="text-muted mb-0">Kelola stok barang dan harga inventory bengkel.</p>
                </div>
                <a href="{{ route('inventory.create') }}"
                    class="btn btn-primary rounded-pill px-4 shadow-sm w-100 w-md-auto">
                    <i class="fas fa-plus me-2"></i> Tambah Barang
                </a>
            </div>

            {{-- TAMPILAN DESKTOP (TABEL) --}}
            {{-- Hanya muncul di layar Medium ke atas (Laptop) --}}
            <div class="d-none d-md-block">
                <div class="card card-inventory">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-header">
                                    <tr>
                                        <th class="py-3 px-4 text-center" width="5%">No</th>
                                        <th class="py-3 px-4">Nama Barang</th>
                                        <th class="py-3 px-4 text-center">Stok Tersedia</th>
                                        <th class="py-3 px-4 text-end">Harga Satuan</th>
                                        <th class="py-3 px-4 text-center" width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($Inventory as $index => $data)
                                        <tr>
                                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                                            <td class="px-4">
                                                <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                                            </td>
                                            <td class="text-center px-4">
                                                @if ($data->jumlah_barang <= 6)
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger rounded-pill stock-badge">
                                                        {{ $data->jumlah_barang }} Unit
                                                    </span>
                                                    <div style="font-size: 0.7rem;" class="text-danger mt-1 fw-bold">Stok
                                                        Menipis</div>
                                                @else
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success rounded-pill stock-badge">
                                                        {{ $data->jumlah_barang }} Unit
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end px-4">
                                                <span class="price-tag">
                                                    Rp {{ number_format($data->harga_barang, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center px-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('inventory.edit', $data->id) }}"
                                                        class="btn btn-outline-info btn-icon" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('inventory.destroy', $data->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-icon"
                                                            onclick="return confirm('Hapus barang {{ $data->nama_barang }}?')"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-box-open fa-3x mb-3 text-secondary opacity-25"></i>
                                                    <p class="mb-0 fs-5">Inventory Kosong</p>
                                                    <p class="small">Belum ada data spare-part.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAMPILAN MOBILE (CARD LIST) --}}
            {{-- Hanya muncul di layar kecil (HP) --}}
            <div class="d-md-none">
                @forelse ($Inventory as $index => $data)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            {{-- Header Card: Nama & Stok --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $data->nama_barang }}</h5>
                                    <small class="text-muted">No. {{ $index + 1 }}</small>
                                </div>
                                @if ($data->jumlah_barang <= 6)
                                    <div class="text-end">
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                            {{ $data->jumlah_barang }} Unit
                                        </span>
                                        <div style="font-size: 0.65rem;" class="text-danger fw-bold mt-1">Stok Menipis</div>
                                    </div>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                        {{ $data->jumlah_barang }} Unit
                                    </span>
                                @endif
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4 p-2 bg-light rounded-3">
                                <small class="text-muted d-block mb-1">Harga Satuan</small>
                                <h4 class="fw-bold text-primary mb-0 font-monospace">
                                    Rp {{ number_format($data->harga_barang, 0, ',', '.') }}
                                </h4>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('inventory.edit', $data->id) }}"
                                    class="btn btn-outline-info flex-fill fw-bold rounded-pill">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a>
                                <form action="{{ route('inventory.destroy', $data->id) }}" method="POST"
                                    class="flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 fw-bold rounded-pill"
                                        onclick="return confirm('Hapus barang {{ $data->nama_barang }}?')">
                                        <i class="fas fa-trash-alt me-2"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Inventory Kosong</p>
                        <p class="small">Tekan tombol tambah untuk input barang.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    {{-- Script Notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.js"></script>
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
