<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BFC Animal Clinic</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<style>
    .no-scrollbar {
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
        scrollbar-width: none;
        /* Firefox */
        overflow-x: hidden;
        /* Prevent horizontal scroll */
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
        /* WebKit-based browsers (Chrome, Safari, etc.) */
    }

    .checkbox-wrapper-10 .tgl {
        display: none;
    }

    .checkbox-wrapper-10 .tgl,
    .checkbox-wrapper-10 .tgl:after,
    .checkbox-wrapper-10 .tgl:before,
    .checkbox-wrapper-10 .tgl * {
        box-sizing: border-box;
    }

    .checkbox-wrapper-10 .tgl+.tgl-btn {
        outline: 0;
        display: block;
        width: 4em;
        height: 2em;
        position: relative;
        cursor: pointer;
    }

    .checkbox-wrapper-10 .tgl-flip+.tgl-btn {
        padding: 2px;
        transition: all 0.2s ease;
        font-family: sans-serif;
        perspective: 100px;
    }

    .checkbox-wrapper-10 .tgl-flip+.tgl-btn:after,
    .checkbox-wrapper-10 .tgl-flip+.tgl-btn:before {
        display: inline-block;
        transition: all 0.4s ease;
        width: 100%;
        text-align: center;
        position: absolute;
        line-height: 2em;
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 0;
        left: 0;
        backface-visibility: hidden;
        border-radius: 4px;
    }

    .checkbox-wrapper-10 .tgl-flip+.tgl-btn:after {
        content: attr(data-tg-on);
        background: #02C66F;
        transform: rotateY(-180deg);
    }

    .checkbox-wrapper-10 .tgl-flip+.tgl-btn:before {
        background: #FF3A19;
        content: attr(data-tg-off);
    }

    .checkbox-wrapper-10 .tgl-flip:checked+.tgl-btn:before {
        transform: rotateY(180deg);
    }

    .checkbox-wrapper-10 .tgl-flip:checked+.tgl-btn:after {
        transform: rotateY(0);
        left: 0;
        background: #7FC6A6;
    }
</style>

<body>
    @yield('content')
    @vite('resources/js/app.js')
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/zoomies.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/tailChase.js"></script>
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