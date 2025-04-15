@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')
<!-- Search and Filter Section -->
@if (session('success'))
<x-alert message="{{ session('success') }}" type="success" />
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
<x-alert message="{{ $error }}" type="error" />
@endforeach
@endif

<h1 class="text-3xl font-bold mb-5">Appointments</h1>
<form method="GET" action="{{ route('admin.appointments') }}" class="mb-6" id="filter-form">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <!-- Search bar -->
        <div class="flex items-center border border-gray-300 bg-white rounded-md px-2 py-2">
            <input type="text" name="search" placeholder="Search by pet/owner name" value="{{ request('search') }}"
                class="border-none outline-none w-full" id="search-input">
            @if(request('search'))
            <a href="{{ route('admin.appointments') }}" class="ml-2 text-gray-500"><i class="fa-solid fa-xmark hover:text-secondary"></i></a>
            @endif
        </div>

        <!-- Filter by date -->
        <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded-md px-4 py-2" onchange="submitForm()">

        <!-- Clear date filter button -->
        @if(request('date'))
        <a href="{{ route('admin.appointments', array_merge(request()->query(), ['date' => ''])) }}" class="ml-2 text-gray-500"><i class="fa-solid fa-xmark hover:text-secondary"></i></a>
        @endif

        <!-- Filter by status -->
        <select name="status" class="border border-gray-300 rounded-md px-4 py-2" onchange="submitForm()">
            <option value="">Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        @if(auth('admins')->user()->role === 'Super Admin')
        <select name="branch" class="border border-gray-300 rounded-md px-4 py-2" onchange="submitForm()">
            <option value="">Select Branch</option>
            @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
            @endforeach
        </select>
        @endif

        <!-- Sort order with arrows -->
        <div class="flex items-center gap-[0.8px]">
            <!-- Ascending order arrow -->
            <a href="{{ route('admin.appointments', array_merge(request()->query(), ['sort' => 'asc'])) }}"
                class="text-gray-500 {{ request('sort') == 'asc' ? 'text-blue-500' : '' }}">
                <i class="fa-solid fa-arrow-up-long bg-primary hover:bg-primary-light hover:text-secondary p-3 text-white rounded-l-md"></i>
            </a>
            <!-- Descending order arrow -->
            <a href="{{ route('admin.appointments', array_merge(request()->query(), ['sort' => 'desc'])) }}"
                class="text-gray-500 {{ request('sort') == 'desc' ? 'text-blue-500' : '' }}">
                <i class="fa-solid fa-arrow-down-long bg-primary hover:bg-primary-light hover:text-secondary p-3 text-white rounded-r-md"></i>
            </a>
        </div>


        <!-- Clear all filters button -->
        <a href="{{ route('admin.appointments') }}" class="bg-primary hover:bg-primary-light hover:text-secondary text-white rounded-md px-4 py-2">
            <i class="fa-solid fa-xmark"></i>
        </a>

        <!-- Add Appointment Button -->
        <div class="ml-auto">
            @if(in_array('create', $admin_capabilities))
            <button type="button" class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2" data-modal-toggle="add-appointment">
                <i class="fa-regular fa-calendar-plus"></i>
                New Appointment
            </button>
            @endif
        </div>
    </div>
</form>

<!-- Display Appointments -->
<div>
    @include('bfc-animalclinic-inner-system.appointment.add-appointment')
    @include('bfc-animalclinic-inner-system.appointment.edit-appointment')
    @include('bfc-animalclinic-inner-system.appointment.delete-appointment')
    <div id="appointment-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Dynamic generated sticky-notes goes here... -->
        @foreach($appointments as $appointment)
        @php
        $petName = $appointment->pet->name;

        // Format the owner's full name
        $owner = $appointment->pet->owner;
        $ownerName = trim("{$owner->Fname} " . ($owner->Mname ? "{$owner->Mname}. " : "") . "{$owner->Lname}");

        $serviceId = $appointment->service->id;
        $serviceName = $appointment->service->service;
        $branchName = $appointment->branch->name;
        $appointmentDate = \Carbon\Carbon::parse($appointment->appt_date)->format('Y-m-d');
        $appointmentTime = \Carbon\Carbon::parse($appointment->appt_time)->format('H:i');
        $appointmentDateTime = "{$appointmentDate} - {$appointmentTime}";


        // Set color for status based on appointment status
        if ($appointment->status === 'Pending') {
        $statusColor = 'text-gray-500';
        } elseif ($appointment->status === 'Scheduled') {
        $statusColor = 'text-orange-500';
        } elseif ($appointment->status === 'Completed') {
        $statusColor = 'text-green-500';
        } else {$statusColor = 'text-red-500';}

        $appointmentId = $appointment->id; // Get the appointment ID
        @endphp

        @php
        $profilePic = $appointment->pet->profile_pic
        ? asset('storage/' . $appointment->pet->profile_pic)
        : asset('imgs/default_pet.webp');
        @endphp

        <!-- Render the sticky note component -->
        <x-sticky-note
            :petName="$petName"
            :ownerName="$ownerName"
            :profile="$profilePic"
            :appointmentId="$appointmentId"
            :service="$serviceName"
            :branchName="$branchName"
            :appointmentDateTime="$appointmentDateTime"
            :appointmentDate="$appointmentDate"
            :appointmentTime="$appointmentTime"
            :status="$appointment->status"
            :statusColor="$statusColor"
            :serviceId="$serviceId" />
        @endforeach
    </div>

    <div class="mt-4">
        {{ $appointments->links('pagination::tailwind') }}
    </div>
</div>

<script src="{{ asset('js/appointment.js') }}"></script>
@endsection