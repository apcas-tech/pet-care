document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add-service");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-service"]'
    );
    const closeModalBtn = modal.querySelector(
        '[data-modal-hide="add-service"]'
    );

    if (openModalBtn) {
        openModalBtn.addEventListener("click", function () {
            console.log("Opening modal");
            modal.classList.remove("hidden");
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            console.log("Closing modal");
            modal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

//Edit Modal
document.addEventListener("DOMContentLoaded", function () {
    const addModal = document.getElementById("add-service");
    const editModal = document.getElementById("edit-service");
    const openAddModalBtn = document.querySelector(
        '[data-modal-toggle="add-service"]'
    );
    const closeAddModalBtn = addModal.querySelector(
        '[data-modal-hide="add-service"]'
    );

    if (openAddModalBtn) {
        openAddModalBtn.addEventListener("click", function () {
            addModal.classList.remove("hidden");
        });
    }

    if (closeAddModalBtn) {
        closeAddModalBtn.addEventListener("click", function () {
            addModal.classList.add("hidden");
        });
    }

    // Handle the edit button click
    const editButtons = document.querySelectorAll(".edit-service-btn");
    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const serviceId = this.dataset.id;
            fetch(`bfc-animalclinic-innersystem/services/${serviceId}/edit`)
                .then((response) => response.json())
                .then((service) => {
                    document.getElementById("edit-service-id").value =
                        service.id;
                    document.getElementById("edit-service-name").value =
                        service.service;
                    document.getElementById("edit-price").value = service.price;
                    document.getElementById("edit-capacity").value =
                        service.capacity;
                    document.getElementById("edit-description").value =
                        service.description;

                    // Set the form action URL for update
                    const form = document.getElementById("edit-service-form");
                    form.action = `bfc-animalclinic-innersystem/services/${serviceId}`;

                    editModal.classList.remove("hidden");
                })
                .catch((error) =>
                    console.error("Error fetching service:", error)
                );
        });
    });

    const closeEditModalBtn = editModal.querySelector(
        '[data-modal-hide="edit-service"]'
    );

    if (closeEditModalBtn) {
        closeEditModalBtn.addEventListener("click", function () {
            editModal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (e.target === addModal) {
            addModal.classList.add("hidden");
        }
        if (e.target === editModal) {
            editModal.classList.add("hidden");
        }
    });
});

//Delete Service Modal
document.addEventListener("DOMContentLoaded", function () {
    // Handle delete button click
    const deleteButtons = document.querySelectorAll(".delete-service-btn");
    const deleteModal = document.getElementById("delete-service");
    const confirmDeleteBtn = deleteModal.querySelector(
        "#confirm-delete-service"
    );
    let currentServiceId = null;

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            currentServiceId = this.dataset.id;
            deleteModal.classList.remove("hidden");
        });
    });

    // Handle confirm delete button click
    confirmDeleteBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default form submission
        const form = confirmDeleteBtn.closest("form");
        form.action = `bfc-animalclinic-innersystem/services/${currentServiceId}`;
        form.submit(); // Submit the form to delete the service
    });

    // Handle cancel delete button click
    const cancelDeleteBtn = deleteModal.querySelector("#cancel-delete-service");
    cancelDeleteBtn.addEventListener("click", function () {
        deleteModal.classList.add("hidden"); // Hide the modal
    });

    // Handle clicks outside the modal
    window.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add("hidden");
        }
    });
});
