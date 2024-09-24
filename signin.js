function isValid(form) {
  // Get the input fields and error span elements
  const email = form.email.value;
  const password = form.password.value;
 
  const emailError = document.getElementById("lemailerr");
  const passwordError = document.getElementById("lpasserr");
 
  // Clear previous error messages
  emailError.innerHTML = "";
  passwordError.innerHTML = "";
 
  // Flag to track if the form is valid
  let isFormValid = true;
 
  // Check if email is empty
  if (email.trim() === "") {
    emailError.innerHTML = "Email is required.";
    isFormValid = false;
  }
 
  // Check if password is empty
  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  }
 
  // Return the validation result
  return isFormValid;
}
 
