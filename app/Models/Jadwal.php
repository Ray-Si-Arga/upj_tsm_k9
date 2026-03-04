<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'date',
        'title',
        'description',
        'is_closed',
        'is_operational',
    ];
}
