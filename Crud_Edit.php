<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM laptops WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pc_name = $_POST['pc_name'];
    $product_price = $_POST['product_price'];

    $update_sql = "UPDATE laptops SET pc_name='$pc_name', product_price='$product_price' WHERE id=$id";

    if (mysqli_query($conn, $update_sql)) {
        echo "Record updated successfully";
        header("Location: ../views/admin_CrudOperation.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


