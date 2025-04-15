@extends('bfc_animalclinic.layouts.layout')

@section('content')
<div class="container mx-auto p-6 text-center">
    <h1 class="text-3xl font-bold text-primary-dark dark:text-primary-light mb-4">About Us</h1>
    <p class="text-lg leading-relaxed bg-white/20 backdrop-blur-md p-4 rounded-lg shadow-lg border border-white/30">
        Welcome to BFC Animal Clinic! We are dedicated to providing top-quality veterinary care for your beloved pets.
        Our mission is to ensure the health and happiness of your furry companions through compassionate and professional services.
        We, at BFC Animal Clinic promote wellness and well-being for your furbabies, prevent and treat diseases and illnesses.
    </p>
    <div class="mt-6">
        <img src="{{ asset('imgs/emergency.jpg') }}" alt="Our Team" class="rounded-lg shadow-lg w-full max-w-2xl mx-auto">
    </div>
</div>
@endsection