<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgotPass.css">
    <script src="js/forgotPassword.js" defer></script>
</head>
 
<body>
    <div class="container">
        <form action="../controllers/forgotPassword_Action.php" method="POST" novalidate class="forgot-form" id="forgotForm">
            <h2>Forgot Password</h2>
            <label for="email">Enter your email</label>
            <input type="text" id="email" name="email" required>
            <span id="femailerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>
            <button type="submit">Change Password</button>
            <p class="error-message" id="formError" style="color: red;"></p>
        </form>
        <div class="signin-link">
            <p>Remembered your password? <a href="signin.php">Sign In</a></p>
        </div>
    </div>
</body>
 
</html>