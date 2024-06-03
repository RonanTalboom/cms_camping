<?php
function check_login()
{
    if (strlen($_SESSION["id"]) == 0) {
        $_SESSION["id"] = "";
        header("Location: logout.php");
    }
} ?>

<?php function check_admin_login()
{
    if (strlen($_SESSION["admin_id"]) == 0) {
        if (strlen($_SESSION["id"]) == 0) {
            header("Location:logout.php");
        } else {
            header("Location:dashboard.php");
        }
    }
}
?>
