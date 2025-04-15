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
<!-- Pet Info Container -->
<div class="w-11/12 mx-auto mb-5 border-2 border-gray-800 rounded-lg shadow-lg bg-gray-100 bg-opacity-90">

    <!-- Header -->
    <div class="bg-primary text-white p-6 relative text-center">
        <div class="absolute top-6 left-6 flex items-center space-x-2">
            <a href="{{ route('admin.pets') }}"
                class="bg-gray-700 text-white p-3 w-9 h-9 flex items-center justify-center rounded-full hover:bg-blue-700 transform hover:scale-110 transition duration-300">
                B
            </a>
            <span class="text-white">Back</span>
        </div>
        <h1 class="text-2xl font-bold">{{ $pet->name }}'s Info</h1>
        <p class="text-left text-sm mt-8"><strong>Pet No:</strong> {{ $pet->id }}</p>
        <div class="absolute top-6 right-6 flex items-center space-x-2">
            <!-- Edit button -->
            @if(in_array('edit', $admin_capabilities))
            <button class="bg-gray-700 text-white p-3 w-9 h-9 flex items-center justify-center rounded-full hover:bg-green-500 transform hover:scale-110 transition duration-300" data-modal-toggle="edit-pet">
                <i class="fa-solid fa-pen hover:text-lg"></i>
            </button>
            @endif
            @if(in_array('delete', $admin_capabilities))
            <!-- Delete button -->
            <button class="bg-gray-700 text-white p-3 w-9 h-9 flex items-center justify-center rounded-full hover:bg-red-500 transform hover:scale-110 transition duration-300" data-modal-toggle="delete-pet">
                <i class="fa-solid fa-minus hover:text-lg"></i>
            </button>
            @endif
        </div>

    </div>

    <!-- Details Section -->
    <div class="flex flex-wrap justify-between p-6">

        <!-- Left: Pet Image -->
        <div class="w-full md:w-1/3 p-4">
            <img src="{{ $pet->profile_pic ? asset('storage/' . $pet->profile_pic) : asset('imgs/default_pet.webp') }}" alt="{{ $pet->name }}" class="w-full h-auto rounded-lg shadow-lg">
        </div>

        <!-- Middle: Pet Info -->
        <div class="w-full md:w-1/3 p-4 bg-gray-100 rounded-lg shadow-lg text-center bg-opacity-90">
            <div class="mb-6">
                <img src="{{ $speciesIcons[$pet->species] ?? asset('imgs/default_species.webp') }}" alt="{{ $pet->species }}" class="mx-auto border-2 border-blue-900 rounded-full w-16">
            </div>
            <p class="text-xl mb-4"><strong>Breed:</strong> {{ $pet->breed }}</p>
            <p class="text-xl mb-4"><strong>Age:</strong> {{ \Carbon\Carbon::parse($pet->bday)->age }} Years Old</p>
            <p class="text-xl mb-4">
                <strong>Gender:</strong>
                @if ($pet->gender == 'Male')
                <i class="fas fa-mars text-blue-700"></i>
                @elseif ($pet->gender == 'Female')
                <i class="fas fa-venus text-pink-700"></i>
                @endif
            </p>
            <p class="text-xl"><strong>Weight:</strong> {{ $pet->weight }} kg</p>
        </div>

        <!-- Right: Owner Info -->
        <div class="w-full md:w-1/3 p-4 bg-gray-100 rounded-lg shadow-lg text-center bg-opacity-90">
            <h2 class="text-2xl mb-6">Owner Info</h2>
            <p class="text-lg mb-3"><strong>Name:</strong> {{ $owner->Fname }} {{ $owner->Mname ? $owner->Mname . '. ' : '' }}{{ $owner->Lname }}</p>
            <p class="text-lg mb-3"><strong>Email:</strong> {{ $owner->email }}</p>
            <p class="text-lg mb-3"><strong>Phone:</strong> {{ $owner->phone }}</p>
            <p class="text-lg"><strong>Address:</strong> {{ $owner->address }}</p>
        </div>
    </div>

    <div class="mt-10 p-5">
        <!-- Health Records Section -->
        <div class="flex justify-between items-center mb-6 p-5">
            <h2 class="text-2xl font-semibold">Health Records</h2>
            <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300" data-modal-toggle="add-health">
                <i class="fas fa-stethoscope"></i> Add Health Record
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300 mb-10">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="border border-gray-300 p-3">Date</th>
                        <th class="border border-gray-300 p-3">Description</th>
                        <th class="border border-gray-300 p-3">Treatment</th>
                        <th class="border border-gray-300 p-3">Prescription</th>
                        <th class="border border-gray-300 p-3">Vet</th>
                        <th class="border border-gray-300 py-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($healthRecords as $record)
                    <tr class="text-center bg-white hover:bg-gray-100">
                        <td class="border border-gray-300 p-3">{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}</td>
                        <td class="border border-gray-300 p-3">{{ $record->description ?? 'N/A' }}</td>
                        <td class="border border-gray-300 p-3">{{ $record->tx_given ?? 'N/A' }}</td>
                        <td class="border border-gray-300 p-3">
                            @if($record->prescription)
                            <button class="bg-primary text-white px-3 py-1 rounded hover:bg-primary-light transition"
                                onclick="viewPrescription({{ json_encode($record->prescription) }})">
                                <i class="fa-solid fa-file-prescription"></i> View
                            </button>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="border border-gray-300 p-3">
                            @if($record->veterinarian)
                            Dr. {{ $record->veterinarian->Fname }}
                            @if($record->veterinarian->Mname)
                            {{ strtoupper(substr($record->veterinarian->Mname, 0, 1)) }}.
                            @endif
                            {{ $record->veterinarian->Lname }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="border border-gray-300 p-3">
                            <button onclick="openSignatureModal('{{ $record->id }}')" class="bg-green-500 text-white px-4 py-2 rounded">Download</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 p-3 text-gray-500 text-center">No health records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="prescription-modal" class="fixed inset-0 bg-cyan-950 bg-opacity-70 flex justify-center items-center hidden z-50">
            <div class="bg-white p-5 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-semibold mb-4">Prescription Details</h2>
                <ul id="prescription-list" class="list-disc pl-5 text-gray-700"></ul>
                <button onclick="closePrescriptionModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Close</button>
            </div>
        </div>

        <!-- Vaccination Records Section -->
        <div class="mt-10">
            <div class="flex justify-between items-center mb-6 p-5">
                <h2 class="text-2xl font-semibold">Vaccination Records</h2>
                <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300" data-modal-toggle="add-vaccine-modal">
                    <i class="fas fa-syringe"></i> Add Vaccination
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="border border-gray-300 py-1 px-2">Vaccine Name</th>
                            <th class="border border-gray-300 py-1 px-2">Administered</th>
                            <th class="border border-gray-300 py-1 px-2">Next Due</th>
                            <th class="border border-gray-300 py-6 px-2">Notes</th>
                            <th class="border border-gray-300 py-3 px-2">Veterinarian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vaccinations as $vaccine)
                        <tr class="text-center bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 py-1 px-2">{{ $vaccine->vaccine_name }}</td>
                            <td class="border border-gray-300 py-1 px-2">{{ $vaccine->date_administered }}</td>
                            <td class="border border-gray-300 py-1 px-2">{{ $vaccine->next_due_date ?? 'N/A' }}</td>
                            <td class="border border-gray-300 py-6 px-2">{{ $vaccine->notes ?? 'No Notes' }}</td>
                            <td class="border border-gray-300 py-3 px-2">Dr.
                                @if($vaccine->veterinarian)
                                {{ $vaccine->veterinarian->Fname }}
                                @if(!empty($vaccine->veterinarian->Mname))
                                {{ strtoupper(substr($vaccine->veterinarian->Mname, 0, 1)) }}.
                                @endif
                                {{ $vaccine->veterinarian->Lname }}
                                @else
                                N/A
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 p-3 text-gray-500 text-center">No vaccination records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('bfc-animalclinic-inner-system.pets.profile.edit-pet')
@include('bfc-animalclinic-inner-system.pets.profile.delete-pet')
@include('bfc-animalclinic-inner-system.pets.profile.add-health')
@include('bfc-animalclinic-inner-system.pets.profile.add-vaccine')
@include('bfc-animalclinic-inner-system.pets.profile.add-signature')
<script src="{{ asset('js/pet-profile.js') }}"></script>
<script>
    // Define the route for the pets page so JavaScript can access it
    const routeToPets = "{{ route('admin.pets') }}";

    document.addEventListener("DOMContentLoaded", function() {
        const submitButton = document.getElementById("submit-button");
        const vaccineSelect = document.getElementById("vaccineSelect");
        const customVaccineName = document.querySelector("input[name='custom_vaccine_name']");
        const dateAdministered = document.querySelector("input[name='date_administered']");
        const veterinarianSelect = document.querySelector("select[name='administered_by']");

        // Function to check form validity
        function checkFormValidity() {
            if ((vaccineSelect.value || customVaccineName.value) && dateAdministered.value && veterinarianSelect.value) {
                submitButton.disabled = false; // Enable submit button
            } else {
                submitButton.disabled = true; // Disable submit button
            }
        }

        // Attach event listeners to the inputs
        vaccineSelect.addEventListener("change", checkFormValidity);
        customVaccineName.addEventListener("input", checkFormValidity);
        dateAdministered.addEventListener("change", checkFormValidity);
        veterinarianSelect.addEventListener("change", checkFormValidity);

        // Initial check
        checkFormValidity();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Get the vaccine dropdown and custom vaccine input elements
        const vaccineSelect = document.getElementById('vaccineSelect');
        const customVaccineInput = document.querySelector('input[name="custom_vaccine_name"]');

        // Add event listener for vaccine dropdown change
        vaccineSelect.addEventListener('change', function() {
            // If a vaccine is selected, clear the custom input
            if (this.value !== "") {
                customVaccineInput.value = '';
            }
        });

        // Add event listener for custom vaccine input change
        customVaccineInput.addEventListener('input', function() {
            // If user types in custom input, clear the vaccine dropdown
            if (this.value !== "") {
                vaccineSelect.value = '';
            }
        });
    });

    // Add branch Modal
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("add-vaccine-modal");
        const openModalBtn = document.querySelector(
            '[data-modal-toggle="add-vaccine-modal"]'
        );
        const closeModalBtn = modal.querySelector('[data-modal-hide="add-vaccine-modal"]');

        openModalBtn.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        closeModalBtn.addEventListener("click", function() {
            modal.classList.add("hidden");
        });

        window.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    });

    function viewPrescription(prescription) {
        let list = document.getElementById("prescription-list");
        list.innerHTML = ""; // Clear previous content

        if (Array.isArray(prescription) && prescription.length > 0) {
            prescription.forEach(med => {
                let li = document.createElement("li");
                li.textContent = `${med.name} - ${med.dosage} - ${med.frequency}`;
                list.appendChild(li);
            });
        } else {
            list.innerHTML = "<li>No prescription available</li>";
        }

        document.getElementById("prescription-modal").classList.remove("hidden");
    }

    // Close modal when clicking outside
    document.addEventListener("click", function(event) {
        const modal = document.getElementById("prescription-modal");
        if (!modal.classList.contains("hidden") && event.target === modal) {
            closePrescriptionModal();
        }
    });

    function closePrescriptionModal() {
        document.getElementById("prescription-modal").classList.add("hidden");
    }
</script>

@endsection