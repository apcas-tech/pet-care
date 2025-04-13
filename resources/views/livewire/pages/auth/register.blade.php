<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\action;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
    'phone' => '',
    'address' => '',
    'barangay' => '',
    'city' => '',
    'country' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    'phone' => ['required', 'string', 'min:10', 'max:15'],
    'address' => ['required', 'string', 'max:255'],
    'barangay' => ['required', 'string', 'max:255'],
    'city' => ['required', 'string', 'max:255'],
    'country' => ['required', 'string', 'max:255'],
]);

$register = function () {
    $validated = $this->validate();

    $validated['id'] = (string) Str::uuid(); // Generate UUID
    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);

    $this->redirect(route('user.dashboard', absolute: false), navigate: true);
};

?>

<div>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-lg flex flex-col p-6 shadow-lgbg-opacity-10 backdrop-blur-md relative z-10 mx-auto">
            <div class="flex flex-col items-center justify-center gap-10 mb-5 mt-4">
                <x-primary-button class="ms-4 w-full bg-gray-200">
                    <img src="{{ asset('imgs/google-icon.svg') }}" alt="Google" class="w-6 h-6 me-2">
                    {{ __('Sign Up with Google') }}
                </x-primary-button>
                <div class="flex items-center w-full max-w-xs">
                    <div class="flex-grow border-t border-black dark:border-white"></div>
                    <span class="mx-2 text-sm  border-black dark:border-white">OR</span>
                    <div class="flex-grow border-t border-black dark:border-white"></div>
                </div>
            </div>

            <!-- Breadcrumb Stepper -->
            <ol id="breadcrumb" class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-xs dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse">
                <li id="step-1-breadcrumb" class="flex items-center">
                    <span id="step-1-icon" class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">1</span>
                    Personal Info
                    <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                    </svg>
                </li>
                <li id="step-2-breadcrumb" class="flex items-center">
                    <span id="step-2-icon" class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">2</span>
                    Account Info
                </li>
            </ol>

            <form wire:submit.prevent="register" class="w-full">
                <!-- Step 1: Email, Password, Confirm Password -->
                <div id="step-1">
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input wire:model="email" id="email" class="block mt-1 w-full bg-white bg-opacity-15" type="email" name="email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input wire:model="password" id="password" class="block mt-1 w-full bg-white bg-opacity-15" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full bg-white bg-opacity-15" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Next Button -->
                    <div class="mt-4 flex justify-end">
                        <x-primary-button type="button" id="next-step" class="px-6 py-2 bg-white dark:bg-gray-200 text-gray-800">
                            {{ __('Next') }}
                            <x-iconsax-bro-arrow-right-3 class="w-5 h-5 ml-1 inline" />
                        </x-primary-button>
                    </div>
                </div>

                <!-- Step 2: Full Name, Phone, Address, Barangay, City, Country -->
                <div id="step-2" class="hidden">
                    <!-- Full Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input wire:model="name" id="name" class="block mt-1 w-full bg-white bg-opacity-15" type="text" name="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input wire:model="address" id="address" class="block mt-1 w-full bg-white bg-opacity-15" type="text" name="address" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Barangay -->
                        <div>
                            <x-input-label for="barangay" :value="__('Barangay')" />
                            <x-text-input wire:model="barangay" id="barangay" class="block mt-1 w-full bg-white bg-opacity-15" type="text" name="barangay" required />
                            <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input wire:model="city" id="city" class="block mt-1 w-full bg-white bg-opacity-15" type="text" name="city" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <!-- Country -->
                        <div>
                            <x-input-label for="country" :value="__('Country')" />
                            <x-text-input wire:model="country" id="country" class="block mt-1 w-full bg-white bg-opacity-15" type="text" name="country" required />
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <div class="relative mt-1">
                                <input wire:model="phone" id="phone" class="block mt-1 w-full bg-white bg-opacity-15 border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="tel" name="phone" required />
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 flex justify-between">
                        <x-secondary-button type="button" id="prev-step" class="rounded-md">
                            <x-iconsax-bro-arrow-left-2 class="w-5 h-5 mr-1 inline" />
                            {{ __('Previous') }}
                        </x-secondary-button>

                        <x-primary-button type="submit" class="ms-4 w-full bg-white dark:bg-gray-200 text-gray-800">
                            {{ __('Sign Up') }}
                            <x-iconsax-bro-login-1 class="w-5 h-5 ml-1 inline" />
                        </x-primary-button>
                    </div>
                </div>
            </form>

            <div class="flex items-center justify-center mt-4">
                <!-- Link to login -->
                <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" wire:navigate>
                    {{ __('Already registered?') }}
                </a>
            </div>
        </div>

        <!-- Right: Background Image -->
        <div class="flex-1 hidden md:block">
            <img src="{{ asset('imgs/background/signup-bg.webp') }}" alt="Signup Background" class="h-screen w-screen object-cover" />
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector("#phone");

        const iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/utils.js", // utils.js is required for formatting/validation
            nationalMode: false, // Ensure country code is included
            preferredCountries: ["ph"], // You can set preferred countries if needed
            separateDialCode: true // This shows the country code separately
        });

        // Optionally, if you want to get the country code or validate the number, use the following:
        phoneInput.addEventListener('blur', function() {
            if (iti.isValidNumber()) {
                // You can perform actions if the number is valid
            } else {
                // Handle invalid number
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const nextButton = document.getElementById('next-step');
        const prevButton = document.getElementById('prev-step');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step1Breadcrumb = document.getElementById('step-1-breadcrumb');
        const step2Breadcrumb = document.getElementById('step-2-breadcrumb');
        const step1Icon = document.getElementById('step-1-icon');
        const step2Icon = document.getElementById('step-2-icon');

        // Set initial breadcrumb state for step 1
        step1Breadcrumb.classList.add('text-blue-600');
        step1Icon.classList.add('border-blue-600');

        nextButton.addEventListener('click', function() {
            // Validate Step 1 fields
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Check if required fields are filled
            if (!email || !password || !passwordConfirmation) {
                showAlert('error', 'Please fill all the required fields.');
                return; // Prevent proceeding if fields are empty
            }

            // Optionally check if password and confirmation match
            if (password !== passwordConfirmation) {
                showToast('error', 'Passwords do not match.');
                return;
            }

            // Move to Step 2 if validation passes
            step1.classList.add('hidden');
            step2.classList.remove('hidden');

            // Mark Step 1 as done (update breadcrumb for step 1)
            step1Breadcrumb.classList.add('text-blue-600');
            step1Icon.classList.add('bg-blue-600', 'text-white'); // Mark step 1 as done
            step1Breadcrumb.classList.add('text-blue-600'); // Add blue color to text

            // Mark Step 2 as active (update breadcrumb for step 2)
            step2Breadcrumb.classList.add('text-blue-600');
            step2Icon.classList.add('border-blue-600');
        });

        prevButton.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');

            // Unmark Step 2 as done (update breadcrumb for step 2)
            step2Breadcrumb.classList.remove('text-blue-600');
            step2Icon.classList.remove('border-blue-600');
            step2Icon.classList.remove('bg-blue-600', 'text-white'); // Unmark step 2 as done

            // Update breadcrumb for step 1
            step1Breadcrumb.classList.add('text-blue-600');
            step1Icon.classList.add('border-blue-600');
        });
    });
</script>