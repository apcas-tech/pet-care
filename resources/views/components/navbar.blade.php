<div id="navbar" class="bg-primary shadow-md fixed top-0 left-0 w-full z-50 hidden">
    <div class="flex justify-between items-center px-4 h-full">
        <div class="flex items-center gap-4 h-full">
            <!-- Hamburger Icon (only visible on mobile) -->
            <div class="md:hidden">
                <button id="menu-toggle" class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>


            <!-- Logo -->
            <a href="{{ route('landing.page') }}">
                <img src="{{ asset('imgs/logo.webp') }}" alt="Logo" class="h-10 w-10 md:w-16 md:h-16 md:ml-10 my-2" />
            </a>
        </div>

        <!-- Navigation Links for Medium and Larger Screens -->
        <div class="flex items-center space-x-10 h-full">
            <nav class="hidden md:flex space-x-10 h-full items-center">
                <div class="flex space-x-4 h-full items-center">
                    <!-- Home Menu Item - Show if in session -->
                    @if(Cookie::get('in_session'))
                    <a href="{{ route('home.page') }}" class=" text-white relative hover:text-red-700 hover:font-bold px-3 py-7 h-auto flex items-center {{ request()->routeIs('home.page') ? '!text-secondary-light font-bold' : '' }}">
                        Home
                        <!-- Triangle -->
                        @if(request()->routeIs('home.page'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-transparent border-b-secondary-light shadow-lg"></span>
                        @endif
                    </a>
                    @endif

                    <a href="{{ route('services.page') }}" class=" text-white relative hover:text-red-700 hover:font-bold px-3 py-7 h-full flex items-center {{ request()->routeIs('services.page') ? '!text-secondary-light font-bold' : '' }}">
                        Services
                        @if(request()->routeIs('services.page'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-transparent border-b-secondary-light"></span>
                        @endif
                    </a>
                    <a href="{{ route('about.page') }}" class=" text-white relative hover:text-red-700 hover:font-bold px-3 py-7 h-full flex items-center {{ request()->routeIs('about.page') ? '!text-secondary-light font-bold' : '' }}">
                        About US
                        @if(request()->routeIs('about.page'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-transparent border-b-secondary-light"></span>
                        @endif
                    </a>
                    <a href="{{ route('contact.page') }}" class=" text-white relative hover:text-red-700 hover:font-bold px-3 py-7 h-full flex items-center {{ request()->routeIs('contact.page') ? '!text-secondary-light font-bold' : '' }}">
                        Contact
                        @if(request()->routeIs('contact.page'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-transparent border-b-secondary-light"></span>
                        @endif
                    </a>
                </div>
            </nav>

            <!-- Hide login and signup buttons if in session -->
            @unless(Cookie::get('in_session'))
            <div class="flex gap-2">
                <a href="{{ route('auth.login') }}" class="hidden md:block text-white hover:bg-primary-dark px-3 py-2 rounded-full">Login</a>
                <a href="{{ route('auth.signup') }}" class="bg-secondary hidden md:block text-white hover:bg-secondary-dark px-3 py-2 rounded-full">Sign Up</a>
            </div>
            @endunless

            <!-- User Profile Dropdown (only visible when user is authenticated) -->
            @if(Cookie::get('in_session') && auth()->check())
            <div class="dropdown relative inline-flex mr-2">
                <button type="button" data-target="dropdown-with-header" id="dropdown-button" class="dropdown-toggle inline-flex justify-center items-center w-10 h-10 rounded-full cursor-pointer text-center shadow-xs transition-all duration-500 bg-white">
                    <div class="text-white">
                        @php
                        $profilePic = $user->profile_pic
                        ? (Str::startsWith($user->profile_pic, 'http')
                        ? $user->profile_pic
                        : asset('storage/'.$user->profile_pic))
                        : asset('imgs/def-user.webp');
                        @endphp
                        <img src="{{ $profilePic }}" alt="User Avatar" class="w-10 h-10 rounded-full object-cover">
                    </div>
                </button>
                <div id="dropdown-with-header" class="dropdown-menu hidden opacity-0 scale-95 rounded-xl shadow-lg bg-white absolute top-full right-0 min-w-52 mt-2 divide-y divide-gray-200 transition-all duration-300 ease-in-out transform" aria-labelledby="dropdown-with-header">
                    <div class="px-4 py-3 flex gap-3">
                        <div class="block">
                            <!-- Display full name and email -->
                            <div class="text-indigo-600 font-normal mb-1">{{ $user_name }}</div>
                            <div class="text-sm text-gray-500 font-medium truncate">{{ $user_email }}</div>
                        </div>
                    </div>
                    <div class="py-2">
                        <form action="{{ route('auth.logout') }}" method="POST" id="logout-form" class="inline">
                            @csrf
                            <button type="submit" class="block px-6 py-2 text-red-500 font-medium">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Mobile Menu with Animation -->
    <div id="menu" class="hidden md:hidden flex-col items-center bg-primary border-t border-gray-200 transition-all duration-300 ease-in-out max-h-0 overflow-hidden p-3">
        <div class="flex flex-col w-full">

            @if(Cookie::get('in_session'))
            <a href="{{ route('home.page') }}" class="py-2 text-white hover:bg-gray-100 w-full text-center {{ request()->routeIs('home.page') ? '!text-secondary-light font-bold' : '' }}">Home</a>
            @endif

            <a href="{{ route('services.page') }}" class="py-2 text-white hover:bg-gray-100 w-full text-center {{ request()->routeIs('services.page') ? '!text-secondary-light font-bold' : '' }}">Services</a>
            <a href="{{ route('about.page') }}" class="py-2 text-white hover:bg-gray-100 w-full text-center">About US</a>
            <a href="{{ route('contact.page') }}" class="py-2 text-white hover:bg-gray-100 w-full text-center">Contact</a>

            @unless(Cookie::get('in_session'))
            <div class="flex flex-col items-center mt-4 w-full">
                <a href="{{ route('auth.login') }}" class="bg-gray-600 text-white hover:bg-red-700 px-3 py-2 rounded-md w-11/12 text-center">Login</a>
                <a href="{{ route('auth.signup') }}" class="bg-secondary text-white hover:bg-secondary-dark px-3 py-2 rounded-md w-11/12 text-center mt-2">Sign Up</a>
            </div>
            @endunless
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.getElementById("navbar");
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');
        const dropdownToggle = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-with-header');

        // Immediately show the navbar by removing the 'hidden' class
        if (navbar) {
            navbar.classList.remove('hidden');
        }

        // Toggle menu on hamburger click
        if (menuToggle && menu) {
            menuToggle.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevent triggering document click
                toggleMenu();

                // Add or remove 'active' class to animate the hamburger icon
                menuToggle.classList.toggle('active');

                if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                    closeDropdown();
                }
            });
        }

        // Open dropdown when clicked
        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevent triggering document click
                toggleDropdown();
                if (menu && !menu.classList.contains('hidden')) {
                    closeMenu();
                }
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (event) => {
                if (
                    dropdownMenu &&
                    !dropdownMenu.contains(event.target) &&
                    !dropdownToggle.contains(event.target)
                ) {
                    closeDropdown();
                }
            });
        }

        // Close menu if clicked outside
        if (menu && menuToggle) {
            document.addEventListener('click', (event) => {
                if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
                    closeMenu();
                }
            });
        }

        // Close menu on mobile menu item click
        const menuItems = menu ? menu.querySelectorAll('a') : [];
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                closeMenu(); // Close menu when a menu item is clicked
            });
        });

        // Toggle mobile menu visibility
        function toggleMenu() {
            if (menu) {
                menu.classList.toggle('hidden');
                if (!menu.classList.contains('hidden')) {
                    menu.style.maxHeight = "500px"; // Make menu visible with animation
                } else {
                    menu.style.maxHeight = "0"; // Hide menu with animation
                }
            }
        }

        // Close mobile menu
        function closeMenu() {
            if (menu) {
                menu.classList.add('hidden');
                menu.style.maxHeight = "0";
            }

            // Remove 'active' class from hamburger icon when closing menu
            if (menuToggle) {
                menuToggle.classList.remove('active');
            }
        }

        // Toggle dropdown visibility
        function toggleDropdown() {
            if (dropdownMenu) {
                dropdownMenu.classList.toggle('hidden');
                if (!dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.style.opacity = 1;
                    dropdownMenu.style.transform = "scale(1)";
                } else {
                    dropdownMenu.style.opacity = 0;
                    dropdownMenu.style.transform = "scale(0.95)";
                }
            }
        }

        // Close dropdown
        function closeDropdown() {
            if (dropdownMenu) {
                dropdownMenu.classList.add('hidden');
                dropdownMenu.style.opacity = 0;
                dropdownMenu.style.transform = "scale(0.95)";
            }
        }

        // Navbar hide/show on scroll
        if (navbar) {
            let prevScrollPos = window.pageYOffset;

            window.addEventListener("scroll", function() {
                const currentScrollPos = window.pageYOffset;
                if (prevScrollPos > currentScrollPos) {
                    navbar.classList.remove("hidden");
                    navbar.style.transition = "top 0.3s ease-in-out";
                    navbar.style.top = "0"; // Show navbar
                } else {
                    navbar.style.transition = "top 0.3s ease-in-out";
                    navbar.style.top = "-80px"; // Hide navbar
                }
                prevScrollPos = currentScrollPos;
            });
        }
    });
</script>

<style>
    .hamburger {
        position: relative;
        width: 24px;
        height: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
    }

    .hamburger span {
        display: block;
        width: 100%;
        height: 2px;
        background-color: white;
        border-radius: 1px;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .hamburger.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }
</style>