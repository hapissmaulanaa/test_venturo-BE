<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingApproval extends Model
{
    protected $fillable = [
        'booking_id',
        'approver_id',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(VehicleBooking::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
