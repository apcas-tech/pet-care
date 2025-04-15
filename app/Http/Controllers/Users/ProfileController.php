<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Support\Str;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('bfc_animalclinic.profile.profile');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('bfc_animalclinic.profile.edit_profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = PetOwner::find(auth()->id());

        $validator = Validator::make($request->all(), [
            'Fname' => 'required|string|max:255',
            'Mname' => 'nullable|string|max:255',
            'Lname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update user details
        $user->Fname = ucfirst(strtolower($request->input('Fname')));
        $user->Mname = $request->filled('Mname') ? ucfirst(strtolower($request->input('Mname'))) : null;
        $user->Lname = ucfirst(strtolower($request->input('Lname')));
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imagePath = 'profile_pics/' . Str::uuid() . '.webp'; // Save as WEBP format

            // Convert the image to WEBP
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
                imagewebp($imageResource, $webpPath, 80); // 80 is the quality level (0-100)
                imagedestroy($imageResource);

                // Delete old profile picture if it exists
                if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                    Storage::disk('public')->delete($user->profile_pic);
                }

                // Save new profile picture path
                $user->profile_pic = $imagePath;
            }
        }

        $user->save();

        return redirect()->route('profile.page')->with('status', 'Profile updated successfully!');
    }

    public function addPet()
    {
        return view('bfc_animalclinic.profile.add-pet');
    }

    public function myPet()
    {
        $pets = Pet::with('vaccinations.veterinarian', 'prescriptions.veterinarian')->where('owner_id', auth()->id())->get();
        return view('bfc_animalclinic.profile.my-pets', compact('pets'));
    }

    public function storePet(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $petData = $request->all();
        $petData['name'] = ucfirst(strtolower($request->input('name')));
        $petData['breed'] = $request->has('breed') ? ucfirst(strtolower($request->input('breed'))) : null;

        // Handle profile picture conversion to WEBP
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imagePath = 'pets/' . Str::uuid() . '.webp'; // Save as WEBP format

            // Convert the image to WEBP
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

        return redirect()->route('home.page');
    }

    public function destroyPet($id)
    {
        // Find the pet by ID and ensure it belongs to the authenticated user
        $pet = Pet::where('id', $id)->where('owner_id', auth()->id())->firstOrFail();

        // Delete the pet record
        $pet->delete();

        // Decrement the owner's no_pets field
        $owner = PetOwner::findOrFail(auth()->id());
        $owner->decrement('no_pets');
    }
}
