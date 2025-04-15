document.addEventListener("DOMContentLoaded", function () {
    // Filter
    let currentFilterType = "pets"; // or 'owners'
    let currentSortOrder = "asc"; // or 'desc'
    const clearSearchButton = document.getElementById("clear-search");

    // Filter buttons
    const petsButton = document.getElementById("pets-button");
    const ownersButton = document.getElementById("owners-button");
    const ascButton = document.getElementById("asc-button");
    const descButton = document.getElementById("desc-button");

    if (petsButton) {
        petsButton.addEventListener("click", function () {
            currentFilterType = "pets";
            filterPets();
        });
    } else {
        console.error("Pets button not found!");
    }

    if (ownersButton) {
        ownersButton.addEventListener("click", function () {
            currentFilterType = "owners";
            filterPets();
        });
    } else {
        console.error("Owners button not found!");
    }

    if (ascButton) {
        ascButton.addEventListener("click", function () {
            currentSortOrder = "asc";
            filterPets();
        });
    } else {
        console.error("Asc button not found!");
    }

    if (descButton) {
        descButton.addEventListener("click", function () {
            currentSortOrder = "desc";
            filterPets();
        });
    } else {
        console.error("Desc button not found!");
    }

    function filterPets() {
        const pets = [...document.querySelectorAll("#pet-grid > div")];
        pets.sort((a, b) => {
            const petA = a.querySelector("h2").innerText; // Pet name
            const ownerA = a
                .querySelector("p")
                .innerText.replace("Owner: ", ""); // Owner name
            const petB = b.querySelector("h2").innerText; // Pet name
            const ownerB = b
                .querySelector("p")
                .innerText.replace("Owner: ", ""); // Owner name

            const valueA = currentFilterType === "pets" ? petA : ownerA;
            const valueB = currentFilterType === "pets" ? petB : ownerB;

            if (currentSortOrder === "asc") {
                return valueA.localeCompare(valueB);
            } else {
                return valueB.localeCompare(valueA);
            }
        });

        // Clear existing pets and re-add sorted ones
        const petGrid = document.getElementById("pet-grid");
        if (petGrid) {
            petGrid.innerHTML = "";
            pets.forEach((pet) => petGrid.appendChild(pet));
        }

        // Show clear filters button if any filter is active
        const clearFiltersButton = document.querySelector(
            ".clear-filters-button"
        );
        const isFilterActive =
            document.getElementById("search-input").value ||
            currentFilterType !== "pets" ||
            currentSortOrder !== "asc";
        if (clearFiltersButton) {
            clearFiltersButton.classList.toggle("hidden", !isFilterActive);
        }
    }

    function searchPets() {
        const searchTerm = document
            .getElementById("search-input")
            .value.toLowerCase();
        const pets = document.querySelectorAll("#pet-grid > div");

        pets.forEach((pet) => {
            const petName = pet.querySelector("h2").innerText.toLowerCase();
            const ownerName = pet
                .querySelector("p")
                .innerText.replace("Owner: ", "")
                .toLowerCase();

            if (
                petName.includes(searchTerm) ||
                ownerName.includes(searchTerm)
            ) {
                pet.style.display = ""; // Show pet
            } else {
                pet.style.display = "none"; // Hide pet
            }
        });

        clearSearchButton.classList.toggle("hidden", !searchTerm);
    }

    function clearSearch() {
        document.getElementById("search-input").value = "";
        searchPets(); // Reset search
    }

    // Initial filter
    filterPets();

    // Fetch owners as suggestions
    const ownerInput = document.getElementById("owner");
    const ownerSuggestions = document.getElementById("owner-suggestions");

    // Function to fetch owners based on input
    function fetchOwners(inputValue) {
        fetch("bfc-animalclinic-innersystem/fetch-owners")
            .then((response) => response.json())
            .then((data) => {
                const filteredOwners = data.filter((owner) => {
                    const ownerFullName = `${owner.Fname} ${
                        owner.Mname ? owner.Mname + ". " : ""
                    }${owner.Lname}`;
                    return ownerFullName
                        .toLowerCase()
                        .includes(inputValue.toLowerCase());
                });

                const suggestionsHtml = filteredOwners
                    .map((owner) => {
                        const ownerFullName = `${owner.Fname} ${
                            owner.Mname ? owner.Mname + ". " : ""
                        }${owner.Lname}`;
                        return `<div class="p-2 cursor-pointer" data-owner-id="${owner.id}">${ownerFullName}</div>`;
                    })
                    .join("");

                ownerSuggestions.innerHTML = suggestionsHtml;

                // Add event listener to suggestions
                const suggestions = ownerSuggestions.children;
                for (let i = 0; i < suggestions.length; i++) {
                    suggestions[i].addEventListener("click", function () {
                        ownerInput.value = this.innerText;
                        document.getElementById("owner_id").value =
                            this.getAttribute("data-owner-id");
                        ownerSuggestions.innerHTML = "";
                    });
                }
            });
    }

    if (ownerInput) {
        ownerInput.addEventListener("input", function () {
            if (ownerInput.value.length > 0) {
                fetchOwners(ownerInput.value);
            } else {
                ownerSuggestions.innerHTML = "";
            }
        });
    } else {
        console.error("Owner input not found!");
    }

    // Add Pet Modal
    const addPetModal = document.getElementById("add-pet");
    const openAddModalBtn = document.querySelector(
        '[data-modal-toggle="add-pet"]'
    );
    const closeAddModalBtn = addPetModal
        ? addPetModal.querySelector('[data-modal-hide="add-pet"]')
        : null;

    if (openAddModalBtn) {
        openAddModalBtn.addEventListener("click", function () {
            addPetModal.classList.remove("hidden");
        });
    }

    if (closeAddModalBtn) {
        closeAddModalBtn.addEventListener("click", function () {
            addPetModal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (addPetModal && e.target === addPetModal) {
            addPetModal.classList.add("hidden");
        }
    });

    // Edit Pet Modal
    const editPetModal = document.getElementById("edit-pet");
    const openEditModalBtn = document.querySelector(
        '[data-modal-toggle="edit-pet"]'
    );
    const closeEditModalBtn = editPetModal
        ? editPetModal.querySelector('[data-modal-hide="edit-pet"]')
        : null;

    if (openEditModalBtn) {
        openEditModalBtn.addEventListener("click", function () {
            // Fetch the owner suggestions when the modal opens
            if (ownerInput) {
                ownerInput.value = `${ownerInput.value} ${
                    ownerInput.value ? "" : ""
                }`;
                fetchOwners(ownerInput.value);
            }
            editPetModal.classList.remove("hidden");
        });
    }

    if (closeEditModalBtn) {
        closeEditModalBtn.addEventListener("click", function () {
            editPetModal.classList.add("hidden");
        });
    }

    window.addEventListener("click", function (e) {
        if (editPetModal && e.target === editPetModal) {
            editPetModal.classList.add("hidden");
        }
    });
});
