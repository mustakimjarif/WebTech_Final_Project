<?php
session_start();
require "../models/usersData.php";

// Initialize variables
$_SESSION["login_page_error"] = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and validate form inputs
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION["login_page_error"] = "All fields are required.";
        header("Location: ../views/SignIn_page.php");
    } else {
        $result = dbResponse($email, $password);

        // Check if email exists
        if ($result->num_rows == 0) {
            $_SESSION["login_page_error"] = "Invalid email or password.";
            header("Location: ../views/SignIn_page.php");
        } else {
            // Create a cookie with 30 days validity
            setcookie("user", $email, time() + (30 * 24 * 60 * 60), "/");

            // Redirect to dashboard
            header("Location: ../views/HomePage.php");
        }
    }
}

// Function to sanitize input
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>