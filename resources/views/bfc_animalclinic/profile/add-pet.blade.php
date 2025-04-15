@extends('bfc_animalclinic.layouts.layout')

@section('content')
<!-- Header -->
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('profile.page') }}" class="text-2xl font-bold"><i class="fa-solid fa-angle-left fa-sm"></i></a>
    <h1 class="flex-1 text-center text-xl font-semibold">PawFile</h1>
</div>

<!-- Form Container -->
<div class="flex flex-col items-center justify-center">
    <form id="petForm" action="{{ route('pet.store') }}" method="POST" enctype="multipart/form-data" class="w-11/12 max-w-sm mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md dark:text-white">
        @csrf
        <!-- Profile Picture -->
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

        <!-- Pet's Name -->
        <div class="mb-4">
            <label for="name" class="block font-bold mb-1">Pet's Name:</label>
            <input type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 capitalize bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Name" required>
            <input type="hidden" name="owner_id" value="{{ auth()->id() }}">
        </div>

        <!-- Gender -->
        <div class="mb-4">
            <label class="block font-bold mb-1">Gender:</label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="Male" class="mr-2">
                    <span class="flex items-center text-blue-500 dark:text-blue-400"><i class="fa-solid fa-mars"></i> Male</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="Female" class="mr-2">
                    <span class="flex items-center text-pink-500 dark:text-pink-400"><i class="fa-solid fa-venus"></i> Female</span>
                </label>
            </div>
        </div>

        <!-- Species -->
        <div class="mb-4">
            <label for="species" class="block font-bold mb-1">Species:</label>
            <select name="species" id="species" class="w-full border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="" disabled selected>Choose Species</option>
                <option value="Cat">Cat</option>
                <option value="Dog">Dog</option>
            </select>
        </div>

        <!-- Breed -->
        <div class="mb-4">
            <label for="breed" class="block font-bold mb-1">Breed:</label>
            <input type="text" name="breed" id="breed" class="w-full border rounded-md px-3 py-2 capitalize bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Enter Breed">
        </div>

        <!-- Birthday -->
        <div class="mb-4">
            <label for="bday" class="block font-bold mb-1">Birthday:</label>
            <input type="date" name="bday" id="bday" class="w-full border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>

        <!-- Weight -->
        <div class="mb-4">
            <label for="weight" class="block font-bold mb-1">Weight (kg):</label>
            <input type="number" name="weight" id="weight" class="w-full border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0.00" step="0.01" required>
        </div>

        <!-- Special Markings -->
        <div class="mb-4">
            <label for="special_char" class="block font-bold mb-1">Special Characteristics:</label>
            <textarea name="special_char" id="special_char" class="w-full border rounded-md px-3 py-2 normal-case bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Special Markings"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="relative mt-6">
            <button id="addPetButton" type="submit" class="w-full text-white bg-red-500 py-2 hover:bg-red-600 font-semibold flex items-center justify-center dark:bg-red-600 dark:hover:bg-red-500">
                <i class="fa-solid fa-paw mr-2"></i> ADD PET
            </button>

            <!-- Spinner Component -->
            <div id="addPetButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-red-900 hidden">
                <x-spinner />
            </div>
        </div>
    </form>
</div>
<!-- Image Cropping Modal -->
<div id="cropperModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg w-11/12 max-w-lg">
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Crop Your Image</h2>
        <div class="relative w-full h-64 bg-gray-100 dark:bg-gray-700">
            <img id="cropImage" src="" class="max-w-full max-h-full">
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <button id="cropCancel" class="px-4 py-2 text-secondary rounded-md">Cancel</button>
            <button id="cropSave" class="px-4 py-2 bg-primary text-white rounded-md">Crop & Save</button>
        </div>
    </div>
</div>


<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profilePreview');
        const defaultIcon = document.getElementById('defaultIcon');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


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
        const cropperModal = document.getElementById('cropperModal');
        cropperModal.classList.add('hidden');
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

    document.getElementById("petForm").addEventListener("submit", function(e) {
        // Get the spinner and signup button
        var spinner = document.getElementById("addPetButtonSpinner");
        var addPetButton = document.getElementById("addPetButton");

        // Prevent the form from submitting until we show the spinner
        e.preventDefault();

        // Disable the signup button to prevent multiple submissions
        addPetButton.disabled = true;

        // Show the spinner
        spinner.classList.remove("hidden");

        // Proceed with form submission after a slight delay (optional)
        setTimeout(function() {
            e.target.submit();
        }, 500); // Adjust the delay as needed
    });
</script>

@endsection