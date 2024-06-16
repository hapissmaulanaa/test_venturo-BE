<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingApproval;
use App\Models\VehicleBooking;

class BookingApprovalController extends Controller
{
    //Proses Menampilkan Semua DATA BOOKING
    public function index()
    {
        $approvals = BookingApproval::with('booking', 'approver')->get();
        return response()->json(['approvals' => $approvals]);
    }

    // Proses APPROVED(disetujui) Booking 
    public function approve(Request $request, $id)
    {
        $booking = VehicleBooking::findOrFail($id);

        $approval = BookingApproval::create([
            'booking_id' => $booking->id,
            'approver_id' => auth()->id(),
            'status' => 'approved',
        ]);

        $booking->update(['status' => 'approved']);

        return response()->json(['message' => 'Booking approved successfully', 'approval' => $approval]);
    }

    // Proses REJECTED(ditolak) Booking
    public function reject(Request $request, $id)
    {
        $booking = VehicleBooking::findOrFail($id);

        $approval = BookingApproval::create([
            'booking_id' => $booking->id,
            'approver_id' => auth()->id(),
            'status' => 'rejected',
        ]);

        $booking->update(['status' => 'rejected']);

        return response()->json(['message' => 'Booking rejected successfully', 'approval' => $approval]);
    }


}
