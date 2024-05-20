<?php 

session_start();
if($_SESSION['id']){
    header("location:dashboard.php");
} else {
    header("location:login.php");
}

?>