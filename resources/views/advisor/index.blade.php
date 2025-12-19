@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Riwayat Service & Transaksi</h2>
            <a href="{{ route('advisor.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Buat Service Baru
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal & Waktu</th>
                                <th>Info Kendaraan</th>
                                <th>Mekanik</th>
                                <th>Pekerjaan (Jasa)</th>
                                <th>Total Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $index + $histories->firstItem() }}</td>

                                    <td>
                                        {{ $data->created_at->format('d M Y') }}<br>
                                        <small class="text-muted">{{ $data->created_at->format('H:i') }} WIB</small>
                                    </td>

                                    <td>
                                        <span class="fw-bold">{{ $data->booking->plate_number }}</span><br>
                                        <small>{{ $data->booking->vehicle_type }}
                                            ({{ $data->booking->customer_name }})</small>
                                    </td>

                                    <td>{{ $data->nama_mekanik ?? '-' }}</td>

                                    <td>{{ $data->jobs }}</td>

                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($data->total_estimation, 0, '.', '.') }}
                                    </td>

                                    <td class="text-center">
                                        {{-- Tombol Cetak Ulang --}}
                                        <a href="{{ route('advisor.print', $data->id) }}" class="btn btn-sm btn-secondary"
                                            title="Download Invoice">
                                            <i class="bi bi-printer"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">Belum ada riwayat service.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
