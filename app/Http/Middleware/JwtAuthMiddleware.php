<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('in_session') ?? $request->bearerToken();

        if (!$token) {
            return $this->redirectToLogin('Please log in to access this page.');
        }

        try {
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return $this->redirectToLogin('Invalid token. Please log in again.');
            }

            // Extract token details
            $payload = JWTAuth::getPayload($token);
            $exp = $payload->get('exp'); // Token expiry timestamp
            $iat = $payload->get('iat'); // Token issued timestamp
            $currentTime = now()->timestamp;

            // Only refresh if:
            // - Within 5 minutes of expiry
            // - Token is at least 10 minutes old (to avoid refreshing too soon)
            if (($exp - $currentTime) <= 300 && ($currentTime - $iat) >= 600) {
                $newToken = JWTAuth::refresh($token);
                Cookie::queue('in_session', $newToken, 60 * 24 * 2, '/', null, true, true);
                $request->headers->set('Authorization', 'Bearer ' . $newToken);
            }

            // Share additional user details
            $fullName = trim("{$user->Fname} " . ($user->Mname ? strtoupper(substr($user->Mname, 0, 1)) . ". " : "") . "{$user->Lname}");
            view()->share('user', $user);
            view()->share('user_name', $fullName);
            view()->share('user_email', $user->email);
        } catch (TokenExpiredException $e) {
            Log::warning('Expired token detected', ['exception' => $e->getMessage()]);
            return $this->handleExpiredToken($token);
        } catch (TokenInvalidException $e) {
            Log::warning('Invalid token detected', ['exception' => $e->getMessage()]);
            return $this->handleInvalidToken($token);
        } catch (JWTException $e) {
            Log::error('JWT exception occurred', ['exception' => $e->getMessage()]);
            return $this->handleInvalidToken($token);
        }

        return $next($request);
    }

    private function handleExpiredToken($token)
    {
        $this->invalidateToken($token);
        return $this->redirectToLogin('Your session has expired. Please log in again.');
    }

    private function handleInvalidToken($token)
    {
        $this->invalidateToken($token);
        return $this->redirectToLogin('Token is invalid. Please log in again.');
    }

    private function invalidateToken($token)
    {
        try {
            JWTAuth::setToken($token)->invalidate();
            Log::info('Token invalidated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to invalidate token', ['exception' => $e->getMessage()]);
        }

        Cookie::queue(Cookie::forget('in_session'));
    }

    private function redirectToLogin($message)
    {
        return redirect()->route('landing.page')->withErrors(['error' => $message]);
    }
}
