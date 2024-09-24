<?php
session_start();
require '../models/usersData.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $email = sanitize($_COOKIE['user']); // Use the email from the cookie

    $current_password = sanitize($_POST['current_password']);

    // Get user details by email
    $userDetails = getUserDetailsByEmail($email);

    // Check if current password matches
    if ($current_password === $userDetails['password']) 
    {
        echo "match"; // Correct password
    } 
    else 
    {
        echo "incorrect"; // Incorrect password
    }
}

function sanitize($data) 
{
    return htmlspecialchars(stripslashes(trim($data)));
}
