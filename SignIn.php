<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/SignIn.css">
 
  <!-- Link to external JavaScript file -->
  <script src="js/SignIn_page.js"></script>
</head>
 
<body>
  <div class="container">
    <form action="../controllers/signIn_Action.php" method="POST" novalidate class="login-form"
      onsubmit="return isValid(this)">
      <h2>Login</h2>
 
      <label for="email">Email</label>
      <input type="text" id="email" name="email" required>
      <span id="lemailerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>
 
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <span id="lpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>
 
      <button type="submit">Login</button>
 
      <!-- Error message -->
      <p class="error-message"><?php echo empty($_SESSION["login_page_error"]) ? "" : $_SESSION["login_page_error"]; ?>
      </p>
 
      <!-- Forgot password link -->
      <p class="forgot-password-text"><a href="forgot_password.php">Forgot your Password?</a></p>
 
      <!-- Link to the registration page -->
      <p class="register-text">Don't you have an account? <a href="SignUp_page.php">Register</a></p>
    </form>
  </div>
</body>
 
</html>
