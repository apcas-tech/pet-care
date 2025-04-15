document.addEventListener("DOMContentLoaded", function () {
    // Hide email feedback message
    function hideEmailFeedback() {
        var emailFeedback = document.getElementById("email-feedback");
        setTimeout(() => {
            emailFeedback.textContent = "";
        }, 1000); // Hide feedback after 1 second
    }

    let currentStep = 1; // Initially set to the first step

    // Function to show/hide steps and update stepper
    function updateStep(step) {
        // Hide all steps
        const allSteps = document.querySelectorAll(".signup-step");
        allSteps.forEach(function (stepElement) {
            stepElement.style.display = "none";
        });

        // Show the current step
        document.getElementById("step-" + step).style.display = "block";

        // Update the stepper
        const stepperItems = document.querySelectorAll("ol li");
        stepperItems.forEach(function (stepperItem, index) {
            const stepNumber = index + 1;
            const stepSpan = stepperItem.querySelector("span");
            if (stepNumber === step) {
                // Add active class to the current step
                stepperItem.classList.add(
                    "text-blue-600",
                    "dark:text-blue-500"
                );
                stepSpan.classList.add("bg-blue-600", "text-white");
            } else {
                // Remove active class from the other steps
                stepperItem.classList.remove(
                    "text-blue-600",
                    "dark:text-blue-500"
                );
                stepSpan.classList.remove("bg-blue-600", "text-white");
            }
        });
    }

    window.nextStep = function () {
        var currentStepElement = document.querySelector(
            ".signup-step:not([style*='display: none'])"
        );
        var nextStepElement = currentStepElement.nextElementSibling;

        if (currentStepElement.id === "step-1") {
            if (validateStep1()) {
                currentStepElement.style.display = "none";
                nextStepElement.style.display = "block";
                currentStep++; // Increment current step
                updateStep(currentStep); // Update stepper to step 2
            }
        } else if (currentStepElement.id === "step-2") {
            if (validateStep2()) {
                currentStepElement.style.display = "none";
                nextStepElement.style.display = "block";
                currentStep++; // Increment current step
                updateStep(currentStep); // Update stepper to step 3
            }
        } else if (currentStepElement.id === "step-3") {
            currentStepElement.style.display = "none";
            // Assuming there is no next step after step 3
            updateStep(currentStep); // Update stepper to step 3
        }
    };

    // Move to the previous step
    window.prevStep = function () {
        var currentStepElement = document.querySelector(
            ".signup-step:not([style*='display: none'])"
        );
        var prevStepElement = currentStepElement.previousElementSibling;

        if (prevStepElement) {
            currentStepElement.style.display = "none";
            prevStepElement.style.display = "block";
            currentStep--; // Decrement current step
            updateStep(currentStep); // Update stepper to previous step
        }
    };
    // Initialize stepper with the first step
    updateStep(currentStep);

    // Check if email is in correct format
    function checkEmailFormat() {
        const emailInput = document.getElementById("email");
        const emailValue = emailInput.value;

        // Simple regex for validating email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailRegex.test(emailValue)) {
            // If the email format is correct, add a green focus ring
            emailInput.classList.remove(
                "border-gray-300",
                "focus:ring-red-500"
            );
            emailInput.classList.add("border-gray-300", "focus:ring-green-500");
        } else {
            // If the email format is incorrect, add a red focus ring
            emailInput.classList.remove(
                "border-gray-300",
                "focus:ring-green-500"
            );
            emailInput.classList.add("border-gray-300", "focus:ring-red-500");
        }
    }

    // Validate Step 1 fields
    function validateStep1() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("signup-password").value;
        var confirmPassword = document.getElementById("signup-cpassword").value;
        var strengthIndicator =
            document.getElementById("strength-indicator").style.width;

        // Check if all fields are filled
        if (!email || !password || !confirmPassword) {
            showToast("Please fill in all required fields.", "error");
            return false;
        }

        // Check if email format is valid
        checkEmailFormat(); // Call the function to check email format
        if (
            document
                .getElementById("email")
                .classList.contains("focus:ring-red-500")
        ) {
            showToast("Please enter a valid email address.", "error");
            return false;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            showToast("Passwords do not match!", "error");
            return false;
        }

        // Check if password strength is at least "Moderate"
        if (strengthIndicator.includes("30%")) {
            showToast(
                "Your password must be at least Moderate to proceed.",
                "error"
            );
            return false;
        }

        return true;
    }

    // Validate Step 2 fields
    function validateStep2() {
        var firstName = document.getElementById("first_name").value;
        var lastName = document.getElementById("last_name").value;

        if (!firstName) {
            document
                .getElementById("first_name-feedback")
                .classList.remove("hidden");
            return false;
        } else {
            document
                .getElementById("first_name-feedback")
                .classList.add("hidden");
        }

        if (!lastName) {
            document
                .getElementById("last_name-feedback")
                .classList.remove("hidden");
            return false;
        } else {
            document
                .getElementById("last_name-feedback")
                .classList.add("hidden");
        }

        return true;
    }

    // Attach functions to window for global access
    window.checkEmailFormat = checkEmailFormat;
    window.hideEmailFeedback = hideEmailFeedback;
    window.checkPasswordStrength = checkPasswordStrength;
    window.nextStep = nextStep;
    window.prevStep = prevStep;
});

