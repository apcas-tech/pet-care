<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $pets = Pet::with('owner')->paginate(45);

        return view('bfc-animalclinic-inner-system.pets.pets', compact('pets'));
    }

    public function fetchOwners()
    {
        $owners = PetOwner::select('id', 'Fname', 'Lname', 'Mname')->get();
        return response()->json($owners);
    }

    public function store(Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('create', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        $request->validate([
            'owner_id' => 'required|exists:pet_owners,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'bday' => 'required|date',
            'weight' => 'required|numeric|min:0',
            'special_char' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
        ]);

        $petData = $request->all();
        $petData['name'] = ucfirst(strtolower($request->input('name')));
        $petData['breed'] = $request->has('breed') ? ucfirst(strtolower($request->input('breed'))) : null;

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imagePath = 'pets/' . Str::uuid() . '.webp'; // Save as WEBP format

            $imageResource = null;

            switch ($image->getClientOriginalExtension()) {
                case 'jpeg':
                case 'jpg':
                    $imageResource = imagecreatefromjpeg($image->getPathname());
                    break;
                case 'png':
                    $imageResource = imagecreatefrompng($image->getPathname());
                    break;
                case 'gif':
                    $imageResource = imagecreatefromgif($image->getPathname());
                    break;
                case 'webp':
                    $imageResource = imagecreatefromwebp($image->getPathname());
                    break;
            }

            if ($imageResource) {
                $webpPath = storage_path('app/public/' . $imagePath);
                imagewebp($imageResource, $webpPath, 80); // Quality level (0-100)
                imagedestroy($imageResource);

                // Add the path to the pet data
                $petData['profile_pic'] = $imagePath;
            }
        }

        $petData['id'] = (string) Str::uuid();

        $pet = Pet::create($petData);

        $owner = PetOwner::findOrFail($request->input('owner_id'));
        $owner->increment('no_pets');

        session()->flash('status', 'Fur Pal, ' . $pet->name . ' has been added successfully!');

        return redirect()->back();
    }

    public function show($petId)
    {
        $pet = Pet::with('owner')->findOrFail($petId);
        $owner = $pet->owner;

        // Fetch vaccinations for the pet
        $vaccinations = $pet->vaccinations ?? collect(); // Ensure it's a collection

        // Fetch prescriptions (health records) for the pet
        $healthRecords = $pet->prescriptions()->with('veterinarian')->latest()->get();
        // Fetch users with role 'Vet' from admin_users table
        $veterinarians = Admin::where('role', 'Vet')->get();

        $speciesIcons = [
            'Dog' => asset('imgs/species/dog.webp'),
            'Cat' => asset('imgs/species/cat1.webp'),
        ];

        return view('bfc-animalclinic-inner-system.pets.profile.pet-profile', compact(
            'pet',
            'owner',
            'speciesIcons',
            'vaccinations',
            'veterinarians',
            'healthRecords'
        ));
    }

    public function update(Request $request, $id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'owner_id' => 'required|exists:pet_owners,id',
            'name' => 'required|string',
            'species' => 'required|string',
            'breed' => 'required|string',
            'bday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'weight' => 'required|numeric',
            'special_char' => 'nullable|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
        ]);

        try {
            $pet = Pet::findOrFail($id);

            $previousOwnerId = $pet->owner_id;
            $currentOwnerId = $validatedData['owner_id'];

            if ($previousOwnerId !== $currentOwnerId) {
                $previousOwner = PetOwner::findOrFail($previousOwnerId);
                $previousOwner->decrement('no_pets');

                $currentOwner = PetOwner::findOrFail($currentOwnerId);
                $currentOwner->increment('no_pets');
            }

            // Handle image compression when updating
            if ($request->hasFile('profile_pic')) {
                // Delete the previous profile picture if it exists
                if ($pet->profile_pic && Storage::exists('public/' . $pet->profile_pic)) {
                    Storage::delete('public/' . $pet->profile_pic);
                }

                $image = $request->file('profile_pic');
                $imagePath = 'pets/' . Str::uuid() . '.webp'; // Save as WEBP format

                $imageResource = null;

                switch ($image->getClientOriginalExtension()) {
                    case 'jpeg':
                    case 'jpg':
                        $imageResource = imagecreatefromjpeg($image->getPathname());
                        break;
                    case 'png':
                        $imageResource = imagecreatefrompng($image->getPathname());
                        break;
                    case 'gif':
                        $imageResource = imagecreatefromgif($image->getPathname());
                        break;
                    case 'webp':
                        $imageResource = imagecreatefromwebp($image->getPathname());
                        break;
                }

                if ($imageResource) {
                    $webpPath = storage_path('app/public/' . $imagePath);
                    imagewebp($imageResource, $webpPath, 80); // Quality level (0-100)
                    imagedestroy($imageResource);

                    $validatedData['profile_pic'] = $imagePath;
                }
            } else {
                $validatedData['profile_pic'] = $pet->profile_pic;
            }

            $pet->update([
                'owner_id' => $validatedData['owner_id'],
                'name' => ucfirst(strtolower($validatedData['name'])),
                'species' => ucfirst(strtolower($validatedData['species'])),
                'breed' => ucfirst(strtolower($validatedData['breed'])),
                'bday' => $validatedData['bday'],
                'gender' => $validatedData['gender'],
                'weight' => $validatedData['weight'],
                'special_char' => $validatedData['special_char'],
                'profile_pic' => $validatedData['profile_pic'],
            ]);

            return redirect()->route('admin.pet.show', ['petId' => $pet->id])->with('status', 'Pet Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to Update Pet.']);
        }
    }

    public function destroy($id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('delete', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        try {
            // Find the pet by ID
            $pet = Pet::findOrFail($id);

            // Get the pet's profile picture path
            $profilePicPath = $pet->profile_pic;

            // Delete the pet
            $pet->delete();

            // Decrement the pet count of the owner
            $owner = $pet->owner;
            $owner->decrement('no_pets');

            // Delete the profile picture from storage, if it exists
            if ($profilePicPath && Storage::exists('public/' . $profilePicPath)) {
                Storage::delete('public/' . $profilePicPath);
            }

            return redirect()->route('admin.pets')->with('status', 'Pet Deleted Successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to Delete Pet.']);
        }
    }
}
