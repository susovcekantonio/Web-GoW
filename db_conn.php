<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lv4";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
  die("Došlo je do greške: " . $connect->connect_error);
}
?>
