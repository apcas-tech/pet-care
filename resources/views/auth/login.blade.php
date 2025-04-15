@extends('layouts.app')

@section('title', 'Login')

@section('content')
<x-toast />

<div class="login-container w-screen h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
    <div class="w-full p-8 max-w-md bg-white bg-opacity-10 backdrop-blur-sm rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-semibold text-blue-900 mb-6">Welcome Back!</h2>

        @if (session('error_message'))
        <div class="text-red-600 text-center mb-4">
            {{ session('error_message') }}
        </div>
        @endif

        <form id="login-form" action="{{ route('auth.login') }}" method="post" class="space-y-4">
            @csrf
            <div class="relative mb-4">
                <input type="email" id="email" name="email" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" required />
                <label for="email" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out bg-white bg-opacity-10 peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Email</label>
            </div>

            <label class="block mb-4">
                <div class="relative">
                    <input type="password" id="login-password" name="password" class="peer w-full px-3 py-2 text-black border-b border-gray-700 rounded-md focus:outline-none bg-transparent bg-opacity-50 placeholder-transparent" placeholder=" " oninput="handleInputChange(this)" required />
                    <label for="login-password" class="absolute left-3 top-2 text-black transition-all duration-200 ease-in-out peer-placeholder-shown:top-2 peer-placeholder-shown:text-black peer-focus:-top-3 peer-focus:text-sm">Password</label>
                    <i class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600" id="login-password-icon" onclick="togglePasswordVisibility('login-password', 'login-password-icon')"></i>
                </div>
            </label>

            <div class="relative mt-4">
                <button id="loginButton" type="submit" class="w-full bg-blue-900 text-white py-2 flex items-center justify-center gap-2 hover:bg-primary-light transition">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <!-- Spinner Component -->
                <div id="loginButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-blue-900 hidden">
                    <x-spinner />
                </div>
            </div>
        </form>

        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-700"></div>
            <span class="mx-4 text-black">Or</span>
            <div class="flex-grow border-t border-gray-700"></div>
        </div>

        <div class="relative mt-4">
            <a id="login-google-button" href="{{ route('auth.google.redirect') }}" class="w-full border bg-white border-gray-300 text-gray-700 py-2 flex items-center justify-center gap-2 hover:bg-gray-100 transition">
                <img src="{{ asset('imgs/google-icon.svg') }}" alt="Google Icon" class="w-6 h-6">
                Login with Google
            </a>
        </div>

        <div class="mt-6 text-center text-black">
            Not a member? <a href="{{ route('auth.signup') }}" class="text-blue-600 hover:underline hover:cursor-pointer">Sign up</a>
        </div>
    </div>
</div>

<script src="{{ asset('js/login.js') }}"></script>

<style>
    .login-container {
        background-image: url('imgs/mobile-explorer.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        flex: 1;
        overflow-y: auto;
    }

    @media screen and (min-width: 768px) {
        .login-container {
            background-image: url('imgs/explorer.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            flex: 1;
            overflow-y: auto;
        }
    }
</style>
@endsection