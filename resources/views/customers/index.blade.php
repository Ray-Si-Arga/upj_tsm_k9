@extends('layouts.app')

@section('content')

    {{-- Main Content --}}
    <main>
        <div class="container py-4">

            <h1 class="h4 pb-2 mb-4 text-info border-bottom border-info">Daftar Customer</h1>

            @if ($customers->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-users-slash fa-2x mb-2"></i>
                    <p class="mb-0">Belum ada customer yang terdaftar dengan role 'customer'.</p>
                </div>
            @else
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="py-3 px-4">#</th>
                                        <th scope="col" class="py-3 px-4">Nama Customer</th>
                                        <th scope="col" class="py-3 px-4">Email</th>
                                        <th scope="col" class="py-3 px-4">No. WhatsApp Terakhir</th>
                                        <th scope="col" class="py-3 px-4 text-center">Total Booking</th>
                                        <th scope="col" class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        <tr>
                                            <td class="px-4 align-middle">{{ $index + 1 }}</td>
                                            <td class="px-4 align-middle fw-bold">{{ $customer->name }}</td>
                                            <td class="px-4 align-middle">{{ $customer->email }}</td>
                                            <td class="px-4 align-middle">
                                                @if ($customer->bookings->isNotEmpty())
                                                    @php
                                                        // Ambil nomor WhatsApp dari booking terakhir (first() karena di eager load)
                                                        // Ini adalah cara yang benar untuk mengakses data dari relasi.
                                                        $whatsappNumber = $customer->bookings->first()
                                                            ->customer_whatsapp;
                                                    @endphp
                                                    {{ $whatsappNumber }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td class="px-4 align-middle text-center">
                                                <span
                                                    class="badge bg-info rounded-pill py-2 px-3">{{ $customer->bookings->count() }}</span>
                                            </td>
                                            <td class="px-4 align-middle text-center">
                                                @if ($customer->bookings->isNotEmpty())
                                                    <!-- INI ADALAH SOLUSI UNTUK MISSING PARAMETER -->
                                                    <!-- Kita passing 'whatsappNumber' yang sudah dipastikan ada ke route -->
                                                    <a href="{{ route('customers.bookings', ['email' => $customer->email, 'whatsapp' => $whatsappNumber ?? 'N/A']) }}"
                                                        class="btn btn-sm btn-outline-info fw-bold">
                                                        <i class="fas fa-search me-1"></i> Semua Riwayat
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>Tidak ada
                                                        Booking</button>
                                                @endif
                                            </td>

                                            <td>
                                                <form action="{{ route('hapus', $customer->id) }}" method="DELETE"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Yakin data dihapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

@endsection
