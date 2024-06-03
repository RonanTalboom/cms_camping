<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM medewerkers WHERE medewerkerID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('medewerker has been Deleted successfully');</script>";
    header("location:medewerkers.php");
}

?>
