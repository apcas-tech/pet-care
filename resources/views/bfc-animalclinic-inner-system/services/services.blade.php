@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')

@if (session('success'))
<x-alert message="{{ session('success') }}" type="success" />
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
<x-alert message="{{ $error }}" type="error" />
@endforeach
@endif
<!-- Add Service Button -->
<h1 class="text-3xl font-bold mb-5">Services</h1>
<div class="mb-4 flex justify-end"> <!-- Added flex and justify-end -->
    @if(in_array('create', $admin_capabilities))
    <button type="button" data-modal-toggle="add-service" class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2">
        <i class="fas fa-stethoscope"></i>
        New Service
    </button>
    @endif
</div>
@include('bfc-animalclinic-inner-system.services.add-service')
@include('bfc-animalclinic-inner-system.services.edit-service')
@include('bfc-animalclinic-inner-system.services.delete-service')

<!-- Table to display services -->
<div class="overflow-x-auto mt-6 rounded-md">
    <table class="min-w-full bg-white border border-primary-dark bg-opacity-90">
        <thead>
            <tr class="bg-primary text-white">
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Service</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Capacity</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr class="border-primary-dark border-b text-center">
                <td class="py-6 px-2 font-semibold">{{ $service->id }}</td> <!-- Updated padding -->
                <td class="py-6 px-2 font-semibold">{{ $service->service }}</td> <!-- Updated padding -->
                <td class="py-6 px-2 font-semibold">₱{{ number_format($service->price, 2) }}</td> <!-- Updated padding -->
                <td class="py-6 px-2 font-semibold">{{ $service->capacity }}</td> <!-- Updated padding -->
                <td class="py-6 px-2">{{ $service->description }}</td> <!-- Updated padding -->
                <td class="flex py-6 px-2 border-b space-x-8 justify-center items-center"> <!-- Updated padding -->
                    <!-- Action buttons -->
                    @if(in_array('edit', $admin_capabilities))
                    <button type="button" class="text-blue-600 hover:text-blue-900 font-medium hover:text-lg edit-service-btn" data-id="{{ $service->id }}">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                    @endif
                    @if(in_array('delete', $admin_capabilities))
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-600 hover:text-red-900 font-medium hover:text-2xl delete-service-btn" data-id="{{ $service->id }}">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('js/services.js') }}"></script>
@endsection