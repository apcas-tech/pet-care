@extends('bfc_animalclinic.layouts.layout')

@section('content')

<!-- Header -->
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('adopt.page') }}" class="text-2xl font-bold">
        <i class="fa-solid fa-angle-left fa-sm"></i>
    </a>
    <h1 class="flex-1 text-center text-xl font-semibold">Pet Details</h1>
</div>

<!-- Background Blob Design -->
<div class="w-full my-28 items-center flex justify-center">
    <div class=" bg-white bg-opacity-10 backdrop-blur-md shadow-xl rounded-lg text-white max-w-md w-full text-center p-6 pt-24">
        <!-- Pet Image (Floating) -->
        <div class="absolute top-[-80px] left-1/2 transform -translate-x-1/2">
            <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img src="{{ $pet->profile_pic ? asset('storage/'.$pet->profile_pic) : asset('imgs/default_pet.webp') }}"
                    alt="{{ $pet->name }}" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Pet Info -->
        <h2 class="text-3xl font-extrabold mt-4">{{ $pet->name }}</h2>
        <div class="mt-4 space-y-3 text-lg">
            <p><i class="fa-solid fa-paw mr-2"></i> <strong>Breed:</strong> {{ $pet->breed }}</p>
            <p><i class="fa-solid fa-dog mr-2"></i> <strong>Species:</strong> {{ $pet->species }}</p>
            <p><i class="fa-solid fa-venus-mars mr-2"></i> <strong>Gender:</strong> {{ $pet->gender }}</p>
            <p><i class="fa-solid fa-cake-candles mr-2"></i> <strong>Age:</strong> {{ \Carbon\Carbon::parse($pet->bday)->age }} Years Old</p>
            <p><i class="fa-solid fa-weight-scale mr-2"></i> <strong>Weight:</strong> {{ $pet->weight }} kg</p>
            @if ($pet->remarks)
            <p><i class="fa-solid fa-comment mr-2"></i> <strong>Remarks:</strong> {{ $pet->remarks }}</p>
            @endif
        </div>
    </div>
</div>

@endsection