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
    $fecha = isset($_GET['fecha']) && is_string($_GET['fecha']) ? $_GET['fecha'] : "2000-01-01";
    if ($_SESSION['usuario']["rol"] == 1) {
        $id_empleado = -1;
    } else {
        $id_empleado = $_SESSION['usuario']["id_empleado"];
    }

    $result = $Ventas->getVentasXProductoXFecha($id_empleado, $id_producto, $fecha);
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

        <!-- Tabla de clientes responsive -->
        <div class="table-responsive">
            <!-- Tabla de clientes -->
            <table class="table table-bordered table-striped caption-top">
                <thead class="table-principal">
                    <tr>
                        <th class="text-center">
                            <?php if ($id_producto == -1): echo "Producto";
                            else: echo "<a href='reporte_ventas_x_productos_fecha.php?fecha=$fecha' class='btn btn-link btn-sm'>Producto <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                            endif; ?>
                        </th>
                        <th class="text-center">
                            <?php if ($fecha == "2000-01-01"): echo "Fecha";
                            else: echo "<a href='reporte_ventas_x_productos_fecha.php?id_producto=$id_producto' class='btn btn-link btn-sm'>Fecha <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                            endif; ?>
                        </th>
                        <th class="text-center">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a href="reporte_ventas_x_productos_fecha.php?id_producto=<?php echo $row['id_producto'] ?>&fecha=<?php echo $fecha ?>" class="btn btn-link btn-sm"><?php echo $row['descripcion']; ?></a>
                            </td>
                            <td class="text-center">
                                <a href="reporte_ventas_x_productos_fecha.php?id_producto=<?php echo $id_producto ?>&fecha=<?php echo $row['fecha'] ?>" class="btn btn-link btn-sm">
                                    <?php
                                    $timestamp = strtotime($row['fecha']);
                                    echo date('d/m/Y', $timestamp);
                                    ?>
                                </a>
                            </td>
                            <td class="text-end"><?php echo $row['cantidad']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>