<div wire:poll.10000ms>

    {{-- ── LIVE INDICATOR ── --}}
    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
        <div class="d-flex align-items-center gap-2">
            <span class="live-dot"></span>
            <span style="font-size:.72rem; font-weight:700; color:#047857; letter-spacing:.5px; text-transform:uppercase;">
                Live Update
            </span>
        </div>
        <span style="font-size:.70rem; color:#94a3b8; font-weight:500;">
            <i class="fas fa-sync-alt me-1" style="font-size:.65rem;"></i>
            Terakhir diperbarui: <strong>{{ $lastUpdated }}</strong>
        </span>
    </div>

    @if ($activeBookings->isEmpty())
        {{-- ── EMPTY STATE ── --}}
        <div class="empty-panel">
            <div class="empty-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="empty-title">Tidak Ada Booking Aktif</div>
            <div class="empty-sub">Semua pekerjaan selesai atau belum ada booking yang dibuat.</div>
            <a href="{{ route('pelanggan.service') }}" class="btn-red mt-4" style="font-size:.82rem; padding:10px 22px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; background:#B10000; color:#fff; font-weight:700; border-radius:999px; box-shadow:0 4px 14px rgba(177,0,0,.35);">
                <i class="fas fa-plus"></i> Buat Booking Baru
            </a>
        </div>
    @else

        @foreach ($activeBookings as $booking)
            @php
                $status  = $booking->status;
                $progW   = '0%';
                if ($status === 'pending')     $progW = '0%';
                if ($status === 'approved')    $progW = '44%';
                if ($status === 'on_progress') $progW = '75%';

                $badgeCfg = match($status) {
                    'pending'     => ['label' => 'Menunggu Konfirmasi', 'icon' => 'fa-clock',           'bg' => '#fef3c7', 'color' => '#92400e', 'border' => '#fcd34d'],
                    'approved'    => ['label' => 'Diterima',            'icon' => 'fa-clipboard-check', 'bg' => '#d1fae5', 'color' => '#065f46', 'border' => '#6ee7b7'],
                    'on_progress' => ['label' => 'Sedang Dikerjakan',   'icon' => 'fa-wrench',          'bg' => '#fee2e2', 'color' => '#991b1b', 'border' => '#fca5a5'],
                    default       => ['label' => $status,               'icon' => 'fa-circle',          'bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#cbd5e1'],
                };
            @endphp

            <div class="panel booking-item" style="border-left: 4px solid
                {{ $status === 'on_progress' ? '#B10000' : ($status === 'approved' ? '#047857' : '#b45309') }};">

                {{-- HEADER ROW --}}
                <div class="booking-meta-row">
                    <div>
                        <div class="booking-date">
                            <i class="fas fa-calendar-alt me-1" style="color:#94a3b8;"></i>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d M Y · H:i') }} WIB
                        </div>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach ($booking->services as $svc)
                                <span class="svc-chip">{{ $svc->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    {{-- STATUS BADGE --}}
                    <span class="status-badge" style="
                        background: {{ $badgeCfg['bg'] }};
                        color: {{ $badgeCfg['color'] }};
                        border: 1.5px solid {{ $badgeCfg['border'] }};
                        display:inline-flex; align-items:center; gap:6px;
                        padding:5px 14px; border-radius:999px;
                        font-size:.72rem; font-weight:800;
                        white-space:nowrap;
                        {{ $status === 'on_progress' ? 'animation: pulse-badge 1.8s infinite;' : '' }}
                    ">
                        <i class="fas {{ $badgeCfg['icon'] }}" style="font-size:.7rem;"></i>
                        {{ $badgeCfg['label'] }}
                    </span>
                </div>

                {{-- VEHICLE INFO --}}
                <div class="d-flex flex-wrap gap-3 mb-14" style="margin-bottom:14px;">
                    <div class="vehicle-chip">
                        <i class="fas fa-motorcycle me-1" style="color:#94a3b8;"></i>
                        <span>{{ strtoupper($booking->plate_number) }}</span>
                    </div>
                    <div class="vehicle-chip">
                        <i class="fas fa-hashtag me-1" style="color:#94a3b8;"></i>
                        <span>Antrian #{{ $booking->queue_number }}</span>
                    </div>
                </div>

                {{-- STEPPER --}}
                <div class="stepper-wrap">
                    <div class="step-progress" style="width:{{ $progW }};"></div>

                    <div class="step-item {{ in_array($status, ['pending','approved','on_progress']) ? 'done' : '' }}">
                        <div class="step-icon"><i class="fas fa-clock"></i></div>
                        <div class="step-lbl">Menunggu</div>
                    </div>
                    <div class="step-item {{ in_array($status, ['approved','on_progress']) ? 'done' : '' }}">
                        <div class="step-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div class="step-lbl">Diterima</div>
                    </div>
                    <div class="step-item {{ $status === 'on_progress' ? 'done' : '' }}">
                        <div class="step-icon">
                            <i class="fas fa-wrench {{ $status === 'on_progress' ? 'fa-spin' : '' }}" style="{{ $status === 'on_progress' ? 'animation-duration:2s;' : '' }}"></i>
                        </div>
                        <div class="step-lbl">Dikerjakan</div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon"><i class="fas fa-flag-checkered"></i></div>
                        <div class="step-lbl">Selesai</div>
                    </div>
                </div>

                {{-- ON-PROGRESS ALERT --}}
                @if ($status === 'on_progress' && $booking->estimation_duration)
                    @php
                        $estTime = \Carbon\Carbon::parse($booking->booking_date)
                            ->addMinutes($booking->estimation_duration);
                    @endphp
                    <div class="progress-alert" style="margin-top:16px;">
                        <div class="progress-alert-icon" style="animation: pulse-icon 1.8s infinite;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <div class="progress-alert-title">🔧 Kendaraan Anda Sedang Dikerjakan Mekanik</div>
                            <div class="progress-alert-sub">
                                Estimasi selesai pukul <strong>{{ $estTime->format('H:i') }} WIB</strong>
                                &nbsp;·&nbsp; Mohon tunggu di area bengkel
                            </div>
                        </div>
                    </div>
                @endif

                {{-- APPROVED INFO --}}
                @if ($status === 'approved')
                    <div class="approved-alert" style="margin-top:16px;">
                        <div class="approved-alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="approved-alert-title">✅ Booking Dikonfirmasi</div>
                            <div class="approved-alert-sub">
                                Silakan datang 15 menit sebelum jadwal dan tunjukkan nomor antrian kepada petugas.
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endforeach

    @endif

    {{-- ── STYLES ── --}}
    <style>
        /* Live dot */
        .live-dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: #047857;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(4,120,87,.5);
            animation: live-pulse 1.6s infinite;
        }
        @keyframes live-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(4,120,87,.5); }
            70%  { box-shadow: 0 0 0 7px rgba(4,120,87,0); }
            100% { box-shadow: 0 0 0 0 rgba(4,120,87,0); }
        }

        /* Service chips */
        .svc-chip {
            display: inline-block;
            background: rgba(177,0,0,.08);
            color: #8B0000;
            border: 1px solid rgba(177,0,0,.15);
            font-size: .68rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 999px;
        }

        /* Vehicle chip */
        .vehicle-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: .75rem;
            font-weight: 600;
            color: #475569;
            padding: 3px 12px;
            border-radius: 8px;
        }

        /* Badge pulse */
        @keyframes pulse-badge {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.75; }
        }

        /* Progress alert */
        .progress-alert {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff5f5;
            border: 1.5px solid rgba(177,0,0,.20);
            border-radius: 12px;
            padding: 14px 16px;
        }
        .progress-alert-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #B10000;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .progress-alert-title {
            font-size: .85rem;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 2px;
        }
        .progress-alert-sub {
            font-size: .76rem;
            color: #64748b;
            font-weight: 500;
        }
        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); }
            50%       { transform: scale(1.1); }
        }

        /* Approved alert */
        .approved-alert {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #f0fdf4;
            border: 1.5px solid #6ee7b7;
            border-radius: 12px;
            padding: 14px 16px;
        }
        .approved-alert-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #047857;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .approved-alert-title {
            font-size: .85rem;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 2px;
        }
        .approved-alert-sub {
            font-size: .76rem;
            color: #64748b;
            font-weight: 500;
        }
    </style>

</div>