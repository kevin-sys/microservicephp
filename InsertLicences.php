<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');

// Validar y sanear los datos recibidos
$FechaAdquisicion = filter_input(INPUT_POST, 'FechaAdquisicion', FILTER_SANITIZE_STRING);
$FechaExpiracion = filter_input(INPUT_POST, 'FechaExpiracion', FILTER_SANITIZE_STRING);
$OrdenCompra = filter_input(INPUT_POST, 'OrdenCompra', FILTER_SANITIZE_STRING);
$FacturaNumero = filter_input(INPUT_POST, 'FacturaNumero', FILTER_SANITIZE_STRING);
$ClaveLicencia = filter_input(INPUT_POST, 'ClaveLicencia', FILTER_SANITIZE_STRING);
$Proveedor = filter_input(INPUT_POST, 'Proveedor', FILTER_SANITIZE_STRING);
$CantidadEquipos = filter_input(INPUT_POST, 'CantidadEquipos', FILTER_VALIDATE_INT);
$PrecioLicencia = filter_input(INPUT_POST, 'PrecioLicencia', FILTER_VALIDATE_FLOAT);
$Descripcion = filter_input(INPUT_POST, 'Descripcion', FILTER_SANITIZE_STRING);

// Verificar si los datos son válidos
if (
    $FechaAdquisicion &&
    $FechaExpiracion &&
    $OrdenCompra &&
    $FacturaNumero &&
    $ClaveLicencia &&
    $Proveedor &&
    $CantidadEquipos !== false &&
    $PrecioLicencia !== false &&
    $Descripcion 
) {

    // Consulta SQL preparada para la inserción de datos
    $query = "INSERT INTO licencias (FechaAdquisicion, FechaExpiracion, OrdenCompra, FacturaNumero, ClaveLicencia, Proveedor, CantidadEquipos, PrecioLicencia, Descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $connect->prepare($query)) {
        // Vincular parámetros y sus tipos
        $stmt->bind_param("ssssssiss", $FechaAdquisicion, $FechaExpiracion, $OrdenCompra, $FacturaNumero, $ClaveLicencia, $Proveedor, $CantidadEquipos, $PrecioLicencia, $Descripcion);

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            echo json_encode(array('status' => 'success', 'message' => 'Licencia registrada con éxito.'));
        } else {
            // Hubo un error en la inserción
            echo json_encode(array('status' => 'error', 'message' => 'Error al registrar la licencia: ' . $stmt->error));
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
