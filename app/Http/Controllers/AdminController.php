<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Admin Registration
    public function register(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the admin
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate API token
        $token = $admin->createToken('AdminToken', ['admin'])->plainTextToken;

        return response()->json([
            'message' => 'Admin registered successfully',
            'token' => $token,
        ], 201);
    }

    // Admin Login
    public function login(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Generate API token
        $token = $admin->createToken('AdminToken', ['admin'])->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    // Show Profile
    public function show(Request $request)
    {
        // Get the authenticated admin
        $admin = $request->user(); // Since we're using Sanctum, the user is already authenticated

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        return response()->json($admin);
    }

    // Update Profile
    public function update(Request $request)
    {
        // Get the authenticated admin
        $admin = $request->user();

        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:admins,email,' . $admin->id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the admin's details
        if ($request->has('name')) {
            $admin->name = $request->name;
        }
        if ($request->has('email')) {
            $admin->email = $request->email;
        }
        if ($request->has('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $admin]);
    }
}
