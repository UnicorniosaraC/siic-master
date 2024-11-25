<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Razón Social</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/stylo.css" rel="stylesheet">
    <style>
        .register-container {
            background-color: #fff8e1;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
        }
        .register-container h2 {
            color: #d47500;
        }
        .form-label {
            color: #d47500;
        }
        .btn-success {
            background-color: #4caf50;
            border-color: #4caf50;
            color: white;
        }
        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        footer {
            background-color: #fff8e1; /* Color de fondo beige */
            padding: 10px 0; /* Menor padding para reducir el tamaño del footer */
        }

        footer .container {
            display: flex;
            justify-content: center; /* Centrar el texto horizontalmente */
            align-items: center; /* Centrar el texto verticalmente */
            height: 50px; /* Ajustar la altura del contenedor */
        }

        footer p {
            margin: 0; /* Eliminar márgenes del párrafo */
            font-size: 14px; /* Reducir el tamaño de la fuente */
            color: #6c757d; /* Color del texto */
            text-align: center; /* Centrar el texto */
        }
    </style>
</head>
<body>
<div class="container register-container">
    <h2 class="text-center">Registrar Razón Social</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <form action="registro_razon.php" method="POST">
        <div class="mb-3">
            <label for="cuit" class="form-label">CUIT</label>
            <input type="text" id="cuit" name="cuit" class="form-control" placeholder="Ingrese el CUIT" required>
        </div>
        <div class="mb-3">
            <label for="razon" class="form-label">Razón</label>
            <input type="text" id="razon" name="razon" class="form-control" placeholder="Nombre Completo" required>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="" disabled selected>Seleccione el estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success w-100">Registrar</button>
        </div>
    </form>
</div>

<footer class="footer mt-5 p-3">
    <div class="container">
        <p class="text-muted">© 2024 - Todos los derechos reservados | Desarrollado por Gobierno de San Juan</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
