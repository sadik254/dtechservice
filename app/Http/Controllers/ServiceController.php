<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    // Create a new service
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer', // Assuming duration is in minutes
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the new service
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service,
        ], 201);
    }

    // Get all services
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    // Show a single service
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        return response()->json($service);
    }

    // Update a service
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'duration' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the service
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        // Update the service
        if ($request->has('name')) {
            $service->name = $request->name;
        }
        if ($request->has('description')) {
            $service->description = $request->description;
        }
        if ($request->has('price')) {
            $service->price = $request->price;
        }
        if ($request->has('duration')) {
            $service->duration = $request->duration;
        }

        $service->save();

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service,
        ]);
    }

    // Delete a service
    public function delete($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
