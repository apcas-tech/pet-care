<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdoptablePet;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PetListController extends Controller
{
    public function index(Request $request)
    {
        $adoptablePets = AdoptablePet::all();
        return view('bfc-animalclinic-inner-system.pet-listing.pet-listing', compact('adoptablePets'));
    }

    public function store(Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('create', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate input data
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:Male,Female',
            'species'     => 'required|string|max:255',
            'breed'       => 'required|string|max:255',
            'weight'      => 'required|numeric|min:0',
            'bday'        => 'required|date',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
            'remarks'     => 'nullable|string|max:500',
        ]);

        // Generate a UUID for the pet ID
        $petId = Str::uuid()->toString();

        // Handle profile picture upload and compression
        $imagePath = null;
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = $petId . '.webp'; // Save as .webp
            $imagePath = 'profile_pics/' . $imageName;

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
                imagewebp($imageResource, $webpPath, 80); // Compress with quality 80
                imagedestroy($imageResource);
            }

            $validatedData['profile_pic'] = $imagePath;
        }

        // Store pet in database
        AdoptablePet::create([
            'id'          => $petId,
            'name'        => $validatedData['name'],
            'gender'      => $validatedData['gender'],
            'species'     => $validatedData['species'],
            'breed'       => $validatedData['breed'],
            'weight'      => $validatedData['weight'],
            'bday'        => $validatedData['bday'],
            'profile_pic' => $imagePath,
            'remarks'     => $validatedData['remarks'] ?? null,
        ]);

        return redirect()->route('admin.pet-listings')->with('status', 'Adoption Pet Added Successfully!');
    }

    public function show($id)
    {
        $pet = AdoptablePet::with(['prescriptions.veterinarian', 'vaccinations.veterinarian'])->findOrFail($id);
        $speciesIcons = [
            'Dog' => asset('imgs/species/dog.webp'),
            'Cat' => asset('imgs/species/cat1.webp')
        ];

        // Fetch health records and vaccinations
        $healthRecords = $pet->prescriptions;
        $vaccinations = $pet->vaccinations;

        // Fetch veterinarians
        $veterinarians = Admin::where('role', 'Vet')->get();

        return view('bfc-animalclinic-inner-system.pet-listing.profile.pet-profile', compact('pet', 'speciesIcons', 'healthRecords', 'vaccinations', 'veterinarians'));
    }

    public function update(Request $request, $id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Validate input data
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:Male,Female',
            'species'     => 'required|string|max:255',
            'breed'       => 'required|string|max:255',
            'weight'      => 'required|numeric|min:0',
            'bday'        => 'required|date',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
            'remarks'     => 'nullable|string|max:500',
        ]);

        // Find the pet
        $pet = AdoptablePet::findOrFail($id);

        // Handle profile picture update
        if ($request->hasFile('profile_pic')) {
            if ($pet->profile_pic) {
                Storage::delete('public/' . $pet->profile_pic);
            }

            $image = $request->file('profile_pic');
            $imageName = $pet->id . '.webp'; // Save as .webp
            $imagePath = 'profile_pics/' . $imageName;

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
                imagewebp($imageResource, $webpPath, 80); // Compress with quality 80
                imagedestroy($imageResource);
            }

            $validatedData['profile_pic'] = $imagePath;
        }

        // Update pet details
        $pet->update($validatedData);

        return redirect()->route('admin.pet.profile', $id)->with('status', 'Pet details updated successfully!');
    }

    public function destroy($id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('delete', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Find the pet
        $pet = AdoptablePet::findOrFail($id);

        // Delete the profile picture if it exists
        if ($pet->profile_pic) {
            Storage::delete('public/' . $pet->profile_pic);
        }

        // Delete the pet record from the database
        $pet->delete();

        return redirect()->route('admin.pet-listings')->with('status', 'Pet deleted successfully!');
    }
}