function handleInputChange(input) {
    const label = input.nextElementSibling; // Get the label for the password input
    if (input.value) {
        label.classList.add("-top-4", "text-sm", "text-gray-800");
        label.classList.remove("top-2", "text-gray-500");
    } else {
        label.classList.remove("-top-4", "text-sm", "text-gray-800");
        label.classList.add("top-2", "text-gray-500");
    }
}

// Toggle password visibility
function togglePasswordVisibility(passwordFieldId, iconId) {
    var passwordField = document.getElementById(passwordFieldId);
    var icon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// Check password strength
function checkPasswordStrength() {
    const password = document.getElementById("signup-password").value;
    const strengthMessage = document.getElementById("strength-message");
    const strengthIndicator = document.getElementById("strength-indicator");
    const strengthBar = document.getElementById("password-strength");

    // Show the strength bar
    strengthBar.classList.remove("hidden");

    let strength = 0;

    // Assign weights to each criterion
    if (password.length >= 8) strength += 2; // Length criteria
    if (password.match(/[A-Z]/)) strength += 1; // Uppercase criteria
    if (password.match(/[a-z]/)) strength += 1; // Lowercase criteria
    if (password.match(/[0-9]/)) strength += 1; // Number criteria
    if (password.match(/[\W_]/)) strength += 1; // Special character criteria

    // Update strength message and indicator
    switch (true) {
        case strength <= 2:
            strengthIndicator.style.width = "30%";
            strengthIndicator.style.backgroundColor = "red";
            break;
        case strength <= 4:
            strengthIndicator.style.width = "60%";
            strengthIndicator.style.backgroundColor = "orange";
            break;
        case strength >= 5:
            strengthIndicator.style.width = "100%";
            strengthIndicator.style.backgroundColor = "green";
            break;
    }
}

// Check if passwords match
function checkPasswordMatch() {
    const passwordInput = document.getElementById("signup-password");
    const confirmPasswordInput = document.getElementById("signup-cpassword");

    const passwordValue = passwordInput.value;
    const confirmPasswordValue = confirmPasswordInput.value;

    if (passwordValue === confirmPasswordValue) {
        // If passwords match, add green focus ring
        confirmPasswordInput.classList.remove(
            "border-gray-300",
            "focus:ring-red-500"
        );
        confirmPasswordInput.classList.add(
            "border-gray-300",
            "focus:ring-green-500"
        );
    } else {
        // If passwords do not match, add red focus ring
        confirmPasswordInput.classList.remove(
            "border-gray-300",
            "focus:ring-green-500"
        );
        confirmPasswordInput.classList.add(
            "border-gray-300",
            "focus:ring-red-500"
        );
    }
}

function toggleSignupButtons() {
    const termsCheckbox = document.getElementById("terms-checkbox");
    const signupButton = document.getElementById("signup-Button");
    const googleSignupButton = document.getElementById("google-signup-button");

    // Enable or disable buttons based on checkbox state
    if (termsCheckbox.checked) {
        signupButton.removeAttribute("disabled");
        googleSignupButton.removeAttribute("disabled");
    } else {
        signupButton.setAttribute("disabled", "true");
        googleSignupButton.setAttribute("disabled", "true");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const termsCheckbox = document.getElementById("terms-checkbox");
    const signupButton = document.getElementById("signup-Button"); // Corrected ID
    const otpInput = document.getElementById("otp");

    // Only proceed if the elements exist
    if (termsCheckbox && signupButton && otpInput) {
        function toggleButtonState() {
            const isTermsChecked = termsCheckbox.checked;
            const isOtpVerified =
                otpInput.getAttribute("data-otp-verified") === "true";
            signupButton.disabled = !(isTermsChecked && isOtpVerified);
        }

        termsCheckbox.addEventListener("change", toggleButtonState);
        otpInput.addEventListener("input", toggleButtonState);
        toggleButtonState();
    }
});

//Spinner
document.getElementById("signup-form").addEventListener("submit", function (e) {
    // Get the spinner and signup button
    var spinner = document.getElementById("signupButtonSpinner");
    var signupButton = document.getElementById("signup-Button");
    var otpInput = document.getElementById("otp");

    // Prevent submission if OTP is not verified
    if (otpInput.getAttribute("data-otp-verified") !== "true") {
        alert("Please verify your OTP before submitting the form.");
        e.preventDefault(); // Prevent form submission
        return;
    }

    // Prevent the form from submitting until we show the spinner
    e.preventDefault();

    // Disable the signup button to prevent multiple submissions
    signupButton.disabled = true;

    // Show the spinner
    spinner.classList.remove("hidden");

    // Proceed with form submission after a slight delay (optional)
    setTimeout(function () {
        e.target.submit();
    }, 500); // Adjust the delay as needed
});
