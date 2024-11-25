<?php
include('config/db.php');
session_start();

if (isset($_GET['cuit']) && isset($_GET['estado'])) {
    $cuit = $_GET['cuit'];
    $nuevoEstado = $_GET['estado'];

    try {
        $sql = "UPDATE registro_razon SET ESTADO = ? WHERE CUIT = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $nuevoEstado, $cuit);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Estado cambiado con éxito.';
        } else {
            $_SESSION['error'] = 'Error al cambiar el estado.';
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }

    header('Location: index.php');
    exit();
}
?>
