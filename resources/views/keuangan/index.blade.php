@extends('layouts.app')

@section('content')

<style>
    /* ---- Google Font ---- */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap');

    .keuangan-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 28px 24px;
        background: #f8fafc;
        min-height: 100vh;
    }

    /* ---- PAGE HEADER ---- */
    .page-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 28px;
    }
    .page-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .page-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 4px;
        font-weight: 500;
    }

    /* ---- FILTER TABS ---- */
    .filter-tabs {
        display: flex;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 4px;
        gap: 2px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .filter-tab {
        padding: 7px 18px;
        border-radius: 9px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .filter-tab:hover {
        background: #f1f5f9;
        color: #334155;
        text-decoration: none;
    }
    .filter-tab.active {
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(15,23,42,0.25);
    }

    /* ---- SUMMARY CARDS ---- */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }
    @media (max-width: 900px) { .cards-grid { grid-template-columns: 1fr; } }

    .summary-card {
        border-radius: 18px;
        padding: 24px 22px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    }

    /* Saldo - Dark Navy */
    .card-saldo {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
        box-shadow: 0 6px 24px rgba(15,23,42,0.3);
    }
    .card-saldo::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 150px; height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .card-saldo::after {
        content: '';
        position: absolute;
        bottom: -30px; left: -20px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }

    /* Pemasukan - Emerald */
    .card-pemasukan {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);
        box-shadow: 0 6px 24px rgba(6,78,59,0.3);
    }
    .card-pemasukan::before {
        content: '';
        position: absolute;
        top: -50px; right: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    /* Pengeluaran - Rose/Red */
    .card-pengeluaran {
        background: linear-gradient(135deg, #881337 0%, #9f1239 60%, #be123c 100%);
        box-shadow: 0 6px 24px rgba(136,19,55,0.3);
    }
    .card-pengeluaran::before {
        content: '';
        position: absolute;
        top: -50px; right: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .card-icon-wrap {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
        font-size: 1.1rem;
        color: #fff;
        position: relative; z-index: 1;
        backdrop-filter: blur(4px);
    }
    .card-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.6);
        margin-bottom: 6px;
        position: relative; z-index: 1;
    }
    .card-amount {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.65rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.2;
        position: relative; z-index: 1;
        letter-spacing: -1px;
    }
    .card-amount.negative { color: #fca5a5; }
    .card-meta {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
        margin-top: 8px;
        position: relative; z-index: 1;
        font-weight: 500;
    }
    .card-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.8);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        margin-top: 10px;
        position: relative; z-index: 1;
    }

    /* ---- CHART AREA ---- */
    .chart-container {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        margin-bottom: 28px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
    }
    .chart-period-label {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
        background: #f8fafc;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    /* ---- HISTORY TABLE ---- */
    .history-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    }
    .history-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        gap: 12px;
    }
    .history-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .history-count {
        font-size: 0.75rem;
        background: #f1f5f9;
        color: #64748b;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* Table Styling */
    .fin-table { width: 100%; border-collapse: collapse; }
    .fin-table thead th {
        padding: 12px 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #94a3b8;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .fin-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .fin-table tbody tr:last-child { border-bottom: none; }
    .fin-table tbody tr:hover { background: #fafafa; }
    .fin-table tbody td {
        padding: 15px 20px;
        font-size: 0.875rem;
        color: #334155;
        vertical-align: middle;
    }

    /* Tipe Badge */
    .tipe-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .tipe-badge.pemasukan {
        background: #d1fae5;
        color: #065f46;
    }
    .tipe-badge.pengeluaran {
        background: #ffe4e6;
        color: #9f1239;
    }

    /* Nominal */
    .nominal-pemasukan {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.9rem;
        color: #059669;
    }
    .nominal-pengeluaran {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.9rem;
        color: #e11d48;
    }

    /* Deskripsi */
    .desc-main {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.875rem;
        margin-bottom: 2px;
    }
    .desc-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 3rem;
        color: #e2e8f0;
        margin-bottom: 16px;
        display: block;
    }
    .empty-state p {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Responsive table */
    .table-scroll { overflow-x: auto; }

    /* Saldo positif/negatif warna */
    .saldo-positif { color: #6ee7b7; }
    .saldo-negatif { color: #fca5a5; }

    /* Animate on load */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-up { animation: fadeUp 0.4s ease both; }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.2s; }
    .delay-5 { animation-delay: 0.25s; }
</style>

<div class="keuangan-wrap">

    {{-- ======================== PAGE HEADER ======================== --}}
    <div class="page-header animate-up">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-wallet me-2" style="color: #e11d48;"></i>Keuangan</h1>
            <p class="page-subtitle">Financial Transaction · {{ $labelPeriode }}</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="filter-tabs">
            @foreach(['harian' => 'Harian', 'mingguan' => 'Mingguan', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan'] as $key => $label)
                <a href="{{ route('keuangan.index', ['periode' => $key]) }}"
                   class="filter-tab {{ $periode === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ======================== SUMMARY CARDS ======================== --}}
    <div class="cards-grid">

        {{-- SALDO --}}
        <div class="summary-card card-saldo animate-up delay-1">
            <div class="card-icon-wrap"><i class="fa-solid fa-scale-balanced"></i></div>
            <div class="card-label">Saldo Bersih</div>
            <div class="card-amount {{ $saldo < 0 ? 'negative' : '' }}">
                {{ $saldo < 0 ? '-' : '' }}Rp {{ number_format(abs($saldo), 0, ',', '.') }}
            </div>
            <div class="card-meta">Pemasukan – Pengeluaran pada periode ini</div>
            <div class="card-badge">
                <i class="fa-solid fa-circle-dot" style="font-size:0.6rem; color: {{ $saldo >= 0 ? '#6ee7b7' : '#fca5a5' }};"></i>
                {{ $saldo >= 0 ? 'Surplus' : 'Defisit' }}
            </div>
        </div>

        {{-- PEMASUKAN --}}
        <div class="summary-card card-pemasukan animate-up delay-2">
            <div class="card-icon-wrap"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="card-label">Total Pemasukan</div>
            <div class="card-amount">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="card-meta">Dari hasil service kendaraan</div>
            <div class="card-badge">
                <i class="fa-solid fa-wrench" style="font-size:0.65rem;"></i>
                {{ $jumlahTransaksiService }} transaksi service
            </div>
        </div>

        {{-- PENGELUARAN --}}
        <div class="summary-card card-pengeluaran animate-up delay-3">
            <div class="card-icon-wrap"><i class="fa-solid fa-arrow-trend-down"></i></div>
            <div class="card-label">Total Pengeluaran</div>
            <div class="card-amount">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <div class="card-meta">Estimasi nilai stok sparepart</div>
            <div class="card-badge">
                <i class="fa-solid fa-boxes-stacked" style="font-size:0.65rem;"></i>
                {{ $jumlahItemInventory }} item inventory
            </div>
        </div>
    </div>

    {{-- ======================== CHART ======================== --}}
    <div class="chart-container animate-up delay-4">
        <div class="chart-header">
            <span class="chart-title"><i class="fa-solid fa-chart-area me-2" style="color:#0f172a;"></i>Grafik Pemasukan</span>
            <span class="chart-period-label">{{ $labelPeriode }}</span>
        </div>
        <canvas id="keuanganChart" height="80"></canvas>
    </div>

    {{-- ======================== HISTORY TABLE ======================== --}}
    <div class="history-card animate-up delay-5">
        <div class="history-header">
            <div class="history-title">
                <i class="fa-solid fa-clock-rotate-left" style="color:#64748b;"></i>
                Riwayat Transaksi
                <span class="history-count">{{ $historyTransaksi->count() }} entri</span>
            </div>
            <span style="font-size:0.78rem; color:#94a3b8; font-weight:500;">
                <i class="fa-regular fa-calendar me-1"></i>{{ $labelPeriode }}
            </span>
        </div>

        <div class="table-scroll">
            @if($historyTransaksi->isEmpty())
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>Belum ada transaksi pada periode ini.</p>
                </div>
            @else
                <table class="fin-table">
                    <thead>
                        <tr>
                            <th style="width:40px; text-align:center;">No</th>
                            <th>Tanggal & Waktu</th>
                            <th>Tipe</th>
                            <th>Deskripsi</th>
                            <th>Info Tambahan</th>
                            <th style="text-align:right;">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyTransaksi as $i => $transaksi)
                        <tr>
                            {{-- No --}}
                            <td style="text-align:center; color:#cbd5e1; font-weight:600;">{{ $i + 1 }}</td>

                            {{-- Tanggal --}}
                            <td>
                                <div style="font-weight:600; color:#1e293b; font-size:0.85rem;">
                                    {{ \Carbon\Carbon::parse($transaksi['tanggal'])->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size:0.75rem; color:#94a3b8;">
                                    {{ \Carbon\Carbon::parse($transaksi['tanggal'])->format('H:i') }} WIB
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td>
                                <span class="tipe-badge {{ $transaksi['tipe'] }}">
                                    <i class="fa-solid {{ $transaksi['icon'] }}" style="font-size:0.7rem;"></i>
                                    {{ ucfirst($transaksi['tipe']) }}
                                </span>
                            </td>

                            {{-- Deskripsi --}}
                            <td>
                                <div class="desc-main">{{ $transaksi['deskripsi'] }}</div>
                                @if($transaksi['tipe'] === 'pemasukan' && $transaksi['mekanik'] !== '-')
                                    <div class="desc-sub">
                                        <i class="fa-solid fa-user-tie" style="font-size:0.65rem;"></i>
                                        {{ $transaksi['mekanik'] }}
                                    </div>
                                @endif
                            </td>

                            {{-- Info Tambahan --}}
                            <td>
                                <div class="desc-sub" style="font-size:0.8rem; color:#64748b;">
                                    {{ $transaksi['sub_info'] }}
                                </div>
                            </td>

                            {{-- Nominal --}}
                            <td style="text-align:right;">
                                <span class="nominal-{{ $transaksi['tipe'] }}">
                                    {{ $transaksi['tipe'] === 'pemasukan' ? '+' : '-' }}
                                    Rp {{ number_format($transaksi['nominal'], 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    {{-- FOOTER TOTAL --}}
                    <tfoot>
                        <tr style="background:#f8fafc; border-top: 2px solid #e2e8f0;">
                            <td colspan="5" style="padding: 14px 20px; font-weight:700; color:#0f172a; font-size:0.875rem;">
                                Saldo Bersih Periode Ini
                            </td>
                            <td style="padding: 14px 20px; text-align:right;">
                                <span style="font-family:'JetBrains Mono',monospace; font-size:1rem; font-weight:800; color: {{ $saldo >= 0 ? '#059669' : '#e11d48' }};">
                                    {{ $saldo < 0 ? '-' : '+' }}
                                    Rp {{ number_format(abs($saldo), 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>

</div>

{{-- ======================== CHART.JS ======================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels    = @json($chartData['labels']);
    const pemasukan = @json($chartData['pemasukan']);

    const ctx = document.getElementById('keuanganChart').getContext('2d');

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(5, 150, 105, 0.25)');
    gradient.addColorStop(1, 'rgba(5, 150, 105, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pemasukan',
                data: pemasukan,
                borderColor: '#059669',
                backgroundColor: gradient,
                borderWidth: 2.5,
                pointBackgroundColor: '#059669',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.45,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
                    },
                    border: { display: false }
                },
                y: {
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: 'JetBrains Mono', size: 10 },
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp ' + (val/1000).toFixed(0) + 'rb';
                            return 'Rp ' + val;
                        }
                    },
                    border: { display: false }
                }
            }
        }
    });
});
</script>

@endsection