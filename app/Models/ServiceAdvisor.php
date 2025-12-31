<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAdvisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'nama_mekanik',
        'jobs',
        'estimation_cost',
        'spareparts',
        'estimation_parts',
        'total_estimation',
        'customer_complaint',
        'advisor_notes',
        
        // Field Baru:
        'carrier_name',
        'carrier_phone',
        'carrier_address',
        'carrier_area',
        'relationship',
        'owner_name',
        'owner_phone',
        'owner_address',
        'owner_area',
        'is_own_dealer',
        'visit_reason',
        'odometer',
        'vehicle_year',
        'engine_number',
        'chassis_number',
        'fuel_level',
        'customer_email',
        'customer_social',
        'pkb_approval',
        'part_bekas_dibawa',
    ];

    protected $casts = [
        'spareparts' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
