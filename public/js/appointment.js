document.addEventListener("DOMContentLoaded", function () {
    // Search Input Handling
    document
        .getElementById("search-input")
        .addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent form submission
                document.getElementById("filter-form").submit();
            }
        });

    // Submit Form Function
    window.submitForm = function () {
        document.getElementById("filter-form").submit();
    };

    // Add Appointment Modal
    const modal = document.getElementById("add-appointment");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-appointment"]'
    );
    const closeModalBtn = modal.querySelector(
        '[data-modal-hide="add-appointment"]'
    );

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

    // Owner and Pet Selection
    const ownerInput = document.getElementById("owner");
    const ownerSuggestions = document.getElementById("owner-suggestions");
    let owners = [];
    const petInput = document.getElementById("pet");
    const petSuggestions = document.getElementById("pet-suggestions");

    async function fetchOwners() {
        try {
            const response = await fetch("fetch-owners");
            owners = await response.json();
        } catch (error) {
            console.error("Error fetching owners:", error);
        }
    }

    fetchOwners();

    ownerInput.addEventListener("input", function () {
        const query = ownerInput.value.toLowerCase();
        ownerSuggestions.innerHTML = "";

        const filteredOwners = owners.filter((owner) => {
            const fullName = `${owner.Fname} ${
                owner.Mname ? owner.Mname + ". " : ""
            }${owner.Lname}`.toLowerCase();
            return fullName.includes(query);
        });

        filteredOwners.forEach((owner) => {
            const div = document.createElement("div");
            div.textContent = `${owner.Fname} ${
                owner.Mname ? owner.Mname + ". " : ""
            }${owner.Lname}`;
            div.dataset.ownerId = owner.id;
            div.classList.add("cursor-pointer", "p-2", "hover:bg-gray-200");
            ownerSuggestions.appendChild(div);
        });
    });

    ownerSuggestions.addEventListener("click", function (event) {
        const selectedOwner = event.target;
        const ownerId = selectedOwner.dataset.ownerId;
        ownerInput.value = selectedOwner.textContent; // Keep the name for display
        ownerSuggestions.innerHTML = "";
        localStorage.setItem("selectedOwnerId", ownerId);
        document.querySelector('input[name="owner_id"]').value = ownerId; // Set hidden input
    });

    petInput.addEventListener("input", async function () {
        const query = petInput.value.toLowerCase();
        petSuggestions.innerHTML = "";

        if (query.length > 0 && localStorage.getItem("selectedOwnerId")) {
            const ownerId = localStorage.getItem("selectedOwnerId");
            try {
                const response = await fetch(
                    `bfc-animalclinic-innersystem/fetch-pets/${ownerId}`
                );
                const pets = await response.json();
                const filteredPets = pets.filter((pet) =>
                    pet.name.toLowerCase().includes(query)
                );
                filteredPets.forEach((pet) => {
                    const div = document.createElement("div");
                    div.textContent = pet.name;
                    div.dataset.petId = pet.id;
                    div.classList.add(
                        "cursor-pointer",
                        "p-2",
                        "hover:bg-gray-200"
                    );
                    petSuggestions.appendChild(div);
                });
            } catch (error) {
                console.error("Error fetching pets:", error);
            }
        }
    });

    petSuggestions.addEventListener("click", function (event) {
        const selectedPet = event.target;
        const petId = selectedPet.dataset.petId;
        petInput.value = selectedPet.textContent; // Keep the name for display
        petSuggestions.innerHTML = "";
        document.querySelector('input[name="pet_id"]').value = petId; // Set hidden input
    });

    // Edit Appointment Modal
    const editModal = document.getElementById("edit-appointment-modal");
    const editForm = document.getElementById("edit-appointment-form");
    const openEditButtons = document.querySelectorAll(
        '[data-modal-toggle="edit-appointment-modal"]'
    );
    const closeEditModalBtn = editModal.querySelector(
        '[data-modal-hide="edit-appointment-modal"]'
    );

    function fetchAndFillEditModal(appointmentId) {
        fetch(`bfc-animalclinic-innersystem/appointments/${appointmentId}`)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("edit-appointment-id").value = data.id;
                document.getElementById("edit-owner").value = data.owner_name;
                document.getElementById("edit-pet").value = data.pet_name;
                document.getElementById("edit-service").value = data.service_id;
                document.getElementById("edit-branch").value = data.branch_id;
                document.getElementById("edit-appointment-date").value =
                    data.appt_date;
                document.getElementById("edit-appointment-time").value =
                    data.appt_time;
                document.getElementById("edit-status").value = data.status;
                document.getElementById("edit-notes").value = data.notes;

                const formAction = editForm
                    .getAttribute("action")
                    .replace("__ID__", appointmentId);
                editForm.setAttribute("action", formAction);
                editModal.classList.remove("hidden");
            })
            .catch((error) =>
                console.error("Error fetching appointment data:", error)
            );
    }

    openEditButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const appointmentId = button.getAttribute("data-appointment-id");
            fetchAndFillEditModal(appointmentId);
        });
    });

    closeEditModalBtn.addEventListener("click", function () {
        editModal.classList.add("hidden");
    });

    window.addEventListener("click", function (e) {
        if (e.target === editModal) {
            editModal.classList.add("hidden");
        }
    });

    // Delete Appointment Modal
    const deleteModal = document.getElementById("delete-appointment-modal");
    const openDeleteButtons = document.querySelectorAll(
        '[data-modal-toggle="delete-appointment-modal"]'
    );
    const confirmDeleteBtn = deleteModal.querySelector("#confirm-delete");
    const cancelDeleteBtn = deleteModal.querySelector("#cancel-delete");

    function openDeleteModal(button) {
        const appointmentId = button.getAttribute("data-appointment-id");
        const formAction = `bfc-animalclinic-innersystem/appointments/${appointmentId}`;
        const deleteForm = deleteModal.querySelector("form");
        deleteForm.setAttribute("action", formAction);
        deleteModal.classList.remove("hidden");
    }

    openDeleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            openDeleteModal(button);
        });
    });

    cancelDeleteBtn.addEventListener("click", function () {
        deleteModal.classList.add("hidden");
    });

    window.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add("hidden");
        }
    });

    confirmDeleteBtn.addEventListener("click", function (event) {
        event.preventDefault();
        const deleteForm = deleteModal.querySelector("form");
        deleteForm.submit();
    });

    const eventSource = new EventSource(
        `sse/appointments?page=${getCurrentPage()}`
    );

    eventSource.onmessage = function (event) {
        const appointments = JSON.parse(event.data);
        const appointmentGrid = document.getElementById("appointment-grid");

        // Clear current appointments
        appointmentGrid.innerHTML = "";

        // Generate new sticky notes dynamically
        appointments.forEach((appointment) => {
            const stickyNote = `
                <div class="group bg-neutral-200 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 shadow-xl rounded-lg max-w-sm relative overflow-hidden cursor-pointer transition-all duration-300 hover:scale-105 hover:rotate-[0.7deg]">
                    <div class="absolute top-4 right-4 flex flex-col space-y-2">
                        ${
                            appointment.canDelete
                                ? `<button class="text-red-500 hover:text-red-700 font-medium text-xl hover:text-2xl"
                                aria-label="Delete"
                                data-modal-toggle="delete-appointment-modal"
                                data-appointment-id="${appointment.id}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>`
                                : ""
                        }
                        ${
                            appointment.canEdit
                                ? `<button class="text-blue-500 hover:text-blue-700 font-medium hover:text-lg"
                                aria-label="Edit"
                                data-modal-toggle="edit-appointment-modal"
                                data-appointment-id="${appointment.id}">
                                <i class="fa-solid fa-pencil"></i>
                            </button>`
                                : ""
                        }
                    </div>

                    <div class="flex items-center">
                        <div class="w-28 h-28 rounded-full bg-gray-200 overflow-hidden mr-5 shadow-lg">
                            <img src="${
                                appointment.profile_pic
                                    ? `storage/${appointment.profile_pic}`
                                    : "imgs/default_pet.webp"
                            }"
                                alt="${appointment.petName}'s profile"
                                class="object-cover w-full h-full transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-4xl">${
                                appointment.petName
                            }</h4>
                            <p class="mt-2"><strong>Owner: </strong>
                                <span class="text-base font-medium text-gray-700">${
                                    appointment.ownerName
                                }</span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <p><strong>Service & Branch: </strong>
                            <span class="text-base font-medium text-gray-700">${
                                appointment.service
                            }</span>
                            <span class="text-base font-medium text-gray-700"> | ${
                                appointment.branchName || "N/A"
                            }</span>
                        </p>
                        <p><strong>Appointment Date: </strong>
                            <span class="text-base font-medium text-gray-700">${
                                appointment.appointmentDateTime
                            }</span>
                        </p>
                        <p><strong>Status: </strong>
                            <span class="font-medium ${
                                appointment.statusColor
                            }">${appointment.status}</span>
                        </p>
                    </div>

                    <div class="absolute bottom-4 right-4 text-[8px] text-gray-700">
                        <strong>Ref. ID: </strong>
                        <span class="font-medium">${appointment.id}</span>
                    </div>
                </div>
            `;
            appointmentGrid.insertAdjacentHTML("beforeend", stickyNote);
        });

        // Reattach modal triggers
        attachModalTriggers();
    };

    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get("page") || 1;
    }

    // Attach Modal Triggers
    function attachModalTriggers() {
        document
            .getElementById("appointment-grid")
            .addEventListener("click", function (event) {
                const target = event.target.closest("[data-modal-toggle]");

                if (!target) return;

                const modalType = target.getAttribute("data-modal-toggle");
                const appointmentId = target.getAttribute(
                    "data-appointment-id"
                );

                if (modalType === "edit-appointment-modal") {
                    fetchAndFillEditModal(appointmentId);
                } else if (modalType === "delete-appointment-modal") {
                    openDeleteModal(target);
                }
            });
    }

    attachModalTriggers();
});
