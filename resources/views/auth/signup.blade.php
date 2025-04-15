@extends('layouts.app')

@section('title', 'Login and Signup')

@section('content')
<x-toast />

<div class="signup-container flex items-center justify-center w-screen h-screen bg-gray-100 p-4 dark:bg-gray-900 text-black dark:text-white">
    <div class="flex flex-col w-full max-w-lg bg-white bg-opacity-10 backdrop-blur-sm rounded-lg shadow-lg overflow-hidden my-6" id="auth-container">

        <!-- Stepper -->
        <ol class="flex items-center justify-between w-full p-3 space-x-2 text-sm font-medium text-center bg-transparent rounded-lg sm:p-4 sm:space-x-4 rtl:space-x-reverse">
            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                    1
                </span>
                Step 1
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    2
                </span>
                Step 2
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-gray-500 dark:text-gray-400">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    3
                </span>
                Step 3
            </li>
        </ol>

        <div id="signup-container" class="flex flex-col w-full p-6">
            <!-- Signup Form -->
            <form id="signup-form" action="{{ route('auth.signup.post') }}" method="post">
                @csrf

                <!-- Step 1: Personal Info -->
                <div class="signup-step space-y-4" id="step-1">
                    <div class="relative mb-4">
                        <input type="email" id="email" name="email" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" required />
                        <label for="email" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm" id="email-label">Email</label>
                    </div>

                    <label class="block mb-4">
                        <div class="relative">
                            <input type="password" id="signup-password" name="password" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this), checkPasswordStrength()" required />
                            <label for="signup-password" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Password</label>
                            <i class="fas fa-eye absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600" id="signup-password-icon" onclick="togglePasswordVisibility('signup-password', 'signup-password-icon')"></i>
                        </div>

                        <div id="password-strength" class="hidden">
                            <div id="strength-indicator" class="h-2 bg-red-500 rounded-lg"></div>
                        </div>
                        <div id="password-feedback" class="text-red-600 mt-1 hidden"></div>
                    </label>

                    <label class="block mb-4">
                        <div class="relative">
                            <input type="password" id="signup-cpassword" name="password_confirmation" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" required />
                            <label for="signup-password" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Confirm Password</label>
                            <i class="fas fa-eye absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600" id="signup-cpassword-icon" onclick="togglePasswordVisibility('signup-cpassword', 'signup-cpassword-icon')"></i>
                        </div>
                    </label>
                    <button type="button" class="w-full bg-blue-900 text-white py-2 shadow-md" onclick="nextStep()">
                        Next Step
                    </button>
                </div>

                <!-- Step 2: Account Info -->
                <div class="signup-step" id="step-2" style="display:none;">
                    <label class="block mb-4">
                        <div class="relative mb-4">
                            <input type="text" name="first_name" id="first_name" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" required />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">First Name</label>
                        </div>
                        <div id="first_name-feedback" class="text-red-600 mt-1 hidden">First name is required.</div>
                    </label>

                    <label class="block mb-4">
                        <div class="relative mb-4">
                            <input type="text" name="last_name" id="last_name" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" required />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Last Name</label>
                        </div>
                        <div id="last_name-feedback" class="text-red-600 mt-1 hidden">Last name is required.</div>
                    </label>

                    <label class="block mb-4">
                        <div class="relative mb-4">
                            <input type="text" name="middle_name" id="middle_name" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Middle Name (Optional)</label>
                        </div>
                    </label>

                    <div class="flex justify-between">
                        <button type="button" class="w-auto py-2 px-14 bg-gray-600" onclick="prevStep()"><i class="fa-solid fa-chevron-left"></i></button>
                        <button type="button" class="w-auto py-2 px-14 bg-blue-900 text-white" onclick="nextStep()"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <!-- Step 3: Review -->
                <div class="signup-step" id="step-3" style="display:none;">
                    <!-- Phone Number Field -->
                    <div class="relative mb-4">
                        <input type="text" name="phone" id="phone"
                            class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent"
                            placeholder=" " oninput="handleInputChange(this)" autocomplete="off" maxlength="10" required />
                        <label for="phone"
                            class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">
                            Phone (+63)
                        </label>
                    </div>
                    <button type="button" id="sendOtpBtn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md">Send OTP</button>

                    <!-- OTP Verification Field -->
                    <div class="relative mb-4 hidden" id="otpContainer">
                        <input type="number" name="otp" id="otp"
                            class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent"
                            placeholder=" " oninput="handleInputChange(this)" autocomplete="off" maxlength="6" data-otp-verified="false" />
                        <label for="otp"
                            class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">
                            Enter OTP
                        </label>
                        <p id="otpMessage" class="text-sm mt-2"></p>

                        <!-- Container for Resend OTP Button and Countdown -->
                        <div class="flex items-center mt-2">
                            <button type="button" id="resendOtpBtn" class="text-gray-700 underline hidden">Resend OTP</button>
                            <p id="resendOtpCountdown" class="text-sm ml-2 text-gray-600 hidden"></p>
                        </div>
                    </div>

                    <label class="block my-4">
                        <div class="relative mb-4">
                            <input type="text" name="municipality" id="municipality" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" required />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Municipality</label>
                        </div>
                        <div id="municipality-feedback" class="text-red-600 mt-1 hidden">Municipality is required.</div>
                    </label>
                    <label class="block mb-4">
                        <div class="relative mb-4">
                            <input type="text" name="brgy" id="brgy" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" required />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Barangay</label>
                        </div>
                        <div id="brgy-feedback" class="text-red-600 mt-1 hidden">Barangay is required.</div>
                    </label>
                    <label class="block mb-4">
                        <div class="relative mb-4">
                            <input type="text" name="address" id="address" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" autocomplete="off" required />
                            <label for="fname" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-outpeer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Unit No./House No./Building name</label>
                        </div>
                        <div id="address-feedback" class="text-red-600 mt-1 hidden">Address is required.</div>
                    </label>

                    <div class="flex justify-between">
                        <button type="button" class="w-auto py-2 px-14 bg-gray-600 shadow-md rounded-md" onclick="prevStep()"><i class="fa-solid fa-chevron-left"></i></button>
                        <div class="relative">
                            <button id="signup-Button" type="submit" class="w-auto bg-blue-900 text-white py-2 px-12" disabled>Sign Up</button>

                            <!-- Spinner Component -->
                            <div id="signupButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-blue-900 hidden">
                                <x-spinner />
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div class="mt-6">
                        <label class="flex flex-row items-center justify-between px-4 md:px-6">
                            <div class="checkbox-wrapper-10 mr-4">
                                <input class="tgl tgl-flip" id="terms-checkbox" type="checkbox" />
                                <label class="tgl-btn" data-tg-off="Nope" data-tg-on="Yeah!" for="terms-checkbox"></label>
                            </div>
                            <span class="text-black">I agree to the <a href="{{ route('privacy.policy') }}" class="text-blue-600">Privacy Policy</a> and <a href="{{  route('terms.conditions') }}" class="text-blue-600">Terms and Conditions</a></span>
                        </label>
                    </div>
                </div>
            </form>

            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-700"></div>
                <span class="mx-4 text-black">Or</span>
                <div class="flex-grow border-t border-gray-700"></div>
            </div>

            <div>
                <a id="google-signup-button" href="{{ route('auth.google.redirect') }}" class="w-full bg-white border border-gray-300 text-gray-700 py-2 flex items-center justify-center gap-2 hover:bg-gray-100 transition" disabled>
                    <img src="{{ asset('imgs/google-icon.svg') }}" alt="Google Icon" class="w-6 h-6">
                    Sign Up with Google
                </a>
            </div>

            <div class="mt-4 text-center text-black">
                Already a member? <a href="{{ route('auth.login') }}" class="text-blue-600 hover:underline">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/signup.js') }}"></script>
