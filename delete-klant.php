<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM klant WHERE klantID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('klant has been Deleted successfully');</script>";
    header("location:klanten.php");
}

?>
