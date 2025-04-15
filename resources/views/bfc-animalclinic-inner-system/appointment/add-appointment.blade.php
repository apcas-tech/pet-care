<!-- Appointment Modal -->
<div id="add-appointment" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-2">
                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm hover:text-md w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-appointment">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <h3 class="text-xl text-center font-semibold text-gray-900">Add New Appointment</h3>

                    @csrf
                    <input type="hidden" id="owner_id" name="owner_id" value="">
                    <input type="hidden" id="pet_id" name="pet_id" value="">
                    <div>
                        <label for="owner" class="block mb-2 text-sm font-medium text-gray-900">Owner</label>
                        <input type="text" id="owner" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Type owner name" autocomplete="off" required>
                        <div id="owner-suggestions" class="text-gray-400 border-gray-300 rounded-md mt-2 max-h-40 overflow-y-auto"></div>
                    </div>
                    <div>
                        <label for="pet" class="block mb-2 text-sm font-medium text-gray-900">Pet</label>
                        <input type="text" id="pet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Type pet name" autocomplete="off" required>
                        <div id="pet-suggestions" class="text-gray-400 border-gray-300 rounded-md mt-2 max-h-40 overflow-y-auto"></div>
                    </div>
                    <div>
                        <label for="service" class="block mb-2 text-sm font-medium text-gray-900">Service</label>
                        <select id="service" name="service_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                            <option value="" disabled selected>Select a Service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->service }} - ₱{{ $service->price }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch" class="block mb-2 text-sm font-medium text-gray-900">Branch</label>
                        <select id="branch" name="branch_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                            <option value="" disabled selected>Select a Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="appt_date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                        <input type="date" id="appt_date" name="appt_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="appt_time" class="block mb-2 text-sm font-medium text-gray-900">Time</label>
                        <input type="time" id="appt_time" name="appt_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                            <option value="Pending">Pending</option>
                            <option value="Scheduled">Scheduled</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Notes</label>
                        <textarea id="notes" name="notes" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Add any additional notes..."></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5 dark:bg-primary dark:hover:bg-primary-light dark:focus:ring-blue-800">Add Appointment</button>
                </form>
            </div>
        </div>
    </div>
</div>