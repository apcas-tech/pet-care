<div id="flowbite-alert-overlay" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40"></div>

<div id="flowbite-alert" class="hidden fixed inset-x-0 z-50 w-full max-w-md mx-auto px-4">
    <div id="flowbite-alert-content"
        class="flex items-center p-4 text-sm rounded-lg shadow-lg transition-all duration-300"
        role="alert">

        <!-- Icon container -->
        <div id="flowbite-alert-icon" class="shrink-0 w-4 h-4 mr-2">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
        </div>

        <!-- Alert message -->
        <div id="flowbite-alert-message" class="text-sm font-medium"></div>

        <!-- Close button -->
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 justify-center items-center text-sm"
            aria-label="Close" onclick="dismissAlert()">
            <x-fas-xmark class="w-5 h-5" />
        </button>
    </div>
</div>

<script>
    function showAlert(type, message) {
        const alertBox = document.getElementById('flowbite-alert');
        const alertOverlay = document.getElementById('flowbite-alert-overlay');
        const alertContent = document.getElementById('flowbite-alert-content');
        const alertIcon = document.getElementById('flowbite-alert-icon');
        const alertMessage = document.getElementById('flowbite-alert-message');

        // Reset classes
        alertContent.className = "flex items-center p-4 text-sm rounded-lg shadow-lg transition-all duration-300";

        // Set message
        alertMessage.textContent = message;

        // Set icon and styles based on type
        switch (type) {
            case 'success':
                alertContent.classList.add('text-green-800', 'bg-green-50', 'dark:bg-gray-800', 'dark:text-green-400');
                alertIcon.innerHTML = `<x-clarity-success-standard-solid />`;
                break;
            case 'error':
                alertContent.classList.add('text-red-800', 'bg-red-50', 'dark:bg-gray-800', 'dark:text-red-400');
                alertIcon.innerHTML = `<x-clarity-error-standard-solid />`;
                break;
            case 'info':
            default:
                alertContent.classList.add('text-blue-800', 'bg-blue-50', 'dark:bg-gray-800', 'dark:text-blue-400');
                alertIcon.innerHTML = `<x-clarity-info-standard-solid />`;
                break;
        }

        // Show overlay and alert box
        alertOverlay.classList.remove('hidden');
        alertBox.classList.remove('hidden');
        alertBox.classList.add('block');
    }

    function dismissAlert() {
        const alertBox = document.getElementById('flowbite-alert');
        const alertOverlay = document.getElementById('flowbite-alert-overlay');
        alertBox.classList.add('hidden');
        alertBox.classList.remove('block');
        alertOverlay.classList.add('hidden');
    }
</script>

<style>
    /* Position alert at the bottom for small screens */
    #flowbite-alert {
        bottom: 26px;
        top: auto;
    }

    /* For medium screens and above, position it at the top */
    @media (min-width: 768px) {
        #flowbite-alert {
            top: 2rem;
            bottom: auto;
        }
    }
</style>