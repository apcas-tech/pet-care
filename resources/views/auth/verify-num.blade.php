@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-700 text-center mb-4">Verify Your Phone Number</h2>
        <p class="text-gray-600 text-center mb-4">A verification code has been sent to your phone number.</p>

        @if(session('error'))
        <p class="text-red-500 text-center">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('auth.verify-phone') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <label for="code" class="block text-sm font-medium text-gray-600">Enter Verification Code:</label>
            <input type="text" name="code" id="code" required
                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">

            <button type="submit" class="w-full mt-4 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                Verify
            </button>
        </form>
    </div>
</div>
@endsection