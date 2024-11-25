<?php
// Incluir la conexión a la base de datos
include('config/db.php');
session_start();

// Consulta para obtener todos los registros de la tabla
$query = "SELECT CUIT, RAZON, FECHA, ESTADO FROM registro_razon";
$result_registro = mysqli_query($conn, $query);

if (!$result_registro) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razones Sociales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/stylo.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Para la lupa -->
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Tabla Registro Razón</h1>
        <a href="registro.php" class="btn btn-primary btn-lg">Agregar CUIT</a>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por razón" style="max-width: 300px;">
        <button class="btn btn-light" style="margin-left: -40px; z-index: 1;">
            <i class="fas fa-search"></i>
        </button>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>CUIT</th>
                <th>Razón</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php while ($row = mysqli_fetch_assoc($result_registro)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['CUIT']); ?></td>
                    <td><?php echo htmlspecialchars($row['RAZON']); ?></td>
                    <td><?php echo htmlspecialchars($row['FECHA']); ?></td>
                    <td><?php echo $row['ESTADO'] ? 'Activo' : 'Inactivo'; ?></td>
                    <td>
                        <a href="change_status.php?cuit=<?php echo $row['CUIT']; ?>&estado=<?php echo $row['ESTADO'] ? '0' : '1'; ?>" class="btn btn-<?php echo $row['ESTADO'] ? 'warning' : 'success'; ?> btn-sm"><?php echo $row['ESTADO'] ? 'Desactivar' : 'Activar'; ?></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        table = document.querySelector('.table');
        tr = table.getElementsByTagName('tr');

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName('td')[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
</script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
