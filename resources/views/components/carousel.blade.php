{{-- resources/views/components/carousel.blade.php --}}
<div class="container w-full mt-6 bg-white dark:bg-gray-800 pb-2 md:pb-4 md:justify-center md:items-center">
    <!-- Appointments Button -->
    <div class="flex justify-center w-full">
        <a href="{{ route('appointments.page') }}"
            class="flex items-center justify-between hover:bg-gray-200 dark:hover:bg-gray-700 font-bold py-2 px-4 w-full">
            <span class="text-lg md:text-xl text-gray-900 dark:text-white">My Appointments</span>

            <div>
                <span class="inline-flex items-center justify-center w-auto h-6 min-w-6 min-h-6 rounded-full border-2 border-black dark:border-white ml-2 text-sm text-gray-600 dark:text-gray-300  font-bold">
                    {{ $appointmentCount }}
                </span>
                <i class="fa-solid fa-chevron-right ml-2 text-gray-600 dark:text-gray-300"></i>
            </div>

        </a>
    </div>

    <!-- Carousel -->
    <div class="relative w-full overflow-hidden rounded-lg shadow-lg border-2 dark:border-gray-600">
        <div class="carousel flex transition-transform duration-300 ease-in-out">
            <div class="carousel-item min-w-full">
                <img src="{{asset('imgs/bg_frame.webp')}}" alt="carousel image" class="w-full h-56 md:h-64 object-cover">
            </div>
            <div class="carousel-item min-w-full">
                <img src="{{asset('imgs/bg_frame.webp')}}" alt="carousel image" class="w-full h-56 md:h-64 object-cover">
            </div>
            <div class="carousel-item min-w-full">
                <img src="{{asset('imgs/bg_frame.webp')}}" alt="carousel image" class="w-full h-56 md:h-64 object-cover">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        function updateCarousel() {
            document.querySelector('.carousel').style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function autoSlide() {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        }

        setInterval(autoSlide, 5000); // Slides change every 5 seconds
    });
</script>