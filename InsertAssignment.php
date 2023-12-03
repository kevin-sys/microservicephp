<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');

// Validar y sanear los datos recibidos
$FechaAsignacion = filter_input(INPUT_POST, 'FechaAsignacion', FILTER_SANITIZE_STRING);
$CodigoActivo = filter_input(INPUT_POST, 'CodigoActivo', FILTER_SANITIZE_STRING);
$FechaIngreso = filter_input(INPUT_POST, 'FechaIngreso', FILTER_SANITIZE_STRING);
$OrdenCompra = filter_input(INPUT_POST, 'OrdenCompra', FILTER_SANITIZE_STRING);
$FacturaNumero = filter_input(INPUT_POST, 'FacturaNumero', FILTER_SANITIZE_STRING);
$Estado = filter_input(INPUT_POST, 'Estado', FILTER_SANITIZE_STRING);
$Proveedor = filter_input(INPUT_POST, 'Proveedor', FILTER_SANITIZE_STRING);
$Descripcion = filter_input(INPUT_POST, 'Descripcion', FILTER_SANITIZE_STRING);
$Marca = filter_input(INPUT_POST, 'Marca', FILTER_SANITIZE_STRING);
$Modelo = filter_input(INPUT_POST, 'Modelo', FILTER_SANITIZE_STRING);
$Capacidad = filter_input(INPUT_POST, 'Capacidad', FILTER_SANITIZE_STRING);
$Dependencia = filter_input(INPUT_POST, 'Dependencia', FILTER_SANITIZE_STRING);
$Identificacion = filter_input(INPUT_POST, 'Identificacion', FILTER_SANITIZE_STRING);
$Cuenta = filter_input(INPUT_POST, 'Cuenta', FILTER_SANITIZE_STRING);
$Subcuenta = filter_input(INPUT_POST, 'Subcuenta', FILTER_SANITIZE_STRING);
$PrimerNombre = filter_input(INPUT_POST, 'PrimerNombre', FILTER_SANITIZE_STRING);
$PrimerApellido = filter_input(INPUT_POST, 'PrimerApellido', FILTER_SANITIZE_STRING);




// Verificar si los datos son válidos
if (
    $FechaAsignacion && $CodigoActivo && $FechaIngreso && $OrdenCompra && $FacturaNumero &&
    $Estado && $Proveedor && $Descripcion && $Marca && $Modelo && $Capacidad &&
    $Dependencia && $Identificacion && $Cuenta && $Subcuenta && $PrimerNombre &&$PrimerApellido
) {
    // Convertir los campos a mayúsculas
    $FechaAsignacion = strtoupper($FechaAsignacion);
    $CodigoActivo = strtoupper($CodigoActivo);
    $FechaIngreso = strtoupper($FechaIngreso);
    $OrdenCompra = strtoupper($OrdenCompra);
    $FacturaNumero = strtoupper($FacturaNumero);
    $Estado = strtoupper($Estado);
    $Proveedor = strtoupper($Proveedor);
    $Descripcion = strtoupper($Descripcion);
    $Marca = strtoupper($Marca);
    $Modelo = strtoupper($Modelo);
    $Capacidad = strtoupper($Capacidad);
    $Dependencia = strtoupper($Dependencia);
    $Identificacion = strtoupper($Identificacion);
    $Cuenta = strtoupper($Cuenta);
    $Subcuenta = strtoupper($Subcuenta);
    $PrimerNombre = strtoupper($PrimerNombre);
    $PrimerApellido = strtoupper($PrimerApellido);


    $query = "INSERT INTO asignacion_activos (FechaAsignacion, CodigoActivo, FechaIngreso, OrdenCompra, FacturaNumero, 
       Estado, Proveedor, Descripcion, Marca, Modelo, Capacidad, Dependencia, Identificacion, Cuenta, Subcuenta,PrimerNombre, PrimerApellido) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param(
            "sssssssssssssssss",
            $FechaAsignacion,
            $CodigoActivo,
            $FechaIngreso,
            $OrdenCompra,
            $FacturaNumero,
            $Estado,
            $Proveedor,
            $Descripcion,
            $Marca,
            $Modelo,
            $Capacidad,
            $Dependencia,
            $Identificacion,
            $Cuenta,
            $Subcuenta,
            $PrimerNombre,
            $PrimerApellido
        );

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            echo json_encode(array('status' => 'success', 'message' => 'Asignación exitosa'));
        } else {
            // Hubo un error en la inserción
            echo json_encode(array('status' => 'error', 'message' => 'Error al registrar la asignación: ' . $stmt->error));
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
