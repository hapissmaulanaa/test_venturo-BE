<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    // Proses Menampilkan Semua Data Vehicle
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json(['vehicles' => $vehicles]);
    }

    // Proses Menampilkan Data Vehicle by ID
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json(['vehicle' => $vehicle]);
    }

    // Proses ADD Vehicle
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'merk' => 'required',
            'registration_number' => 'required',
        ]);

        $vehicle = Vehicle::create([
            'type' => $validatedData['type'],
            'merk' => $validatedData['merk'],
            'registration_number' => $validatedData['registration_number'],
        ]);

        return response()->json(['message' => 'Vehicle created successfully', 'vehicle' => $vehicle]);
    }

    // Proses UPDATE/EDIT Vehicle
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required',
            'merk' => 'required',
            'registration_number' => 'required',
        ]);

        $vehicle->update([
            'type' => $validatedData['type'],
            'merk' => $validatedData['merk'],
            'registration_number' => $validatedData['registration_number'],
        ]);

        return response()->json(['message' => 'Vehicle updated successfully', 'vehicle' => $vehicle]);
    }

    // Proses DELETE Vehicle
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully']);
    }
}
