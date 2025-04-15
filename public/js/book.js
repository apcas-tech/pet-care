document.addEventListener("DOMContentLoaded", function () {
    let selectedDate = "";
    let selectedTime = "";
    let selectedPet = "";
    let selectedService = "";
    let selectedServicePrice = "";
    let selectedBranchId = "";
    let selectedBranchName = "";
    let selectedNotes = "";
    const userId = "{{ auth()->user()->id }}";

    // Scroll to top helper function
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    }

    document
        .querySelector("#branch_id")
        .addEventListener("change", function () {
            selectedBranchId = this.value; // Get the selected branch ID
            selectedBranchName = this.options[this.selectedIndex].text; // Get the selected branch name
            console.log("Selected Branch:", selectedBranchName); // Log the selected branch
            console.log("Selected Branch ID:", selectedBranchId); // Log the selected branch ID
        });

    document.querySelectorAll(".time-slot").forEach(function (slot) {
        slot.addEventListener("click", function () {
            document.querySelectorAll(".time-slot").forEach(function (s) {
                s.classList.remove("bg-primary", "text-white", "font-semibold");
                s.classList.add("bg-gray-200", "text-gray-800");
            });
            slot.classList.remove("bg-gray-200", "text-gray-800");
            slot.classList.add("bg-primary", "text-white", "font-semibold");
            selectedTime = slot.getAttribute("data-time");
        });
    });

    // Step 1 to Step 2 transition
    document.querySelector("#nextStep1").addEventListener("click", function () {
        const petId = document.querySelector("#pet_id").value;
        const serviceId = document
            .querySelector(".service-item[data-id]")
            .getAttribute("data-id");

        if (!petId || !serviceId) {
            alert("Please select both pet and service.");
            return;
        }

        selectedNotes = document.querySelector("#notes").value;

        document.querySelector("#step-1").classList.add("hidden");
        document.querySelector("#step-2").classList.remove("hidden");
        document.querySelector("#backStep2").classList.remove("hidden");

        scrollToTop(); // Scroll to top when moving to step 2
    });

    document.querySelector("#nextStep2").addEventListener("click", function () {
        selectedDate = document.querySelector("#appointmentDate").textContent;
        if (selectedDate === "No date selected" || !selectedTime) {
            showAlert("Please select both a date and time.");
            return;
        }

        // Check if the selected time slot is disabled
        const selectedTimeSlot = Array.from(
            document.querySelectorAll(".time-slot")
        ).find((slot) => slot.getAttribute("data-time") === selectedTime);
        if (selectedTimeSlot && selectedTimeSlot.disabled) {
            showToast("Please select another time slot.");
            return;
        }

        // Set the hidden fields
        document.querySelector("#appt_date").value = selectedDate;
        document.querySelector("#appt_time").value = selectedTime;

        // Get the selected branch ID directly from the select element
        selectedBranchId = document.querySelector("#branch_id").value;

        document.querySelector("#step-2").classList.add("hidden");
        document.querySelector("#step-3").classList.remove("hidden");

        // Update confirmation details
        document.querySelector("#confirmDate").textContent = selectedDate;
        document.querySelector("#confirmTime").textContent = selectedTime;
        document.querySelector("#confirmPet").textContent = selectedPet;
        document.querySelector("#confirmService").textContent = selectedService;
        document.querySelector("#confirmBranch").textContent =
            selectedBranchName;
        document.querySelector("#confirmNotes").textContent = selectedNotes;

        scrollToTop(); // Scroll to top when moving to step 3
    });

    // Service search and filter functionality with dynamic reordering
    const serviceSearchInput = document.querySelector("#service_search");
    const servicesList = document.querySelector("#services-list");
    const serviceItems = Array.from(document.querySelectorAll(".service-item"));

    serviceSearchInput.addEventListener("input", function () {
        const query = serviceSearchInput.value.toLowerCase();

        if (query.length > 0) {
            // Filter and sort services based on similarity to the input
            const filteredServices = serviceItems
                .map((item) => ({
                    element: item,
                    text: item.textContent.trim().toLowerCase(),
                    matchIndex: item.textContent
                        .trim()
                        .toLowerCase()
                        .indexOf(query),
                }))
                .filter((item) => item.matchIndex !== -1) // Only keep items that contain the query
                .sort((a, b) => a.matchIndex - b.matchIndex); // Sort by closest match (lower index appears first)

            // Clear and append sorted items to services list
            servicesList.innerHTML = ""; // Clear previous list
            filteredServices.forEach((service) =>
                servicesList.appendChild(service.element)
            );

            servicesList.classList.remove("hidden"); // Show services list
        } else {
            servicesList.classList.add("hidden"); // Hide if input is empty
        }
    });

    // Click event for selecting a service
    document.querySelectorAll(".service-item").forEach(function (item) {
        item.addEventListener("click", function () {
            selectedService = item.textContent.trim(); // Trim whitespace around service name
            selectedServicePrice = item.getAttribute("data-price"); // Retrieve service price
            selectedServiceCapacity = item.getAttribute("data-capacity");
            const serviceId = item.getAttribute("data-id"); // Retrieve service ID

            console.log("Capacity:", selectedServiceCapacity);
            // Set the selected service ID and capacity in the hidden input
            document.querySelector("#service_id").value = serviceId;
            document
                .querySelector("#service_id")
                .setAttribute("data-capacity", selectedServiceCapacity); // Set capacity

            serviceSearchInput.value = selectedService; // Display selected service
            servicesList.classList.add("hidden"); // Hide the list after selection
        });
    });

    document.querySelector("#pet_id").addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        selectedPet = selectedOption.text;

        const petProfilePic =
            selectedOption.getAttribute("data-profile-pic") ||
            "imgs/default_pet.webp";
        document.querySelector("#confirmPetProfile").src = petProfilePic;
    });

    // Back Button for Step 2
    document.querySelector("#backStep2").addEventListener("click", function () {
        document.querySelector("#step-2").classList.add("hidden");
        document.querySelector("#step-1").classList.remove("hidden");
        document.querySelector("#backStep2").classList.add("hidden");

        scrollToTop(); // Scroll to top when going back to step 1
    });

    // Back Button for Step 3
    document.querySelector("#backStep3").addEventListener("click", function () {
        document.querySelector("#step-3").classList.add("hidden");
        document.querySelector("#step-2").classList.remove("hidden");

        scrollToTop(); // Scroll to top when going back to step 2
    });

    // Show alert dialog with a custom message
    function showAlert(message, cancelUrl) {
        const alertDialog = document.getElementById("alert-dialog");
        const alertMessage = document.getElementById("alert-message");
        const alertCloseButton = document.getElementById("alert-close");
        const alertCancelButton = document.getElementById("alert-cancel");

        // Set the alert message
        alertMessage.textContent = message;

        // Assign the cancel URL to the cancel button
        alertCancelButton.setAttribute("data-url", cancelUrl);

        // Show the alert dialog
        alertDialog.classList.remove("hidden");

        // Close the alert when the OK button is clicked
        alertCloseButton.addEventListener("click", function () {
            alertDialog.classList.add("hidden");

            // Redirect to the cancel URL when OK is clicked
            window.location.href = alertCancelButton.getAttribute("data-url");
        });

        // Close the alert when the Cancel button is clicked
        alertCancelButton.addEventListener("click", function () {
            alertDialog.classList.add("hidden");
        });
    }

    // Click event for canceling the booking
    document
        .getElementById("cancelBooking")
        .addEventListener("click", function () {
            // Pass the cancel URL to the showAlert function
            showAlert("Are you sure you want to cancel the booking?", "home");
        });
});

