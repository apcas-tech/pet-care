<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BFC Animal Clinic Admin</title>
    @vite('resources/css/app.css') <!-- Use Vite for CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- FullCalendar Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />

    <!-- FullCalendar Script -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

</head>
<style>
    .main-content {
        background-image: url('imgs/bg_frame.webp');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100vw;
        overflow: auto;
        transition: margin-left 0.3s ease-in-out;
    }

    /* For desktop screens */
    @media (min-width: 768px) {
        .main-content {
            margin-left: 14rem;
        }
    }

    /* For mobile screens */
    @media (max-width: 767px) {
        .main-content {
            margin-left: 0;
        }
    }


    .main-content.expanded {
        margin-left: 14rem;
        /* Sidebar expanded */
    }

    .main-content.collapsed {
        margin-left: 0;
        /* Sidebar collapsed */
    }

    .fc-day-today {
        background-color: rgba(0, 88, 255, 0.17) !important;
        color: black !important;
    }

    .fc-day-today a {
        color: black !important;
    }
</style>

<body class="bg-gray-100 text-gray-900">
    <div class="flex"> <!-- Add padding-top to account for the fixed topbar -->
        <!-- Sidebar -->
        <div class="flex">
            <button id="drawerButton" class="fixed top-4 left-4 z-40 px-1 rounded-lg text-2xl focus:outline-none duration-300 ease-in">
                <i class="fa-solid fa-bars-staggered text-black"></i>
            </button>

            <x-sidebar />
        </div>

        <!-- Main Content -->
        <div class="main-content ml-56 flex-1">
            <x-alert />
            <x-alert-dialog />
            <div class="pl-14 pr-6 pt-10">
                <input type="hidden" id="scannedAppointmentId" name="scannedAppointmentId" autocomplete="off">

                @yield('content')
                @include('bfc-animalclinic-inner-system.users.change-pass')
            </div>
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a stored message in localStorage
            const toastMessage = localStorage.getItem("toastMessage");
            const toastType = localStorage.getItem("toastType");

            if (toastMessage) {
                showToast(toastMessage, toastType);
                localStorage.removeItem("toastMessage"); // Remove after showing
                localStorage.removeItem("toastType");
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const qrInput = document.getElementById('scannedAppointmentId');
            qrInput.focus(); // Auto-focus on input field

            let scanBuffer = "";
            let scanTimeout = null;
            let clearInputTimeout = null; // Timeout to clear input after 2 seconds

            document.addEventListener('keydown', function(event) {
                if (event.key.length === 1) {
                    scanBuffer += event.key;
                }

                if (event.key === "Enter") {
                    event.preventDefault();

                    // Validate that input is exactly 16 characters
                    if (scanBuffer.length === 16) {
                        qrInput.value = scanBuffer; // Store the scanned value
                        sendToController(scanBuffer); // Send to backend
                    } else {
                        showToast("Invalid QR Code. Must be exactly 16 characters.", "error");
                        qrInput.value = ""; // Clear input immediately if invalid
                    }

                    scanBuffer = ""; // Clear buffer regardless
                }

                // Reset buffer if human typing is detected
                if (scanTimeout) clearTimeout(scanTimeout);
                scanTimeout = setTimeout(() => {
                    scanBuffer = "";
                }, 100); // Scanner inputs instantly; humans take longer

                // Clear input after 2 seconds if it contains text
                if (clearInputTimeout) clearTimeout(clearInputTimeout);
                clearInputTimeout = setTimeout(() => {
                    if (qrInput.value.length > 0) {
                        qrInput.value = "";
                        qrInput.focus();
                    }
                }, 2000); // Clears after 2 seconds
            });

            function sendToController(appointmentId) {
                fetch(`appointments/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.setItem("toastMessage", data.message);
                            localStorage.setItem("toastType", "success");
                            window.location.reload(); // Reload page to show toast
                        } else {
                            showToast(data.message, "error");
                            qrInput.value = ""; // Clear input if error occurs
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast("An error occurred while updating the appointment.", "error");
                        qrInput.value = ""; // Clear input on failure
                    });
            }
        });

        function showToast(message, type = "success") {
            const toastContainer = document.createElement("div");
            toastContainer.className = `fixed top-5 left-1/2 transform -translate-x-1/2 z-50 flex items-center py-3 px-4 mb-4 border-2 shadow-lg rounded-lg opacity-100 transition-opacity duration-500`;

            if (type === "error") {
                toastContainer.id = "toast-error";
                toastContainer.classList.add("border-red-500", "bg-red-200", "text-black");
                toastContainer.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-times-circle text-red-600 mr-2"></i>
                <span>${message}</span>
            </div>`;
            } else {
                toastContainer.id = "toast-success";
                toastContainer.classList.add("border-green-500", "bg-green-200", "text-black");
                toastContainer.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span>${message}</span>
            </div>`;
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