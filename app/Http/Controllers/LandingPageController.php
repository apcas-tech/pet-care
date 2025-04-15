<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the JWT token from the cookie
        $token = $request->cookie('in_session');

        // Check if the token exists and is valid
        if ($token) {
            // Check if the token is expired and remove it if necessary
            $this->checkAndRemoveExpiredToken($token);

            try {
                JWTAuth::setToken($token);

                // Check if the token is authenticated (valid)
                if (JWTAuth::authenticate()) {
                    return redirect()->route('home.page');
                }
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                // Do nothing; proceed to load the landing page
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                // Token is expired, proceed to load the landing page
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                // General JWT exception, proceed to load the landing page
            }
        }

        // If no valid token, load the landing page
        return view('landing.landing');
    }

    /**
     * Check if the token is expired and remove it from the cookie if it is.
     */
    private function checkAndRemoveExpiredToken($token)
    {
        try {
            JWTAuth::setToken($token);
            // Attempt to authenticate the token
            JWTAuth::authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Token is expired, remove it from the cookie
            Cookie::queue(Cookie::forget('in_session'));
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            // Token is invalid, remove it from the cookie
            Cookie::queue(Cookie::forget('in_session'));
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // General JWT exception, you may choose to log this
        }
    }
}
