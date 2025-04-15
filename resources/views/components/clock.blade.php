<!-- Delete Appointment Modal -->
<div id="delete-appointment-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-cyan-950 bg-opacity-70">
    <div class="bg-white rounded-lg p-6 shadow-lg w-96">
        <h3 class="text-lg font-bold text-center">Confirm Deletion</h3>
        <p class="mt-2 text-center">Are you sure you want to delete this appointment?</p>
        <div class="mt-4 flex justify-center">
            <form method="POST" action="">
                @csrf
                @method('DELETE')
                <button id="confirm-delete" class="bg-red-600 hover:bg-red-700 text-white rounded-md px-4 py-2">Delete</button>
            </form>
            <button id="cancel-delete" class="ml-2 bg-gray-300 hover:bg-gray-800 text-gray-700 hover:text-white rounded-md px-4 py-2" data-modal-hide="delete-appointment-modal">Cancel</button>
        </div>
    </div>
</div>

<!-- Digital Clock Component -->
<div class="w-auto h-full p-6 bg-white rounded-lg shadow-lg flex-none">
    <div class="w-auto p-6">
        <div class="text-center mb-6">
            <div id="digitalClock" class="text-4xl font-bold">
                <span id="hours" class="text-gray-900"></span>:<span id="minutes" class="text-gray-900"></span>:<span id="seconds" class="text-gray-900"></span>
            </div>
        </div>
        <div class="text-center">
            <button id="backupBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Back Up</button>
        </div>
    </div>
</div>

<!-- Backup Modal -->
<div id="backupModal" class="fixed inset-0 flex items-center justify-center bg-cyan-950 bg-opacity-70 hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4 text-center">Select Tables to Backup</h2>
        <form id="backupForm" action="{{ route('admin.backup') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-3 mb-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="appointments" class="form-checkbox text-blue-600">
                    <span>Appointments</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="pets" class="form-checkbox text-blue-600">
                    <span>Pets</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="pet_owners" class="form-checkbox text-blue-600">
                    <span>Pet Owners</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="adoptable_pets" class="form-checkbox text-blue-600">
                    <span>Pet Listings</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="services" class="form-checkbox text-blue-600">
                    <span>Services</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="admin_users" class="form-checkbox text-blue-600">
                    <span>Users</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="prescriptions" class="form-checkbox text-blue-600">
                    <span>Health Records</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="vaccinations" class="form-checkbox text-blue-600">
                    <span>Vaccinations</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="tables[]" value="vet_contacts" class="form-checkbox text-blue-600">
                    <span>Branches</span>
                </label>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeBModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2 hover:bg-blue-600 transition">Download</button>
            </div>
        </form>
    </div>
</div>