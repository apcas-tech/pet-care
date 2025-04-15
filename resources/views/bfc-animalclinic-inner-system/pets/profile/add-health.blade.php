<div id="add-health" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form method="POST" action="{{ route('health.store') }}" class="space-y-2">
                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm hover:text-md w-8 h-8" data-modal-hide="add-health">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <h3 class="text-xl text-center font-semibold text-gray-900">Add Health Record</h3>

                    @csrf
                    <div>
                        <input type="hidden" name="pet_id" id="pet_id" value="{{ $pet->id }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <input type="hidden" name="pet_type" value="Pet">
                    </div>

                    <div>
                        <label for="record_date" class="block mb-2 text-sm font-medium text-gray-900">Record Date</label>
                        <input type="date" name="record_date" id="record_date" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">History/Complaints/Request</label>
                        <textarea name="description" id="description" rows="3" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter description of the health record"></textarea>
                    </div>

                    <div>
                        <label for="tx_given" class="block mb-2 text-sm font-medium text-gray-900">Tx Given</label>
                        <input type="text" name="tx_given" id="tx_given" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter Treatment Given" required>
                    </div>

                    <!-- Prescription Section -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Prescription (Rx Given)</label>
                        <div id="prescription-container">
                            <div class="prescription-item flex space-x-2 mb-2">
                                <input type="text" name="medication[]" placeholder="Medication Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5" required>
                                <input type="text" name="dosage[]" placeholder="Dosage (e.g., 250mg)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5" required>
                                <input type="text" name="frequency[]" placeholder="Frequency (e.g., 2x/day)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5" required>
                                <input type="text" name="duration[]" placeholder="Duration (e.g., 7 days)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5" required>
                                <button type="button" class="remove-prescription text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="add-prescription" class="text-blue-600 hover:text-blue-800 text-sm mt-2">
                            <i class="fa-solid fa-plus"></i> Add Another Prescription
                        </button>

                        <div class="relative">
                            <label class="block text-sm font-medium">Veterinarian</label>
                            <select name="vet_id" class="w-full border p-2 rounded text-black bg-white" required>
                                <option value="" disabled selected>Select Veterinarian</option>
                                @foreach($veterinarians as $vet)
                                <option value="{{ $vet->id }}">
                                    {{ $vet->Fname }}
                                    @if(!empty($vet->Mname))
                                    {{ strtoupper(substr($vet->Mname, 0, 1)) }}.
                                    @endif
                                    {{ $vet->Lname }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5">Add Record</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const prescriptionContainer = document.getElementById("prescription-container");
        const addPrescriptionBtn = document.getElementById("add-prescription");

        addPrescriptionBtn.addEventListener("click", function() {
            const newPrescription = document.createElement("div");
            newPrescription.classList.add("prescription-item", "flex", "space-x-2", "mb-2");

            newPrescription.innerHTML = `
            <input type="text" name="medication[]" placeholder="Medication Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5">
            <input type="text" name="dosage[]" placeholder="Dosage (e.g., 250mg)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5">
            <input type="text" name="frequency[]" placeholder="Frequency (e.g., 2x/day)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5">
            <input type="text" name="duration[]" placeholder="Duration (e.g., 7 days)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5">
            <button type="button" class="remove-prescription text-red-500 hover:text-red-700">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;

            prescriptionContainer.appendChild(newPrescription);

            // Attach remove event
            newPrescription.querySelector(".remove-prescription").addEventListener("click", function() {
                newPrescription.remove();
            });
        });

        // Remove prescription item when clicking the trash icon
        prescriptionContainer.addEventListener("click", function(event) {
            if (event.target.closest(".remove-prescription")) {
                event.target.closest(".prescription-item").remove();
            }
        });
    });
</script>