@if (session('status'))
<div id="toast-success" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 flex items-center py-3 px-4 mb-4 border-2 border-green-500 bg-green-200 text-black shadow-lg rounded-lg opacity-100 transition-opacity duration-500">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-600 mr-2"></i> <!-- Check Icon -->
        <span>{{ session('status') }}</span>
    </div>
</div>
@endif

@if (session('error'))
<div id="toast-error" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 flex items-center py-3 px-4 mb-4 border-2 border-red-500 bg-red-200 text-black shadow-lg rounded-lg opacity-100 transition-opacity duration-500">
    <div class="flex items-center">
        <i class="fas fa-times-circle text-red-600 mr-2"></i> <!-- X Icon -->
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
            }, 4000);
        }
    }

    if (document.getElementById('toast-success')) {
        hideToast('toast-success');
    }

    if (document.getElementById('toast-error')) {
        hideToast('toast-error');
    }
</script>