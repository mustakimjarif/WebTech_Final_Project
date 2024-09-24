<?php
session_start();
require "../models/usersData.php";

$_SESSION["error"] = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    // Collect and validate form inputs
    $email = sanitize($_POST['email']);

    $phone = sanitize($_POST['phone']);

    $username = sanitize($_POST['username']);
    $gender = sanitize($_POST['gender']);
    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);

    // Validate inputs
    if (empty($email) || empty($phone) || empty($username) || empty($gender) || empty($password) || empty($confirm_password)) {
        $_SESSION["error"] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email format.";
    } elseif (!preg_match('/^[0-9]{10,14}$/', $phone)) {
        $_SESSION["error"] = "Invalid phone number. It should contain only digits and be between 10 to 14 digits long.";
    } elseif ($password !== $confirm_password) {
        $_SESSION["error"] = "Passwords do not match.";
    } else {
        if (isEmailPhoneExist($email, $phone) > 0) {
            $_SESSION["error"] = "Email or phone number already exists.";
        } else {
            if (insertUser($email, $phone, $username, $gender, $password)) {
                header("Location: ../views/SignIn_page.php");
                exit();
            } else {
                $_SESSION["error"] = "Insert Failed: " . $conn->error;
            }
        }
    }

    // Redirect to registration page with error message
    header("Location: ../views/SignUp_page.php");
    // Close connection
    $conn->close();
    exit();

}

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>