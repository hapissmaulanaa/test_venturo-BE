<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleUsage;
use App\Models\VehicleBooking;

class VehicleUsageController extends Controller
{
    // Proses Menampilkan Semua Data Penggunaan Kendaraan
    public function index()
    {
        $usages = VehicleUsage::with(['vehicle', 'user', 'driver'])->get();
        return response()->json(['usages' => $usages]);
    }

    // Proses Menampilkan Data Penggunaan Kendaraan by ID
    public function show($id)
    {
        $usage = VehicleUsage::with(['vehicle', 'user', 'driver'])->findOrFail($id);
        return response()->json(['usage' => $usage]);
    }

    // Proses Menampilkan Data Penggunaan Kendaraan by Booking ID
    public function showByBookingId($bookingId)
    {
        $usages = VehicleUsage::with(['vehicle', 'user', 'driver'])
                    ->where('booking_id', $bookingId)
                    ->get();
        return response()->json(['usages' => $usages]);
    }

    // Proses ADD Data Vehicle Usage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:vehicle_bookings,id',
            'purpose' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $booking = VehicleBooking::findOrFail($validatedData['booking_id']);

        $usage = VehicleUsage::create([
            'vehicle_id' => $booking->vehicle_id,
            'user_id' => $booking->user_id,
            'driver_id' => $booking->driver_id,
            'booking_id' => $booking->id,
            'purpose' => $validatedData['purpose'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        return response()->json(['message' => 'Vehicle usage recorded successfully', 'usage' => $usage]);
    }

    // Proses UPDATE/EDIT Data Vehicle Usage
    public function update(Request $request, $id)
    {
        $usage = VehicleUsage::findOrFail($id);

        $validatedData = $request->validate([
            'purpose' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
        ]);

        $usage->update($validatedData);

        return response()->json(['message' => 'Vehicle usage updated successfully', 'usage' => $usage]);
    }

    // Proses DELETE Data Vehicle Usage
    public function destroy($id)
    {
        $usage = VehicleUsage::findOrFail($id);
        $usage->delete();

        return response()->json(['message' => 'Vehicle usage deleted successfully']);
    }
}
