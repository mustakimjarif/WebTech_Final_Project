// Function to show the selected section
function showSection(section) {
  var sections = document.getElementsByClassName("form-section");
  for (var i = 0; i < sections.length; i++) {
    sections[i].classList.remove("active");
  }
  document.getElementById(section).classList.add("active");
  document.getElementById("main-heading").innerText = section.replace("-", " ").toUpperCase();

  if (section === 'profile') {
    // Fetch profile data via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../controller/getProfileData.php", true);
    
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const profileData = JSON.parse(xhr.responseText);
        // Populate the profile fields
        document.getElementById("user-id").value = profileData.id;
        document.getElementById("email").value = profileData.email;
        document.getElementById("phone").value = profileData.phone;
        document.getElementById("full-name").value = profileData.name;
        // Add any additional fields here
      }
    };
    xhr.send();
  }
}

function changePassword(form) {
  const currentPassword = form.current_password.value;
  const newPassword = form.new_password.value;
  const email = "<?php echo htmlspecialchars($email); ?>"; // Correct PHP variable usage

  const currentPasswordError = document.getElementById("cCurrentpasserr");
  const newPasswordError = document.getElementById("cNewpasserr");

  // Clear previous error messages
  currentPasswordError.innerHTML = "";
  newPasswordError.innerHTML = "";

  let isFormValid = true;

  if (currentPassword.trim() === "") {
      currentPasswordError.innerHTML = "Current password is required.";
      isFormValid = false;
  }

  if (newPassword.trim() === "") {
      newPasswordError.innerHTML = "New password is required.";
      isFormValid = false;
  } else if (newPassword.trim() === currentPassword.trim()) {
      newPasswordError.innerHTML = "New password cannot be the same as the current password.";
      isFormValid = false;
  }

  if (isFormValid) {
      // Use AJAX to check the current password
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../controller/checkCurrentPasswordAction.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
              const response = xhr.responseText.trim(); // Trim the response

              if (response === "match") {
                  // If the current password is correct, submit the form
                  form.submit();
              } else if (response === "incorrect") {
                  currentPasswordError.innerHTML = "Current password is incorrect.";
              } else {
                  currentPasswordError.innerHTML = "An unexpected error occurred.";
              }
          }
      };

      // Send the request
      xhr.send(`email=${encodeURIComponent(email)}&current_password=${encodeURIComponent(currentPassword)}`);
  }

  return false; // Prevent form submission until checks are done
}

function toggleEdit() {
  const editButton = document.getElementById("editButton");
  const saveButton = document.getElementById("saveButton");
  const fields = document.querySelectorAll("#profileForm input[type='text']");

  // Toggle readOnly and button visibility
  const isEditable = fields[1].readOnly; // Check if the fields are currently editable

  fields.forEach(field => {
      if (field.id !== "user-id") {
          field.readOnly = !isEditable; // Toggle readOnly
      }
  });

  // Toggle button text and visibility
  if (isEditable) {
      editButton.innerText = "Cancel";
      editButton.style.backgroundColor = "red"; // Change to red
      saveButton.style.display = "inline-block"; // Show save button

      const hiddenSpans = document.querySelectorAll("#profileForm span");
      hiddenSpans.forEach(span => {
          span.style.display = "inline"; // Make the span visible
      });
  } else {
      editButton.innerText = "Edit Profile";
      editButton.style.backgroundColor = ""; // Reset to original color
      saveButton.style.display = "none"; // Hide save button

      const hiddenSpans = document.querySelectorAll("#profileForm span");
      hiddenSpans.forEach(span => {
          span.style.display = "none"; // Make the span visible
          span.innerHTML = ""; // Clear any error messages
      });

      if (!isEditable) {
        fetchProfileData(); // Refresh profile data
      }
  }
}

function fetchProfileData() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "../controller/getProfileData.php", true);
  
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          const profileData = JSON.parse(xhr.responseText);
          // Populate the profile fields
          document.getElementById("user-id").value = profileData.id;
          document.getElementById("email").value = profileData.email;
          document.getElementById("phone").value = profileData.phone;
          document.getElementById("full-name").value = profileData.name;
      }
  };
  xhr.send();
}

function updateProfile(form) {
  event.preventDefault(); // Prevent default form submission

  const email = form.email.value.trim();
  const phone = form.phone.value.trim();
  const fullName = form.full_name.value.trim();

  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");
  const nameError = document.getElementById("nameError");

  // Clear previous error messages
  emailError.innerHTML = "";
  phoneError.innerHTML = "";
  nameError.innerHTML = "";

  // Create an AJAX request
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../controller/JSupdateProfileAction.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Handle the response
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);

          // Handle success or errors
          if (response.success) {
              alert("Profile updated successfully!");
              location.reload(); // Reload the profile section
          } else {
              // Display the single error message
              const errorMessage = response.error; // Changed to response.error
              if (errorMessage) {
                  // Display appropriate error message based on its content
                  if (errorMessage.includes("Email")) {
                      emailError.innerHTML = errorMessage;
                  } else if (errorMessage.includes("Phone")) {
                      phoneError.innerHTML = errorMessage;
                  } else if (errorMessage.includes("Full name")) {
                      nameError.innerHTML = errorMessage;
                  } else {
                      // Handle any other general errors
                      nameError.innerHTML = errorMessage; // Or choose an appropriate error display
                  }
              }
          }
      }
  };

  // Send the request with the data
  xhr.send(`email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&full_name=${encodeURIComponent(fullName)}`);
}
