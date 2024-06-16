<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUsage extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'driver_id',
        'purpose',
        'start_time',
        'end_time',
        'booking_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function booking()
    {
        return $this->belongsTo(VehicleBooking::class, 'booking_id');
    }
}
