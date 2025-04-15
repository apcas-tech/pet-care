<div class="container mt-2 bg-white dark:bg-gray-800 no-scrollbar">
    <!-- Button to go to Pets page -->
    <a href="{{ route('mypets.page') }}"
        class="flex items-center justify-between font-bold py-3 px-4 mb-4 shadow hover:bg-gray-200 dark:hover:bg-gray-700 transition">
        <span class="text-lg md:text-xl text-gray-900 dark:text-white">My Pets</span>
        <i class="fa-solid fa-chevron-right ml-2 text-gray-600 dark:text-gray-300"></i>
    </a>

    <!-- Horizontal scrollable image carousel -->
    <div class="overflow-x-auto whitespace-nowrap px-2 py-2 no-scrollbar">
        <!-- Loop through the pets and display each one -->
        @foreach ($pets as $pet)
        <img src="{{ !empty($pet->profile_pic) ? asset('storage/'.$pet->profile_pic) : asset('imgs/default_pet.webp') }}"
            alt="{{ $pet->name }}"
            class="border inline-block w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover mr-4" />
        @endforeach
    </div>
</div>