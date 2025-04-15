<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

class JwtAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('admin_session');

        if (!$token) {
            return $this->redirectToLogin('Please log in as an admin to access this page.');
        }

        try {
            $request->headers->set('Authorization', 'Bearer ' . $token);
            JWTAuth::setToken($token);

            if (!JWTAuth::setToken($token)->check()) {
                return $this->redirectToLogin('Invalid token or token is expired');
            }

            $admin = auth('admins')->user();

            if (!$admin) {
                return $this->redirectToLogin('Unauthorized access. Admin credentials required.');
            }

            // Extract token details
            $payload = JWTAuth::getPayload($token);
            $iat = $payload->get('iat'); // Issued at timestamp
            $currentTime = now()->timestamp;

            // Refresh token if it's 60 minutes old or older
            if (($currentTime - $iat) >= 3600) { // 3600 seconds = 60 minutes
                $newToken = JWTAuth::refresh($token);
                Cookie::queue('admin_session', $newToken, 60 * 8, null, null, false, true);
                $request->headers->set('Authorization', 'Bearer ' . $newToken);
            }

            $profilePicPath = $admin->profile_pic
                ? asset('storage/' . $admin->profile_pic)
                : asset('imgs/default-user.webp');

            // Share additional user details
            $fullName = trim("{$admin->Fname} " . ($admin->Mname ? strtoupper(substr($admin->Mname, 0, 1)) . ". " : "") . "{$admin->Lname}");
            view()->share('admin', $admin);
            view()->share('admin_name', $fullName);
            view()->share('admin_email', $admin->email);
            view()->share('admin_profile_pic', $profilePicPath);

            if ($admin->role === 'Super Admin') {
                view()->share('admin_pages', ['Dashboard', 'Appointments', 'Services', 'Pets', 'Pet Adoption Listings', 'Pet Owners', 'Users', 'Branch']);
                view()->share('admin_capabilities', ['create', 'edit', 'delete']);
            } else {
                view()->share('admin_pages', is_string($admin->pages) ? json_decode($admin->pages, true) : ($admin->pages ?? []));
                view()->share('admin_capabilities', is_string($admin->capabilities)
                    ? json_decode($admin->capabilities, true)
                    : ($admin->capabilities ?? []));
            }
        } catch (TokenExpiredException $e) {
            return $this->handleExpiredToken($token);
        } catch (TokenInvalidException $e) {
            return $this->handleInvalidToken($token);
        } catch (JWTException $e) {
            return $this->handleInvalidToken($token);
        }

        return $next($request);
    }

    private function handleExpiredToken($token)
    {
        $this->invalidateToken($token);
        return $this->redirectToLogin('Your admin session has expired. Please log in again.');
    }

    private function handleInvalidToken($token)
    {
        $this->invalidateToken($token);
        return $this->redirectToLogin('Admin token is invalid. Please log in again.');
    }

    private function invalidateToken($token)
    {
        try {
            JWTAuth::setToken($token)->invalidate();
        } catch (\Exception $e) {
        }

        Cookie::queue(Cookie::forget('admin_session'));
    }

    private function redirectToLogin($message)
    {
        return redirect()->route('admin.login')->withErrors(['error' => $message]);
    }
}
