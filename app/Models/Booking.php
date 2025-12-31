<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_type',
        'plate_number',
        'complaint',
        'booking_date',
        'quota',
        // 'service_id',
        'customer_name',
        'customer_whatsapp',
        'status',
        'rejection_reason',
        'queue_number',
        'estimation_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

       public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service');
    }

    public function serviceAdvisors()
    {
        return $this->hasMany(ServiceAdvisor::class);
    }

    public function getServiceAttribute()
    {
        return $this ->services->first();
    }
}


