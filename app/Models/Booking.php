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
        'booking_date',
        'quota',
        'service_id',
        'customer_name',
        'customer_whatsapp',
        'status',
        'queue_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

       public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceAdvisors()
    {
        return $this->hasMany(ServiceAdvisor::class);
    }
}


