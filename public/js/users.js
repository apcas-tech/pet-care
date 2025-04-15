// Add Users Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add-user");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-user"]'
    );
    const closeModalBtn = modal.querySelector('[data-modal-hide="add-user"]');

    if (openModalBtn) {
        openModalBtn.addEventListener("click", function () {
            modal.classList.remove("hidden");
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

// Edit Users Modal
document.addEventListener("DOMContentLoaded", function () {
    // Edit Users Modal
    const editModal = document.getElementById("edit-user");
    const editModalForm = document.getElementById("edit-user-form");
    const editModalInputs = editModalForm.querySelectorAll("input, select");

    // Add event listener to edit buttons
    const editButtons = document.querySelectorAll(".edit-user-btn");
    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const userId = button.getAttribute("data-user-id");

            fetch(`bfc-animalclinic-innersystem/users/edit/${userId}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((userData) => {
                    document.getElementById("edit-user-id").value = userData.id;
                    document.getElementById("edit-fname").value =
                        userData.Fname;
                    document.getElementById("edit-mname").value =
                        userData.Mname || ""; // If Mname is null, set it to an empty string
                    document.getElementById("edit-lname").value =
                        userData.Lname;
                    document.getElementById("edit-email").value =
                        userData.email;
                    document.getElementById("edit-role").value = userData.role;
                    userData.email;
                    document.getElementById("edit-role").value = userData.role;

                    // Set capabilities and pages
                    document
                        .querySelectorAll('input[name="capabilities[]"]')
                        .forEach((input) => {
                            input.checked = userData.capabilities.includes(
                                input.value
                            );
                        });
                    document
                        .querySelectorAll('input[name="pages[]"]')
                        .forEach((input) => {
                            input.checked = userData.pages.includes(
                                input.value
                            );
                        });

                    // Update profile picture preview
                    const profilePicPreview =
                        document.getElementById("editProfilePreview");
                    const defaultIcon =
                        document.getElementById("editDefaultIcon");

                    if (userData.profile_pic) {
                        profilePicPreview.src = userData.profile_pic;
                        profilePicPreview.classList.remove("hidden");
                        defaultIcon.classList.add("hidden");
                    } else {
                        profilePicPreview.classList.add("hidden");
                        defaultIcon.classList.remove("hidden");
                    }
                    // **Set form action URL dynamically**
                    editModalForm.action = `${window.Laravel.updateUserUrl}${userData.id}`;

                    // **Set Pre-Selected Branch**
                    const branchDropdown =
                        document.getElementById("edit-branch");
                    if (userData.branch_id) {
                        branchDropdown.value = userData.branch_id;
                    } else {
                        branchDropdown.value = "";
                    }

                    // Show edit modal
                    editModal.classList.remove("hidden");
                })
                .catch((error) => {
                    console.error("Error fetching user data:", error);
                    alert("Failed to load user data. Please try again.");
                });
        });
    });

    // Close Modal Logic
    const closeModalBtn = editModal.querySelector(
        '[data-modal-hide="edit-user"]'
    );
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            editModal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === editModal) {
            editModal.classList.add("hidden");
        }
    });
});

window.Laravel = {
    updateUserUrl: "{{ url('bfc-animalclinic-innersystem/users/update') }}/",
};

// Delete Users Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("delete-user");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="delete-user"]'
    );
    const closeModalBtn = modal.querySelector(
        '[data-modal-hide="delete-user"]'
    );

    if (openModalBtn) {
        openModalBtn.addEventListener("click", function () {
            modal.classList.remove("hidden");
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-user-btn");
    const deleteUserForm = document.getElementById("deleteUserForm");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const userId = button.getAttribute("data-user-id");
            deleteUserForm.action = `bfc-animalclinic-innersystem/users/${userId}`;
            document.getElementById("delete-user").classList.remove("hidden");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const resetPasswordBtn = document.getElementById("reset-password-btn");
    const alertDialog = document.getElementById("alert-dialog");
    const alertMessage = document.getElementById("alert-message");
    const alertClose = document.getElementById("alert-close");
    const alertCancel = document.getElementById("alert-cancel");

    if (resetPasswordBtn) {
        resetPasswordBtn.addEventListener("click", function () {
            const userId = document.getElementById("edit-user-id").value;

            if (!userId) {
                showToast("User ID not found. Please try again.", "error");
                return;
            }

            // Show Alert Dialog
            alertMessage.innerHTML =
                "Are you sure you want to reset this user's password to <strong>@bfcClinic123</strong>?";
            alertDialog.classList.remove("hidden");

            // Handle Confirm Reset
            alertClose.onclick = function () {
                resetUserPassword(userId);
                alertDialog.classList.add("hidden");
            };

            // Handle Cancel
            alertCancel.onclick = function () {
                alertDialog.classList.add("hidden");
            };
        });
    }

    function resetUserPassword(userId) {
        fetch(`bfc-animalclinic-innersystem/users/reset-password/${userId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                showToast(data.message, "success");
            })
            .catch((error) => {
                console.error("Error resetting password:", error);
                showToast(
                    "Failed to reset password. Please try again.",
                    "error"
                );
            });
    }
});
