<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-6 right-6 flex flex-col-reverse gap-2 max-h-[250px] overflow-visible group transition-all z-50">
    <!-- Toasts will be injected here -->
</div>

<!-- Toast Styles -->
<style>
    #toast-container {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        display: flex;
        flex-direction: column-reverse;
        gap: 0.5rem;
        max-height: 250px;
        overflow: visible;
        transition: all 0.3s ease;
        z-index: 50;
        width: auto;
    }

    #toast-container>.toast-wrapper {
        transition: all 0.3s ease;
        margin-top: -45px;
        opacity: 0;
        transform: translateY(10px);
        z-index: 10;
        width: 400px;
    }

    #toast-container>.toast-wrapper:nth-child(1) {
        animation: toast-enter 0.6s forwards;
        width: 400px;
    }

    #toast-container>.toast-wrapper:nth-child(2) {
        animation: toast-enter 0.8s forwards;
        z-index: 9;
        width: 370px;
        margin-left: auto;
        margin-right: auto;
    }

    #toast-container>.toast-wrapper:nth-child(3) {
        animation: toast-enter 1s forwards;
        z-index: 8;
        width: 340px;
        margin-left: auto;
        margin-right: auto;
    }

    #toast-container>.toast-wrapper:nth-child(n+4) {
        display: none;
    }

    #toast-container:hover>.toast-wrapper {
        margin-top: 0px;
        width: 400px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    @keyframes toast-enter {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes toast-exit {
        0% {
            opacity: 1;
            transform: translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateY(10px);
        }
    }

    /* ✅ Responsive styles for mobile */
    @media (max-width: 640px) {
        #toast-container {
            bottom: 1rem;
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            width: 100%;
            max-width: 90%;
            align-items: center;
        }

        #toast-container>.toast-wrapper {
            width: 100% !important;
            max-width: 100%;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #toast-container>.toast-wrapper:nth-child(1) {
            width: 100% !important;
            z-index: 10;
        }

        #toast-container>.toast-wrapper:nth-child(2) {
            width: 95% !important;
            z-index: 9;
        }

        #toast-container>.toast-wrapper:nth-child(3) {
            width: 90% !important;
            z-index: 8;
        }

        #toast-container.clicked>.toast-wrapper {
            margin-top: 0px;
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
</style>


<!-- Toast Script -->
<script>
    function showToast(type = 'info', message) {
        const toastContainer = document.getElementById("toast-container");

        if (window.matchMedia("(max-width: 640px)").matches) {
            toastContainer.addEventListener('click', (e) => {
                toastContainer.classList.toggle('clicked');
                e.stopPropagation();
            });

            document.addEventListener('click', (e) => {
                if (!toastContainer.contains(e.target)) {
                    toastContainer.classList.remove('clicked');
                }
            });
        }

        // Define styles and icons per type
        const types = {
            success: {
                border: 'border-green-500',
                icon: `<x-clarity-success-standard-solid class="w-5 h-5 text-green-600" />`
            },
            error: {
                border: 'border-red-500',
                icon: `<x-clarity-error-standard-solid class="w-5 h-5 text-red-600" />`
            },
            info: {
                border: 'border-blue-500',
                icon: `<x-clarity-info-standard-solid class="w-5 h-5 text-blue-600" />`
            }
        };

        const {
            border,
            icon
        } = types[type] || types.info;

        // Create toast element
        const toast = document.createElement("div");
        toast.className = `
            toast-wrapper
            flex items-center w-full max-w-md p-4 space-x-4 text-sm text-gray-800 bg-gray-200 border rounded-lg shadow ${border}
        `.trim();

        toast.innerHTML = `
            ${icon}
            <div class="text-sm font-medium">${message}</div>
        `;

        // Prepend toast
        toastContainer.prepend(toast);

        // Exit animation
        setTimeout(() => {
            toast.style.animation = 'toast-exit 0.5s forwards';
        }, 4500);

        // Keep only top 3 visible
        const toasts = toastContainer.querySelectorAll(".toast-wrapper");
        if (toasts.length > 3) {
            toasts[toasts.length - 1].remove();
        }

        // Auto-remove
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
</script>