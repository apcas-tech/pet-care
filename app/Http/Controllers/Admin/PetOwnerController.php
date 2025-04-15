<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetOwner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PetOwnerController extends Controller
{
    public function index(Request $request)
    {
        $petOwners = PetOwner::with('pets')->get();
        return view('bfc-animalclinic-inner-system.petOwners.petowners', compact('petOwners'));
    }

    public function store(Request $request)
    {
        // Validate input fields
        $request->validate([
            'fname'       => 'required|string|max:255',
            'mname'       => 'nullable|string|max:255',
            'lname'       => 'required|string|max:255',
            'email'       => 'required|email|unique:pet_owners,email',
            'phone'       => 'required|string|max:20',
            'address'    => 'required|string|max:255',
            'barangay'    => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
        ]);

        // Generate unique ID
        $id = Str::uuid()->toString();

        // Create the pet owner
        $petOwner = PetOwner::create([
            'id'        => $id,
            'Fname'     => ucfirst(strtolower($request->fname)),
            'Mname'     => $request->mname ? ucfirst(strtolower($request->mname)) : null,
            'Lname'     => ucfirst(strtolower($request->lname)),
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => ucwords(strtolower("{$request->address}, {$request->barangay}, {$request->municipality}")),
            'password'  => Hash::make('defaultpassword'), // Default password (change later)
            'no_pets'   => 0,
            'verified_at' => null,
            'profile_pic' => null
        ]);

        // Return success response
        return back()->with('status', 'Pet owner created successfully.');
    }

    public function destroy($id)
    {
        $petOwner = PetOwner::with('pets', 'appointments')->find($id);

        if (!$petOwner) {
            return back()->with('error', 'Pet owner not found.');
        }

        // Delete the pet owner
        $petOwner->delete();

        return back()->with('status', 'Pet owner deleted successfully.');
    }
}
