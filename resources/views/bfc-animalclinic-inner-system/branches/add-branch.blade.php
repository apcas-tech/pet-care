<!-- Add Branch Modal -->
<div id="add-branch" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-2">
            <h3 class="text-xl font-semibold text-gray-800">Add New Branch</h3>
            <button class="text-gray-600 hover:text-gray-900" data-modal-hide="add-branch">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Add Branch Form -->
        <form action="{{ route('admin.branches.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf

            <!-- Branch Name -->
            <div>
                <label for="branch_name" class="block text-sm font-medium text-gray-700">Branch Name</label>
                <input type="text" id="branch_name" name="name" class="w-full p-2 border rounded-md shadow-sm focus:ring focus:ring-primary" autocomplete="off" required>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" class="w-full p-2 border rounded-md shadow-sm focus:ring focus:ring-primary" autocomplete="off" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-light">Add Branch</button>
            </div>
        </form>
    </div>
</div>