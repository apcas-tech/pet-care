@extends('bfc_animalclinic.layouts.layout')

@section('content')

<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('home.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold">PawFile</h1>
</div>

<!-- Card Container -->
<div class="flex flex-col items-center justify-center">
    <div class="w-11/12 max-w-sm md:max-w-lg bg-gradient-to-r my-6 bg-primary-dark opacity-95 rounded-lg shadow-md text-white relative">
        <!-- Header -->
        <div class="text-yellow-400 text-xl font-bold pt-4 px-6">
            <div class="flex items-center justify-between">
                <div>FUR PARENT CARD</div>
                <div class="flex space-x-1">
                    @for($i = 0; $i < 5; $i++)
                        <div class="w-4 h-4 pr-0.5 md:pr-0 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-paw text-black text-xs"></i>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="flex flex-row border-2 rounded-md border-secondary px-2 mx-1 items-center justify-center">
        <!-- Left Side: Details -->
        <div class="flex-1 pt-2">
            <div class="mb-2">
                <strong>Name: </strong>{{ $user->Fname }} {{ $user->Mname ? strtoupper(substr($user->Mname, 0, 1)) . '. ' : '' }}{{ $user->Lname }}
            </div>

            <div class="inline-block relative mb-2">
                <span class="text-white rounded-full cursor-pointer font-semibold transition-all duration-500" data-tooltip-target="id-popover">
                    ID: <span class="font-light">{{ Str::limit($user->id, 13, '...') }}</span>
                </span>
                <div class="absolute mb-2 bottom-full left-1/2 transform -translate-x-1/2 invisible z-10 py-4 px-5 bg-white text-sm text-gray-600 rounded-xl shadow-md transition-opacity duration-300 opacity-0" role="tooltip" id="id-popover">
                    <p class="text-sm text-gray-600 font-normal">{{ $user->id }}</p>
                </div>
            </div>
            <div class="flex flex-col pt-6">
                <div class="text-gray-200 mb-2">
                    <strong>Phone:</strong> {{ substr($user->phone, 0, 2) . str_repeat('*', strlen($user->phone) - 6) . substr($user->phone, -4) }}
                </div>
                <div class="text-gray-200 mb-2">
                    <strong>Pets Owned:</strong> {{ $user->no_pets }}
                </div>
                <div class="text-gray-200 mb-2">
                    <strong>Address:</strong> {{ $user->address }}
                </div>
            </div>
        </div>

        <!-- Right Side: Profile Picture -->
        <div class="relative flex-shrink-0 ml-4">
            <!-- Edit Button -->
            <a href="{{ route('profile.edit') }}" class="absolute -top-12 md:-top-10 right-0 text-white rounded-full shadow-md transition">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>

            <!-- Profile Picture Container -->
            <div class="bg-white rounded-lg">
                @php
                $profilePic = $user->profile_pic
                ? (Str::startsWith($user->profile_pic, 'http')
                ? $user->profile_pic
                : asset('storage/'.$user->profile_pic))
                : asset('imgs/def-user.webp');
                @endphp
                <img src="{{ $profilePic }}" alt="Profile" class="w-28 h-34 rounded-md border-4 border-yellow-400">
            </div>
        </div>
    </div>

    <!-- Pets Section -->
    <div class="mt-6 pb-2">
        <h2 class="text-yellow-400 text-lg font-bold ml-6">Pets</h2>
        <div class="border-2 rounded-md border-secondary py-3 px-2 mx-1 grid grid-cols-3 gap-5">
            @php
            $totalPets = $user->pets->count();
            $totalBoxes = ceil($totalPets / 3) * 3; // Round up to nearest multiple of 3 for grid layout
            @endphp

            @for ($i = 0; $i < $totalBoxes; $i++)
                <div class="flex flex-col items-center justify-center text-white">
                <!-- Check if pet exists for this box -->
                @if (isset($user->pets[$i]))
                <div class="w-20 h-20 flex items-center justify-center border border-gray-500 relative">
                    @if($user->pets[$i]->profile_pic && $user->pets[$i]->profile_pic != '')
                    <img src="{{ asset('storage/' . $user->pets[$i]->profile_pic) }}" alt="Pet Image" class="w-full h-full object-cover">
                    @else
                    <img src="{{ asset('imgs/default_pet.webp') }}" alt="Default Pet Image" class="w-full h-full object-cover">
                    @endif
                    <!-- Display pet's age -->
                    @php
                    $bday = \Carbon\Carbon::parse($user->pets[$i]->bday);
                    $age = $bday->age;
                    @endphp
                    <div class="absolute bottom-0 left-0 text-xs text-white p-1 bg-black bg-opacity-60">
                        Age: {{ $age }} yrs.
                    </div>
                </div>
                @else
                <div class="w-20 h-20 flex items-center justify-center border border-gray-500 text-white">
                    <span class="text-center text-sm">Empty</span>
                </div>
                @endif
        </div>
        @endfor
    </div>
</div>
</div>
</div>

<!-- Action Buttons Section -->
<div class="mt-16 w-full px-4">
    <a href="{{ route('addpet.page')}}" class="flex items-center justify-between w-full text-left py-2 border-t-2 font-semibold dark:border-gray-700">
        <span class="ml-4">Add Pet</span>
        <i class="fa-solid fa-chevron-right mr-4"></i> <!-- Right arrow -->
    </a>
    <a href="{{  route('terms.conditions') }}" class="flex items-center justify-between w-full text-left py-2 border-t-2 font-semibold dark:border-gray-700">
        <span class="ml-4">Terms and Conditions</span>
        <i class="fa-solid fa-chevron-right mr-4"></i>
    </a>
    <a href="{{ route('privacy.policy') }}" class="flex items-center justify-between w-full text-left py-2 border-t-2 font-semibold dark:border-gray-700">
        <span class="ml-4">Privacy Policy</span>
        <i class="fa-solid fa-chevron-right mr-4"></i>
    </a>
    <a href="#" class="flex items-center justify-between w-full text-left py-2 border-y-2 font-semibold dark:border-gray-700">
        <span class="ml-4">About Us</span>
        <i class="fa-solid fa-chevron-right mr-4"></i>
    </a>
    <form action="{{ route('auth.logout') }}" method="POST" class="block mt-14">
        @csrf
        <button type="submit" class="w-full text-center py-2 rounded-full border-2 border-secondary font-semibold dark:border-gray-700">
            Log Out
        </button>
    </form>
</div>

<script src="{{ asset('js/profile.js') }}"></script>
@endsection