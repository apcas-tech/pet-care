<!-- Edit Admin User Modal -->
<div id="edit-user" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-3xl max-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form id="edit-user-form" action="#" method="POST" class="space-y-2" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Close Button -->
                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-user">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Modal Header -->
                    <h2 class="text-2xl text-center font-semibold mb-4">Edit Admin User</h2>
                    <input type="hidden" id="edit-user-id" name="user_id">

                    <!-- Profile Picture Input -->
                    <div class="mb-8 flex flex-col items-center">
                        <label for="edit-profile-pic" class="block font-bold mb-2">Profile Picture (Optional)</label>
                        <div class="w-36 h-36 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center border-4 border-primary dark:border-primary-dark overflow-hidden relative">
                            <img id="editProfilePreview"
                                src="{{ asset('imgs/default-user.webp') }}"
                                alt="Profile Preview"
                                class="w-full h-full rounded-full object-cover hidden">
                            <div id="editDefaultIcon" class="flex items-center justify-center">
                                <i class="fa-solid fa-cloud-arrow-up text-gray-400 dark:text-gray-500 text-4xl"></i>
                            </div>
                        </div>
                        <label for="edit-profile-pic" class="text-blue-500 dark:text-blue-400 mt-2 cursor-pointer">Choose Photo</label>
                        <input type="file" name="profile_pic" id="edit-profile-pic" class="hidden" accept="image/*" onchange="previewEditUserImage(event)">
                    </div>
                    <!-- Form Layout -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <div>
                                <label for="edit-fname" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                                <input type="text" id="edit-fname" name="Fname" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 capitalize">
                            </div>

                            <div>
                                <label for="edit-mname" class="block mb-2 text-sm font-medium text-gray-900">Middle Name (Optional)</label>
                                <input type="text" id="edit-mname" name="Mname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 capitalize">
                            </div>

                            <div>
                                <label for="edit-lname" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                                <input type="text" id="edit-lname" name="Lname" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 capitalize">
                            </div>

                            <!-- Email Input -->
                            <div>
                                <label for="edit-email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                <input type="email" id="edit-email" name="email" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>

                            <!-- Role Selection -->
                            <div>
                                <label for="edit-role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                                <select name="role" id="edit-role" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="Admin">Admin</option>
                                    <option value="Vet">Vet</option>
                                </select>
                            </div>
                            <!-- Reset Password Button -->
                            <button type="button" id="reset-password-btn"
                                class="w-full text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5">
                                Reset Password
                            </button>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="edit-branch" class="block mb-2 text-sm font-medium text-gray-900">Branch</label>
                                <select name="branch_id" id="edit-branch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Select a Branch</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Capabilities -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Capabilities</label>
                                <div class="gap-3 flex">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="capabilities[]" value="create" class="mr-2"> Create
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="capabilities[]" value="edit" class="mr-2"> Edit
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="capabilities[]" value="delete" class="mr-2"> Delete
                                    </label>
                                </div>
                            </div>

                            <!-- Pages Access -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Pages Access</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Appointments" class="mr-2"> Appointments
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Services" class="mr-2"> Services
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Pets" class="mr-2"> Pets
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Pet Adoption Listings" class="mr-2"> Pet Adoption Listings
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Pet Owners" class="mr-2"> Pet Owners
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pages[]" value="Branch" class="mr-2"> Branch
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-4 py-2.5">Update Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="cropperUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-4 rounded-lg shadow-lg w-11/12 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Crop Your Image</h2>
        <div class="relative w-full h-64 bg-gray-100">
            <img id="cropUserImage" src="" class="max-w-full max-h-full">
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <button id="cropUserCancel" class="px-4 py-2 text-secondary">Cancel</button>
            <button id="cropUserSave" class="px-4 py-2 bg-primary text-white rounded">Crop & Save</button>
        </div>
    </div>
</div>
<script>
    let userCropper;

    function previewEditUserImage(event) {
        const input = event.target;
        const preview = document.getElementById('editProfilePreview');
        const defaultIcon = document.getElementById('editDefaultIcon');
        const cropperUserModal = document.getElementById('cropperUserModal');
        const cropUserImage = document.getElementById('cropUserImage');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    // Check image dimensions
                    if (img.width > 500 || img.height > 500) {
                        // Show Cropper Modal
                        cropUserImage.src = e.target.result;
                        cropperUserModal.classList.remove('hidden');

                        // Initialize Cropper.js
                        if (userCropper) {
                            userCropper.destroy();
                        }
                        userCropper = new Cropper(cropUserImage, {
                            aspectRatio: 1,
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

    // Cancel Crop
    document.getElementById('cropUserCancel').addEventListener('click', function() {
        document.getElementById('cropperUserModal').classList.add('hidden');
    });

    // Save Cropped Image
    document.getElementById('cropUserSave').addEventListener('click', function() {
        const cropperUserModal = document.getElementById('cropperUserModal');
        const croppedCanvas = userCropper.getCroppedCanvas();
        const preview = document.getElementById('editProfilePreview');
        const defaultIcon = document.getElementById('editDefaultIcon');

        // Convert cropped image to a Data URL and update preview
        preview.src = croppedCanvas.toDataURL('image/jpeg', 0.7); // Compress to 70% quality
        preview.classList.remove('hidden');
        defaultIcon.classList.add('hidden');

        // Convert cropped canvas to a compressed Blob
        croppedCanvas.toBlob((blob) => {
            const fileInput = document.getElementById('edit-profile-pic');
            const file = new File([blob], "cropped_image.webp", {
                type: 'image/jpeg'
            });

            // Create a new DataTransfer object to update file input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
        }, 'image/jpeg', 0.7); // Adjust compression level if needed

        cropperUserModal.classList.add('hidden');
    });
</script>