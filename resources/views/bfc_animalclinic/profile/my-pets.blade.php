@extends('bfc_animalclinic.layouts.layout')

@section('content')
<!-- Header -->
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('home.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold">PawFile</h1>
</div>

<!-- Pets Profile -->
<div class="flex flex-col items-center justify-center my-6 p-4">
    <div class="relative bg-primary dark:bg-gray-800 p-4 rounded-lg w-80 shadow-lg flex flex-col items-center">
        <!-- Check if there are no pets -->
        <button
            id="releasePet"
            class="absolute top-0 right-0 underline font-semibold px-4 py-2 rounded-lg text-sm text-gray-100">
            Release
        </button>

        @if($pets->isEmpty())
        <!-- Display GIF when there are no pets -->
        <div class="flex flex-col items-center justify-center space-y-4 mt-6">
            <div aria-label="Orange and tan hamster running in a metal wheel" role="img" class="wheel-and-hamster">
                <div class="wheel"></div>
                <div class="hamster">
                    <div class="hamster__body">
                        <div class="hamster__head">
                            <div class="hamster__ear"></div>
                            <div class="hamster__eye"></div>
                            <div class="hamster__nose"></div>
                        </div>
                        <div class="hamster__limb hamster__limb--fr"></div>
                        <div class="hamster__limb hamster__limb--fl"></div>
                        <div class="hamster__limb hamster__limb--br"></div>
                        <div class="hamster__limb hamster__limb--bl"></div>
                        <div class="hamster__tail"></div>
                    </div>
                </div>
                <div class="spoke"></div>
            </div>
            <p class="text-white text-center">You have not added any pets yet. Please add one to get started!</p>
            <a class="text-gray-100 text-center border border-gray-300 hover:underline px-4 py-1 rounded-full" href="{{ route('addpet.page') }}">Add Pet</a>
        </div>
        @else
        <!-- Pet Details -->
        <div id="pet-details" class="flex flex-col items-center justify-center space-y-4 my-6 text-white dark:text-gray-200">
            <img id="pet-profile-pic" src="{{ asset('storage/' . ($pet->profile_pic ?? 'default_pet.webp')) }}" alt="Pet Profile Picture" class="w-28 h-28 object-cover bg-white rounded-xl dark:bg-gray-700">
            <h2 id="pet-name" class="text-xl font-bold flex items-center space-x-2">
                <span id="pet-name-text"></span>
                <i id="gender-icon" class="text-blue-500 text-lg"></i>
            </h2>
            <p id="pet-breed" class="text-sm"></p>
            <p id="pet-birthday" class="text-sm text-gray-300 dark:text-gray-400"></p>
        </div>

        <!-- Sliders Container -->
        <div class="swiper-container w-full max-h-56 my-4 overflow-hidden flex-shrink-0 items-center justify-center">
            <div class="swiper-wrapper">
                @foreach($pets as $pet)
                <div class="swiper-slide" data-pet='@json($pet)' data-pet-id="{{ $pet->id }}">
                    <img src="{{ $pet->profile_pic ? asset('storage/'.$pet->profile_pic) : asset('imgs/default_pet.webp') }}"
                        alt="{{ $pet->name }}"
                        class="w-14 h-14 object-cover border border-white dark:border-gray-600">
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @endif
    </div>

    <!-- Include the Vaccination Component -->

    <div id="e-health-container" class="w-full">
        @if(!$pets->isEmpty())
        <x-e-healthdata :pet="$pets->first()" />
        @endif
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script src="{{ asset('js/my-pets.js') }}"></script>

<style>
    .swiper-container {
        height: auto;
        /* Fixed height */
        overflow: hidden;
        /* Prevent overflow */
    }

    .swiper-slide img {
        transition: transform 0.3s ease, width 0.3s ease;
    }

    .swiper-slide-active img {
        width: 64px;
    }

    .swiper-slide-next img,
    .swiper-slide-prev img {
        opacity: 0.8;
    }

    /* Ensure the gender icon aligns properly with the pet name */
    #pet-name i {
        margin-left: 0.5rem;
    }

    .wheel-and-hamster {
        --dur: 1s;
        position: relative;
        width: 12em;
        height: 12em;
        font-size: 14px;
    }

    .wheel,
    .hamster,
    .hamster div,
    .spoke {
        position: absolute;
    }

    .wheel,
    .spoke {
        border-radius: 50%;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .wheel {
        background: radial-gradient(100% 100% at center, hsla(0, 0%, 60%, 0) 47.8%, hsl(0, 0%, 60%) 48%);
        z-index: 2;
    }

    .hamster {
        animation: hamster var(--dur) ease-in-out infinite;
        top: 50%;
        left: calc(50% - 3.5em);
        width: 7em;
        height: 3.75em;
        transform: rotate(4deg) translate(-0.8em, 1.85em);
        transform-origin: 50% 0;
        z-index: 1;
    }

    .hamster__head {
        animation: hamsterHead var(--dur) ease-in-out infinite;
        background: hsl(30, 90%, 55%);
        border-radius: 70% 30% 0 100% / 40% 25% 25% 60%;
        box-shadow: 0 -0.25em 0 hsl(30, 90%, 80%) inset,
            0.75em -1.55em 0 hsl(30, 90%, 90%) inset;
        top: 0;
        left: -2em;
        width: 2.75em;
        height: 2.5em;
        transform-origin: 100% 50%;
    }

    .hamster__ear {
        animation: hamsterEar var(--dur) ease-in-out infinite;
        background: hsl(0, 90%, 85%);
        border-radius: 50%;
        box-shadow: -0.25em 0 hsl(30, 90%, 55%) inset;
        top: -0.25em;
        right: -0.25em;
        width: 0.75em;
        height: 0.75em;
        transform-origin: 50% 75%;
    }

    .hamster__eye {
        animation: hamsterEye var(--dur) linear infinite;
        background-color: hsl(0, 0%, 0%);
        border-radius: 50%;
        top: 0.375em;
        left: 1.25em;
        width: 0.5em;
        height: 0.5em;
    }

    .hamster__nose {
        background: hsl(0, 90%, 75%);
        border-radius: 35% 65% 85% 15% / 70% 50% 50% 30%;
        top: 0.75em;
        left: 0;
        width: 0.2em;
        height: 0.25em;
    }

    .hamster__body {
        animation: hamsterBody var(--dur) ease-in-out infinite;
        background: hsl(30, 90%, 90%);
        border-radius: 50% 30% 50% 30% / 15% 60% 40% 40%;
        box-shadow: 0.1em 0.75em 0 hsl(30, 90%, 55%) inset,
            0.15em -0.5em 0 hsl(30, 90%, 80%) inset;
        top: 0.25em;
        left: 2em;
        width: 4.5em;
        height: 3em;
        transform-origin: 17% 50%;
        transform-style: preserve-3d;
    }

    .hamster__limb--fr,
    .hamster__limb--fl {
        clip-path: polygon(0 0, 100% 0, 70% 80%, 60% 100%, 0% 100%, 40% 80%);
        top: 2em;
        left: 0.5em;
        width: 1em;
        height: 1.5em;
        transform-origin: 50% 0;
    }

    .hamster__limb--fr {
        animation: hamsterFRLimb var(--dur) linear infinite;
        background: linear-gradient(hsl(30, 90%, 80%) 80%, hsl(0, 90%, 75%) 80%);
        transform: rotate(15deg) translateZ(-1px);
    }

    .hamster__limb--fl {
        animation: hamsterFLLimb var(--dur) linear infinite;
        background: linear-gradient(hsl(30, 90%, 90%) 80%, hsl(0, 90%, 85%) 80%);
        transform: rotate(15deg);
    }

    .hamster__limb--br,
    .hamster__limb--bl {
        border-radius: 0.75em 0.75em 0 0;
        clip-path: polygon(0 0, 100% 0, 100% 30%, 70% 90%, 70% 100%, 30% 100%, 40% 90%, 0% 30%);
        top: 1em;
        left: 2.8em;
        width: 1.5em;
        height: 2.5em;
        transform-origin: 50% 30%;
    }

    .hamster__limb--br {
        animation: hamsterBRLimb var(--dur) linear infinite;
        background: linear-gradient(hsl(30, 90%, 80%) 90%, hsl(0, 90%, 75%) 90%);
        transform: rotate(-25deg) translateZ(-1px);
    }

    .hamster__limb--bl {
        animation: hamsterBLLimb var(--dur) linear infinite;
        background: linear-gradient(hsl(30, 90%, 90%) 90%, hsl(0, 90%, 85%) 90%);
        transform: rotate(-25deg);
    }

    .hamster__tail {
        animation: hamsterTail var(--dur) linear infinite;
        background: hsl(0, 90%, 85%);
        border-radius: 0.25em 50% 50% 0.25em;
        box-shadow: 0 -0.2em 0 hsl(0, 90%, 75%) inset;
        top: 1.5em;
        right: -0.5em;
        width: 1em;
        height: 0.5em;
        transform: rotate(30deg) translateZ(-1px);
        transform-origin: 0.25em 0.25em;
    }

    .spoke {
        animation: spoke var(--dur) linear infinite;
        background: radial-gradient(100% 100% at center, hsl(0, 0%, 60%) 4.8%, hsla(0, 0%, 60%, 0) 5%),
            linear-gradient(hsla(0, 0%, 55%, 0) 46.9%, hsl(0, 0%, 65%) 47% 52.9%, hsla(0, 0%, 65%, 0) 53%) 50% 50% / 99% 99% no-repeat;
    }

    /* Animations */
    @keyframes hamster {

        from,
        to {
            transform: rotate(4deg) translate(-0.8em, 1.85em);
        }

        50% {
            transform: rotate(0) translate(-0.8em, 1.85em);
        }
    }

    @keyframes hamsterHead {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(0);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(8deg);
        }
    }

    @keyframes hamsterEye {

        from,
        90%,
        to {
            transform: scaleY(1);
        }

        95% {
            transform: scaleY(0);
        }
    }

    @keyframes hamsterEar {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(0);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(12deg);
        }
    }

    @keyframes hamsterBody {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(0);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(-2deg);
        }
    }

    @keyframes hamsterFRLimb {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(50deg) translateZ(-1px);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(-30deg) translateZ(-1px);
        }
    }

    @keyframes hamsterFLLimb {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(-30deg);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(50deg);
        }
    }

    @keyframes hamsterBRLimb {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(-60deg) translateZ(-1px);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(20deg) translateZ(-1px);
        }
    }

    @keyframes hamsterBLLimb {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(20deg);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(-60deg);
        }
    }

    @keyframes hamsterTail {

        from,
        25%,
        50%,
        75%,
        to {
            transform: rotate(30deg) translateZ(-1px);
        }

        12.5%,
        37.5%,
        62.5%,
        87.5% {
            transform: rotate(10deg) translateZ(-1px);
        }
    }

    @keyframes spoke {
        from {
            transform: rotate(0);
        }

        to {
            transform: rotate(-1turn);
        }
    }
</style>
@endsection