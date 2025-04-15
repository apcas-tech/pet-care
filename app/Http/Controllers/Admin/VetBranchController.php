<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VetContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VetBranchController extends Controller
{
    public function index()
    {
        $branches = VetContact::all();
        return view('bfc-animalclinic-inner-system.branches.branch', compact('branches'));
    }
    public function store(Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('create', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate input
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9\+\-\(\) ]+$/',
        ]);

        // Create new branch with UUID
        VetContact::create([
            'id'           => Str::uuid(), // 👈 Assign UUID manually
            'name'         => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        // Redirect with success message
        return redirect()->route('admin.branches')->with('status', 'Branch added successfully!');
    }

    public function show($id)
    {
        $branch = VetContact::findOrFail($id);
        return response()->json($branch); // Return branch data as JSON
    }

    public function update(Request $request, $id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate input
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9\+\-\(\) ]+$/',
        ]);

        // Find the branch by ID
        $branch = VetContact::findOrFail($id);

        // Update branch details
        $branch->update([
            'name'         => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        // Redirect with success message
        return redirect()->route('admin.branches')->with('status', 'Branch updated successfully!');
    }

    public function destroy($id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('delete', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Find the branch
        $branch = VetContact::findOrFail($id);

        // Delete the branch
        $branch->delete();

        // Redirect with success message
        return redirect()->route('admin.branches')->with('status', 'Branch deleted successfully!');
    }
}
