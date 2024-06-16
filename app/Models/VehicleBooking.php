<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'driver_id',
        'approver_id',
        'status',
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

    public function approver()
    {
        return $this->belongsTo(User::class);
    }

    public function usage()
    {
        return $this->hasOne(VehicleUsage::class);
    }
}
