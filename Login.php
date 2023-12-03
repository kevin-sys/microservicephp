<?php
// Archivo de conexión a la base de datos (conexion.php)
require('Connect.php');

// Inicio de la sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $usuario = $_POST['Usuario'];
    $contrasena = $_POST['Contraseña'];

    // Consulta SQL para buscar al usuario
    $sql = "SELECT * FROM usuarios WHERE Usuario = ?";

    if ($stmt = $connect->prepare($sql)) {
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verificar si el usuario existe y la contraseña es válida
        if ($user && $contrasena === $user['Contrasena']) {
            // Iniciar la sesión
            $_SESSION['Usuario'] = $user['Usuario'];

            // Crear una respuesta JSON de éxito
            $response = [
                'success' => true,
                'message' => 'Inicio de sesión exitoso'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos'
            ];
        }

        $stmt->close();
    } else {
        $response = [
            'success' => false,
            'message' => 'Error en la consulta'
        ];
    }

    // Devuelve la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = [
        'success' => false,
        'message' => 'Método no permitido'
    ];

    // Devuelve la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
