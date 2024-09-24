<?php
session_start();
include '../models/usersData.php'; // Adjust path as needed

if (isset($_COOKIE['user'])) {
    $email = htmlspecialchars($_COOKIE['user']);
    $userDetails = getUserDetailsByEmail($email);
    
    if ($userDetails) {
        echo json_encode($userDetails);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'No user cookie set']);
}
