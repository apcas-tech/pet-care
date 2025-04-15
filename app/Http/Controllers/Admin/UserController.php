<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\VetContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Add this line
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        $users = Admin::where('role', '!=', 'Super Admin')->get(); // Fetch all users
        $branches = VetContact::all();
        return view('bfc-animalclinic-inner-system.users.users', compact('users', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Fname' => 'required|string|max:255',
            'Mname' => 'nullable|string|max:255',
            'Lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'branch_id' => 'required|exists:vet_contacts,id',
            'role' => 'required|string',
            'capabilities' => 'nullable|array',
            'pages' => 'nullable|array',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
        ]);

        // Handle profile picture upload and convert to WEBP
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imagePath = 'profile_pictures/' . Str::uuid() . '.webp'; // Save as WEBP format

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

                $validated['profile_pic'] = $imagePath;
            }
        }

        // Store capabilities and pages as JSON
        $validated['capabilities'] = json_encode($request->capabilities ?? []);
        $validated['pages'] = json_encode($request->pages ?? []);

        // Create User
        $user = Admin::create([
            'Fname' => $validated['Fname'],
            'Mname' => $validated['Mname'] ?? null,
            'Lname' => $validated['Lname'],
            'email' => $validated['email'],
            'branch_id' => $validated['branch_id'],
            'role' => $validated['role'],
            'capabilities' => $validated['capabilities'],
            'pages' => $validated['pages'],
            'profile_pic' => $validated['profile_pic'] ?? null,
            'password' => Hash::make('@bfcClinic123'), // Default password (should be changed later)
        ]);

        return redirect()->back()->with('status', 'User Added successfully.');
    }

    public function edit($id)
    {
        $user = Admin::findOrFail($id); // Find the user by ID

        // If capabilities and pages are already arrays, skip decoding
        $capabilities = is_array($user->capabilities) ? $user->capabilities : json_decode($user->capabilities, true);
        $pages = is_array($user->pages) ? $user->pages : json_decode($user->pages, true);

        return response()->json([
            'id' => $user->id,
            'Fname' => $user->Fname,
            'Mname' => $user->Mname,
            'Lname' => $user->Lname,
            'email' => $user->email,
            'role' => $user->role,
            'capabilities' => $capabilities,
            'pages' => $pages,
            'profile_pic' => $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('imgs/default-user.png'),
            'branch_id' => $user->branch_id, // Include branch_id
        ]);
    }

    public function update(Request $request, $id)
    {
        Log::info('Update function called.', ['request_data' => $request->all()]);

        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to edit users.');
            return redirect()->back();
        }

        // Validate the request
        $request->validate([
            'Fname' => 'required|string|max:255',
            'Mname' => 'nullable|string|max:255',
            'Lname' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,' . $id,
            'role' => 'required|in:Admin,Vet',
            'capabilities' => 'nullable|array',
            'pages' => 'nullable|array',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,webp|max:10240',
            'branch_id' => 'required|exists:vet_contacts,id',
        ]);

        // Find the user
        $user = Admin::find($id);

        if (!$user) {
            Log::error('User not found.', ['user_id' => $id]);
            return redirect()->back()->with('error', 'User not found.');
        }

        DB::enableQueryLog();

        // Log user before update
        Log::info('User before update:', $user->toArray());

        // Update fields
        $user->Fname = $request->Fname;
        $user->Mname = $request->Mname;
        $user->Lname = $request->Lname;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->capabilities = json_encode($request->capabilities);
        $user->pages = json_encode($request->pages);
        $user->branch_id = $request->branch_id;

        if ($request->hasFile('profile_pic')) {
            // Delete the old profile picture if it exists
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
                Log::info('Previous profile picture deleted successfully.', ['user_id' => $id]);
            }

            // Process and save the new profile picture
            $image = $request->file('profile_pic');
            $imagePath = 'profile_pictures/' . Str::uuid() . '.webp';

            $imageResource = match ($image->getClientOriginalExtension()) {
                'jpeg', 'jpg' => imagecreatefromjpeg($image->getPathname()),
                'png' => imagecreatefrompng($image->getPathname()),
                'gif' => imagecreatefromgif($image->getPathname()),
                'webp' => imagecreatefromwebp($image->getPathname()),
                default => null
            };

            if ($imageResource) {
                $webpPath = storage_path('app/public/' . $imagePath);
                imagewebp($imageResource, $webpPath, 80);
                imagedestroy($imageResource);

                $user->profile_pic = $imagePath;
            }
        }

        // Log user after update
        Log::info('User after update:', [
            'Fname' => $user->Fname,
            'Mname' => $user->Mname,
            'Lname' => $user->Lname,
            'email' => $user->email,
            'role' => $user->role,
            'capabilities' => $user->capabilities,
            'pages' => $user->pages,
            'branch_id' => $user->branch_id,
        ]);

        if ($user->save()) {
            Log::info('User successfully updated.', ['user_id' => $id]);
        } else {
            Log::error('User update failed.', ['user_id' => $id]);
        }

        Log::info('Executed query:', DB::getQueryLog());

        return redirect()->back()->with('status', 'User updated successfully.');
    }

    public function resetPassword($id)
    {
        $user = Admin::findOrFail($id);
        $newPassword = '@bfcClinic123';

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password has been reset successfully!']);
    }

    public function destroy($id, Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('delete', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Find the user
        $user = Admin::findOrFail($id);

        // Delete profile picture if it exists
        // Delete profile picture if it exists
        if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
            Storage::disk('public')->delete($user->profile_pic);
        }

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->back()->with('status', 'User deleted successfully.');
    }
}