function fetchAppointments(serviceId, selectedDate) {
    const branchId = document.querySelector("#branch_id").value; // Get the selected branch ID

    fetch(
        `get-appointments?service_id=${serviceId}&date=${selectedDate}&branch_id=${branchId}`
    )
        .then((response) => response.json())
        .then((data) => {
            console.log(data); // Log the fetched appointments

            // Get the capacity of the selected service
            const selectedServiceCapacity = document
                .querySelector("#service_id")
                .getAttribute("data-capacity");
            const timeSlots = document.querySelectorAll(".time-slot");

            // Reset all time slots to enabled
            timeSlots.forEach((slot) => {
                slot.disabled = false;
                slot.classList.remove("bg-gray-400", "text-gray-200"); // Reset styles
            });

            // Count appointments for each time slot
            const appointmentCount = {};
            data.forEach((appointment) => {
                const time = appointment.appt_time; // Assuming this is in the format "HH:MM:SS"
                appointmentCount[time] = (appointmentCount[time] || 0) + 1;
            });

            // Disable time slots based on the appointment count
            timeSlots.forEach((slot) => {
                const slotTime = slot.getAttribute("data-time");
                const count = appointmentCount[slotTime] || 0;
                if (count >= selectedServiceCapacity) {
                    slot.disabled = true; // Disable the button
                    slot.classList.add("bg-gray-400", "text-gray-200"); // Optional: Add additional styles if needed
                }
            });
        })
        .catch((error) => {
            console.error("Error fetching appointments:", error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const monthYearDisplay = document.getElementById("monthYear");
    const calendarDays = document.getElementById("calendarDays");
    const prevMonthButton = document.getElementById("prevMonth");
    const nextMonthButton = document.getElementById("nextMonth");
    const appointmentDateDisplay = document.getElementById("appointmentDate");

    let currentDate = new Date();
    const today = new Date();

    // Update the calendar display based on the current month and year
    function updateCalendar() {
        // Set month and year display
        const month = currentDate.toLocaleString("default", {
            month: "long",
        });
        const year = currentDate.getFullYear();
        monthYearDisplay.textContent = `${month} ${year}`;

        // Disable prevMonth button if it's the current month
        if (
            currentDate.getMonth() === today.getMonth() &&
            currentDate.getFullYear() === today.getFullYear()
        ) {
            prevMonthButton.disabled = true;
        } else {
            prevMonthButton.disabled = false;
        }

        // Get first and last day of the month
        const firstDayOfMonth = new Date(
            currentDate.getFullYear(),
            currentDate.getMonth(),
            1
        ).getDay();
        const daysInMonth = new Date(
            currentDate.getFullYear(),
            currentDate.getMonth() + 1,
            0
        ).getDate();

        // Clear the previous days
        calendarDays.innerHTML = "";

        // Add empty spaces for days of previous month
        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyDiv = document.createElement("div");
            calendarDays.appendChild(emptyDiv);
        }

        // Add days of the current month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = day;
            dayDiv.className =
                "cursor-pointer rounded-full text-center p-2 text-sm md:text-base dark:text-gray-100";
            dayDiv.classList.add(
                "hover:bg-blue-500",
                "hover:text-white",
                "dark:hover:bg-blue-700"
            );

            // Highlight today’s date
            if (
                day === today.getDate() &&
                currentDate.getMonth() === today.getMonth()
            ) {
                dayDiv.classList.add("bg-blue-500", "text-white");
            }

            dayDiv.addEventListener("click", function () {
                document
                    .querySelectorAll(".selected")
                    .forEach((el) =>
                        el.classList.remove(
                            "bg-primary",
                            "text-white",
                            "selected"
                        )
                    );
                dayDiv.classList.add("bg-primary", "text-white", "selected");

                // Format the date as m-d-Y with leading zero for the month
                const selectedDate = new Date(
                    currentDate.getFullYear(),
                    currentDate.getMonth(),
                    day
                );
                const formattedDate = `${String(
                    selectedDate.getMonth() + 1
                ).padStart(2, "0")}-${String(selectedDate.getDate()).padStart(
                    2,
                    "0"
                )}-${selectedDate.getFullYear()}`;

                appointmentDateDisplay.textContent = formattedDate;

                // Fetch appointments for the selected service and date
                const serviceId = document.querySelector("#service_id").value; // Get the selected service ID
                if (serviceId) {
                    fetchAppointments(serviceId, formattedDate);
                }
            });

            calendarDays.appendChild(dayDiv);
        }
    }

    // Navigate to the previous month
    prevMonthButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default button behavior
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    });

    // Navigate to the next month
    nextMonthButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default button behavior
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateCalendar();
    });

    // Initialize the calendar
    updateCalendar();
});

document.getElementById("bookingForm").addEventListener("submit", function (e) {
    // Get the spinner and signup button
    var spinner = document.getElementById("bookNowButtonSpinner");
    var bookNowButton = document.getElementById("bookNowButton");

    // Prevent the form from submitting until we show the spinner
    e.preventDefault();

    // Disable the signup button to prevent multiple submissions
    bookNowButton.disabled = true;

    // Show the spinner
    spinner.classList.remove("hidden");

    // Proceed with form submission after a slight delay (optional)
    setTimeout(function () {
        e.target.submit();
    }, 500); // Adjust the delay as needed
});
