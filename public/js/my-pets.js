document
    .getElementById("toggle-vaccine")
    .addEventListener("click", function () {
        let vaccineList = document.getElementById("vaccination-list");
        let icon = document.getElementById("vaccine-icon");

        vaccineList.classList.toggle("hidden");
        icon.classList.toggle("fa-chevron-down");
        icon.classList.toggle("fa-chevron-up");
    });

document.getElementById("toggle-health").addEventListener("click", function () {
    let healthList = document.getElementById("health-list");
    let icon = document.getElementById("health-icon");

    healthList.classList.toggle("hidden");
    icon.classList.toggle("fa-chevron-down");
    icon.classList.toggle("fa-chevron-up");
});

document.addEventListener("DOMContentLoaded", function () {
    const profilePic = document.getElementById("pet-profile-pic");
    const petNameText = document.getElementById("pet-name-text");
    const petGender = document.getElementById("gender-icon");
    const petBreed = document.getElementById("pet-breed");
    const petBirthday = document.getElementById("pet-birthday");
    const vaccinationList = document.getElementById("vaccination-list");
    const releasePetButton = document.getElementById("releasePet");
    const alertDialog = document.getElementById("alert-dialog");
    const alertMessage = document.getElementById("alert-message");
    const alertCloseButton = document.getElementById("alert-close");
    const alertCancelButton = document.getElementById("alert-cancel");

    releasePetButton.addEventListener("click", function () {
        const activeSlide = swiper.slides[swiper.activeIndex];
        const petId = activeSlide.dataset.petId;

        const petData = JSON.parse(activeSlide.dataset.pet); // Parse the JSON string
        alertMessage.textContent = `Are you sure you want to release ${petData.name}?`;
        alertDialog.classList.remove("hidden");

        alertCloseButton.onclick = function () {
            fetch(`release-pet/${petId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            }).then((response) => {
                if (response.ok) {
                    // Remove the pet from the UI
                    activeSlide.remove();
                    // Optionally, you can update the swiper if needed
                    swiper.update();
                    showToast(`${petData.name} has been released!`, "success");
                } else {
                    showToast(
                        "Failed to release your pet. Please try again.",
                        "error"
                    );
                }
            });
            alertDialog.classList.add("hidden");
        };

        alertCancelButton.onclick = function () {
            alertDialog.classList.add("hidden");
        };
    });

    const updatePetDetails = (petData) => {
        // Update pet profile details
        petNameText.textContent = petData.name;
        petGender.className =
            petData.gender === "Male"
                ? "fa fa-mars text-blue-500 text-lg"
                : "fa fa-venus text-pink-500 text-lg";
        petBreed.textContent = `Breed: ${petData.breed}`;

        // Format birthday
        const birthday = new Date(petData.bday);
        petBirthday.textContent = `Birthday: ${birthday.toLocaleDateString(
            "en-US",
            { month: "long", day: "2-digit", year: "numeric" }
        )}`;

        // Update profile picture
        profilePic.src = petData.profile_pic
            ? `storage/${petData.profile_pic}`
            : `imgs/default_pet.webp`;

        // Update Health Records
        updateHealthRecords(petData.prescriptions);
        // Update Vaccination List
        updateVaccinationRecords(petData.vaccinations);
    };

    const updateHealthRecords = (prescriptions) => {
        const healthList = document.getElementById("health-list");
        healthList.innerHTML = ""; // Clear previous records

        if (!prescriptions || prescriptions.length === 0) {
            healthList.innerHTML = `<p class="text-sm text-gray-400 text-center">No health records available.</p>`;
            return;
        }

        // Sort by record date (descending)
        prescriptions.sort(
            (a, b) => new Date(b.record_date) - new Date(a.record_date)
        );

        // Identify the latest record
        let latestRecordId =
            prescriptions.length > 0 ? prescriptions[0].id : null;

        let healthHTML = `<ol class="relative border-l border-gray-700">`;
        prescriptions.forEach((prescription, index) => {
            let isLatest =
                prescription.id === latestRecordId
                    ? `<span class="ml-2 bg-red-500 text-xs px-2 py-1 text-white rounded">Latest</span>`
                    : "";

            healthHTML += `
            <li class="mb-4 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 text-white ring-8 ring-white dark:ring-gray-900 bg-secondary-dark dark:bg-secondary-light">
                   <i class="fa-solid fa-file-prescription fa-rotate-by" style="--fa-rotate-angle: -30deg;"></i>
                </span>
                <div class="p-2 rounded-lg shadow">
                    <h3 class="mb-1 text-lg font-semibold flex items-center justify-between">
                        ${prescription.tx_given} ${isLatest}
                    </h3>
                    <time class="block mb-2 text-sm font-normal text-gray-400">
                        <strong>Administered: </strong>${new Date(
                            prescription.record_date
                        ).toLocaleDateString("en-US", {
                            month: "long",
                            day: "2-digit",
                            year: "numeric",
                        })}
                    </time>
                    <p class="text-sm text-gray-400"><strong>Description:</strong> ${
                        prescription.description || "No description available"
                    }</p>
                    <p class="text -sm text-gray-400"><strong>Attending Vet: </strong>Dr. ${
                        prescription.veterinarian
                            ? prescription.veterinarian.Fname +
                              " " +
                              prescription.veterinarian.Lname
                            : "Unknown"
                    }</p>
                </div>
            </li>
            `;
        });
        healthHTML += `</ol>`;
        healthList.innerHTML = healthHTML;
    };

    const updateVaccinationRecords = (vaccinations) => {
        vaccinationList.innerHTML = ""; // Clear previous records

        if (!vaccinations || vaccinations.length === 0) {
            vaccinationList.innerHTML = `<p class="text-sm text-gray-400 text-center">No vaccinations recorded.</p>`;
            return;
        }

        let latestVaccine = vaccinations.sort(
            (a, b) =>
                new Date(b.date_administered) - new Date(a.date_administered)
        )[0];

        let vaccineHTML = `<ol class="relative border-l border-gray-700">`;
        vaccinations.forEach((vaccine, index) => {
            let isLatest =
                vaccine.id === latestVaccine.id
                    ? `<span class="ml-2 bg-blue-500 text-xs px-2 py-1 text-white rounded">Latest</span>`
                    : "";

            vaccineHTML += `
            <li class="mb-4 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 text-white text-center ring-8 ring-white dark:ring-gray-900 bg-primary-dark dark:bg-primary-light">
                    <i class="fa-solid fa-shield-virus"></i>
                </span>
                <div class="p-2 rounded-lg shadow">
                    <h3 class="mb-1 text-lg font-semibold flex items-center justify-between">
                        ${vaccine.vaccine_name} ${isLatest}
                    </h3>
                    <time class="block mb-2 text-sm font-normal text-gray-400">
                        <strong>Administered: </strong>${new Date(
                            vaccine.date_administered
                        ).toLocaleDateString("en-US", {
                            month: "long",
                            day: "2-digit",
                            year: "numeric",
                        })}
                    </time>
                    <p class="text-sm text-gray-400"><strong>Next Due: </strong>${new Date(
                        vaccine.next_due_date
                    ).toLocaleDateString("en-US", {
                        month: "long",
                        day: "2-digit",
                        year: "numeric",
                    })}</p>
                    <p class="text-sm text-gray-400"><strong>Attending Vet: </strong>Dr. ${
                        vaccine.veterinarian
                            ? vaccine.veterinarian.Fname +
                              " " +
                              vaccine.veterinarian.Lname
                            : "Unknown"
                    }</p>
                </div>
            </li>
        `;
        });
        vaccineHTML += `</ol>`;
        vaccinationList.innerHTML = vaccineHTML;
    };

    // Initialize Swiper
    const swiper = new Swiper(".swiper-container", {
        direction: "horizontal",
        slidesPerView: 3,
        spaceBetween: 10,
        centeredSlides: true,
        grabCursor: true,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true, // Allow clicking on dots to navigate
        },
        on: {
            slideChange: function () {
                const activeSlide = this.slides[this.activeIndex];
                const petData = JSON.parse(activeSlide.dataset.pet);
                updatePetDetails(petData);
            },
        },
    });

    // Load initial pet details
    const initialPetData = JSON.parse(
        swiper.slides[swiper.activeIndex].dataset.pet
    );
    updatePetDetails(initialPetData);
});
