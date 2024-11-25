  <?ph
 // include('config/db.php');
 // session_start(); 

  /*
if (isset($_GET['cuit'])) {
    $cuit = $_GET['cuit'];

    try {
        $sql = "DELETE FROM registro_razon WHERE CUIT = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $cuit);
            if ($stmt->execute()) {
                $_SESSION['success'] = 'CUIT eliminado con éxito.';
            } else {
                $_SESSION['error'] = 'Error al eliminar el CUIT.';
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = 'Error en la preparación de la consulta: ' . $conn->error;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }

    header('Location: index.php');
    exit();
}
?>
