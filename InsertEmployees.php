<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');

// Obtener los valores del formulario y aplicar saneamiento
$Identificacion = filter_input(INPUT_POST, 'Identificacion', FILTER_SANITIZE_STRING);
$PrimerNombre = filter_input(INPUT_POST, 'PrimerNombre', FILTER_SANITIZE_STRING);
$SegundoNombre = filter_input(INPUT_POST, 'SegundoNombre', FILTER_SANITIZE_STRING);
$PrimerApellido = filter_input(INPUT_POST, 'PrimerApellido', FILTER_SANITIZE_STRING);
$SegundoApellido = filter_input(INPUT_POST, 'SegundoApellido', FILTER_SANITIZE_STRING);
$FechaNacimiento = filter_input(INPUT_POST, 'FechaNacimiento', FILTER_SANITIZE_STRING);
$Sexo = filter_input(INPUT_POST, 'Sexo', FILTER_SANITIZE_STRING);
$Celular = filter_input(INPUT_POST, 'Celular', FILTER_SANITIZE_STRING);
$Correo = filter_input(INPUT_POST, 'Correo', FILTER_SANITIZE_EMAIL);
$Cargo = filter_input(INPUT_POST, 'Cargo', FILTER_SANITIZE_STRING);
$Dependencia = filter_input(INPUT_POST, 'Dependencia', FILTER_SANITIZE_STRING);
$EstadoLaboral = filter_input(INPUT_POST, 'EstadoLaboral', FILTER_SANITIZE_STRING);

// Verificar si los datos son válidos
if (
    $Identificacion && $PrimerNombre && $PrimerApellido &&
    $FechaNacimiento && $Sexo && $Celular && $Correo &&
    $Cargo && $Dependencia && $EstadoLaboral
) {
    // Convertir los campos a mayúsculas
    $Identificacion = strtoupper($Identificacion);
    $PrimerNombre = strtoupper($PrimerNombre);
    $SegundoNombre = strtoupper($SegundoNombre);
    $PrimerApellido = strtoupper($PrimerApellido);
    $SegundoApellido = strtoupper($SegundoApellido);
    $Sexo = strtoupper($Sexo);
    $Cargo = strtoupper($Cargo);
    $Dependencia = strtoupper($Dependencia);
    $EstadoLaboral = strtoupper($EstadoLaboral);

    // Consulta SQL preparada para la inserción de datos
    $query = "INSERT INTO empleados (Identificacion, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, FechaNacimiento, Sexo, Celular, Correo, Cargo, Dependencia, EstadoLaboral) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $connect->prepare($query)) {
        // Vincular parámetros y sus tipos
        $stmt->bind_param(
            "ssssssssssss",
            $Identificacion,
            $PrimerNombre,
            $SegundoNombre,
            $PrimerApellido,
            $SegundoApellido,
            $FechaNacimiento,
            $Sexo,
            $Celular,
            $Correo,
            $Cargo,
            $Dependencia,
            $EstadoLaboral
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
