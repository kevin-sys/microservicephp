<?php
$servername = "localhost";
$username = "kevin";
$password = "kevin"; 
$database = "idreec"; 

$connect = new mysqli($servername, $username, $password, $database);

if ($connect->connect_error) {
    die("Error de conexión: " . $connect->connect_error);
}
$connect->set_charset("utf8");

?>
