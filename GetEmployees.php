<?php
// Incluir el archivo de conexión a la base de datos
include('Connect.php');

// Consulta SQL para obtener todos los empleados
$query = "SELECT * FROM empleados"; // Reemplaza "empleados" con el nombre de tu tabla

// Ejecutar la consulta
$result = $connect->query($query);

// Verificar si la consulta se ejecutó con éxito
if ($result) {
    $employees = array();

    // Recorrer los resultados y almacenarlos en un arreglo
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    // Devolver la respuesta como JSON
    echo json_encode(array(
        'status' => 'success',
        'data' => $employees
    ));
} else {
    // En caso de error, devolver un mensaje de error
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Error al obtener los empleados'
    ));
}

// Cerrar la conexión a la base de datos
$connect->close();
?>
