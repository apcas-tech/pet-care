<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all services from the database
        $services = Service::all();

        // Pass the services to the view
        return view('bfc-animalclinic-inner-system.services.services', compact('services'));
    }

    public function store(Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('create', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate the request data
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Create a new service
        Service::create($validated);

        // Redirect back to the service list page with a success message
        return redirect()->route('admin.services')->with('success', 'Service added successfully!');
    }

    public function edit($id)
    {
        // Fetch the service data
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate the request data
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Find the service and update it
        $service = Service::findOrFail($id);
        $service->update($validated);

        // Redirect back to the service list page with a success message
        return redirect()->route('admin.services')->with('success', 'Service updated successfully!');
    }

    public function destroy($id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('delete', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Find the service and delete it
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Service deleted successfully!');
    }
}
