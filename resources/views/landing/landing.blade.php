@extends('bfc_animalclinic.layouts.layout') <!-- Update this to your main layout file -->

@section('content')
<!-- Hero Section -->
<div class="flex items-center justify-center text-center w-full h-screen relative px-8">
    <!-- Collage Container -->
    <div class="absolute inset-0 grid grid-cols-3 grid-rows-3 z-0 md:grid-cols-4 md:grid-rows-2">
        <div class="col-span-2 row-span-2 md:col-span-2 md:row-span-1">
            <img src="imgs/GIF/cat_sleep.gif" alt="Pet Care GIF 1" class="w-full h-full object-cover">
        </div>
        <div class="col-span-1 row-span-1 md:col-span-1 md:row-span-1">
            <img src="imgs/GIF/worst-walker.gif" alt="Pet Care GIF 2" class="w-full h-full object-cover">
        </div>
        <div class="col-span-1 row-span-1 md:col-span-1 md:row-span-1">
            <img src="imgs/GIF/banana-corgi.gif" alt="Pet Care GIF 3" class="w-full h-full object-cover">
        </div>
        <div class="col-span-1 row-span-2 md:col-span-1 md:row-span-2">
            <img src="imgs/GIF/cat-box.gif" alt="Pet Care GIF 4" class="w-full h-full object-cover">
        </div>
        <div class="col-span-2 row-span-1 md:col-span-2 md:row-span-2">
            <img src="imgs/GIF/coffeecup.gif" alt="Pet Care GIF 5" class="w-full h-full object-cover">
        </div>
        <div class="col-span-2 row-span-1 md:col-span-1 md:row-span-1">
            <img src="imgs/GIF/fat-doggy.gif" alt="Pet Care GIF 6" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- Text Content -->
    <div class="relative z-10 p-6 bg-black bg-opacity-60 rounded-lg max-w-xl md:max-w-2xl">
        <h1 class="text-3xl md:text-6xl font-extrabold mb-4">
            <span class="text-secondary-light">Caring</span> for Your Pets,<br> Just Like <span class="text-primary-light">Family!</span>
        </h1>
        <p class="my-4 text-lg text-white dark:text-gray-200">
            We, at BFC Animal Clinic, promote wellness and well-being for your furbabies, prevent and treat diseases and illnesses. Caring for your furry friends with love and compassion.
        </p>

        <div class="flex items-center justify-center gap-8">
            <a href="#services" class="mt-6 px-3 p-2 border border-primary-light bg-secondary text-white rounded-full shadow-md hover:underline hover:underline-offset-1 transition duration-300">
                Learn More
            </a>
            <a href="{{ route('auth.signup', ['showSignup' => 'true']) }}" class="mt-6 px-3 py-2 border border-secondary bg-primary text-white rounded-full shadow-md hover:bg-primary-light transition duration-300 dark:bg-primary-dark dark:hover:bg-primary-light">
                Get Started!
            </a>
        </div>
    </div>
</div>

<!-- Services Section -->
<div id="services" class="py-10 px-5 mt-20 md:mt-30">
    <h2 class="text-2xl font-bold text-center mb-10 text-black dark:text-white">Our Services</h2>
    <x-offered-services />
</div>

<!-- Contact Section -->
<div class="w-full mt-20 md:mt-30 bg-white py-4 dark:bg-gray-800">
    <h2 class="text-2xl font-bold text-center text-black dark:text-white">Get in Touch</h2>
    <div class="bg-white mt-6 md:mt-6 dark:bg-gray-800">
        <img src="{{ asset('imgs/emergency_cont.webp') }}" alt="Hero Image" class="w-full h-full object-cover">
        <p class="mt-4 md:text-xl text-center text-black dark:text-gray-200">Have questions? We're here to help!</p>
        <div class="flex justify-center mt-6">
            <a href="#contact" class="px-6 py-2 bg-primary-dark text-white rounded-full shadow-md hover:bg-primary-light transition duration-300 dark:bg-primary-light dark:text-black">
                Contact Us
            </a>
        </div>
    </div>
</div>

<div class=" py-12 px-4">
    <h2 class="text-2xl font-semibold text-center text-black dark:text-white">What Our Clients Say</h2>
    <p class="text-center text-gray-600 dark:text-gray-400 mb-6">Feedback from happy pet owners</p>
    <div class="flex flex-col md:flex-row md:justify-around">
        <div class="bg-white rounded-lg shadow-lg p-4 mb-4 md:mb-0 w-full md:w-1/3 md:mx-2 dark:bg-gray-700">
            <p class="italic text-black dark:text-white">"The staff are so caring and attentive to my dog's needs!"</p>
            <p class="font-semibold text-right text-black dark:text-white">- Sarah J.</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-4 mb-4 md:mb-0 w-full md:w-1/3 md:mx-2 dark:bg-gray-700">
            <p class="italic text-black dark:text-white">"Great experience! They really took care of my cat during his stay."</p>
            <p class="font-semibold text-right text-black dark:text-white">- Mike T.</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-4 mb-4 md:mb-0 w-full md:w-1/3 md:mx-2 dark:bg-gray-700">
            <p class="italic text-black dark:text-white">"I trust them completely with my pets' health."</p>
            <p class="font-semibold text-right text-black dark:text-white">- Lisa K.</p>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-primary w-full text-center p-6 md:p-12 dark:bg-primary-dark">
    <h2 class="text-xl md:text-2xl font-semibold">Ready to Care for Your Pet?</h2>
    <p class="mt-2">Schedule an appointment today and give your pet the best care!</p>
    <a href="{{ route('auth.signup') }}" class="mt-4 inline-block bg-white font-semibold px-4 py-2 rounded-md shadow-lg hover:bg-gray-200 transition dark:bg-gray-800 dark:hover:bg-gray-600">
        Book an Appointment
    </a>
</div>

<script>
    // Smooth scroll for the "Explore Our Services" button
    document.querySelector('a[href="#contact"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#contact').scrollIntoView({
            behavior: 'smooth'
        });
    });
    // Smooth scroll for the "Explore Our Services" button
    document.querySelector('a[href="#services"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#services').scrollIntoView({
            behavior: 'smooth'
        });
    });
</script>
@endsection