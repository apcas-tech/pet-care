@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')
<h1 class="text-3xl font-bold mb-5">Branches</h1>
<div class="mb-4 flex justify-end"> <!-- Added flex and justify-end -->
    @if(in_array('create', $admin_capabilities))
    <button type="button" data-modal-toggle="add-branch" class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2">
        <i class="fa-solid fa-store"></i>
        New Branch
    </button>
    @endif
</div>
<!-- Vet Branch Contacts Table -->
<div class="overflow-x-auto mt-6 rounded-t-md rounded-b-md">
    <table class="min-w-max w-full bg-white table-auto">
        <thead>
            <tr class="bg-primary text-white">
                <th class="py-3 px-6 text-left">Branch Name</th>
                <th class="py-3 px-6 text-left">Phone Number</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light" id="branchTableBody">
            @foreach($branches as $branch)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <!-- Branch Name -->
                <td class="py-3 px-6">
                    <div class="flex items-center">
                        <div class="mr-2">
                            <img src="{{ asset('imgs/logo.webp') }}" alt="Branch Icon" class="w-10 h-10 rounded-full">
                        </div>
                        <div>
                            <span class="font-medium">{{ $branch->name }}</span>
                        </div>
                    </div>
                </td>

                <!-- Phone Number -->
                <td class="py-3 px-6">
                    <span class="text-sm bg-green-200 text-green-700 py-1 px-3 rounded-full">
                        {{ $branch->phone_number }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="flex py-6 px-2 border-b space-x-8 justify-center items-center">
                    @if(in_array('edit', $admin_capabilities))
                    <button class="text-blue-600 hover:text-blue-900 text-base hover:text-lg edit-branch-btn"
                        data-branch-id="{{ $branch->id }}"
                        data-modal-toggle="edit-branch">
                        <i class="fa-solid fa-pencil"></i>
                    </button>
                    @endif
                    @if(in_array('delete', $admin_capabilities))
                    <button type="button"
                        class="text-red-600 hover:text-red-900 text-lg hover:text-2xl delete-branch-btn"
                        data-branch-id="{{ $branch->id }}"
                        data-modal-toggle="delete-branch">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('bfc-animalclinic-inner-system.branches.add-branch')
@include('bfc-animalclinic-inner-system.branches.edit-branch')
@include('bfc-animalclinic-inner-system.branches.delete-branch')
<script src="{{ asset('js/branch.js') }}"></script>

@endsection