@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')
<h1 class="text-3xl font-bold mb-5">Pet Adoption Listings</h1>

<!-- Search Bar and Filters -->
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-2">
        <!-- Search Bar -->
        <div class="flex items-center border border-gray-300 bg-white rounded-md px-2 py-2">
            <input type="text" id="search-input" placeholder="Search by pet/owner name" class="border-none outline-none w-full"
                oninput="searchPets()">
            <button id="clear-search" class="hidden ml-2 text-gray-500" onclick="clearSearch()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <button id="pets-button" class="flex items-center bg-primary hover:bg-primary-light text-white p-3 rounded" aria-label="Filter by Pets">
            <i class="fa-solid fa-paw"></i>
        </button>

        <!-- Ascending and Descending Filters -->
        <div class="flex items-center gap-[0.8px]">
            <button id="asc-button" class="flex items-center bg-primary hover:bg-primary-light text-white rounded-l-md p-3" aria-label="Sort Ascending">
                <i class="fa-solid fa-arrow-up-long"></i>
            </button>
            <button id="desc-button" class="flex items-center bg-primary hover:bg-primary-light text-white rounded-r-md p-3" aria-label="Sort Descending">
                <i class="fa-solid fa-arrow-down-long"></i>
            </button>
        </div>

        <button class="bg-primary hover:bg-primary-light hover:text-secondary text-white rounded-md px-4 py-2 clear-filters-button">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Add Pet Button -->
    @if(in_array('create', $admin_capabilities))
    <button class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2" data-modal-toggle="add-pet-adoption">
        <i class="fa-solid fa-cat"></i> New Pet
    </button>
    @endif
</div>


<div class="flex flex-wrap justify-start bg-white p-4 rounded-md shadow-lg border border-gray-950 w-auto" id="pet-grid">
    @foreach($adoptablePets as $pet)
    <div class="relative flex flex-col text-center justify-center items-center bg-white py-4 px-2 border border-gray-950 pet-grid-item transition-transform duration-300 hover:scale-105 hover:cursor-pointer hover:rounded-sm hover:shadow-lg hover:z-10" style="width: 170px; height:206px;">
        <a href="{{ route('admin.pet.profile', $pet->id) }}" class="flex flex-col items-center">
            <img src="{{ $pet->profile_pic ? asset('storage/' . $pet->profile_pic) : asset('imgs/default_pet.webp') }}" alt="{{ $pet->name }}" class="w-28 h-28 object-cover rounded-md mb-2">
            <h2 class="text-lg font-semibold">{{ $pet->name }}</h2>
            <p class="text-gray-700 text-sm">{{ $pet->gender }} - {{ $pet->breed }}</p>
        </a>
    </div>
    @endforeach
</div>
@include('bfc-animalclinic-inner-system.pet-listing.add-pet')
<script src="{{ asset('js/adopt.js') }}"></script>
@endsection