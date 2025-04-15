@extends('layouts.app')

@section('content')
<x-toast />

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-10 md:max-w-2xl md:p-10" id="auth-container">
        <h2 class="text-lg font-semibold text-gray-700 text-center mb-6 md:text-xl">Complete Your Registration</h2>
        <form id="detailsForm" method="POST" action="{{ route('auth.save-details') }}">
            @csrf
            <input type="hidden" name="google_id" value="{{ $google_id }}">

            <div class="space-y-4 md:grid md:grid-cols-2 md:gap-6">
                <!-- Phone Field with OTP Button -->
                <div class="col-span-2 md:col-span-1 md:mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-600">Phone:</label>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-2">+63</span>
                        <input type="number" name="phone" id="phone" placeholder="Enter your phone number" maxlength="10"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            autocomplete="off" required>
                    </div>
                    <button type="button" id="sendOtpBtn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md">Send OTP</button>
                </div>

                <!-- OTP Verification Field -->
                <div class="col-span-2 md:col-span-1 md:mt-4 hidden" id="otpContainer">
                    <label for="otp" class="block text-sm font-medium text-gray-600">Enter OTP:</label>
                    <input type="number" name="otp" id="otp" placeholder="Enter OTP"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none"
                        autocomplete="off" maxlength="6" data-otp-verified="false">
                    <p id="otpMessage" class="text-sm mt-2"></p>

                    <!-- Container for Resend OTP Button and Countdown -->
                    <div class="flex items-center mt-2">
                        <!-- Resend OTP Button -->
                        <button type="button" id="resendOtpBtn" class="text-gray-700 underline rounded-md hidden">Resend OTP</button>
                        <p id="resendOtpCountdown" class="text-sm ml-2 text-gray-600 hidden"></p>
                    </div>
                </div>

                <!-- Municipality Field -->
                <div class="col-span-2 md:col-span-1">
                    <label for="municipality" class="block text-sm font-medium text-gray-600">Municipality:</label>
                    <input type="text" name="municipality" id="municipality" placeholder="Enter your municipality"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 capitalize"
                        autocomplete="off" required>
                </div>

                <!-- Barangay Field -->
                <div class="col-span-2 md:col-span-1">
                    <label for="brgy" class="block text-sm font-medium text-gray-600">Barangay:</label>
                    <input type="text" name="brgy" id="brgy" placeholder="Enter your barangay"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 capitalize"
                        autocomplete="off" required>
                </div>

                <!-- Address Field -->
                <div class="col-span-2 md:col-span-1">
                    <label for="address" class="block text-sm font-medium text-gray-600">Address:</label>
                    <input type="text" name="address" id="address" placeholder="Enter your address"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 capitalize"
                        autocomplete="off" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="relative mt-6">
                <button id="submitButton" type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ok
                </button>

                <div id="submitButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-blue-900 hidden">
                    <x-spinner />
                </div>
            </div>

            <!-- Checkbox -->
            <div class="mt-4">
                <label class="flex flex-row items-center justify-between px-4 md:px-6">
                    <div class="checkbox-wrapper-10 mr-4">
                        <input class="tgl tgl-flip" id="terms-checkbox" type="checkbox" />
                        <label class="tgl-btn" data-tg-off="Nope" data-tg-on="Yeah!" for="terms-checkbox"></label>
                    </div>
                    <span class="text-gray-700">I agree to the <a href="{{ route('privacy.policy') }}" class="text-blue-600">Privacy Policy</a> and <a href="{{  route('terms.conditions') }}" class="text-blue-600">Terms and Conditions</a></span>
                </label>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('detailsForm').addEventListener('submit', function(e) {
        const submitButton = document.getElementById('submitButton');
        const loaderOverlay = document.getElementById('loaderOverlay');

        // Show loader and disable submit button
        loaderOverlay.classList.remove('hidden');
        submitButton.disabled = true;

        // Set a timeout to hide loader if submission takes too long
        const timeout = setTimeout(() => {
            loaderOverlay.classList.add('hidden');
            submitButton.disabled = false;
            showToast('Submission timed out. Please try again.', 'error');
        }, 15000); // 15 seconds timeout

        // Handle form submission
        this.addEventListener('submit', () => {
            clearTimeout(timeout); // Clear timeout if submission succeeds
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const termsCheckbox = document.getElementById("terms-checkbox");
        const signupButton = document.getElementById("submitButton");
        const otpInput = document.getElementById("otp");

        function toggleButtonState() {
            const isTermsChecked = termsCheckbox.checked;
            const isOtpVerified = otpInput.getAttribute('data-otp-verified') === 'true';
            signupButton.disabled = !(isTermsChecked && isOtpVerified);
        }

        termsCheckbox.addEventListener("change", toggleButtonState);
        otpInput.addEventListener("input", toggleButtonState);

        toggleButtonState(); // Initial check on page load
    });

    document.getElementById("detailsForm").addEventListener("submit", function(e) {
        const submitButton = document.getElementById("submitButton");
        const loaderOverlay = document.getElementById("loaderOverlay");
        const otpInput = document.getElementById('otp');

        // Prevent submission if OTP is not verified
        if (otpInput.getAttribute('data-otp-verified') !== 'true') {
            showToast('Please verify your OTP before submitting the form.', 'error');
            e.preventDefault(); // Prevent form submission
            return;
        }

        // Show loader and disable submit button
        loaderOverlay.classList.remove('hidden');
        submitButton.disabled = true;

        // Set a timeout to hide loader if submission takes too long
        const timeout = setTimeout(() => {
            loaderOverlay.classList.add('hidden');
            submitButton.disabled = false;
            showToast('Submission timed out. Please try again.', 'error');
        }, 15000); // 15 seconds timeout

        // Handle form submission
        this.addEventListener('submit', () => {
            clearTimeout(timeout); // Clear timeout if submission succeeds
        });
    });

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
@endsection