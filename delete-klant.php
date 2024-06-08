<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();

if (isset($_GET["id"])) {
    $klant_id = $_GET["id"];
    
    $query = "SELECT * FROM boekingen WHERE klant_id=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $klant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $query = "DELETE FROM boekingen WHERE id=?";
            $stmt = $conn->prepare($query);
            $rc = $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $query = "DELETE FROM boeking_tarieven WHERE id=?";
            $stmt = $conn->prepare($query);
            $rc = $stmt->bind_param("i", $id);
            $stmt->execute();
        
            $query = "DELETE FROM plaats_boekingen WHERE boeking_id=?";
            $stmt = $conn->prepare($query);
            $rc = $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
    $query = "DELETE FROM klant WHERE id=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("i", $klant_id);
    $stmt->execute();
    echo "<script>alert('klant has been Deleted successfully');</script>";
    header("location:klanten.php");
}

?>
