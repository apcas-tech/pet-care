// Add branch Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add-branch");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-branch"]'
    );
    const closeModalBtn = modal.querySelector('[data-modal-hide="add-branch"]');

    openModalBtn.addEventListener("click", function () {
        modal.classList.remove("hidden");
    });

    closeModalBtn.addEventListener("click", function () {
        modal.classList.add("hidden");
    });

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

//Edit Modal
document.addEventListener("DOMContentLoaded", function () {
    const editModal = document.getElementById("edit-branch");
    const editForm = document.getElementById("edit-branch-form");
    const editBranchId = document.getElementById("edit-branch-id");
    const editBranchName = document.getElementById("edit-branch-name");
    const editBranchPhone = document.getElementById("edit-branch-phone");

    // Open Edit Modal
    document.querySelectorAll(".edit-branch-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const branchId = this.dataset.branchId; // Use dataset.branchId instead of dataset.id

            if (!branchId) {
                console.error("Branch ID is undefined");
                return;
            }

            // Fetch branch details via AJAX
            fetch(`admin/branches/${branchId}`)
                .then((response) => response.json())
                .then((data) => {
                    editBranchId.value = branchId;
                    editBranchName.value = data.name;
                    editBranchPhone.value = data.phone_number;
                    editForm.action = `admin/branches/${branchId}`;
                    editModal.classList.remove("hidden");
                })
                .catch((error) =>
                    console.error("Error loading branch data:", error)
                );
        });
    });

    // Close Edit Modal
    document
        .getElementById("cancel-edit-branch")
        .addEventListener("click", function () {
            editModal.classList.add("hidden");
        });

    // Close modal when clicking outside
    window.addEventListener("click", function (e) {
        if (e.target === editModal) {
            editModal.classList.add("hidden");
        }
    });
});

//Delete branch Modal
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-branch-btn");
    const deleteModal = document.getElementById("delete-branch");
    const confirmDeleteBtn = document.getElementById("confirm-delete-branch");
    let currentBranchId = null;

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            currentBranchId = this.dataset.branchId; // Use correct dataset key
            deleteModal.classList.remove("hidden");
        });
    });

    confirmDeleteBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default form submission
        const form = confirmDeleteBtn.closest("form");
        form.action = `admin/branches/${currentBranchId}`;
        form.submit();
    });

    document
        .getElementById("cancel-delete-branch")
        .addEventListener("click", function () {
            deleteModal.classList.add("hidden");
        });

    window.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add("hidden");
        }
    });
});
