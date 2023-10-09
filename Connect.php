<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "kevin"; // Nombre de usuario de la base de datos
$password = "kevin"; // Contraseña de la base de datos
$database = "idreec"; // Nombre de la base de datos

// Crear una conexión
$connect = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($connect->connect_error) {
    die("Error de conexión: " . $connect->connect_error);
}

// Establecer el juego de caracteres a UTF-8 (opcional)
$connect->set_charset("utf8");

// Si necesitas cerrar la conexión en algún momento, puedes hacerlo con:
// $connect->close();
?>
