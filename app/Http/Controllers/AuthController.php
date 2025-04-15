<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private function generateToken($user)
    {
        $token = JWTAuth::fromUser($user);
        Cookie::queue('in_session', $token, 60 * 24 * 2, '/', null, true, true);
        return $token;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return back()->with('error', 'Invalid credentials');
        }

        $this->generateToken(auth()->user());
        $request->headers->set('Authorization', 'Bearer ' . $token);

        return redirect()->route('home.page')->with('status', 'Login successful');
    }

    public function register(Request $request)
    {
        $commonPasswords = explode("\n", file_get_contents(storage_path('app/passwords/blacklist.txt')));

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if (in_array($request->password, $commonPasswords)) {
            return back()->with('error', 'This password is too common and cannot be used.');
        }

        if (PetOwner::where('email', $request->email)->exists()) {
            return back()->with('error', 'The email already exists.');
        }

        try {
            $petOwner = new PetOwner();
            $petOwner->id = (string) Str::uuid();
            $petOwner->Fname = ucwords(strtolower($request->first_name));
            $petOwner->Lname = ucwords(strtolower($request->last_name));
            $petOwner->Mname = isset($request->middle_name) ? ucwords(strtolower($request->middle_name)) : '';
            $petOwner->email = $request->email;
            $petOwner->phone = $request->phone;
            $petOwner->address = ucwords(strtolower($request->municipality)) . ', ' .
                ucwords(strtolower($request->brgy)) . ', ' .
                ucwords(strtolower($request->address));
            $petOwner->password = Hash::make($request->password);
            $petOwner->verified_at = now();
            $petOwner->save();

            $this->generateToken($petOwner);
            $request->headers->set('Authorization', 'Bearer ' . JWTAuth::fromUser($petOwner));

            Mail::to($petOwner->email)->send(new WelcomeEmail($petOwner));

            return redirect()->route('home.page')->with('status', 'Registration successful');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        try {
            // Get the token from the Authorization header or cookie
            $token = $request->bearerToken() ?? $request->cookie('in_session');

            if (!$token) {
                return back()->with('error', 'No active session found.');
            }

            // Invalidate the token
            JWTAuth::setToken($token)->invalidate(true);

            // Clear the session cookie
            Cookie::queue(Cookie::forget('in_session'));

            return redirect()->route('landing.page')->with('status', 'Logged out successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to log out. Please try again.');
        }
    }
}
