@extends('bfc_animalclinic.layouts.layout')

@section('content')
<!-- Banner Section -->
<div class="flex flex-col items-center bg-primary-light justify-center text-center w-full h-screen relative">
    <img src="{{ asset('imgs/services/banner.webp') }}" alt="Banner Image" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative z-10 px-4 sm:px-8 bottom-48">
        <h1 class="text-5xl font-bold text-primary">Our Veterinary Services</h1>
        <p class="my-4 text-lg max-w-2xl mx-auto text-black">At our clinic, we offer a variety of services to ensure your pet’s well-being. Explore below to learn more about the care we provide!</p>

        <div class="flex justify-center gap-4">
            <a href="#services" class="mt-6 px-6 py-2 bg-primary font-semibold text-white hover:bg-primary-light hover:text-secondary-light rounded-full shadow-md transition duration-300">
                Explore Our Services
            </a>
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="py-12 mt-40 overflow-hidden" id="services">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 text-gray-800 dark:text-gray-200">Our Services</h2>

        <div class="swiper-container pl-5 md:pl-10 flex justify-center items-center mx-auto">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/consultation.webp') }}" alt="Consultation Service" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Consultation</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our professional veterinary consultation service helps in diagnosing your pet's health and provides expert advice on proper care and treatment plans.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/treatment.webp') }}" alt="Treatment Service" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Treatment</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">We offer comprehensive treatments for a variety of pet health conditions, ensuring your furry friend receives the best care available to recover quickly.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/vaccination.webp') }}" alt="Vaccination" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Vaccination</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Protect your pet from preventable diseases with our vaccination services, tailored to your pet's age and health status.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/deworm.webp') }}" alt="Deworming Service" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Deworming</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Keep your pet healthy with our safe and effective deworming services, designed to eliminate intestinal parasites and improve overall health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/lodging.webp') }}" alt="Pet Boarding and Lodging" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pet Boarding and Lodging</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our pet boarding services provide a safe, comfortable, and secure environment for your pet while you are away, with personalized care and attention.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/confinement.webp') }}" alt="Pet Confinement" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Confinement</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our confinement services ensure that your pet receives the necessary care and monitoring during recovery from surgery or illness.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/grooming.webp') }}" alt="Pet Grooming Care" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pet Grooming Care</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Pamper your pet with our professional grooming services, including baths, haircuts, nail trimming, and ear cleaning, to keep them looking and feeling their best.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/dental.webp') }}" alt="Dental Prophylaxis" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Dental Prophylaxis</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Maintain your pet's oral health with our dental prophylaxis services, which include cleanings and examinations to prevent dental disease.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/whelping.webp') }}" alt="Whelping Assistance" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Whelping Assistance</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our experienced staff provides support and care during the whelping process, ensuring a safe and healthy delivery for both mother and puppies.</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Surgery Section -->
    <div class="container mt-16 md:mt-24 mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 px-6">Surgery</h2>
        <div class="surgery-container pl-5 md:pl-10 flex justify-center items-center mx-auto">
            <div class="surgery-wrapper">
                <div class="surgery">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/surgery.webp') }}" alt="Pet Surgery" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Minor & Major Surgery</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">We provide both minor and major surgical procedures, ensuring your pet receives the highest level of care and attention before, during, and after surgery.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Microscopy Section -->
    <div class="container mt-16 md:mt-24 mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 px-6">Microscopy</h2>
        <div class="swiper-container pl-5 md:pl-10 flex justify-center items-center mx-auto">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/fecalysis.webp') }}" alt="Fecalysis" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Fecalysis</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our fecalysis service helps diagnose intestinal parasites and other gastrointestinal issues, ensuring your pet's digestive health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/sarcoptic.webp') }}" alt="Skin Scrape" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Skin Scrape</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our skin scrape tests help identify skin conditions and parasites, ensuring your pet receives appropriate treatment.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/ear-swab.webp') }}" alt="Ear Swab" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Ear Swab</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our ear swab tests help diagnose ear infections and other conditions, ensuring your pet's ears remain healthy.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/urine-test.webp') }}" alt="Urinalysis" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Urinalysis</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our urinalysis service helps detect urinary tract infections and other urinary issues, providing essential information for your pet's health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/surgery.webp') }}" alt="Smear Test" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Smear Test</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our smear tests help identify blood parasites and other conditions, ensuring your pet receives timely treatment.</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Laboratory Section -->
    <div class="container mt-16 md:mt-24 mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 px-6">Laboratory Diagnostics</h2>
        <div class="swiper-container pl-5 md:pl-10 flex justify-center items-center mx-auto">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/cbc.webp') }}" alt="Complete Blood Count" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Complete Blood Count</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our complete blood count service provides vital information about your pet's overall health and helps diagnose various conditions.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/blood-chem.webp') }}" alt="Blood Chemistry" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Blood Chemistry</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our blood chemistry tests assess organ function and metabolic status, providing crucial insights into your pet's health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/ultrasound.webp') }}" alt="Ultrasound" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Ultrasound</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our ultrasound service provides non-invasive imaging to help diagnose internal conditions and monitor your pet's health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/progesterone.webp') }}" alt="Progesterone Testing" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Progesterone Testing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Our progesterone testing helps monitor reproductive health and timing for breeding, ensuring the best outcomes for your pet.</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Rapid Test Section -->
    <div class="container mt-16 md:mt-24 mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 px-6">Rapid Testkits</h2>
        <div class="swiper-container pl-5 md:pl-10 flex justify-center items-center mx-auto">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/canine.webp') }}" alt="Canine Rapid Test" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Canine (Dog)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Tests for Parvo, Distemper, Heartworm, Leptospirosis, and Blood Parasitism to ensure your dog's health.</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="service-card w-80 max-w-52 md:max-w-full bg-white dark:bg-gray-600 p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-xl hover:z-10 transition-all duration-300 ease-in-out transform">
                        <img src="{{ asset('imgs/services/feline.webp') }}" alt="Feline Rapid Test" class="w-full h-auto object-cover rounded-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Feline (Cat)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Tests for Panleukopenia, Calici, Herpes, Corona, and Toxoplasma to keep your cat healthy.</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<style>
    .swiper-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-pagination {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }

    /* Initial state: invisible */
    .service-card,
    .swiper-slide {
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    /* When visible, make the card visible */
    .service-card.visible,
    .swiper-slide.visible {
        opacity: 1;
    }
</style>

<!-- Include Swiper CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1.5, // Number of slides to show at once
        spaceBetween: 5, // Space between slides
        navigation: false, // Disable left/right buttons
        pagination: {
            el: '.swiper-pagination',
            clickable: true, // Allow clicking on dots to navigate
        },
        grabCursor: true, // Allow grabbing/swiping
        loop: true, // Loop the carousel
        breakpoints: {
            // For medium screens and up (768px and larger)
            768: {
                slidesPerView: 4, // Show 3 slides at once
                spaceBetween: 10, // Adjust space between slides
            }
        }
    });

    // Smooth scroll for the "Explore Our Services" button
    document.querySelector('a[href="#services"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#services').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Intersection Observer for fade-in/out effect
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // If the element is in view, add the 'visible ' class
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
        });
    }, {
        threshold: 0.2 // Trigger the visibility effect when 20% of the element is visible
    });

    // Observe all service cards and swiper slides
    document.querySelectorAll('.service-card, .swiper-slide').forEach(card => {
        observer.observe(card);
    });
</script>
@endsection