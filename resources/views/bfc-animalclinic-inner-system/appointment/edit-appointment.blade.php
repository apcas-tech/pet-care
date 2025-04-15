<div id="edit-appointment-modal" class="hidden fixed inset-0 flex items-center justify-center bg-cyan-950 bg-opacity-70 z-50 overflow-y-auto">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="bg-white rounded-lg shadow-lg w-full p-6 relative">
            <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-appointment-modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h2 class="text-2xl text-center font-semibold mb-4">Edit Appointment</h2>

            <!-- Appointment edit form -->
            <form id="edit-appointment-form" action="{{ route('admin.appointments.update', ['appointment' => '__ID__']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hidden field to store the appointment ID -->
                <input type="hidden" id="edit-appointment-id" name="appointment_id" value="">

                <!-- Owner field (readonly or pre-selected) -->
                <div class="mb-4">
                    <label for="edit-owner" class="block text-sm font-medium text-gray-700">Owner</label>
                    <input type="text" id="edit-owner" name="owner_name" class="border border-gray-300 rounded-md w-full px-4 py-2" readonly>
                </div>

                <!-- Pet field (readonly or pre-selected) -->
                <div class="mb-4">
                    <label for="edit-pet" class="block text-sm font-medium text-gray-700">Pet</label>
                    <input type="text" id="edit-pet" name="pet_name" class="border border-gray-300 rounded-md w-full px-4 py-2" readonly>
                </div>

                <!-- Service dropdown -->
                <div class="mb-4">
                    <label for="edit-service" class="block text-sm font-medium text-gray-700">Service</label>
                    <select id="edit-service" name="service_id" class="border border-gray-300 rounded-md w-full px-4 py-2">
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->service }} - ₱{{ $service->price }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Branch dropdown -->
                <div class="mb-4">
                    <label for="edit-branch" class="block text-sm font-medium text-gray-700">Branch</label>
                    <select id="edit-branch" name="branch_id" class="border border-gray-300 rounded-md w-full px-4 py-2">
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Appointment date -->
                <div class="mb-4">
                    <label for="edit-appointment-date" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                    <input type="date" id="edit-appointment-date" name="appt_date" class="border border-gray-300 rounded-md w-full px-4 py-2">
                </div>

                <!-- Appointment time -->
                <div class="mb-4">
                    <label for="edit-appointment-time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
                    <input type="time" id="edit-appointment-time" name="appt_time" class="border border-gray-300 rounded-md w-full px-4 py-2">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="edit-status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="edit-status" name="status" class="border border-gray-300 rounded-md w-full px-4 py-2">
                        <option value="Pending">Pending</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Notes field -->
                <div class="mb-4">
                    <label for="edit-notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="edit-notes" name="notes" class="border border-gray-300 rounded-md w-full px-4 py-2"></textarea>
                </div>

                <!-- Submit button -->
                <div class="flex justify-end">
                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5 dark:bg-primary dark:hover:bg-primary-light dark:focus:ring-blue-800">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>