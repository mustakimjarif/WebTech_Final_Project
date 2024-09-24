<?php
session_start();
require '../models/usersData.php'; // Ensure your model functions are included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $newEmail = sanitize($_POST['email']);
    $newPhone = sanitize($_POST['phone']);
    $newName = sanitize($_POST['full_name']);
    
    // Validate email
    if (empty($newEmail)) {
        echo json_encode(['success' => false, 'error' => 'Email is required.']);
        exit();
    }
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        exit();
    }

    // Validate phone
    if (empty($newPhone)) {
        echo json_encode(['success' => false, 'error' => 'Phone number is required.']);
        exit();
    }
    if (!preg_match('/^[0-9]{10,14}$/', $newPhone)) {
        echo json_encode(['success' => false, 'error' => 'Phone number must be between 10 to 14 digits.']);
        exit();
    }

    // Validate full name
    if (empty($newName)) {
        echo json_encode(['success' => false, 'error' => 'Full name is required.']);
        exit();
    }

    // Get current email from cookie
    $currentEmail = sanitize($_COOKIE['user']);
    
    // Fetch user details for verification
    $userDetails = getUserDetailsByEmail($currentEmail);
    
    // Check if email or phone already exists
    if ($newEmail !== $currentEmail && isEmailExist($newEmail)) {
        echo json_encode(['success' => false, 'error' => 'Email already exists.']);
        exit();
    }
    if ($newPhone !== $userDetails['phone'] && isPhoneExist($newPhone)) {
        echo json_encode(['success' => false, 'error' => 'Phone number already exists.']);
        exit();
    }

    // Update user profile
    $userId = $userDetails['id'];
    if (updateUserProfile($userId, $newEmail, $newPhone, $newName)) {
        setcookie("user", $newEmail, time() + (30 * 24 * 60 * 60), "/");
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update profile.']);
    }

    exit();
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
