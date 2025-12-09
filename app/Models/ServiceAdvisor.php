<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAdvisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'jobs', 'estimation_cost',
        'spareparts', 'estimation_parts', 'total_estimation',
        'customer_complaint', 'advisor_notes'
    ];

    protected $casts = [
    'spareparts' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
