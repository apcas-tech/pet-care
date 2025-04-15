@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')
<h1 class="text-3xl font-bold mb-5">Pets</h1>

<!-- Search Bar and Filters -->
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-2">
        <!-- Search Bar -->
        <div class="flex items-center border border-gray-300 bg-white rounded-md px-2 py-2">
            <input type="text" id="search-input" placeholder="Search by Pet/Owner Name" class="border-none outline-none w-full"
                oninput="searchPets()">
            <button id="clear-search" class="hidden ml-2 text-gray-500" onclick="clearSearch()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <button id="pets-button" class="flex items-center bg-primary hover:bg-primary-light text-white p-3 rounded" aria-label="Filter by Pets">
            <i class="fa-solid fa-paw"></i>
        </button>
        <button id="owners-button" class="flex items-center bg-primary hover:bg-primary-light text-white p-3 rounded" aria-label="Filter by Owners">
            <i class="fa-solid fa-user "></i>
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

        <a href="{{ route('admin.pets') }}" class="bg-primary hover:bg-primary-light hover:text-secondary text-white rounded-md px-4 py-2 clear-filters-button">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>

    <!-- Add Pet Button -->
    @if(in_array('create', $admin_capabilities))
    <button class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2" data-modal-toggle="add-pet">
        <i class="fa-solid fa-dog"></i> New Pet
    </button>
    @endif

</div>

<!-- Filtered Pets Display -->
<div>
    <div class="bg-white p-4 rounded-md shadow-lg border border-gray-950 w-auto flex flex-wrap justify-start" id="pet-grid">
        @foreach($pets as $pet)
        <div class="relative flex flex-col text-center justify-center items-center bg-white py-4 px-2 border border-gray-950 pet-grid-item transition-transform duration-300 hover:scale-105 hover:cursor-pointer hover:rounded-sm hover:shadow-lg hover:z-10" style="width: 170px; height:206px;">
            <a href="{{ route('admin.pets.profile', $pet->id) }}" class="flex flex-col items-center">
                <img src="{{ $pet->profile_pic ? asset('storage/' . $pet->profile_pic) : asset('imgs/default_pet.webp') }}"
                    alt="{{ $pet->name }}"
                    class="w-28 h-28 object-cover rounded-md mb-2">
                <h2 class="text-lg font-semibold">{{ $pet->name }}</h2>
                <p class="text-gray-700 whitespace-normal text-clip overflow-hidden">
                    Owner:
                    @if($pet->owner)
                    {{ $pet->owner->Fname }}
                    {{ $pet->owner->Mname ? $pet->owner->Mname . '. ' : '' }}
                    {{ $pet->owner->Lname }}
                    @else
                    No Owner
                    @endif
                </p>
            </a>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $pets->links('pagination::tailwind') }}
    </div>
</div>

@include('bfc-animalclinic-inner-system.pets.add-pet')

<!-- Script for Filtering Logic -->
<script src="{{ asset('js/pet.js') }}"></script>
<script>
    const eventSource = new EventSource(`sse/pets?page=${getCurrentPage()}`);

    eventSource.onmessage = function(event) {
        const pets = JSON.parse(event.data);
        const petGrid = document.getElementById('pet-grid');

        petGrid.innerHTML = '';

        pets.forEach(pet => {
            const petItem = document.createElement('div');
            petItem.className = 'relative flex flex-col text-center justify-center items-center bg-white py-4 px-2 border border-gray-950 pet-grid-item transition-transform duration-300 hover:scale-105 hover:cursor-pointer hover:rounded-sm hover:shadow-lg hover:z-10';
            petItem.style.width = '170px';
            petItem.style.height = '206px';

            petItem.innerHTML = `
            <a href="pets/profile/${pet.id}" class="flex flex-col items-center">
                <img src="${pet.profile_pic ? 'storage/' + pet.profile_pic : 'imgs/default_pet.webp'}" alt="${pet.name}" class="w-28 h-28 object-cover rounded-md mb-2">
                <h2 class="text-lg font-semibold">${pet.name}</h2>
                <p class="text-gray-700 whitespace-normal text-clip overflow-hidden">
                    Owner: 
                    ${pet.owner ? pet.owner.Fname + ' ' + (pet.owner.Mname ? pet.owner.Mname + '. ' : '') + pet.owner.Lname : 'No Owner'}
                </p>
            </a>
        `;

            petGrid.appendChild(petItem);
        });
    };

    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }
</script>
@endsection