<!-- delete-service.blade.php -->
<div id="delete-service" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-cyan-950 bg-opacity-70">
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h3 class="text-lg font-bold">Confirm Deletion</h3>
        <p class="mt-2">Are you sure you want to delete this service?</p>
        <div class="mt-4 flex justify-end">
            <form method="POST" action="">
                @csrf
                @method('DELETE')
                <button id="confirm-delete-service" class="bg-secondary hover:bg-secondary-light text-white rounded-md px-4 py-2">Delete</button>
            </form>
            <button id="cancel-delete-service" class="ml-2 bg-gray-300 hover:bg-gray-800 text-gray-700 hover:text-white rounded-md px-4 py-2" data-modal-hide="delete-service-modal">Cancel</button>
        </div>
    </div>
</div>