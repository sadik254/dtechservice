<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index(Request $request)
    {
        $appointments = Appointment::with(['user', 'service', 'admin'])->paginate(10);
        return response()->json($appointments);
    }

    /**
     * Store a new appointment in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
        ]);

        $appointment = Appointment::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        return response()->json(['message' => 'Appointment created successfully.', 'appointment' => $appointment], 201);
    }

    /**
     * Display a specific appointment.
     */
    public function show($id)
    {
        $appointment = Appointment::with(['user', 'service', 'admin'])->find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        return response()->json($appointment);
    }

    /**
     * Update an existing appointment.
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:pending,confirmed,canceled',
            'admin_id' => 'sometimes|exists:admins,id',
            'appointment_date' => 'sometimes|date',
        ]);

        $appointment->update($validated);

        return response()->json(['message' => 'Appointment updated successfully.', 'appointment' => $appointment]);
    }

    /**
     * Remove an appointment from the database.
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully.']);
    }
}
