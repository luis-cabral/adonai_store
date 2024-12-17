<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Ventas.php';
$Ventas = new Ventas();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_producto = isset($_GET['id_producto']) && is_string($_GET['id_producto']) ? $_GET['id_producto'] : -1;
    if ($_SESSION['usuario']["rol"] == 1) {
        $id_empleado = -1;
    } else {
        $id_empleado = $_SESSION['usuario']["id_empleado"];
    }

    $result = $Ventas->getVentasXProductoXFecha($id_empleado, $id_producto);
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas por Fecha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .container-index {
        background: url(./assets/img/bsb-logo.webp) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        height: 100vh;
    }
</style>

<body class="container-index">
    <?php
    include_once("navbar.php")
    ?>
    <div class="container bg-white mt-3">
        <h2>Ventas de Productos por Fecha</h2>

        <!-- Tabla de productos -->
        <table class="table table-striped table-responsive mb-3">
            <thead class="table-principal">
                <tr>
                    <th>Descripcion</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><a href="reporte_ventas_x_productos_fecha.php?id_producto=<?php echo $row['id_producto'] ?>" class="btn btn-link btn-sm"><?php echo $row['descripcion']; ?></a></td>
                        <td><?php
                            $timestamp = strtotime($row['fecha']);
                            echo date('d/m/Y', $timestamp);
                            ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>