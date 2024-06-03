<?php
session_start();
include "../includes/config.php";
include "../includes/checklogin.php";
check_admin_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM tarieven WHERE ID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Tarief has been Deleted successfully');</script>";
    header("location:tarieven.php");
}

?>
