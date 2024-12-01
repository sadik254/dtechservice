<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create and return a token
        // $token = $user->createToken('YourAppName')->plainTextToken;
         // Create the token
        $plainTextToken = $user->createToken('YourAppName')->plainTextToken;

        // Extract the token part after the '|'
        $token = explode('|', $plainTextToken)[1];

        return response()->json(['token' => $token, 'user_id' => $user->id,]);
    }

    // Registration method
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // $token = $user->createToken('YourAppName')->plainTextToken;
        $plainTextToken = $user->createToken('YourAppName')->plainTextToken;

        // Extract the token part after the '|'
        $token = explode('|', $plainTextToken)[1];

        return response()->json(['token' => $token, 'user_id' => $user->id,]);
    }

    public function update(Request $request)
    {
        // Ensure the user is authenticated
        $user = $request->user();

        // Validate the incoming request data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:20',
        ]);

        // Update the user's profile with the validated data
        $user->update($request->only(['name', 'email', 'phone']));

        // Return the updated user data as a response
        return response()->json(['user' => $user], 200);
    }

    public function forgotPassword(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Generate the reset token
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent successfully.']);
        } else {
            return response()->json(['error' => 'Unable to send reset link.'], 500);
        }
    }

    public function show(Request $request)
    {
        // Get the authenticated user
        $user = $request->user(); // This will get the authenticated user

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        return response()->json($user);
    }
}
