<?php
$server = "localhost";
$gebruiker = "root";
$wachtwoord = "";
$databasenaam = "camping";

 $conn = new mysqli($server, $gebruiker, $wachtwoord, $databasenaam);

if ($conn->connect_error) {
  echo "Failed to connect to MySQL: " . $conn->connect_error;
  exit();
}
?>