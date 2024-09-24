<?php
session_start();
session_destroy();
setcookie("user", "", time() - 100, "/");
setcookie("forgotEmail", "", time() - 100, "/");

header("Location: ../views/SignIn_page.php");
exit();
?>