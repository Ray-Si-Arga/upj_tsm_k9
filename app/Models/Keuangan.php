<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tipe',         // 'pemasukan' | 'pengeluaran'
        'judul',        // Label transaksi
        'nominal',      // Jumlah uang
        'sumber',       // 'service' | 'inventory' | 'manual'
        'kategori',     // Sub-kategori bebas
        'keterangan',   // Catatan tambahan
        'referensi_id', // ID dari tabel asal (opsional)
    ];

    protected $casts = [
        'nominal'    => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ── Scope helpers ──────────────────────────────────

    public function scopePemasukan($query)
    {
        return $query->where('tipe', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('tipe', 'pengeluaran');
    }

    public function scopePeriode($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeDariService($query)
    {
        return $query->where('sumber', 'service');
    }

    public function scopeDariInventory($query)
    {
        return $query->where('sumber', 'inventory');
    }

    public function scopeManual($query)
    {
        return $query->where('sumber', 'manual');
    }
}