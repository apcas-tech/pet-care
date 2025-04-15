@if (session('status'))
<div id="toast-success" class="fixed bottom-5 right-5 z-50 flex items-center py-3 px-4 mb-4 w-full max-w-xs text-black bg-white shadow-lg opacity-100 transition-opacity duration-500 md:top-5 md:left-1/2 md:-translate-x-1/2 md:bottom-auto">
    <div class="flex items-center">
        <span>{{ session('status') }}</span>
    </div>
</div>
@endif

@if (session('error'))
<div id="toast-error" class="fixed bottom-5 right-5 z-50 flex items-center py-3 px-4 mb-4 w-full max-w-xs text-black bg-white shadow-lg opacity-100 transition-opacity duration-500 md:top-5 md:left-1/2 md:-translate-x-1/2 md:bottom-auto">
    <div class="flex items-center">
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif


<script>
    function hideToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            setTimeout(() => {
                toast.classList.remove("opacity-100");
                toast.classList.add("opacity-0");
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 2000);
        }
    }


    if (document.getElementById('toast-success')) {
        hideToast('toast-success');
    }

    if (document.getElementById('toast-error')) {
        hideToast('toast-error');
    }
</script>