<?php
// Start session
session_start();

// Check if the forgotEmail cookie is set
if (!isset($_COOKIE['forgotEmail'])) {
    // Redirect to login page if the cookie is not set
    header("Location: SignIn_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - New Password</title>
    <link rel="stylesheet" href="css/forgot_NewPassword.css">

    <!-- Link to external JavaScript file for validation -->
    <script src="js/forgot_NewPassword.js" defer></script>


</head>

<body>
    <div class="container">
        <form action="../controllers/newPassword_Action.php" method="POST" novalidate class="forgot-new-pass-form"
            onsubmit="return isValidNewPass(this)">
            <h2>Set New Password</h2>

            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" required>
            <span id="new-pass-err" class="error-message"></span><br>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <span id="confirm-pass-err" class="error-message"></span>

            <button type="submit">Change Password</button>

            <!-- Error message -->
            <p class="error-message">
                <?php echo empty($_SESSION["forgot_new_pass_error"]) ? "" : $_SESSION["forgot_new_pass_error"]; ?>
            </p>
        </form>
    </div>
</body>

</html>