@extends('bfc_animalclinic.layouts.layout')

@section('content')

<!-- Welcome Message -->
<div class="text-center my-6">
    <h1 class="text-xl md:text-3xl font-semibold text-gray-800 dark:text-gray-200">Welcome to BFC Animal Clinic</h1>
    <p class="text-gray-600 md:text-lg dark:text-gray-400">Your one-stop care for pets</p>
</div>

<!-- Features Grid -->
<div class="grid grid-cols-2 md:grid-cols-2 gap-4 md:gap-10 w-full max-w-xs md:max-w-2xl mx-auto text-center">
    <!-- Vet Appointment Booking -->
    <a href="{{ route('book.page') }}" class="group bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-lg flex flex-col items-center justify-center p-4 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-secondary">
        <i class="fa-solid fa-book-bookmark text-primary dark:text-primary-light text-2xl mb-2"></i>
        <p class="text-gray-700 dark:text-white font-semibold text-sm md:text-base group-hover:text-black dark:group-hover:text-black">Paw Care</p>
    </a>

    <!-- Pet Adoption -->
    <a href="{{ route('adopt.page') }}" class="group bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-lg flex flex-col items-center justify-center p-4 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-secondary">
        <i class="fa-solid fa-paw fa-rotate-by text-primary dark:text-primary-light text-2xl mb-2" style="--fa-rotate-angle: 50deg;"></i>
        <p class="text-gray-700 dark:text-white font-semibold text-sm md:text-base group-hover:text-black dark:group-hover:text-black">Fur Pal</p>
    </a>

    <!-- Emergency Contacts -->
    <a href="{{route('paw-patrol.page')}}" class="group bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-lg flex flex-col items-center justify-center p-4 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-secondary">
        <i class="fa-solid fa-shield-cat text-primary dark:text-primary-light text-2xl mb-2"></i>
        <p class="text-gray-700 dark:text-white font-semibold text-sm md:text-base group-hover:text-black dark:group-hover:text-black">Paw Guard</p>
    </a>

    <!-- Profile -->
    <a href="{{ route('profile.page') }}" class="group bg-white dark:bg-gray-800 dark:text-white shadow-md rounded-lg flex flex-col items-center justify-center p-4 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-secondary">
        <i class="fas fa-user text-primary dark:text-primary-light text-2xl mb-2"></i>
        <p class="text-gray-700 dark:text-white font-semibold text-sm md:text-base group-hover:text-black dark:group-hover:text-black">Pawfile</p>
    </a>
</div>


<!-- My Pets and Carousel Components -->
<div class="w-full mt-6 md:mt-8 flex flex-col md:justify-center md:items-center">
    <x-my-pets :pets="$pets" />
    <x-carousel :appointmentCount="$appointmentCount" />
</div>
@endsection