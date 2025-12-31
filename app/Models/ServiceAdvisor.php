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
        'customer_email', //Email customer atau pelanggan
        'customer_social', //Social Media customer atau pelanggan
        'advisor_notes',
        'odometer',  //Kilometer
        'vehicle_year', //Tahun Motor
        'engine_number', //No Mesin
        'chassis_number', //No Rangka
        'carrier_name',
        'carrier_address',
        'carrier_area',
        'carrier_phone',
        'relationship',
        'owner_name',
        'owner_address',
        'owner_area',
        'owner_phone',
        'is_own_dealer',
        'visit_reason',
    ];

    protected $casts = [
        'spareparts' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
