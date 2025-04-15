<div class="group bg-neutral-200 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 shadow-xl rounded-lg max-w-sm relative overflow-hidden cursor-pointer transition-all duration-300 hover:scale-105 hover:rotate-[0.7deg]">
    <div class="absolute top-4 right-4 flex flex-col space-y-2">
        @if(in_array('delete', $admin_capabilities))
        <button class="text-red-500 hover:text-red-700 font-medium text-xl hover:text-2xl" aria-label="Delete" data-modal-toggle="delete-appointment-modal" data-appointment-id="{{ $appointmentId }}">
            <i class="fa-solid fa-xmark"></i>
        </button>
        @endif

        @if(in_array('edit', $admin_capabilities))
        <button class="text-blue-500 hover:text-blue-700 font-medium hover:text-lg" aria-label="Edit"
            data-modal-toggle="edit-appointment-modal"
            data-appointment-id="{{ $appointmentId }}">
            <i class="fa-solid fa-pencil"></i>
        </button>
        @endif

    </div>

    <div class="flex items-center">
        <div class="w-28 h-28 rounded-full bg-gray-200 overflow-hidden mr-5 shadow-lg">
            <img src="{{ $profile ?? asset('imgs/default_pet.webp') }}" alt="{{ $petName }}'s profile" class="object-cover w-full h-full transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-4xl">{{ $petName }}</h4>
            <p class="mt-2"><strong>Owner: </strong>
                <span class="text-base font-medium text-gray-700">{{ $ownerName }}</span>
            </p>
        </div>
    </div>

    <div class="mt-3">
        <p><strong>Service & Branch: </strong>
            <span class="text-base font-medium text-gray-700">{{ $service }}</span>
            <span class="text-base font-medium text-gray-700"> | {{ $branchName ?? 'N/A' }}</span>
        </p>
        <p><strong>Appointment Date: </strong><span class="text-base font-medium text-gray-700">{{ $appointmentDateTime }}</span></p>
        <p><strong>Status: </strong><span class="font-medium {{ $statusColor }}">{{ $status }}</span></p>
    </div>

    <div class="absolute bottom-4 right-4 text-[8px] text-gray-700">
        <strong>Ref. ID: </strong><span class="font-medium">{{ $appointmentId }}</span>
    </div>
</div>