// Add Users Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add-pet-owner");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-pet-owner"]'
    );
    const closeModalBtns = document.querySelectorAll(
        '[data-modal-hide="add-pet-owner"]'
    ); // Select all close buttons

    if (openModalBtn) {
        openModalBtn.addEventListener("click", function () {
            modal.classList.remove("hidden");
        });
    }

    // Add event listener to all close buttons
    closeModalBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const flipCards = document.querySelectorAll(".flip-card");
    let flippedCard = null; // Store the currently flipped card

    flipCards.forEach((card) => {
        card.addEventListener("click", function () {
            // If there's already a flipped card and it's not the clicked one, unflip it
            if (flippedCard && flippedCard !== this) {
                flippedCard.classList.remove("flipped");
            }

            // Toggle the clicked card
            this.classList.toggle("flipped");

            // Update the flippedCard variable
            flippedCard = this.classList.contains("flipped") ? this : null;
        });
    });
});

// Delete Users Modal
document.addEventListener("DOMContentLoaded", function () {
    const deleteModal = document.getElementById("delete-owner");
    const cancelDeleteBtn = document.getElementById("cancel-delete");
    const deleteButtons = document.querySelectorAll(
        "[data-modal-toggle='delete-owner']"
    );
    const deleteForm = document.getElementById("deleteUserForm");

    // Open Delete Modal
    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.stopPropagation(); // Prevents flipping when clicking delete button
            const ownerId = this.getAttribute("data-id");
            deleteForm.action = `pet-owners/${ownerId}`;
            deleteModal.classList.remove("hidden");
        });
    });

    // Close Delete Modal when clicking Cancel Button
    cancelDeleteBtn.addEventListener("click", function () {
        deleteModal.classList.add("hidden");
    });

    // Close Delete Modal when clicking outside the modal
    window.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add("hidden");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const clearSearchBtn = document.getElementById("clear-search");
    const ascButton = document.getElementById("asc-button");
    const descButton = document.getElementById("desc-button");
    const petOwnersContainer = document.querySelector(
        ".flex.flex-row.flex-wrap"
    );

    let petOwners = Array.from(document.querySelectorAll(".flip-card"));

    // SEARCH FUNCTION
    searchInput.addEventListener("input", function () {
        const searchValue = searchInput.value.toLowerCase().trim();

        petOwners.forEach((card) => {
            const name = card.querySelector(".title").textContent.toLowerCase();
            card.style.display = name.includes(searchValue) ? "block" : "none";
        });

        // Show clear button if search input is not empty
        clearSearchBtn.classList.toggle("hidden", searchValue === "");
    });

    // CLEAR SEARCH
    clearSearchBtn.addEventListener("click", function () {
        searchInput.value = "";
        petOwners.forEach((card) => (card.style.display = "block"));
        clearSearchBtn.classList.add("hidden");
    });

    // SORT FUNCTION
    function sortPetOwners(order = "asc") {
        petOwners.sort((a, b) => {
            const nameA = a.querySelector(".title").textContent.toLowerCase();
            const nameB = b.querySelector(".title").textContent.toLowerCase();
            return order === "asc"
                ? nameA.localeCompare(nameB)
                : nameB.localeCompare(nameA);
        });

        // Re-append sorted elements
        petOwners.forEach((card) => petOwnersContainer.appendChild(card));
    }

    // EVENT LISTENERS FOR SORT BUTTONS
    ascButton.addEventListener("click", () => sortPetOwners("asc"));
    descButton.addEventListener("click", () => sortPetOwners("desc"));
});
