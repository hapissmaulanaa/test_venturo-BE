<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    // Proses Menampilkan Semua Data DRIVER
    public function index()
    {
        $drivers = Driver::all();
        return response()->json(['drivers' => $drivers]);
    }

    // Proses Menampilkan Data DRIVER by ID
    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        return response()->json(['driver' => $driver]);
    }

    // Proses ADD Data Driver
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:drivers',
            'phone' => 'required|string|max:15',
        ]);

        $driver = Driver::create([
            'name' => $validatedData['name'],
            'license_number' => $validatedData['license_number'],
            'phone' => $validatedData['phone'],
        ]);

        return response()->json(['message' => 'Driver created successfully', 'driver' => $driver]);
    }

    // Proses UPDATE/EDIT Data Driver
    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'license_number' => 'sometimes|required|string|max:255|unique:drivers,license_number,' . $driver->id,
            'phone' => 'sometimes|required|string|max:15',
        ]);

        $driver->update([
            'name' => $validatedData['name'] ?? $driver->name,
            'license_number' => $validatedData['license_number'] ?? $driver->license_number,
            'phone' => $validatedData['phone'] ?? $driver->phone,
        ]);

        return response()->json(['message' => 'Driver updated successfully', 'driver' => $driver]);
    }

    // Proses DELETE Data Driver
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return response()->json(['message' => 'Driver deleted successfully']);
    }
}
