<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM boekingen WHERE boekingID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $query = "DELETE FROM boeking_tarieven WHERE boekingID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();

    $query = "DELETE FROM plaats_boekingen WHERE boeking_id=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $id);
    $stmt->execute();


    echo "<script>alert('boeking has been Deleted successfully');</script>";
    header("location:boekingen.php");
}

?>
