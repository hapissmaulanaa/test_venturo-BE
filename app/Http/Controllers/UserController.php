<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Proses Menampilkan Semua Data User
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    // Proses Menampilkan Data User by ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    // Proses ADD User
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'role' => ['required', Rule::in(['admin', 'approver'])],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    // Proses UPDATE/EDIT User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|nullable|string',
            'role' => ['sometimes', 'required', Rule::in(['admin', 'approver'])],
        ]);

        $user->update([
            'name' => $validatedData['name'] ?? $user->name,
            'email' => $validatedData['email'] ?? $user->email,
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            'role' => $validatedData['role'] ?? $user->role,
        ]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // Proses DELETE User 
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Proses LOGIN
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Login successful', 'token' => $token, 'user' => $user]);
    }

    // Proeses LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
