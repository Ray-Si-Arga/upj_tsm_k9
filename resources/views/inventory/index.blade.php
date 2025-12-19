@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.6/dist/simple-notify.min.css">

    <style>
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
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Daftar Spare-Part</h2>
                    <p class="text-muted mb-0">Kelola stok barang dan harga inventory bengkel.</p>
                </div>
                <a href="{{ route('inventory.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Barang
                </a>
            </div>

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
                                                <div style="font-size: 0.7rem;" class="text-danger mt-1">Stok Menipis</div>
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
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('inventory.edit', $data->id) }}"
                                                    class="btn btn-outline-info btn-icon" title="Edit Barang">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('inventory.destroy', $data->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-icon"
                                                        onclick="return confirm('Yakin ingin menghapus barang {{ $data->nama_barang }}?')"
                                                        title="Hapus Barang">
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
                                                <p class="small">Belum ada data spare-part yang ditambahkan.</p>
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
