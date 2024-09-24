<?php
include '../models/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM laptops WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    header('Location: ../views/admin_CrudOperation.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
