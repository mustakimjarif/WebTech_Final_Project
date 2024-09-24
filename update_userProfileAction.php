<?php
session_start();
include '../models/usersData.php'; // Assuming this is where your database functions are

// Clear previous error messages
unset($_SESSION['emailError'], $_SESSION['phoneError'], $_SESSION['nameError'], $_SESSION['generalError']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $newEmail = $_POST['email'] ?? '';
    $newPhone = $_POST['phone'] ?? '';
    $newName = $_POST['full_name'] ?? '';
    
    // Flag for validation success
    $isValid = true;

    // Check if fields are empty
    if (empty($newEmail)) {
        $_SESSION['emailError'] = "Email is required.";
        $isValid = false;
    }

    if (empty($newPhone)) {
        $_SESSION['phoneError'] = "Phone number is required.";
        $isValid = false;
    }

    if (empty($newName)) {
        $_SESSION['nameError'] = "Full name is required.";
        $isValid = false;
    }

    // Email format validation
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailError'] = "Invalid email format.";
        $isValid = false;
    }

    // Phone format validation (assumed to be digits only, adjust regex as needed)
    if (!preg_match('/^[0-9]{10,15}$/', $newPhone)) {
        $_SESSION['phoneError'] = "Invalid phone number format. It should be 10-15 digits long.";
        $isValid = false;
    }

    // If validation failed, redirect back to the profile section
    if (!$isValid) {
        header('Location: ../views/HomePage.php#profile');
        exit();
    }

    // Fetch user ID and current details using the email stored in cookie
    if (isset($_COOKIE['user'])) {
        $currentEmail = $_COOKIE['user']; // Assuming the email is stored in 'user' cookie
        $userData = getUserDetailsByEmail($currentEmail); // Fetch user details from database

        if ($userData) {
            $userId = $userData['id'];
            $oldEmail = $userData['email'];
            $oldPhone = $userData['phone'];

            // Check if the old and new email/phone are the same
            if ($newEmail === $oldEmail) {
                $_SESSION['emailError'] = "New email cannot be the same as the current email.";
                $isValid = false;
            }

            if ($newPhone === $oldPhone) {
                $_SESSION['phoneError'] = "New phone number cannot be the same as the current phone number.";
                $isValid = false;
            }

            if (!$isValid) {
                header('Location: ../views/HomePage.php#profile');
                exit();
            }

            // Check if the new email or phone number already exists in the database
            if (isEmailExist($newEmail) && $newEmail !== $oldEmail) {
                $_SESSION['emailError'] = "This email is already registered.";
                $isValid = false;
            }

            if (isPhoneExist($newPhone) && $newPhone !== $oldPhone) {
                $_SESSION['phoneError'] = "This phone number is already registered.";
                $isValid = false;
            }

            if (!$isValid) {
                header('Location: ../views/HomePage.php#profile');
                exit();
            }

            // If everything is valid, proceed to update the user's details
            $updateStatus = updateUserProfile($userId, $newEmail, $newPhone, $newName);
            if ($updateStatus) {
                // Update successful, set a success message or redirect as needed
                $_SESSION['successMessage'] = "Profile updated successfully!";
                setcookie('user', $newEmail, time() + (86400 * 30), "/"); // Update the cookie to reflect the new email
            } else {
                $_SESSION['generalError'] = "Failed to update profile. Please try again.";
            }
        } else {
            $_SESSION['generalError'] = "User not found.";
        }
    } else {
        $_SESSION['generalError'] = "No user is logged in.";
    }
} else {
    $_SESSION['generalError'] = "Invalid request method.";
}

header('Location: ../views/HomePage0.php#profile');
exit();
?>
