document.addEventListener("DOMContentLoaded", function () {
    // Fetch owners as suggestions for add-pet modal
    const ownerInput = document.getElementById("owner");
    const ownerSuggestions = document.getElementById("owner-suggestions");

    // Fetch owners as suggestions for edit-pet modal
    const editOwnerInput = document.getElementById("edit-owner");
    const editOwnerSuggestions = document.getElementById(
        "edit-owner-suggestions"
    );

    // Function to fetch owners based on input
    function fetchOwners(
        inputValue,
        suggestionsElement,
        inputField,
        hiddenField
    ) {
        fetch("/fetch-owners")
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

                suggestionsElement.innerHTML = suggestionsHtml;

                // Add event listener to suggestions
                const suggestions = suggestionsElement.children;
                for (let i = 0; i < suggestions.length; i++) {
                    suggestions[i].addEventListener("click", function () {
                        inputField.value = this.innerText;
                        hiddenField.value = this.getAttribute("data-owner-id");
                        suggestionsElement.innerHTML = "";
                    });
                }
            });
    }

    // Add event listeners for the add-pet modal
    if (ownerInput) {
        ownerInput.addEventListener("input", function () {
            if (ownerInput.value.length > 0) {
                fetchOwners(
                    ownerInput.value,
                    ownerSuggestions,
                    ownerInput,
                    document.getElementById("owner_id")
                );
            } else {
                ownerSuggestions.innerHTML = "";
            }
        });
    } else {
    }

    // Add event listeners for the edit-pet modal
    if (editOwnerInput) {
        editOwnerInput.addEventListener("input", function () {
            if (editOwnerInput.value.length > 0) {
                fetchOwners(
                    editOwnerInput.value,
                    editOwnerSuggestions,
                    editOwnerInput,
                    document.getElementById("edit-owner_id")
                );
            } else {
                editOwnerSuggestions.innerHTML = "";
            }
        });
    } else {
    }
});

//Edit Pet Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("edit-pet");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="edit-pet"]'
    );
    const closeModalBtn = modal.querySelector('[data-modal-hide="edit-pet"]');

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

//Delete Pet Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("delete-pet");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="delete-pet"]'
    );
    const closeModalBtn = modal.querySelector('[data-modal-hide="delete-pet"]');

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

//Add Health Modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("add-health");
    const openModalBtn = document.querySelector(
        '[data-modal-toggle="add-health"]'
    );
    const closeModalBtn = modal.querySelector('[data-modal-hide="add-health"]');

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
