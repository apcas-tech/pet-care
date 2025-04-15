<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function sendOTP(Request $request)
    {
        Log::info('Request received for OTP', $request->all());

        // Validate phone number
        $validated = $request->validate([
            'phone' => 'required|string|regex:/^63[0-9]{10}$/',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('phone', $validated['phone']);
        Session::put('otp_timestamp', now()); // Store the timestamp when OTP was sent

        Log::info('Generated OTP:', ['otp' => $otp]);

        // Prepare the phone number in international format without '+'
        $recipient = $validated['phone']; // Keep the full number

        // Get PhilSMS credentials
        $apiUrl = env('PHILSMS_URL');
        $apiKey = env('PHILSMS_API_KEY');
        $sender = env('PHILSMS_SENDER'); // Max 11 characters, no spaces

        // Validate API settings
        if (empty($apiUrl) || empty($apiKey)) {
            Log::error("PhilSMS API URL or Key is missing.");
            return response()->json(['message' => 'SMS sending failed: Invalid API configuration'], 500);
        }

        // Prepare the message payload
        $messageData = [
            'recipient' => $recipient,
            'sender_id' => $sender,
            'type' => 'plain',
            'message' => "Your OTP is: BFC - $otp. Do not share this with anyone.",
        ];

        // Send SMS via PhilSMS
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
            ])->post($apiUrl, $messageData);

            Log::info('PhilSMS Raw Response:', ['raw_response' => $response->body()]);

            Log::info('PhilSMS Response:', ['response' => $response->json()]);

            if ($response->successful() && $response->json()['status'] === 'success') {
                return response()->json(['message' => 'OTP sent successfully.']);
            } else {
                return response()->json(['message' => 'Failed to send OTP.', 'error' => $response->json()], 500);
            }
        } catch (\Exception $e) {
            Log::error("PhilSMS API error: " . $e->getMessage());
            return response()->json(['message' => 'Error sending OTP.', 'error' => $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $inputOtp = $request->input('otp');
        $sessionOtp = Session::get('otp');
        $otpTimestamp = Session::get('otp_timestamp');

        // Check if OTP is expired (5 minutes lifespan)
        if (now()->diffInMinutes($otpTimestamp) > 5) {
            return response()->json(['valid' => false, 'message' => 'OTP has expired. Please request a new one.']);
        }

        if ($inputOtp == $sessionOtp) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false]);
    }
}
