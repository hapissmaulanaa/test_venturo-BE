<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleBooking;
use App\Models\BookingApproval;
use App\Models\VehicleUsage;

class VehicleBookingController extends Controller
{
    public function index()
    {
        $bookings = VehicleBooking::with('vehicle', 'user', 'driver', 'approver', 'usage')->get();
        return response()->json(['bookings' => $bookings]);
    }

    // Proses ADD Booking
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle_id' => 'required',
            'user_id' => 'required',
            'driver_id' => 'required',
            'approver_id' => 'required',
        ]);

        $booking = VehicleBooking::create([
            'vehicle_id' => $validatedData['vehicle_id'],
            'user_id' => auth()->id(), // ID pengguna yang membuat pemesanan
            'driver_id' => $validatedData['driver_id'],
            'approver_id' => $validatedData['approver_id'],
            'status' => 'pending', // default status pemesanan
        ]);

        return response()->json(['message' => 'Booking created successfully', 'booking' => $booking]);
    }

    // Proses menyimpan informasi penggunaan kendaraan
    public function storeVehicleUsage(Request $request, $id)
    {
        $validatedData = $request->validate([
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'usage_purpose' => 'nullable|string',
        ]);

        $booking = VehicleBooking::findOrFail($id);

        $usage = VehicleUsage::create([
            'booking_id' => $booking->id,
            'start_date_time' => $validatedData['start_date_time'],
            'end_date_time' => $validatedData['end_date_time'],
            'usage_purpose' => $validatedData['usage_purpose'],
        ]);

        return response()->json(['message' => 'Vehicle usage recorded successfully', 'usage' => $usage]);
    }

    // Proses mengambil informasi penggunaan kendaraan
    public function getVehicleUsage($id)
    {
        $booking = VehicleBooking::findOrFail($id);
        $usage = $booking->usage;

        return response()->json(['usage' => $usage]);
    }

    // Proses Delete Vehicle usage
    public function destroyVehicleUsage($usageId)
    {
        $usage = VehicleUsage::findOrFail($usageId);
        $usage->delete();

        return response()->json(['message' => 'Vehicle usage deleted successfully']);
    }
}
