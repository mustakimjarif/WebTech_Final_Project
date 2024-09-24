<?php
include '../models/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pc_name = $_POST['pc_name'];
    $product_price = $_POST['product_price'];

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO laptops (pc_name, product_price) VALUES (?, ?)");
    $stmt->bind_param("sd", $pc_name, $product_price); // "sd" means string for pc_name, double for product_price

    if ($stmt->execute()) {
        echo "Record added successfully";
        // Redirect only after successful execution and prevent further output
        header("Location: ../views/admin_CrudOperation.php");
        exit(); // Ensure script stops after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
