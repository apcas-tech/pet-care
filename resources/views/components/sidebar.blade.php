<!-- Sidebar -->
<aside :class="{ 'w-64': open, 'w-16': !open }"
    class="transition-all duration-300 bg-white dark:bg-gray-800 shadow h-screen fixed z-50 flex flex-col">

    <!-- Sidebar Logo Only -->
    <div class="flex items-center justify-center p-4 border-b dark:border-gray-800">
        <img src="{{ asset('imgs/logo.webp') }}" alt="Clinic Logo" class="min-h-10 min-w-10 h-20 w-20 object-contain">
    </div>

    <!-- Nav Links Container -->
    <div class="flex-grow mt-4 relative">
        <nav class="space-y-2">
            <a href="#"
                class="group relative flex items-center px-4 py-2 text-black/90 dark:text-white/90 hover:bg-gray-100 dark:hover:bg-gray-900"
                :class="{ 'font-bold text-blue-600 dark:text-blue-400': window.location.pathname === '/admin/dashboard' }">

                <!-- Icon -->
                <x-carbon-dashboard class="w-5 h-5 mr-2 text-black dark:text-white" />

                <!-- Label (visible only when sidebar is open) -->
                <span x-show="open" x-cloak>Dashboard</span>

                <span x-show="!open"
                    x-transition
                    class="absolute z-50 left-full top-1/2 -ml-2 -translate-y-1/2 whitespace-nowrap rounded bg-gray-900 dark:bg-white px-2 py-1 text-sm text-white/90 dark:text-black/90 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-200">
                    Dashboard
                </span>
            </a>
            <a href="#"
                class="group relative flex items-center px-4 py-2 text-black/90 dark:text-white/90 hover:bg-gray-100 dark:hover:bg-gray-900"
                :class="{ 'font-bold text-blue-600 dark:text-blue-400': window.location.pathname === '/admin/appointments' }">

                <x-iconsax-bro-calendar-2 class="w-5 h-5 mr-2 text-black dark:text-white" />
                <span x-show="open" x-cloak>Appointments</span>

                <span x-show="!open"
                    x-transition
                    class="absolute z-50 left-full top-1/2 -ml-2 -translate-y-1/2 whitespace-nowrap rounded bg-gray-900 dark:bg-white px-2 py-1 text-sm text-white/90 dark:text-black/90 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-200">
                    Appointments
                </span>
            </a>
        </nav>
    </div>

    <!-- User Dropdown at Bottom -->
    <div class="relative p-4 border-t dark:border-gray-700">
        <button @click="profileOpen = !profileOpen"
            class="flex items-center w-full p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none"
            :class="{ 'justify-center': !open }">
            <img class="min-w-10 min-h-10 w-10 h-10 rounded-full object-cover border" src="{{ asset('images/user.png') }}" alt="User ">
            <div x-show="open" class="ml-3 text-left">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Admin</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">admin@email.com</p>
            </div>
            <svg x-show="open" class="w-4 h-4 ml-auto text-gray-500 dark:text-gray-400"
                fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0  =" 1.06.02L10 11.586l3.71-4.356a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="profileOpen" @click.outside="profileOpen = false"
            class="absolute bottom-16 left-4 z-50 w-56 bg-white dark:bg-gray-900 rounded-md shadow-lg border dark:border-gray-700"
            x-transition>
            <ul class="py-1 text-sm text-black/90 dark:text-gray-200">
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a></li>
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a></li>
            </ul>
            <div class="border-t border-gray-200 dark:border-gray-600">
                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-red-400">Logout</a>
            </div>
        </div>
    </div>
</aside>