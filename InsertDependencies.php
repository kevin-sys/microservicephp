<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');
// Validar y sanear los datos recibidos

$Nombre = filter_input(INPUT_POST, 'Nombre', FILTER_SANITIZE_STRING);
$Descripcion = filter_input(INPUT_POST, 'Descripcion', FILTER_SANITIZE_STRING);
$CorreoContacto = filter_input(INPUT_POST, 'CorreoContacto', FILTER_SANITIZE_EMAIL);

// Verificar si los datos son válidos
if ($Nombre && $Descripcion && $CorreoContacto && filter_var($CorreoContacto, FILTER_VALIDATE_EMAIL)) {
    // Convertir los campos a mayúsculas
    $Nombre = strtoupper($Nombre);
    $Descripcion = strtoupper($Descripcion);

    // Consulta SQL preparada para la inserción de datos
    $query = "INSERT INTO dependencias (Nombre, Descripcion, CorreoContacto) VALUES (?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $connect->prepare($query)) {
        // Vincular parámetros y sus tipos
        $stmt->bind_param("sss", $Nombre, $Descripcion, $CorreoContacto);

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            echo json_encode(array('status' => 'success', 'message' => 'Registro exitoso'));
        } else {
            // Hubo un error en la inserción
            echo json_encode(array('status' => 'error', 'message' => 'Error al registrar los datos: ' . $stmt->error));
        }

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        // Hubo un error en la preparación de la consulta
        echo json_encode(array('status' => 'error', 'message' => 'Error al preparar la consulta: ' . $connect->error));
    }
} else {
    // Datos no válidos
    echo json_encode(array('status' => 'error', 'message' => 'Los datos ingresados no son válidos.'));
}

// Cerrar la conexión a la base de datos
$connect->close();
?>
