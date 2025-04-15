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
<h1 class="text-3xl font-bold mb-5">Users</h1>

<div class="mb-4 flex justify-end"> <!-- Added flex and justify-end -->
    @if(in_array('create', $admin_capabilities))
    <button type="button" data-modal-toggle="add-user" class="bg-primary hover:bg-primary-light text-white rounded-md px-4 py-2">
        <i class="fas fa-stethoscope"></i>
        New User
    </button>
    @endif
</div>
<x-users-list :users="$users" />
@include('bfc-animalclinic-inner-system.users.add-user')
@include('bfc-animalclinic-inner-system.users.edit-user')
@include('bfc-animalclinic-inner-system.users.delete-user')
<script src="{{ asset('js/users.js') }}"></script>
<script>
    window.Laravel = {
        updateUserUrl: "{{ url('bfc-animalclinic-innersystem/users/update') }}/"
    };
</script>
@endsection