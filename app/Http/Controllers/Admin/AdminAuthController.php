<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('auth.adminlogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!$token = auth('admins')->attempt($credentials)) {
            return back()->with('error', 'Invalid credentials');
        }

        $admin = auth('admins')->user();

        Cookie::queue('admin_session', $token, 60 * 8, null, null, false, true);
        $request->headers->set('Authorization', 'Bearer ' . $token);

        return redirect()->route('admin.dashboard')->with('status', 'Login successful');
    }

    public function changePassword(Request $request)
    {
        try {
            // Get the admin ID from the authenticated session
            $adminId = auth('admins')->id();

            // Debug: Check if admin ID is retrieved
            if (!$adminId) {
                return response()->json(['message' => 'Unauthorized access.'], 401);
            }

            // Fetch the admin from the database
            $admin = Admin::find($adminId);

            // Debug: Check if admin record exists
            if (!$admin) {
                return response()->json(['message' => 'Admin not found.'], 404);
            }

            // Validate input
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            // Check if the current password matches
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json(['error' => 'Current password is incorrect.'], 401);
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return response()->json(['message' => 'Password updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Check logs.'], 500);
        }
    }

    public function adminLogout(Request $request)
    {
        try {
            // Get the token from the Authorization header or cookie
            $token = $request->bearerToken() ?? $request->cookie('admin_session');

            if (!$token) {
                return back()->with('error', 'No active session found.');
            }

            // Invalidate the token
            JWTAuth::setToken($token)->invalidate(true);

            // Clear the session cookie
            Cookie::queue(Cookie::forget('admin_session'));

            return redirect()->route('admin.login')->with('status', 'Logged out successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to log out. Please try again.');
        }
    }
}
