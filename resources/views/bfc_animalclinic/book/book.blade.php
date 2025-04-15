@extends('bfc_animalclinic.layouts.layout')

@section('content')
<div class="w-full bg-primary px-4 py-2  flex items-center">
    <a href="{{ route('home.page') }}" class="text-2xl text-white font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold text-white">Paw Care</h1>
</div>

<form id="bookingForm" method="POST" action="{{ route('booking.store') }}" class="my-6 p-4 shadow-md rounded-lg">
    @csrf
    <div class="steps">
        <!-- Step 1 -->
        <div id="step-1" class="step">
            <h2 class="text-lg md:text-2xl font-bold dark:text-gray-100">Schedule your Pet's appointment now!</h2>
            <p class="mb-4 md:text-lg dark:text-gray-300">Please select from the available date and time.</p>
            <div class="flex -mb-8 z-10 relative">
                <div class="flex-1"></div>
                <img src="{{ asset('imgs/cat-smile.webp') }}" alt="Cat" />
            </div>

            <div class="bg-white dark:bg-gray-700 p-4 shadow-xl rounded-lg">
                <h2 class="text-lg md:text-2xl font-bold">Which pet is this appointment for?</h2>
                <div class="mb-4">
                    <label for="pet_id" class="block text-sm font-medium md:text-lg">Select Pet</label>
                    <select name="pet_id" id="pet_id" class="w-full p-2 border border-gray-500 rounded-lg mt-1 dark:bg-gray-900">
                        <option value="" clas="md:text-xl">Select a Pet</option>
                        @foreach($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 relative">
                    <label for="service_search" class="block text-sm font-medium md:text-lg">Services</label>
                    <p class="text-xs md:text-base">Choose among the <a href="{{ route('services.page') }}" class="underline">services</a> offered the service you want to book.</p>
                    <input type="text" id="service_search" placeholder="Search for a service..." class="w-full p-2 border border-gray-500 rounded-lg mb-2 dark:bg-gray-900" required autocomplete="off">

                    <div id="services-list" class="absolute border p-2 max-h-40 overflow-y-auto rounded mt-1 w-full hidden border-gray-800 bg-gray-100 dark:bg-gray-900">
                        @foreach($services as $service)
                        <div class="service-item p-2 hover:bg-gray-700 cursor-pointer" data-id="{{ $service->id }}" data-price="{{ $service->price }}" data-capacity="{{ $service->capacity }}">
                            {{ $service->service }} - ₱{{ $service->price }}
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="service_id" id="service_id" value="">
                </div>

                <div class="mb-4">
                    <label for="branch_id" class="block text-sm font-medium md:text-lg">Select a Branch</label>
                    <p class="text-xs md:text-base">Choose the branch where you'd like to book your appointment.</p>
                    <select name="branch_id" id="branch_id" class="w-full p-2 border border-gray-500 rounded-lg mt-1 dark:bg-gray-900" required>
                        <option value="" class="md:text-xl">Select a Branch</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium md:text-lg">What is the reason for your consultation? (Optional)</label>
                    <p class="text-xs md:text-base">Please indicate your reason for the consultation so that the doctor may assess your pet ahead of time.</p>
                    <textarea name="notes" id="notes" class="w-full p-2 border border-gray-500 rounded-xl mt-1 dark:bg-gray-900" rows="3"></textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" id="nextStep1" class="bg-primary text-white py-2 px-4">
                        <i class="fa-solid fa-cat mr-2"></i> Continue
                    </button>
                </div>
            </div>
        </div>


        <div id="step-2" class="step hidden">
            <div class="-mb-8 z-10 relative md:-mb-11">
                <img src="{{ asset('imgs/dog-lick.webp') }}" alt="Dog" />
            </div>
            <div class="bg-white shadow-xl dark:bg-gray-700">
                <div class="p-4 mt-3 md:p-8 md:mt-6 md:ml-10">
                    <p class="font-semibold md:text-xl dark:text-gray-200">Select Date</p>
                    <x-date-picker id="appointmentDate" name="appointment_date" />
                </div>
                <div class="border border-dashed border-black my-4 dark:border-gray-500"></div>

                <div class="time p-4 md:p-8">
                    <h3 class="font-semibold">Morning</h3>
                    <div class="p-2 time-morning space-y-2 md:space-x-4">
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="08:00:00">08:00 AM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="09:00:00">09:00 AM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="10:00:00">10:00 AM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="11:00:00">11:00 AM</button>
                    </div>

                    <h3 class="font-semibold mt-4">Afternoon</h3>
                    <div class="p-2 time-afternoon space-y-2 md:space-x-4">
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="13:00:00">01:00 PM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="14:00:00">02:00 PM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="15:00:00">03:00 PM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="16:00:00">04:00 PM</button>
                        <button type="button" class="time-slot bg-gray-200 text-gray-800 py-1 px-2 rounded" data-time="17:00:00">05:00 PM</button>
                    </div>

                    <div class="justify-between flex">
                        <button type="button" id="backStep2" class="mt-4 dark:text-white py-2 px-4 rounded hidden">
                            <i class="fa-solid fa-angle-left"></i>
                        </button>
                        <button type="button" id="nextStep2" class="mt-4 bg-primary text-white py-2 px-4">
                            <i class="fa-solid fa-dog mr-2"></i> Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="step-3" class="step hidden">
            <div class="-mb-6 z-10 relative flex items-center justify-center">
                <img src="{{ asset('imgs/cat-dog.webp') }}" alt="Cat-Dog" />
            </div>
            <div class="bg-white dark:bg-gray-700 p-4 shadow-xl rounded-lg">
                <h2 class="text-lg md:text-2xl font-bold">Appointment Summary</h2>
                <p class="mb-4 text-sm md:text-lg">To finish booking your appointment, please confirm the Appointment details. Once confirmed, proceed to book your appointment.</p>

                <div class="border bottom-2 border-gray-500 rounded-xl p-3 md:flex md:flex-col md:text-center md:items-center md:justify-center">
                    <h3 class="text-center font-bold md:text-xl ">Appointment Summary</h3>
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('imgs/logo.webp') }}" alt="Logo" class="w-60 h-60" />
                    </div>
                    <p class="my-4 md:text-xl ">
                        <strong>Schedule:</strong><br />
                        <span id="confirmDate" class="px-2 rounded-full bg-blue-400 "></span>
                        <strong> at </strong>
                        <span id="confirmTime" class="px-2 rounded-full bg-blue-400 "></span>
                    </p>
                    <input type="hidden" name="appt_date" id="appt_date" value="">
                    <input type="hidden" name="appt_time" id="appt_time" value="">
                    <div class="flex my-4">
                        <div>
                            <strong class="md:text-xl ">Pet:</strong><br />
                            <img src="{{asset('imgs/default_pet.webp')}}" id="confirmPetProfile" alt="Pet Profile" class="w-16 h-16 p-1 border-4 border-primary rounded-full md:w-40 md:h-40 my-2 md:my-6">
                            <span id="confirmPet" class=""></span>
                        </div>
                    </div>
                    <p class="my-4 md:text-xl "><strong>Service:</strong><br /><span id="confirmService"></span></p>
                    <p class="my-4 md:text-xl"><strong>Branch:</strong><br /><span id="confirmBranch"></span></p>
                    <p class="my-4 md:text-xl "><strong>Notes:</strong><br /><span id="confirmNotes"></span></p>

                    <div class="flex justify-between mt-4 md:space-x-5">
                        <!-- Back Button on the left side -->
                        <button type="button" id="backStep3" class=" mt-6 rounded">
                            <i class="fa-solid fa-angle-left"></i>
                        </button>

                        <!-- Confirm and Cancel Buttons on the right side -->
                        <div class="flex space-x-2">
                            <!-- Cancel Booking Button -->
                            <button id="cancelBooking" type="button" class="mt-6 text-red-500 font-semibold">Cancel</button>

                            <div class="relative mt-6">
                                <button id="bookNowButton" type="submit" class="bg-primary hover:bg-primary-light text-white py-2 px-4">
                                    <i class="fa-regular fa-calendar-check mr-2"></i>Book Now
                                </button>

                                <!-- Spinner Component -->
                                <div id="bookNowButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-blue-900 hidden">
                                    <x-spinner />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="{{ asset('js/book.js') }}"></script>
@endsection