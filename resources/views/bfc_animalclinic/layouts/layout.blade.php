<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BFC Animal Clinic Mobile</title>
    @vite('resources/css/app.css') <!-- Use Vite for CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<style>
    /* Default background for mobile-main-content */
    .mobile-main-content {
        background-image: url('imgs/Mobile.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        flex: 1;
        overflow-y: auto;
    }

    /* Apply bg_frame.webp at screen width 768px or above */
    @media screen and (min-width: 768px) {
        .mobile-main-content {
            background-image: url('imgs/bg_frame.webp');
            background-size: cover;
            /* Adjust background size as needed */
            background-position: center;
            background-repeat: repeat-y;
            /* Repeat vertically */
            flex: 1;
            overflow-y: auto;
        }
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
        scrollbar-width: none;
        /* Firefox */
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
        /* WebKit-based browsers (Chrome, Safari, etc.) */
    }

    .skeleton {
        background-color: #e0e0e0;
        animation: pulse 1.5s infinite ease-in-out;
    }

    @keyframes pulse {
        0% {
            background-color: #e0e0e0;
        }

        50% {
            background-color: #c0c0c0;
        }

        100% {
            background-color: #e0e0e0;
        }
    }

    .time-slot:disabled {
        background-color: #d1d5db45;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .time-slot:disabled:hover {
        background-color: #d1d5db;
    }
</style>

<body class="text-gray-900 bg-[#fff7ec] dark:bg-[#1a202c] dark:text-white flex flex-col h-screen w-full">
    <div class="flex flex-col flex-1">
        <div class="bg-white shadow-md fixed top-0 left-0 w-full z-50 dark:bg-gray-800">
            <x-navbar :isAuthenticated="auth()->check()" />
        </div>
        <x-toast />
        <x-alert-dialog /> <!-- Include the alert dialog component here -->
        <div class="mobile-main-content flex flex-grow basis-52 flex-col overflow-y-auto mt-14 pb-6 md:mt-16 md:py-2 overflow-hidden no-scrollbar">
            @yield('content')
        </div>
    </div>

    <div id="contact">
        @include('components.footer')
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-primary-light text-white p-4 w-14 h-14 rounded-full shadow-lg hover:bg-primary-dark transition-all duration-300 ease-in-out transform scale-90 hover:scale-100 focus:outline-none z-20" style="display: none;">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        // Scroll to top when the page is loaded
        window.onload = function() {
            window.scrollTo(0, 0);
        };

        // Also scroll to top on back/forward navigation
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual'; // Disable the default behavior
        }

        // Scroll to top on back/forward navigation (when history.scrollRestoration is not supported)
        window.addEventListener('popstate', function() {
            window.scrollTo(0, 0);
        });

        // Back to top button functionality
        const backToTopButton = document.getElementById('back-to-top');

        // Show the button when scrolling down 100px from the top
        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        };

        // When the button is clicked, scroll to the top of the page
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        function showToast(message, type) {
            const toastContainer = document.createElement("div");
            toastContainer.className = `fixed bottom-5 right-5 z-50 flex items-center py-3 px-4 mb-4 w-full max-w-xs text-black bg-white shadow-lg opacity-100 transition-opacity duration-500`;

            if (type === "error") {
                toastContainer.id = "toast-error";
                toastContainer.innerHTML = `<div class="flex items-center"><span>${message}</span></div>`;
            } else {
                toastContainer.id = "toast-success";
                toastContainer.innerHTML = `<div class="flex items-center"><span>${message}</span></div>`;
            }

            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.classList.remove("opacity-100");
                toastContainer.classList.add("opacity-0");
                setTimeout(() => {
                    toastContainer.remove();
                }, 500);
            }, 4000);
        }
    </script>
</body>

</html>