@extends('bfc_animalclinic.layouts.layout')

@section('content')
<!-- Header -->
<div class="w-full bg-primary px-4 py-2 text-white flex items-center md:px-8 md:py-4">
    <a href="{{ route('home.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold md:text-2xl">My Appointments</h1>
</div>

<!-- Content Area -->
<div class="my-6">
    <div class="w-full max-w-screen-sm p-4">
        @if ($appointments->isEmpty())
        <div class="flex flex-col items-center justify-center h-full">
            <!-- From Uiverse.io by TheAbieza -->
            <div class="container">
                <div class="folder">
                    <div class="top"></div>
                    <div class="bottom"></div>
                </div>
                <p class="title text-center text-lg md:text-2xl mt-4">You have no upcoming appointments.</p>
            </div>

        </div>
        @else
        <div class="w-full space-y-4 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6">
            @foreach ($appointments as $appointment)
            <div class="bg-white shadow-xl dark:bg-gray-700 p-4 rounded-lg appointment-card" data-appointment='@json($appointment)'>
                <div class="flex justify-between items-center md:items-start">
                    <div class="flex flex-col items-center">
                        <img src="{{ $appointment->pet->profile_pic ? asset('storage/' . $appointment->pet->profile_pic) : asset('imgs/default_pet.webp') }}"
                            alt="Pet's Profile Picture"
                            class="w-16 h-16 rounded-sm object-cover md:w-20 md:h-20">
                        <h3 class="font-bold text-center text-gray-900 dark:text-gray-100 ml-2 truncate w-24 md:w-32">
                            {{ $appointment->pet->name }}
                        </h3>
                    </div>
                    <div class="text-right text-sm md:text-base text-gray-600 dark:text-gray-300 space-y-4">
                        <p>{{ \Carbon\Carbon::parse($appointment->appt_date)->format('F d, Y') }} - {{ (new \Carbon\Carbon($appointment->appt_time))->format('h:i A') }}</p>
                        <p>
                            <span class="font-bold">Service: </span>{{ $appointment->service->service }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="appointmentModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg p-6 max-w-md w-full md:max-w-lg">
        <div class="relative bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg p-4">
            <!-- ID Card Header -->
            <div class="bg-primary text-white rounded-t-lg px-4 py-2">
                <h2 id="modalPetName" class="text-center text-lg font-bold md:text-xl">Appointment</h2>
            </div>
            <!-- ID Card Body -->
            <div class="flex flex-col items-center px-4 py-6">
                <!-- Pet's Picture -->
                <img id="petProfilePic" src="" alt="Pet's Profile Picture" class="w-28 h-28 rounded-sm border-2 border-primary object-cover mb-4 md:w-36 md:h-36">

                <!-- Pet Details -->
                <div class="text-center">
                    <p id="appointmentDate" class="text-gray-700 dark:text-gray-300 mb-1"><strong>Date:</strong> </p>
                    <p id="appointmentTime" class="text-gray-700 dark:text-gray-300 mb-1"><strong>Time:</strong> </p>
                    <p id="serviceName" class="text-gray-700 dark:text-gray-300 mb-1"><strong>Service:</strong> </p>
                    <p id="appointmentNotes" class="text-gray-700 dark:text-gray-300"><strong>Notes:</strong> </p>
                </div>
            </div>
        </div>
        <!-- Close Button -->
        <button id="closeModal" class="mt-4 bg-secondary text-white px-4 py-2 w-full">Close</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('appointmentModal');
        const closeModal = document.getElementById('closeModal');

        // Function to format date and time
        function formatDateTime(dateString, timeString) {
            const date = new Date(`${dateString}T${timeString}`);
            const formattedDate = new Intl.DateTimeFormat('en-US', {
                month: 'long',
                day: '2-digit',
                year: 'numeric'
            }).format(date);

            const formattedTime = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            }).format(date);

            return {
                formattedDate,
                formattedTime
            };
        }

        // Function to open the modal and populate it with appointment data
        function openModal(appointment) {
            // Determine pet image URL
            const petImageUrl = appointment.pet.profile_pic ?
                `${window.location.origin}/bfc_animalclinic/public/storage/${appointment.pet.profile_pic}` :
                `${window.location.origin}/bfc_animalclinic/public/imgs/default_pet.webp`;

            // Format date and time
            const {
                formattedDate,
                formattedTime
            } = formatDateTime(appointment.appt_date, appointment.appt_time);

            // Populate modal content
            document.getElementById('modalPetName').textContent = `${appointment.pet.name}'s Appointment`; // Update modal title
            document.getElementById('petProfilePic').src = petImageUrl;
            document.getElementById('appointmentDate').innerHTML = `<strong>Date:</strong> ${formattedDate}`;
            document.getElementById('appointmentTime').innerHTML = `<strong>Time:</strong> ${formattedTime}`;
            document.getElementById('serviceName').innerHTML = `<strong>Service:</strong> ${appointment.service.service}`;
            document.getElementById('appointmentNotes').innerHTML = `<strong>Notes:</strong> ${appointment.notes || 'No notes provided.'}`;

            // Show the modal
            modal.classList.remove('hidden');
        }

        // Close modal event
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Add click event to each appointment card
        document.querySelectorAll('.appointment-card').forEach(card => {
            card.addEventListener('click', function() {
                const appointment = JSON.parse(this.getAttribute('data-appointment'));
                openModal(appointment);
            });
        });
    });
</script>

<style>
    /* From Uiverse.io by TheAbieza */
    .container {
        width: fit-content;
        gap: 10px
    }

    .folder {
        width: min-content;
        margin: auto;
        animation: float 2s infinite linear;
    }

    .folder .top {
        background-color: #FF8F56;
        width: 60px;
        height: 12px;
        border-top-right-radius: 10px;
    }

    .folder .bottom {
        background-color: #FFCE63;
        width: 100px;
        height: 70px;
        box-shadow: 5px 5px 0 0 #283149;
        border-top-right-radius: 8px;
    }

    @keyframes float {
        0% {
            transform: translatey(0px);
        }

        50% {
            transform: translatey(-25px);
        }

        100% {
            transform: translatey(0px);
        }
    }
</style>
@endsection