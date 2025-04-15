<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetOwner;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $profilePic = $googleUser->user['picture'] ?? null; // Ensure profile pic is set

            // Store Google user details in session
            Session::put('google_user', [
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'Fname' => $googleUser->user['given_name'],
                'Lname' => $googleUser->user['family_name'] ?? null,
                'profile_pic' => $profilePic, // Store profile picture
            ]);

            // Check if user exists in database
            $user = PetOwner::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                return redirect()->route('auth.fill-details', ['google_id' => $googleUser->getId()]);
            }

            return $this->loginExistingGoogleUser($user);
        } catch (\Exception $e) {
            return redirect()->route('auth.login')->with('error', 'Failed to authenticate with Google.');
        }
    }

    public function loginExistingGoogleUser($user)
    {
        $token = JWTAuth::fromUser($user);
        Cookie::queue('in_session', $token, 60 * 24 * 2, null, null, false, true);

        return redirect()->route('home.page')->with('status', 'Logged in with Google!');
    }

    public function showDetailsForm($google_id)
    {
        return view('auth.fill-details', compact('google_id'));
    }

    public function saveDetails(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'municipality' => 'required|string',
            'brgy' => 'required|string',
        ]);

        // Format address properly
        $fullAddress = ucwords(strtolower($validated['address'])) . ', ' .
            ucwords(strtolower($validated['brgy'])) . ', ' .
            ucwords(strtolower($validated['municipality']));

        // Retrieve session data
        $googleUserData = Session::get('google_user');

        if ($googleUserData) {
            $userId = (string) Str::uuid();
            // Insert into database
            $user = PetOwner::create([
                'id' => $userId,
                'email' => $googleUserData['email'],
                'google_id' => $googleUserData['google_id'],
                'Fname' => $googleUserData['Fname'],
                'Lname' => $googleUserData['Lname'],
                'phone' => $validated['phone'],
                'address' => $fullAddress,
                'profile_pic' => $googleUserData['profile_pic'], // Save profile picture
                'verified_at' => now(),
            ]);

            // Generate JWT token
            $token = JWTAuth::fromUser($user);
            Cookie::queue('in_session', $token, 60 * 24 * 2, null, null, false, true);

            // Clear session data
            Session::forget('google_user');

            return redirect()->route('home.page')->with('status', 'Registration complete, logged in with Google!');
        }

        return redirect()->route('auth.login')->with('error', 'Failed to complete registration.');
    }
}
