<!-- Add Pet Owner Modal -->
<div id="add-pet-owner" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-3xl">
        <div class="relative bg-white rounded-lg shadow-lg p-6">
            <!-- Close Button -->
            <button type="button" class="absolute top-5 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center" data-modal-hide="add-pet-owner">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <!-- Modal Header -->
            <h2 class="text-2xl font-semibold text-center mb-4">Add Pet Owner</h2>

            <!-- Form -->
            <form id="addPetOwnerForm" method="POST" action="{{ route('admin.pet-owners.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div>
                        <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="fname" name="fname" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                    <!-- Middle Name -->
                    <div>
                        <label for="mname" class="block text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" id="mname" name="mname" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                    <!-- Last Name -->
                    <div>
                        <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="lname" name="lname" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <div class="flex items-center">
                            <span class="px-3 py-2.5 bg-gray-200 text-gray-700 border border-gray-300 rounded-l-lg">+63</span>
                            <input type="tel" id="phone" name="phone" required class="w-full p-2.5 border border-gray-300 rounded-r-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <!-- House No./Street -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">House No./Street</label>
                        <input type="text" id="address" name="address" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                    <!-- Barangay -->
                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                        <input type="text" id="barangay" name="barangay" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                    <!-- Municipality -->
                    <div>
                        <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality</label>
                        <input type="text" id="municipality" name="municipality" required class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 capitalize">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400" data-modal-hide="add-pet-owner">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Pet Owner</button>
                </div>
            </form>
        </div>
    </div>
</div>