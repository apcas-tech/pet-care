@extends('layouts.app')

@section('title', 'Login and Signup')

@section('content')
<div class="flex md:items-center md:justify-center h-screen bg-gray-100">
    <div class="flex flex-col w-full max-w-3xl bg-white rounded-lg shadow-lg overflow-hidden" id="auth-container">
        <!-- Login View -->
        <div id="login-container" class="flex flex-col md:w-full md:h-auto md:flex-row">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('imgs/logo.webp') }}" alt="BFC Animal Clinic" class="w-full h-full object-cover" id="auth-image">
            </div>
            <div class="w-full md:w-1/2 p-8">
                <h2 class="text-2xl font-semibold text-blue-900 mb-6">Welcome Back!</h2>

                @if (session('error_message'))
                <div class="text-red-600 text-center mb-4">
                    {{ session('error_message') }}
                </div>
                @endif

                <form id="login-form" action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <label class="block mb-4">
                        <span class="text-gray-700">Email:</span>
                        <input type="email" name="email" placeholder="Enter your email" class="block w-full mt-1 p-2 border border-gray-300 rounded-md" autocomplete="off" required>
                    </label>

                    <label class="block mb-4">
                        <span class="text-gray-700">Password:</span>
                        <div class="relative">
                            <input type="password" id="login-password" name="password" placeholder="Enter your password" class="block w-full p-2 border border-gray-300 rounded-md" required>
                            <i class="fas fa-eye absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600" id="login-password-icon" onclick="togglePasswordVisibility('login-password', 'login-password-icon')"></i>
                        </div>
                    </label>

                    <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-md flex items-center justify-center gap-2 hover:bg-blue-800 transition">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(passwordFieldId, iconId) {
        var passwordField = document.getElementById(passwordFieldId);
        var icon = document.getElementById(iconId);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection