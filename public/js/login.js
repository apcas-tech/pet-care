document.getElementById("login-form").addEventListener("submit", function (e) {
    // Get the spinner and login button
    var spinner = document.getElementById("loginButtonSpinner");
    var loginButton = document.getElementById("loginButton");

    // Prevent the form from submitting until we show the spinner
    e.preventDefault();

    // Show the spinner
    spinner.classList.remove("hidden");

    // Disable the login button while the spinner is showing
    loginButton.disabled = true;

    // Simulate form submission with a delay (this should be replaced with your actual form submission)
    setTimeout(function () {
        e.target.submit();
    }, 500); // Adjust the delay as needed
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
