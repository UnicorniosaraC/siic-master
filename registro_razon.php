<?php
include('config/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuit = $_POST['cuit'];
    $razon = $_POST['razon'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];

    // Preparar la declaración SQL
    $sql = "INSERT INTO registro_razon (CUIT, RAZON, FECHA, ESTADO) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param('sssi', $cuit, $razon, $fecha, $estado);

        try {
            // Ejecutar la declaración
            $stmt->execute();
            $_SESSION['success'] = "Registro agregado exitosamente.";
            header("Location: index.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            // Verificar si el error es de entrada duplicada
            if ($e->getCode() == 1062) {
                $_SESSION['error'] = "Este registro ya está registrado.";
            } else {
                $_SESSION['error'] = "Error al agregar el registro: " . $e->getMessage();
            }
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error en la preparación de la declaración: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
header("Location: registro.php");
exit();
?>
