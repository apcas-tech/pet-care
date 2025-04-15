<!-- Change Password Modal -->
<div id="change-password-modal" tabindex="-1" aria-hidden="true" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70">
    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-4 md:p-5">
                <form id="change-password-form" method="POST" action="{{ route('admin.change-password') }}">
                    @csrf

                    <!-- Close Button -->
                    <button type="button" class="absolute top-6 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="change-password-modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Modal Header -->
                    <h2 class="text-2xl text-center font-semibold mb-4">Change Password</h2>

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter current password">
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
                        <input type="password" id="new_password" name="new_password" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter new password">
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Confirm new password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-white bg-primary hover:bg-primary-light focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 my-4 py-2.5">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const changePasswordForm = document.getElementById("change-password-form");
        const changePasswordModal = document.getElementById("change-password-modal");

        // Close modal and reset form when closing
        function resetPasswordForm() {
            changePasswordForm.reset(); // Clear input fields
        }

        // Close button event
        document.querySelector("[data-modal-hide='change-password-modal']").addEventListener("click", function() {
            changePasswordModal.classList.add("hidden");
            resetPasswordForm();
        });

        // Also reset form after successful password update
        document.getElementById('change-password-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('admin.change-password') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Accept": "application/json",
                    }
                })
                .then(response => response.json()) // Parse response as JSON
                .then(data => {
                    console.log("Response received:", data); // Debug in browser console

                    if (data.message) {
                        showToast(data.message, "success");

                        if (data.message === "Password updated successfully.") {
                            changePasswordModal.classList.add("hidden");
                            resetPasswordForm(); // Clear inputs after success
                        }
                    } else if (data.error) {
                        showToast(data.error, "error");
                    } else {
                        showToast("Unexpected response. Check console.", "error");
                    }
                })
                .catch(error => {
                    console.error("Fetch Error:", error);
                    showToast("An error occurred. Check console.", "error");
                });
        });
    });
</script>