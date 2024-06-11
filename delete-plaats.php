<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM plaatsen WHERE id=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('plaats has been Deleted successfully');</script>";
    header("location:plaatsen.php");
}

?>
