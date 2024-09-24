<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="css/SignUp.css">

  <!-- Link to external JavaScript file -->
  <script src="js/SignUp_page.js"></script>

  <!-- jQuery CDN for AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- AJAX to check if email already exists -->
  <script>
    $(document).ready(function () {
      $('#email').on('blur', function () {
        var email = $(this).val();

        $.ajax({
          type: "POST",
          url: "../controllers/email_checkingAction.php",
          data: { email: email },
          dataType: "json",
          success: function (response) {
            if (response.exists) {
              $('#remailerr').text('Email already exists.');
            } else {
              $('#remailerr').text('');
            }
          }
        });
      });
    });
  </script>
</head>

<body>
  <div class="container">
    <form action="../controllers/SignUp_Action.php" method="POST" novalidate onsubmit="return isValid(this)"
      class="registration-form">
      <h2>Register</h2>

      <!-- Full Name -->
      <label for="username">Userame</label>
      <input type="text" id="username" name="username" required>
      <span id="rnameerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>

      <!-- Email -->
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <span id="remailerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>

      <!-- Phone Number -->
      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
      <span id="rphoneerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>



      <!-- Gender -->
      <label for="gender">Gender</label>
      <div class="gender-selection">
        <label for="male">
          <input type="radio" id="male" name="gender" value="male" checked required> Male
        </label>
        <label for="female">
          <input type="radio" id="female" name="gender" value="female" required> Female
        </label>
      </div>

      <!-- Password -->
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <span id="rpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>

      <!-- Confirm Password -->
      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <span id="rcpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>

      <!-- Submit Button -->
      <button type="submit">Register</button>

      <!-- Error Message -->
      <p class="error-message" style="color: red; font-size: 12px; text-align: center;">
        <?php echo empty($_SESSION["error"]) ? "" : $_SESSION["error"]; ?>
      </p>

      <!-- Link to Login Page -->
      <p class="login-text">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>

</html>
