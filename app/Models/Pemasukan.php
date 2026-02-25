<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    protected $fillable = [
        'judul',
        'nominal',
        'kategori',
        'keterangan',
    ];

    protected $casts = [
        'nominal'    => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}