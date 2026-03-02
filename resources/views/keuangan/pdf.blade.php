<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - {{ $labelPeriode }}</title>
<style>
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 20px; }
    .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #0f172a; padding-bottom: 10px; }
    
    .summary-box { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
    .summary-box td { padding: 15px; border: 1px solid #e2e8f0; background: #f8fafc; }
    
    .table-data { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .table-data th { background: #0f172a; color: white; padding: 10px; font-size: 11px; text-align: left; }
    .table-data td { 
        padding: 8px; font-size: 10px; border-bottom: 1px solid #e2e8f0; 
        word-wrap: break-word; overflow: hidden;
    }
    .text-right { text-align: right; }
    .pemasukan { color: #059669; font-weight: bold; }
    .pengeluaran { color: #e11d48; font-weight: bold; }

    /* Penambahan margin di sini */
    .footer { 
        margin-top: 40px; 
        font-size: 10px;
        color: #64748b;
    }
</style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEUANGAN BENGKEL</h2>
        <p>Periode: {{ $labelPeriode }}</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <small style="color: #64748b;">Total Pemasukan</small><br>
                <span class="pemasukan" style="font-size: 18px;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
            </td>
            <td>
                <small style="color: #64748b;">Total Pengeluaran</small><br>
                <span class="pengeluaran" style="font-size: 18px;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </td>
            <td>
                <small style="color: #64748b;">Saldo Bersih</small><br>
                <span style="font-size: 18px; font-weight: bold; color: #0f172a;">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 40%">Deskripsi</th>
                <th style="width: 15%">Kategori</th>
                <th class="text-right" style="width: 15%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historyTransaksi as $i => $item)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}<br><small style="color: #64748b">{{ $item->created_at->format('H:i') }}</small></td>
                <td style="text-transform: capitalize;">{{ $item->tipe }}</td>
                <td><strong>{{ $item->judul }}</strong></td>
                <td>{{ $item->kategori }}</td>
                <td class="text-right {{ $item->tipe }}">
                    {{ $item->tipe == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
    </div>
</body>
</html>