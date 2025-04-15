<!-- Add Pet Modal -->
<div id="add-pet-adoption" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form action="{{ route('admin.pet-listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-2">

                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm hover:text-md w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-pet-adoption">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <h3 class="text-xl text-center font-semibold text-gray-900">Add New Adoption Pet</h3>

                    @csrf
                    <div class="mb-8 flex flex-col items-center">
                        <label for="profile_pic" class="block font-bold mb-2">Profile Picture (Optional)</label>
                        <div class="w-36 h-36 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center border-4 border-primary dark:border-primary-dark overflow-hidden relative">
                            <img id="profilePreview" src="#" alt="Profile Preview" class="hidden w-full h-full rounded-full object-cover">
                            <div id="defaultIcon" class="flex items-center justify-center">
                                <i class="fa-solid fa-cloud-arrow-up text-gray-400 dark:text-gray-500 text-4xl"></i>
                            </div>
                        </div>
                        <label for="profile_pic" class="text-blue-500 dark:text-blue-400 mt-2 cursor-pointer">Choose Photo</label>
                        <input type="file" name="profile_pic" id="profile_pic" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Pet Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter Pet Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 capitalize" required>
                    </div>
                    <div>
                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                        <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="species" class="block mb-2 text-sm font-medium text-gray-900">Species</label>
                        <select id="species" name="species" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                            <option value="" disabled selected>Choose Species</option>
                            <option value="Cat">Cat</option>
                            <option value="Dog">Dog</option>
                        </select>
                    </div>
                    <div>
                        <label for="breed" class="block mb-2 text-sm font-medium text-gray-900">Breed</label>
                        <input type="text" id="breed" name="breed" placeholder="Enter Breed" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 capitalize" required>
                    </div>
                    <div>
                        <label for="bday" class="block mb-2 text-sm font-medium text-gray-900">Birthday</label>
                        <input type="date" id="bday" name="bday" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400">
                    </div>
                    <div>
                        <label for="weight" class="block mb-2 text-sm font-medium text-gray-900">Weight</label>
                        <input type="number" id="weight" name="weight" placeholder="Enter Weight" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900">Special Characteristics (Optional)</label>
                        <input type="text" id="remarks" name="remarks" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400">
                    </div>
                    <button id="addPetBtn" class="px-4 py-2 bg-blue-500 text-white rounded" onclick="addPet()">
                        Add Pet
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Cropping Modal -->
<div id="cropperModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-4 rounded-lg shadow-lg w-11/12 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Crop Your Image</h2>
        <div class="relative w-full h-64 bg-gray-100">
            <img id="cropImage" src="" class="max-w-full max-h-full">
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <button id="cropCancel" class="px-4 py-2 text-secondary">Cancel</button>
            <button id="cropSave" class="px-4 py-2 bg-primary text-white rounded">Crop & Save</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/adopt.js') }}"></script>
<script>
    let cropper;

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profilePreview');
        const defaultIcon = document.getElementById('defaultIcon');
        const cropperModal = document.getElementById('cropperModal');
        const cropImage = document.getElementById('cropImage');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    // Check dimensions
                    if (img.width > 500 || img.height > 500) {
                        // Show Cropper Modal
                        cropImage.src = e.target.result;
                        cropperModal.classList.remove('hidden');

                        // Initialize Cropper.js
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(cropImage, {
                            aspectRatio: 1, // Adjust aspect ratio as needed
                            viewMode: 1,
                        });
                    } else {
                        // Show preview if image dimensions are fine
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        defaultIcon.classList.add('hidden');
                    }
                };
            };

            reader.readAsDataURL(file);
        }
    }

    document.getElementById('cropCancel').addEventListener('click', function() {
        document.getElementById('cropperModal').classList.add('hidden');
    });

    document.getElementById('cropSave').addEventListener('click', function() {
        const cropperModal = document.getElementById('cropperModal');
        const croppedCanvas = cropper.getCroppedCanvas();
        const preview = document.getElementById('profilePreview');
        const defaultIcon = document.getElementById('defaultIcon');

        // Convert cropped image to a Data URL and show preview
        preview.src = croppedCanvas.toDataURL('image/jpeg', 0.7); // Compress to 70% quality
        preview.classList.remove('hidden');
        defaultIcon.classList.add('hidden');

        // Convert cropped canvas to a compressed Blob
        croppedCanvas.toBlob((blob) => {
            const fileInput = document.getElementById('profile_pic');
            const file = new File([blob], "cropped_image.jpg", {
                type: 'image/jpeg'
            });

            // Create a new DataTransfer object to update file input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
        }, 'image/jpeg', 0.7); // Adjust compression level if needed

        cropperModal.classList.add('hidden');
    });
</script>