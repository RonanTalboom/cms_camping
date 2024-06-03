<?php
session_start();
unset($_SESSION["admin_id"]);
unset($_SESSION["email"]);
unset($_SESSION["id"]);
session_destroy();
header("Location:index.php");
?>
