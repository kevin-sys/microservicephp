<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');

// Validar y sanear los datos recibidos
$FechaIngreso = filter_input(INPUT_POST, 'FechaIngreso', FILTER_SANITIZE_STRING);
$OrdenCompra = filter_input(INPUT_POST, 'OrdenCompra', FILTER_SANITIZE_STRING);
$Estado = filter_input(INPUT_POST, 'Estado', FILTER_SANITIZE_STRING);
$Proveedor = filter_input(INPUT_POST, 'Proveedor', FILTER_SANITIZE_STRING);
$FacturaNumero = filter_input(INPUT_POST, 'FacturaNumero', FILTER_SANITIZE_STRING);
$Descripcion = filter_input(INPUT_POST, 'Descripcion', FILTER_SANITIZE_STRING);
$Marca = filter_input(INPUT_POST, 'Marca', FILTER_SANITIZE_STRING);
$Modelo = filter_input(INPUT_POST, 'Modelo', FILTER_SANITIZE_STRING);
$Capacidad = filter_input(INPUT_POST, 'Capacidad', FILTER_SANITIZE_STRING);
if ($Capacidad=="") {
    $Capacidad = "No aplica";
}

// Verificar si los datos son válidos
if (
    $FechaIngreso && $OrdenCompra && $Estado && $Proveedor && $FacturaNumero &&
    $Descripcion && $Marca && $Modelo && $Capacidad
) {
    // Convertir los campos a mayúsculas
    $FechaIngreso = strtoupper($FechaIngreso);
    $OrdenCompra = strtoupper($OrdenCompra);
    $Estado = strtoupper($Estado);
    $Proveedor = strtoupper($Proveedor);
    $FacturaNumero = strtoupper($FacturaNumero);
    $Descripcion = strtoupper($Descripcion);
    $Marca = strtoupper($Marca);
    $Modelo = strtoupper($Modelo);
    $Capacidad = strtoupper($Capacidad);

    // Consulta SQL preparada para la inserción de datos
    $query = "INSERT INTO activos (FechaIngreso, OrdenCompra, Estado, Proveedor, FacturaNumero, Descripcion, Marca, Modelo, Capacidad) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $connect->prepare($query)) {
        // Vincular parámetros y sus tipos
        $stmt->bind_param(
            "sssssssss",
            $FechaIngreso,
            $OrdenCompra,
            $Estado,
            $Proveedor,
            $FacturaNumero,
            $Descripcion,
            $Marca,
            $Modelo,
            $Capacidad
        );

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
