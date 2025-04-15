<footer class="relative bg-primary-dark text-white py-6 px-2 md:px-6">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('imgs/cover.webp') }}" class="w-full h-full object-cover opacity-10" alt="Footer Cover">
    </div>

    <!-- Wrapper for content with justify-between -->
    <div class="relative z-10 container mx-auto flex flex-col md:flex-row justify-between items-center space-y-10 md:items-center md:gap-12 py-6">
        <!-- Purpose of the Website -->
        <div class="flex flex-col items-center md:items-start max-w-md text-center md:text-left">
            <h3 class="font-bold mb-3">Our Mission</h3>
            <p class="text-sm opacity-80">
                Our mission is to provide pet owners with a seamless, all-in-one platform for managing pet care.
                From booking vet appointments to finding trusted pet sitters, we strive to make pet ownership
                easier and more enjoyable. With community-driven support and reliable pet services, we aim to
                ensure every pet receives the love and care they deserve.
            </p>
        </div>

        <!-- Quick Links -->
        <div class="flex flex-col items-center md:items-start">
            <h3 class="font-bold mb-3">Quick Links</h3>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('landing.page') }}" class="hover:text-gray-300"><i class="fa-solid fa-location-arrow fa-rotate-by mr-1" style="--fa-rotate-angle: 45deg;"></i> Home</a>
                <a href="{{ route('services.page') }}" class="hover:text-gray-300"><i class="fa-solid fa-location-arrow fa-rotate-by mr-1" style="--fa-rotate-angle: 45deg;"></i> Services</a>
                <a href="{{ route('about.page') }}" class="hover:text-gray-300"><i class="fa-solid fa-location-arrow fa-rotate-by mr-1" style="--fa-rotate-angle: 45deg;"></i> About Us</a>
                <a href="{{ route('contact.page') }}" class="hover:text-gray-300"><i class="fa-solid fa-location-arrow fa-rotate-by mr-1" style="--fa-rotate-angle: 45deg;"></i> Contact</a>
            </div>
        </div>

        <!-- Socials -->
        <div class="flex flex-col items-center md:items-start">
            <h3 class="font-bold mb-3">Socials</h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">
                    <i class="fab fa-facebook-f fa-lg"></i>
                </a>
                <a href="https://www.tiktok.com/" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-black text-white hover:bg-gray-900 transition">
                    <i class="fa-brands fa-tiktok fa-lg"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full text-white transition"
                    style="background: linear-gradient(45deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5);">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
            </div>
        </div>

        <!-- Location -->
        <div class="flex flex-col items-center md:items-start">
            <h3 class="font-bold mb-3">Location</h3>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d246986.52907174092!2d120.5376996029073!3d14.70328668874122!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33964024e6dec43b%3A0x19cc19f159de41a9!2sBfc%20Animal%20Clinic%20%26%20Grooming%20Center!5e0!3m2!1sen!2sph!4v1729055947286!5m2!1sen!2sph" class="w-auto h-auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!3m2!1sen!2sph!4v1729055106614!5m2!1sen!2sph!6m8!1m7!1sYCQuh_O9zLTKMqka0V3zLA!2m2!1d14.70328668874122!2d120.5376996029073!3f63.70823418525031!4f0.5511115360258998!5f2.877317152468198" class="w-auto h-auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <!-- Bottom copyright section -->
    <div class="container mx-auto relative py-4">
        <div class="flex flex-col items-center opacity-75 text-xs">
            <div class="w-full h-0.5 bg-gray-300 rounded-full mb-2"></div>
            <p>© 2025 SweetpewBETA ·
                <a href="{{ route('privacy.policy') }}" class="hover:underline">Privacy</a> ·
                <a href="{{  route('terms.conditions') }}" class="hover:underline">Terms</a>
            </p>
        </div>
    </div>
</footer>