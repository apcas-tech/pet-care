<div id="add-vaccine-modal" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <!-- Close button -->
                <button type="button" class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm hover:text-md w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-vaccine-modal">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <h2 class="text-xl font-semibold text-gray-900 text-center mb-4">Add Vaccination</h2>

                <form method="POST" action="{{ route('vaccinations.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                    <input type="hidden" name="pet_type" value="Pet"> <!-- Add this line for regular pets -->
                    <!-- If you are dealing with adoptable pets, you can set this dynamically based on your logic -->
                    <!-- <input type="hidden" name="pet_type" value="AdoptablePet"> -->

                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium">Vaccine Name</label>
                            <select id="vaccineSelect" name="vaccine_name" class="w-full border p-2 rounded">
                                <option value="" disabled selected>Select Vaccine</option>
                                <option value="Deworming">Deworming</option>
                                <option value="DHLPPi">DHLPPi</option>
                                <option value="Anti-Rabies Vaccine">Anti-Rabies Vaccine</option>
                                <option value="Kennel Cough Vaccine">Kennel Cough Vaccine</option>
                                <option value="Tricat Vaccine">Tricat Vaccine</option>
                                <option value="4N1 Vaccine">4N1 Vaccine</option>
                                <option value="HW Preventative">HW Preventative</option>
                                <option value="Med Bath">Med Bath</option>
                                <option value="Anti Tick and Flea">Anti Tick and Flea</option>
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-sm font-medium">Custom Vaccine Name</label>
                            <input type="text" name="custom_vaccine_name" class="w-full border p-2 rounded" placeholder="Enter custom vaccine name">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Date Administered</label>
                        <input type="date" name="date_administered" class="w-full border p-2 rounded" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Next Due Date</label>
                        <input type="date" name="next_due_date" class="w-full border p-2 rounded" required>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium">Veterinarian</label>
                        <select name="administered_by" class="w-full border p-2 rounded text-black bg-white" required>
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

                    <div>
                        <label class="block text-sm font-medium">Notes</label>
                        <textarea name="notes" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" id="submit-button" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-syringe"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>