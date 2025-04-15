<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('user.dashboard', absolute: false), navigate: true);
};

?>

<div>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-lg flex flex-col p-6 shadow-lgbg-opacity-10 backdrop-blur-md relative z-10 mx-auto">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="w-full">
                <div class="flex flex-col items-center justify-center gap-4 mb-8">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-white">Login</h2>
                    <h4 class="text-gray-700 dark:text-white">Enter your account credentials.</h4>
                </div>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex flex-col items-center justify-center gap-5 mt-4">
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif

                    <x-primary-button class="ms-4 w-full bg-white dark:bg-gray-200 text-gray-800">
                        {{ __('Log in') }}
                    </x-primary-button>

                    <!-- OR Divider -->
                    <div class="flex items-center w-full max-w-xs">
                        <div class="flex-grow border-t border-black dark:border-white"></div>
                        <span class="mx-2 text-sm text-black dark:text-white">OR</span>
                        <div class="flex-grow border-t border-black dark:border-white"></div>
                    </div>

                    <!-- Google Sign Up Button -->
                    <button class="flex items-center justify-center gap-3 bg-blue-600 text-white hover:bg-blue-700 transition">
                        <div class="bg-white p-2">
                            <img src="{{ asset('imgs/google-icon.svg') }}" alt="Google" class="w-5 h-5" />
                        </div>
                        <span class="mr-4">{{ __('Sign In with Google') }}</span>
                    </button>

                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('register') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" wire:navigate>
                            {{ __('Don\'t have an account?') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Right: Background Image -->
        <div class="flex-1 hidden md:block">
            <img src="{{ asset('imgs/background/signup-bg.webp') }}" alt="Signup Background" class="h-screen w-screen object-cover" />
        </div>
    </div>
</div>