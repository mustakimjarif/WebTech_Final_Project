function isValid(form) {
  // Get the input values from the form
  const username = form.username.value.trim();
  const email = form.email.value.trim();
  const phone = form.phone.value.trim();
  const password = form.password.value.trim();
  const confirm_password = form.confirm_password.value.trim();

  // Get the error message elements
  const nameError = document.getElementById("rnameerr");
  const emailError = document.getElementById("remailerr");
  const phoneError = document.getElementById("rphoneerr");
  const passwordError = document.getElementById("rpasserr");
  const confirmPasswordError = document.getElementById("rcpasserr");

  // Clear previous error messages
  nameError.innerHTML = "";
  emailError.innerHTML = "";
  phoneError.innerHTML = "";
  passwordError.innerHTML = "";
  confirmPasswordError.innerHTML = "";

  // Flag to track if the form is valid
  let isFormValid = true;

  // Regular expression patterns
    
  const phonePattern = /^\d{10,14}$/;               // Phone number between 10 to 14 digits
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;// Basic email validation pattern
 

  // Validate username (required)
  if (username === "") {
    nameError.innerHTML = "Username is required.";
    isFormValid = false;
  }

// Define the email regex pattern

// Check if email is empty or invalid
if (email === "") {
  emailError.innerHTML = "Email is required.";
  isFormValid = false;
} else if (!emailRegex.test(email)) {
  emailError.innerHTML = "Invalid email format. Please enter a valid email (e.g., example@domain.com).";
  isFormValid = false;
}

  // Validate phone number (required and must be between 10-14 digits)
  if (phone === "") {
    phoneError.innerHTML = "Phone number is required.";
    isFormValid = false;
  } else if (!phonePattern.test(phone)) {
    phoneError.innerHTML = "Invalid phone number. It must be between 10 and 14 digits.";
    isFormValid = false;
  }

  // Validate password (required)
  if (password === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  }

  // Validate confirm password (required)
  if (confirm_password === "") {
    confirmPasswordError.innerHTML = "Confirm password is required.";
    isFormValid = false;
  }

  // Check if passwords match only when both are not empty
  if (password !== "" && confirm_password !== "" && password !== confirm_password) {
    confirmPasswordError.innerHTML = "Passwords do not match.";
    isFormValid = false;
  }

  // Return the validation result
  return isFormValid;
}