<script>
    let otpCooldown = 60;
    let cooldownInterval;

    document.getElementById('sendOtpBtn').addEventListener('click', function() {
        sendOtp();
    });

    function sendOtp() {
        let phone = document.getElementById('phone').value.trim();
        let sendOtpBtn = document.getElementById('sendOtpBtn');
        let otpContainer = document.getElementById('otpContainer');
        let resendOtpBtn = document.getElementById('resendOtpBtn');
        let resendOtpCountdown = document.getElementById('resendOtpCountdown');

        if (phone.length !== 10) {
            showToast("Please enter a valid 10-digit phone number.", "error");
            return;
        }

        // Disable the button while processing
        sendOtpBtn.disabled = true;
        sendOtpBtn.textContent = "Sending...";

        fetch("{{ route('auth.send-otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    phone: "63" + phone
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === "OTP sent successfully.") {
                    showToast("OTP sent successfully!", "success");

                    // Show OTP input field
                    otpContainer.classList.remove("hidden");

                    // Hide the send OTP button
                    sendOtpBtn.classList.add("hidden");

                    // Show the countdown and start it
                    startOtpCountdown();
                } else {
                    showToast("Failed to send OTP. Try again.", "error");
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.textContent = "Send OTP";
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast("An error occurred. Try again.", "error");
                sendOtpBtn.disabled = false;
                sendOtpBtn.textContent = "Send OTP";
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const otpInput = document.getElementById("otp");
        const otpMessage = document.getElementById("otpMessage");
        const resendOtpBtn = document.getElementById("resendOtpBtn");
        let otpAttempts = 3;
        let isOtpVerified = false;

        otpInput.addEventListener("input", function() {
            if (otpInput.value.length === 6 && !isOtpVerified) {
                verifyOtp(otpInput.value);
            } else {
                otpInput.classList.remove("border-green-500", "border-red-500");
                otpMessage.textContent = "";
            }
        });

        function verifyOtp(otp) {
            fetch("{{ route('auth.verify-otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        otp: otp
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        otpInput.classList.add("border-green-500");
                        otpInput.classList.remove("border-red-500");
                        otpMessage.textContent = "OTP Verified!";
                        otpMessage.classList.add("text-green-600");
                        otpMessage.classList.remove("text-red-600");
                        otpInput.setAttribute("data-otp-verified", "true");
                        isOtpVerified = true;
                    } else {
                        handleOtpFailure();
                    }
                })
                .catch(() => {
                    showToast("An error occurred while verifying OTP.", "error");
                    handleOtpFailure();
                });
        }

        function handleOtpFailure() {
            otpAttempts--;
            otpInput.classList.add("border-red-500");
            otpInput.classList.remove("border-green-500");
            otpMessage.textContent = `Incorrect OTP. ${otpAttempts} attempt(s) left.`;
            otpMessage.classList.add("text-red-600");
            otpMessage.classList.remove("text-green-600");

            if (otpAttempts === 0) {
                otpInput.disabled = true;
                showToast("Maximum attempts reached. Please resend OTP.", "error");
                resendOtpBtn.classList.remove("hidden");
            }
        }
    });

    function startOtpCountdown() {
        let resendOtpBtn = document.getElementById('resendOtpBtn');
        let resendOtpCountdown = document.getElementById('resendOtpCountdown');

        resendOtpBtn.classList.add("hidden");
        resendOtpCountdown.classList.remove("hidden");
        resendOtpCountdown.textContent = `Resend in ${otpCooldown}s`;

        let timeLeft = otpCooldown;

        cooldownInterval = setInterval(() => {
            timeLeft--;
            resendOtpCountdown.textContent = `Resend in ${timeLeft}s`;

            if (timeLeft <= 0) {
                clearInterval(cooldownInterval);
                resendOtpCountdown.classList.add("hidden");
                resendOtpBtn.classList.remove("hidden");
            }
        }, 1000);
    }

    document.getElementById('resendOtpBtn').addEventListener('click', function() {
        // Reset countdown and send OTP again
        otpCooldown = 60;
        sendOtp();
    });
</script>

<style>
    .signup-container {
        background-image: url('imgs/mobile-cat.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        flex: 1;
        overflow-y: auto;
    }

    @media screen and (min-width: 768px) {
        .signup-container {
            background-image: url('imgs/cat-drawing.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            flex: 1;
            overflow-y: auto;
        }
    }
</style>
@endsection