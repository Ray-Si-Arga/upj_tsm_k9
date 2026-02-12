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
            /* Warna khusus untuk angka harga */
            .text-beli {
                color: #dc3545 !important; /* Merah */
                font-weight: bold;
            }

            .text-jual {
                color: #198754 !important; /* Hijau */
                font-weight: bold;
            }
        }

        .stock-badge {
            min-width: 60px;
        }
    </style>

<main class="py-4">
        <div class="container">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <div class="text-center text-md-start">
                    <h2 class="fw-bold text-dark mb-1">Daftar Spare-Part</h2>
                    <p class="text-muted mb-0">Kelola stok, harga beli, dan margin keuntungan.</p>
                </div>
                <a href="{{ route('inventory.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm w-100 w-md-auto">
                    <i class="fas fa-plus me-2"></i> Tambah Barang
                </a>
            </div>

            {{-- TAMPILAN DESKTOP --}}
            <div class="d-none d-md-block">
                <div class="card card-inventory">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-header">
                                    <tr>
                                        <th class="py-3 px-4 text-center">No</th>
                                        <th class="py-3 px-4">Nama Barang</th>
                                        <th class="py-3 px-4 text-center">Stok</th>
                                        <th class="py-3 px-4">Harga Beli / Jual</th>
                                        <th class="py-3 px-4 text-center">Potensi Laba</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($Inventory as $index => $data)
                                        @php
                                            $laba = $data->harga_jual - $data->harga_beli;
                                            $total_laba = $laba * $data->jumlah_barang;
                                        @endphp
                                        <tr>
                                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                                            <td class="px-4">
                                                <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $data->jumlah_barang <= 6 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $data->jumlah_barang <= 6 ? 'text-danger' : 'text-success' }} rounded-pill">
                                                    {{ $data->jumlah_barang }} Unit
                                                </span>
                                            </td>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <small class="text-muted">BELI:</small>
                                                    <span class="price-tag">
                                                        <span class="text-beli">Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</span>
                                                    </span>
                                                    
                                                    <small class="text-muted ms-2">JUAL:</small>
                                                    <span class="price-tag">
                                                        <span class="text-jual">Rp {{ number_format($data->harga_jual, 0, ',', '.') }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center px-4">
                                                <div class="fw-bold text-primary">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                                                <small class="text-muted">Total: Rp {{ number_format($total_laba, 0, ',', '.') }}</small>
                                            </td>
                                            <td class="text-center px-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('inventory.edit', $data->id) }}" class="btn btn-outline-info btn-icon"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('inventory.destroy', $data->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-icon" onclick="return confirm('Hapus barang?')"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- ... (tetap sama seperti sebelumnya) --}}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAMPILAN MOBILE --}}
            <div class="d-md-none">
                @foreach ($Inventory as $index => $data)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="fw-bold mb-0">{{ $data->nama_barang }}</h5>
                                <span class="badge {{ $data->jumlah_barang <= 6 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $data->jumlah_barang <= 6 ? 'text-danger' : 'text-success' }} rounded-pill">
                                    {{ $data->jumlah_barang }} Unit
                                </span>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded-3 text-center">
                                        <small class="text-muted d-block">Beli</small>
                                        <span class="fw-bold text-danger">Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded-3 text-center">
                                        <small class="text-muted d-block">Jual</small>
                                        <span class="fw-bold text-success">Rp {{ number_format($data->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('inventory.edit', $data->id) }}" class="btn btn-outline-info flex-fill rounded-pill">Edit</a>
                                <form action="{{ route('inventory.destroy', $data->id) }}" method="POST" class="flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
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
