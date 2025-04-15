<div class="container mx-auto relative">
    <!-- Scrollable Service Cards Container -->
    <div class="flex w-screen h-auto py-4 overflow-x-auto space-x-4 no-scrollbar" id="service-container">
        <!-- Service Card 1 -->
        <div class="service-card flex-none w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10 opacity-0 transition-opacity duration-500">
            <img src="{{ asset('imgs/services/consultation.webp')}}" alt="Consultation Service" class="w-full h-auto object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Consultation</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Our professional veterinary consultation service helps in diagnosing your pet's health and provides expert advice on proper care and treatment plans.</p>
        </div>

        <!-- Service Card 2 -->
        <div class="service-card flex-none w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10 opacity-0 transition-opacity duration-500">
            <img src="{{ asset('imgs/services/treatment.webp')}}" alt="Treatment Service" class="w-full h-auto object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Treatment</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">We offer comprehensive treatments for a variety of pet health conditions, ensuring your furry friend receives the best care available to recover quickly.</p>
        </div>

        <!-- Service Card 3 -->
        <div class="service-card flex-none w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10 opacity-0 transition-opacity duration-500">
            <img src="{{ asset('imgs/services/deworm.webp')}}" alt="Deworming Service" class="w-full h-auto object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Deworming</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Keep your pet healthy with our safe and effective deworming services. We offer treatments for intestinal parasites to ensure your pet remains in top health.</p>
        </div>

        <!-- Service Card 4 -->
        <div class="service-card flex-none w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10 opacity-0 transition-opacity duration-500">
            <img src="{{ asset('imgs/services/lodging.webp')}}" alt="Pet Boarding and Lodging" class="w-full h-auto object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pet Boarding and Lodging</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Our pet boarding services provide a safe, comfortable, and secure environment for your pet when you're away, with personalized care and attention.</p>
        </div>

        <!-- Service Card 5 -->
        <div class="service-card flex-none w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10 opacity-0 transition-opacity duration-500">
            <img src="{{ asset('imgs/services/grooming.webp')}}" alt="Pet Grooming Care" class="w-full h-auto object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pet Grooming Care</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pamper your pet with our professional grooming services, including baths, haircuts, nail trimming, and ear cleaning, to keep them looking and feeling their best.</p>
        </div>

        <!-- Service Card 4 (See More) -->
        <div class="flex flex-col min-w-60 bg-white dark:bg-gray-600 p-4 rounded-lg shadow-md border items-center justify-center hover:bg-primary hover:bg-opacity-95 text-lg font-semibold text-black dark:text-white hover:text-white hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:z-10">
            <div class=" mb-6 text-primary-light">
                <i class="fa-regular fa-circle-check fa-xl"></i>
            </div>
            <h4 class="text-base font-semibold mb-2 capitalize transition-all duration-500">Quick Pet Care Scheduling</h4>
            <p class="text-sm font-normal transition-all duration-500 leading-5 mb-4">Easily schedule appointments for your pet's health and well-being, with quick and seamless booking.</p>
            <a href="{{route('services.page')}}" class="group flex items-center gap-2 text-sm font-semibold text-primary-light transition-all duration-500 ">See More <i class="fa-solid fa-arrow-right-long text-primary-light"></i>
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div id="scroll-indicator" class="bg-gray-500 dark:bg-gray-700 text-white py-4 w-12 h-full rounded-l-lg absolute right-0 top-1/2 transform -translate-y-1/2 opacity-30 transition-opacity duration-500 ease-in-out flex items-center justify-center cursor-pointer z-10">
        <i class="fa-solid fa-chevron-right"></i>
    </div>
</div>

<!-- Styles for Scroll Indicator -->
<style>
    #service-container {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        /* Smooth scrolling on iOS */
        scroll-snap-type: x mandatory;
        /* Optional: Snap to items */
    }

    #scroll-indicator {
        pointer-events: none;
        /* Disable clicks */
    }

    #scroll-indicator.show {
        opacity: 0.5 !important;
        /* Ensure opacity is fully visible */
    }

    #scroll-indicator.hidden {
        opacity: 0 !important;
        /* Ensure opacity is fully hidden */
    }

    /* Add some transition to the icon */
    #scroll-indicator i {
        transition: transform 0.3s ease-in-out;
    }

    /* Animate the arrow when visible */
    #scroll-indicator.show i {
        transform: translateX(0);
    }

    #scroll-indicator.hidden i {
        transform: translateX(10px);
        /* Slightly offset when hidden */
    }
</style>

<!-- JavaScript for Scroll Behavior -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('service-container');
        const scrollIndicator = document.getElementById('scroll-indicator');

        // Function to show or hide the indicator based on scroll position
        function checkScrollPosition() {
            if (container.scrollLeft === 0) {
                scrollIndicator.classList.add('show');
                scrollIndicator.classList.remove('hidden');
            } else {
                scrollIndicator.classList.add('hidden');
                scrollIndicator.classList.remove('show');
            }
        }

        // Check position on scroll
        container.addEventListener('scroll', checkScrollPosition);

        // Initial check when page loads
        checkScrollPosition();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const serviceCards = document.querySelectorAll('.service-card');

        // IntersectionObserver options
        const options = {
            root: null, // Use the viewport
            rootMargin: '0px',
            threshold: 0.2 // 20% of the element must be visible
        };

        // IntersectionObserver callback function
        const fadeInOnScroll = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0');
                    entry.target.classList.add('opacity-100');
                    observer.unobserve(entry.target); // Stop observing after fade-in
                }
            });
        };

        const observer = new IntersectionObserver(fadeInOnScroll, options);

        // Observe each service card
        serviceCards.forEach(card => {
            observer.observe(card);
        });
    });
</script>