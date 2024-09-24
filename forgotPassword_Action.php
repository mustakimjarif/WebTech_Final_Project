<?php
session_start();
require "../models/usersData.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the form input
    $email = sanitize($_POST['email']);

    // Check if email exists in the database
    $user = getUserByEmail($email); // Assuming this function checks if the email exists

    if (!$user) {
        // Email does not exist
        echo json_encode(["success" => false, "message" => "No account found with this email."]);
    } else {
        // Email exists, store email in cookie
        setcookie("forgotEmail", $email, time() + 3600, "/"); // 1 hour expiration
        echo json_encode(["success" => true, "message" => "An email has been sent to reset your password!"]);
    }
    exit(); // Ensure that no further code is executed
}

// Function to sanitize input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
