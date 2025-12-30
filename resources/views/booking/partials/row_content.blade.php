@php
    $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
    $startTime = $bookingTime;
    $duration = $booking->estimation_duration ?? 60;
    $endTime = $bookingTime->copy()->addMinutes($duration);
    $isOver = now()->greaterThan($endTime) && $booking->status == 'on_progress';
@endphp

<tr>
    {{-- Kolom 1: Nomor Antrian (Besar jika hari ini) --}}
    <td class="text-center px-4">
        <div class="d-flex justify-content-center">
            @if ($isToday)
                <div class="queue-badge">{{ $booking->queue_number }}</div>
            @else
                <span class="text-muted fw-bold">#{{ $booking->queue_number }}</span>
            @endif
        </div>
    </td>

    {{-- Kolom 2: Info Pelanggan --}}
    <td class="px-4">
        <div class="fw-bold text-dark">{{ $booking->customer_name }}</div>
        <div class="text-dark small">{{ $booking->vehicle_type }} - <span
                class="fw-bold">{{ strtoupper($booking->plate_number) }}</span></div>
        <small class="text-muted"><i class="fab fa-whatsapp text-success me-1"></i>
            {{ $booking->customer_whatsapp }}</small>
    </td>

    {{-- Kolom 3: Waktu --}}
    <td class="px-4">
        @if ($isToday)
            {{-- Tampilan Hari Ini: Fokus Jam --}}
            <span class="badge-time fs-6">
                <i class="far fa-clock me-1"></i> {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
            </span>
            @if ($isOver)
                <div class="text-danger fw-bold small mt-1"><i class="fas fa-exclamation-triangle"></i> Lewat Estimasi!
                </div>
            @endif
        @else
            {{-- Tampilan Besok: Fokus Tanggal --}}
            <div class="fw-bold text-dark">{{ $bookingTime->format('d M Y') }}</div>
            <div class="text-muted small">Pukul {{ $startTime->format('H:i') }} WIB</div>
        @endif
    </td>

    {{-- Kolom 4: Status --}}
    <td class="px-4 text-center">
        <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST"
            id="form-status-{{ $booking->id }}">
            @csrf
            @php
                $statusColor = match ($booking->status) {
                    'pending' => 'border-warning text-warning',
                    'approved' => 'border-primary text-primary',
                    'on_progress' => 'border-info text-info',
                    'done' => 'border-success text-success',
                    'cancelled' => 'border-danger text-danger',
                    default => 'border-secondary text-secondary',
                };
            @endphp

            {{-- PERUBAHAN DI SINI: onchange panggil fungsi JS --}}
            <select name="status" class="form-select form-select-sm status-select {{ $statusColor }}"
                onchange="handleStatusChange(this, '{{ $booking->id }}', '{{ route('booking.updateStatus', $booking->id) }}')"
                style="min-width: 140px;">

                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>✅ Diterima</option>
                <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>🔧 Dikerjakan
                </option>
                <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>🏁 Selesai</option>
                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
            </select>
        </form>
    </td>

    {{-- Kolom 5: Aksi --}}
    <td class="px-4 text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-outline-primary btn-icon btn-sm"
                title="Lihat Detail"><i class="fas fa-eye"></i></a>
            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-icon btn-sm"
                    onclick="return confirm('Hapus data booking ini?')" title="Hapus"><i
                        class="fas fa-trash-alt"></i></button>
            </form>
        </div>
    </td>
</tr>
