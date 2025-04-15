document.addEventListener("DOMContentLoaded", function () {
    // Add Pet Modal
    const addPetModal = document.getElementById("add-pet-adoption");
    const openAddModalBtn = document.querySelector(
        '[data-modal-toggle="add-pet-adoption"]'
    );
    const closeAddModalBtn = addPetModal
        ? addPetModal.querySelector('[data-modal-hide="add-pet-adoption"]')
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
});
