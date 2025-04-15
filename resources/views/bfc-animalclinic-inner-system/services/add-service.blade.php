<!-- Add Service Modal -->
<div id="add-service" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-md max-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-2">
                    @csrf
                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm hover:text-md w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-service">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <h2 class="text-2xl text-center font-semibold mb-4">Add Appointment</h2>

                    <div>
                        <label for="service" class="block mb-2 text-sm font-medium text-gray-900">Service Name</label>
                        <input type="text" id="service" name="service" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Enter service name">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                        <input type="number" step="0.01" id="price" name="price" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Enter price">
                    </div>
                    <div>
                        <label for="capacity" class="block mb-2 text-sm font-medium text-gray-900">Capacity to Accomodate</label>
                        <input type="number" step="0.01" id="capacity" name="capacity" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Enter capacity">
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" placeholder="Enter service description"></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5 dark:bg-primary dark:hover:bg-primary-light dark:focus:ring-blue-800">Add Service</button>
                </form>
            </div>
        </div>
    </div>
</div>