@extends('bfc_animalclinic.layouts.layout')

@section('content')
<div class="w-full bg-primary px-4 py-2 text-white flex items-center">
    <a href="{{ route('profile.page') }}" class="text-2xl font-bold">
        <i class="fa-solid fa-angle-left fa-sm"></i>
    </a>
    <h1 class="flex-1 text-center text-xl font-semibold">Edit Profile</h1>
</div>

<div class="w-screen mx-auto my-8 p-6 shadow-md rounded-lg">
    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Profile Picture -->
        <div class="mb-8 flex flex-col items-center">
            <label for="profile_pic" class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Profile Picture (Optional)</label>
            <div class="w-36 h-36 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center border-4 border-primary dark:border-primary-dark overflow-hidden relative">
                @if ($user->profile_pic)
                @php
                $profilePic = $user->profile_pic
                ? (Str::startsWith($user->profile_pic, 'http')
                ? $user->profile_pic
                : asset('storage/'.$user->profile_pic))
                : asset('imgs/def-user.webp');
                @endphp
                <img id="profilePreview" src="{{ $profilePic }}" alt="Profile Preview" class="w-full h-full rounded-full object-cover">
                @else
                <img id="profilePreview" src="#" alt="Profile Preview" class="hidden w-full h-full rounded-full object-cover">
                <div id="defaultIcon" class="flex items-center justify-center">
                    <i class="fa-solid fa-cloud-arrow-up text-gray-400 dark:text-gray-500 text-4xl"></i>
                </div>
                @endif
            </div>
            <label for="profile_pic" class="text-blue-500 dark:text-blue-400 mt-2 cursor-pointer">Choose Photo</label>
            <input type="file" name="profile_pic" id="profile_pic" class="hidden" accept="image/*" onchange="previewImage(event)">
        </div>

        @php
        $fields = [
        'Fname' => 'First Name',
        'Mname' => 'Middle Name',
        'Lname' => 'Last Name',
        'email' => 'Email',
        'address' => 'Address'
        ];
        @endphp

        @foreach ($fields as $name => $label)
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-semibold">{{ $label }}</label>
            <input type="text" name="{{ $name }}" value="{{ old($name, $user->$name) }}"
                class="w-full border dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200">
        </div>
        @endforeach

        <!-- Separate Phone Input Field -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-semibold">Phone Number</label>
            <div class="flex items-center border dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                <span class="px-3 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-l-md">+63</span>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-3 py-2 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border-none focus:ring-0"
                    placeholder="Enter your phone number"
                    pattern="[0-9]{10}" title="Enter a 10-digit phone number" required>
            </div>
        </div>

        <div class="relative mt-10">
            <button id="profileButton" type="submit" class="w-full text-white bg-primary py-2 hover:bg-primary-dark font-semibold flex items-center justify-center dark:bg-primary dark:hover:bg-primary-light">
                Update Profile
            </button>

            <!-- Spinner Component -->
            <div id="profileButtonSpinner" class="absolute inset-0 flex items-center justify-center bg-opacity-95 bg-primary-dark hidden">
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
@endsection

<script>
    let cropper;

    // Define the previewImage function in the global scope
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

    document.addEventListener("DOMContentLoaded", function() {
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

        document.getElementById("profileForm").addEventListener("submit", function(e) {
            var spinner = document.getElementById("profileButtonSpinner");
            var profileButton = document.getElementById("profileButton");

            // Prevent the form from submitting until we show the spinner
            e.preventDefault();

            profileButton.disabled = true;
            spinner.classList.remove("hidden");

            // Proceed with form submission after a slight delay (optional)
            setTimeout(function() {
                e.target.submit();
            }, 500); // Adjust the delay as needed
        });
    });
</script>