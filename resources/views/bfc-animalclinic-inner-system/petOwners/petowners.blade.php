@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')
<h1 class="text-3xl font-bold mb-5">Pet Owners</h1>
<!-- Search Bar and Filters -->
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center space-x-2">
        <!-- Search Bar -->
        <div class="flex items-center border border-gray-300 bg-white rounded-md px-2 py-2">
            <input type="text" id="search-input" placeholder="Search by Name" class="border-none outline-none w-full"
                oninput="searchPets()">
            <button id="clear-search" class="hidden ml-2 text-gray-500" onclick="clearSearch()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Ascending and Descending Filters -->
        <div class="flex items-center gap-[0.8px]">
            <button id="asc-button" class="flex items-center bg-primary hover:bg-primary-light text-white rounded-l-md p-3" aria-label="Sort Ascending">
                <i class="fa-solid fa-arrow-up-long"></i>
            </button>
            <button id="desc-button" class="flex items-center bg-primary hover:bg-primary-light text-white rounded-r-md p-3" aria-label="Sort Descending">
                <i class="fa-solid fa-arrow-down-long"></i>
            </button>
        </div>

        <a href="{{ route('admin.pet_owners') }}" class="bg-primary hover:bg-primary-light hover:text-secondary text-white rounded-md px-4 py-2 clear-filters-button">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>

    @if(in_array('create', $admin_capabilities))
    <button type="button" data-modal-toggle="add-pet-owner" class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2">
        <i class="fas fa-person"></i>
        New Pet Owner
    </button>
    @endif

</div>

<div class="flex flex-row flex-wrap items-center gap-8">
    @foreach($petOwners as $owner)
    <div class="flip-card relative">
        <div class="flip-card-inner">
            <!-- Front of the Card -->
            <div class="flip-card-front py-2 relative">
                <!-- Delete Button -->
                <button class="absolute top-2 right-2 py-1 px-2 text-secondary hover:text-white hover:bg-secondary" data-id="{{ $owner->id }}" data-modal-toggle="delete-owner">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
                @php
                $profilePic = $owner->profile_pic
                ? (Str::startsWith($owner->profile_pic, 'http')
                ? $owner->profile_pic
                : asset('storage/'.$owner->profile_pic))
                : asset('imgs/def-user.webp');
                @endphp

                <img src="{{ $profilePic }}" class="w-full h-3/4 object-cover mb-4">
                <p class="title mt-auto">{{ $owner->Fname }} {{ $owner->Lname }}</p>
            </div>
            <!-- Back of the Card -->
            <div class="flip-card-back">
                <p><span class="font-bold">Email:</span> {{ $owner->email }}</p>
                <p><span class="font-bold">Phone:</span> {{ $owner->phone }}</p>
                <p><span class="font-bold">Address:</span> {{ $owner->address }}</p>
                <p><span class="font-bold">Pets:</span> {{ $owner->pets->count() }}</p>
            </div>
        </div>
    </div>
    @endforeach

    @include('bfc-animalclinic-inner-system.petOwners.add-owner')
    @include('bfc-animalclinic-inner-system.petOwners.delete-owner')
</div>

<script src="{{ asset('js/owner.js') }}"></script>
<style>
    .flip-card {
        background-color: transparent;
        width: 190px;
        height: 254px;
        perspective: 1000px;
        font-family: sans-serif;
        cursor: pointer;
    }

    .title {
        font-size: 1.2em;
        font-weight: bold;
        text-align: center;
        margin: 0;
        max-width: 90%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .flip-card.flipped .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        box-shadow: 0 8px 14px 0 rgba(0, 0, 0, 0.2);
        position: absolute;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border: 1px solid #b80c09;
        border-radius: 1rem;
    }

    .flip-card-front {
        background: white;
    }

    .flip-card-back {
        background: white;
        transform: rotateY(180deg);
    }

    .flip-card-back p {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        text-align: center;
        max-width: 90%;
        margin: 0.3rem 0;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    img {
        border-radius: 0%;
        /* Removed the circular border-radius */
    }
</style>
@endsection