<div id="sidebar" class="h-screen flex flex-col bg-white text-primary w-64 fixed left-0 top-0 z-50 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
    <button id="toggleSidebar" class="absolute top-4 right-4 z-40 text-2xl md:hidden focus:outline-none">
        <i class="fas fa-xmark text-black"></i>
    </button>

    <!-- Logo Section -->
    <div class="flex items-center justify-center py-4">
        <img src="{{ asset('imgs/logo.webp') }}" alt="Logo" class="h-36 w-auto">
    </div>

    <!-- Divider -->
    <hr class="border-t border-gray-300">

    <!-- Sidebar Content -->
    <div class="flex flex-col flex-grow overflow-y-auto">
        <!-- Top Menu Items -->
        <ul class="mt-4 space-y-2">
            <!-- Dashboard -->
            <li class="{{ request()->routeIs('admin.dashboard') ? 'bg-secondary text-white font-bold relative' : '' }} p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Appointments -->
            @if(in_array('Appointments', $admin_pages))
            <li class="{{ request()->routeIs('admin.appointments') ? 'bg-secondary text-white font-bold relative' : '' }} p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold">
                <a href="{{ route('admin.appointments') }}" class="flex items-center space-x-2">
                    <i class="fas fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>
            @endif

            <!-- Services -->
            @if(in_array('Services', $admin_pages))
            <li class="{{ request()->routeIs('admin.services') ? 'bg-secondary text-white font-bold relative' : '' }} p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold">
                <a href="{{ route('admin.services') }}" class="flex items-center space-x-2">
                    <i class="fas fa-stethoscope"></i>
                    <span>Services</span>
                </a>
            </li>
            @endif

            <!-- Pets Dropdown -->
            @if(in_array('Pets', $admin_pages) || in_array('Pet Owners', $admin_pages) || in_array('Pet Adoption', $admin_pages))
            <li class="relative">
                <div class="p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold flex items-center justify-between cursor-pointer" onclick="toggleDropdown()">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-cat"></i><i class="fa-solid fa-dog fa-flip-horizontal"></i>
                        <span>Pets</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <!-- Dropdown Submenu -->
                <ul id="petsDropdown" class="hidden mt-2 space-y-2 ml-4">
                    @if(in_array('Pets', $admin_pages))
                    <li class="{{ request()->routeIs('admin.pets') ? 'bg-secondary text-white font-bold relative' : '' }} p-2 rounded hover:bg-secondary hover:text-white">
                        <a href="{{ route('admin.pets') }}" class="flex items-center space-x-2">
                            <i class="fa-solid fa-paw fa-rotate-by" style="--fa-rotate-angle: 40deg;"></i>
                            <span>Pets</span>
                        </a>
                    </li>
                    @endif

                    @if(in_array('Pet Owners', $admin_pages))
                    <li class="{{ request()->routeIs('admin.pet_owners') ? 'bg-secondary text-white font-bold relative' : '' }} p-2 rounded hover:bg-secondary hover:text-white">
                        <a href="{{ route('admin.pet_owners') }}" class="flex items-center space-x-2">
                            <i class="fa-solid fa-user"></i>
                            <span>Pet Owners</span>
                        </a>
                    </li>
                    @endif

                    @if(in_array('Pet Adoption Listings', $admin_pages))
                    <li class="{{ request()->routeIs('admin.pet-listings') ? 'bg-secondary text-white font-bold relative' : '' }} p-2 rounded hover:bg-secondary hover:text-white">
                        <a href="{{ route('admin.pet-listings')}}" class="flex items-center space-x-2">
                            <div class="flex items-center space-x-2">
                                <div class="relative inline-block">
                                    <i class="fa-regular fa-heart fa-rotate-by text-secondary-light absolute top-0 left-0"
                                        style="--fa-rotate-angle: 30deg; transform: translateX(4px);"></i>
                                    <i class="fa-regular fa-heart fa-rotate-by text-primary-light relative"
                                        style="--fa-rotate-angle: -30deg; transform: translateX(-4px);"></i>
                                </div>
                                <span>Pet Adoption</span>
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif


            <!-- Users -->
            @if(in_array('Users', $admin_pages))
            <li class="{{ request()->routeIs('admin.users') ? 'bg-secondary text-white font-bold relative' : '' }} p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold">
                <a href="{{ route('admin.users') }}" class="flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>Users</span>
                </a>
            </li>
            @endif

            <!-- Branches -->
            @if(in_array('Branch', $admin_pages))
            <li class="{{ request()->routeIs('admin.branches') ? 'bg-secondary text-white font-bold relative' : '' }} p-4 rounded hover:bg-secondary hover:text-white hover:font-semibold">
                <a href="{{ route('admin.branches') }}" class="flex items-center space-x-2">
                    <i class="fa-solid fa-shop"></i>
                    <span>Branches</span>
                </a>
            </li>
            @endif
        </ul>
    </div>

    <!-- Divider -->
    <hr class="border-t border-gray-300 mt-4">

    <!-- Bottom Menu Items -->
    <ul>
        <!-- User Account Dropdown -->
        <li class="relative">
            <div class="p-4 hover:bg-secondary hover:text-white hover:font-semibold flex items-center justify-between cursor-pointer" onclick="toggleAccountDropdown()">
                <div class="flex items-center space-x-2">
                    <img src="{{ $admin_profile_pic }}" alt="Profile Picture" class="w-8 h-8 rounded-full object-cover">
                    <span>{{ $admin_name }}</span>
                </div>
                <div class="flex flex-col">
                    <i class="fas fa-chevron-up text-xs"></i>
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>

            <!-- Account Dropdown Menu -->
            <ul id="accountDropdown" class="hidden absolute right-0 top-[-90px] mt-2 bg-gray-800 border border-gray-900 shadow-lg w-48 rounded-lg p-1">
                <li class="p-2 rounded hover:bg-secondary text-white">
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 w-full text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
                <li class="p-2 rounded hover:bg-secondary text-white">
                    <button type="#" class="flex items-center space-x-2 w-full text-left" id="change-password-button" data-modal-toggle="change-password-modal">
                        <i class="fa-solid fa-key fa-flip-horizontal"></i>
                        <span>Change Password</span>
                    </button>
                </li>
                <hr class="border-t border-gray-300 my-1">
                <li class="p-2 text-white text-sm">
                    <span>{{ $admin_email }}</span> <!-- Replace with dynamic email -->
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    function toggleAccountDropdown() {
        document.getElementById('accountDropdown').classList.toggle('hidden');
    }

    function toggleDropdown() {
        document.getElementById('petsDropdown').classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        const accountDropdown = document.getElementById('accountDropdown');
        const accountButton = document.querySelector('[onclick="toggleAccountDropdown()"]');
        if (!accountButton.contains(e.target) && !accountDropdown.contains(e.target)) {
            accountDropdown.classList.add('hidden');
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const openModalBtn = document.querySelector("#change-password-button"); // Change Password Button
        const modal = document.getElementById("change-password-modal");
        const closeModalBtn = modal.querySelector("[data-modal-hide]");

        // Open Modal
        openModalBtn.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        // Close Modal when clicking the X button
        closeModalBtn.addEventListener("click", function() {
            modal.classList.add("hidden");
        });

        // Close Modal when clicking outside of it
        window.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.classList.add("hidden");
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const openButton = document.getElementById('drawerButton');
        const closeButton = document.getElementById('toggleSidebar');

        openButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });

        closeButton.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
        });

        // Close sidebar when clicking outside
        window.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !openButton.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>