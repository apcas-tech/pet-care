<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BFC Animal Clinic') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Dark mode overrides for FullCalendar */
        .dark .fc-col-header-cell {
            background-color: #1f2937;
            /* Tailwind's 'gray-800' */
            color: white;
        }

        .dark .fc-toolbar-title {
            font-weight: bold;
            font-size: 1.25rem;
        }

        .dark .fc-col-header-cell:hover {
            background-color: #374151;
            /* Slightly lighter gray on hover */
        }
    </style>
</head>

<body x-data="{ open: true, profileOpen: false, darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', value => { 
        localStorage.setItem('theme', value ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', value);
    })"
    :class="{ 'dark': darkMode }"
    class="transition-colors duration-300 ease-in-out bg-gray-200/90 dark:bg-gray-950/95 text-black dark:text-white font-sans antialiased min-h-screen">

    <div x-data="{ open: true, profileOpen: false }" class="flex">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div :class="{ 'ml-64': open, 'ml-16': !open }"
            class="transition-all duration-300 w-full min-h-screen flex flex-col">

            <!-- Header -->
            <header class="sticky top-0 z-40 flex justify-between items-center px-6 py-4 shadow bg-white/80 dark:bg-gray-800/50 backdrop-blur">
                <div class="flex items-center space-x-4">
                    <button @click="open = !open" class="focus:outline-none">
                        <x-bx-dock-left class="w-6 h-6 text-black dark:text-white" />
                    </button>
                    <h1 class="text-lg font-bold text-black dark:text-white">BFC Animal Clinic</h1>
                </div>

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="focus:outline-none p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8.485-8.485h-1M4.515 12.515h-1m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 110 14a7 7 0 010-14z" />
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                    </svg>
                </button>
            </header>

            <!-- Page Heading -->
            @if (isset($header))
            <div class="px-6 py-4">
                {{ $header }}
            </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 px-6 py-4 text-black dark:text-white">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>