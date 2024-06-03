<?php 

session_start();
if($_SESSION['id'] || $_SESSION['admin_id']){
    header("location:dashboard.php");
} else {
    header("location:login.php");
}

?>