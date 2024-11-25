<?php
include('config/db.php');
session_start();

// Predeterminar 50 registros en lugar de 10
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Consulta para contar el total de registros
$total_query = "SELECT COUNT(*) as count FROM registro_razon";
$total_result = mysqli_query($conn, $total_query);
$total_count = mysqli_fetch_assoc($total_result)['count'];

$total_pages = ceil($total_count / $limit);

// Consulta para obtener los registros con límite y desplazamiento
$query = "SELECT CUIT, RAZON, FECHA, ESTADO FROM registro_razon LIMIT $start, $limit";
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
    <img src="assets/img/logo.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 8px;">
    <h1 class="mb-0">Tabla Registro Razón</h1>
</div>

        <div class="d-flex align-items-center">
            <a href="registro.php" class="btn btn-lg btn-custom mr-3">Agregar CUIT</a>
            <button class="btn btn-lg btn-custom mr-3" id="toggleSearch">
                <i class="bi bi-search"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-lg btn-custom dropdown-toggle no-caret" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-list"></i> <!-- icono acutualizado  -->
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="?limit=25">25</a></li>
                    <li><a class="dropdown-item" href="?limit=50">50</a></li>
                    <li><a class="dropdown-item" href="?limit=100">100</a></li>
                    <li><a class="dropdown-item" href="?limit=200">200</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="searchContainer" class="d-flex justify-content-end mb-3 d-none">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por razón" style="max-width: 300px;">
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
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('toggleSearch').addEventListener('click', function() {
        var searchContainer = document.getElementById('searchContainer');
        searchContainer.classList.toggle('d-none');
    });

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
