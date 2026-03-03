<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'event_id',
        'date',
        'title',
        'description',
        'color',
        'start_time',
        'end_time',
        'is_closed',
    ];
}
