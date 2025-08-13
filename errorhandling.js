// Wait until the entire DOM is loaded before executing the script
document.addEventListener("DOMContentLoaded", function () {
    // Select the form element
    const form = document.querySelector("form");
    // Select input fields by their IDs
    const name = document.getElementById("name");
    const phone = document.getElementById("phone");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
// Check if an error message label already exists within the parent element
    function displayError(inputField, message) {
        let errorDiv = inputField.parentElement.querySelector(".error-message");
        if (!errorDiv) {
            errorDiv = document.createElement("label");// Create a new label element for the error message
            errorDiv.classList.add("error-message");// Add a class for styling
            inputField.parentElement.appendChild(errorDiv);// Append the error label to the input's parent element
        }
        errorDiv.innerText = message;// Update the error message text
    }
//Function to remove all error messages displayed on the form
    function clearErrors() {
        // Select all elements with the "error-message" class and remove them 
        document.querySelectorAll(".error-message").forEach(el => el.remove());
    }
   /**
 * Event listener for form submission
 * Prevents submission if validation errors are detected
 */
    form.addEventListener("submit", function (event) {
        let errors = false;// Variable to track if any errors exist

        clearErrors(); // Remove previous errors before new validation

        // Name validation
        if (name.value.trim() === "") {
            displayError(name, "Name is required.");
            errors = true;
        }

        // Phone validation
        if (phone.value.trim() === "") {
            displayError(phone, "Phone number is required.");
            errors = true;
        } else {
            const phonePattern = /^\+?[0-9]{10,15}$/;
            if (!phonePattern.test(phone.value.trim())) {
                displayError(phone, "Enter a valid phone number (10-15 digits).");
                errors = true;
            }
        }

        // Email validation
        if (email.value.trim() === "") {
            displayError(email, "Email is required.");
            errors = true;
        } else {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email.value.trim())) {
                displayError(email, "Enter a valid email address.");
                errors = true;
            }
        }

        // Password validation
        if (password.value.length < 8) {
            displayError(password, "Password must be at least 8 characters long.");
            errors = true;
        }

        // Confirm password validation
        if (password.value !== confirmPassword.value) {
            displayError(confirmPassword, "Passwords do not match.");
            errors = true;
        }

        // Prevent form submission if errors exist
        if (errors) {
            event.preventDefault();
        }
    });

    // Password visibility toggle
    const eyeIcon = document.getElementById("eye");
    eyeIcon.addEventListener("click", function () {
        if (password.type === "password") {
            password.type = "text";
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            password.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const phone = document.getElementById("phone");

    phone.addEventListener("input", function () {
        // Remove any non-numeric characters (except + for country codes)
        phone.value = phone.value.replace(/[^0-9+]/g, "");

        // Show error if invalid input is detected
        const phonePattern = /^\+?[0-9]{10,15}$/;
        if (!phonePattern.test(phone.value.trim())) {
            phone.setCustomValidity("Enter a valid phone number (10-15 digits, numbers only).");
            phone.reportValidity(); // Shows error message on hover
        } else {
            phone.setCustomValidity(""); // Removes error when correct input is entered
        }
    });
});
function showWarning() {
    document.getElementById("warningModal").style.display = "block";
}

function redirectToRegister() {
    window.location.href = "form.html"; // Redirects to registration page
}


