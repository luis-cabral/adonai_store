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
    // Número de resultados para mostrar en cada página, si no devuelve el número de registros por página predeterminado es 5.
    $num_results_on_page = isset($_GET['nrop']) && is_numeric($_GET['nrop']) ? $_GET['nrop'] : 5;
    // Verifique si se especifica el número de página y verifique si es un número, si no devuelve el número de página predeterminado que es 1.
    $page = isset($_GET['pn']) && is_numeric($_GET['pn']) ? $_GET['pn'] : 1;

    $iprod = isset($_GET['iprod']) && is_string($_GET['iprod']) ? $_GET['iprod'] : -1;
    $iclie = isset($_GET['iclie']) && is_string($_GET['iclie']) ? $_GET['iclie'] : -1;
    $fecha = isset($_GET['fecha']) && is_string($_GET['fecha']) ? $_GET['fecha'] : "2000-01-01";

    if ($_SESSION['usuario']["rol"] == 1) {
        $iempl = isset($_GET['iempl']) && is_string($_GET['iempl']) ? $_GET['iempl'] : -1;
    } else {
        $iempl = $_SESSION['usuario']["id_empleado"];
    }

    $total_pages = $Ventas->getTotalItemsVentasReporteEmpleado($iempl, $iprod, $iclie, $fecha);
    $result = $Ventas->getVentasReporteEmpleado($iempl, $iprod, $iclie, $fecha, $page, $num_results_on_page);
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas por Empleado</title>
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
        <h2>Reporte de Ventas</h2>

        <!-- Tabla de clientes responsive -->
        <div class="table-responsive">
            <!-- Tabla de clientes -->
            <table class="table table-bordered table-striped caption-top">
                <caption>
                    <div class="btn-group">
                        <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                            Lista de <?php echo $num_results_on_page ?> Registros de <?php echo $total_pages ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                            <li><a class="dropdown-item" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                                endif; ?>pn=<?php echo $page ?>&nrop=5&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>">5</a></li>
                            <li><a class="dropdown-item" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                                endif; ?>pn=<?php echo $page ?>&nrop=10&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>">10</a></li>
                            <li><a class="dropdown-item" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                                endif; ?>pn=<?php echo $page ?>&nrop=15&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>">15</a></li>
                        </ul>
                    </div>
                </caption>
                <thead class="table-principal">
                    <tr>
                        <th class="text-center">
                            <?php if ($iprod == -1): echo "Producto";
                            else: echo "<a href='reporte_ventas_x_empleado.php?e=$estado&pn=$page&nrop=$num_results_on_page&iclie=$iclie&iempl=$iempl&fecha=$fecha' class='btn btn-link btn-sm'>Producto <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                            endif; ?>
                        </th>
                        <th class="text-center">
                            <?php if ($fecha == "2000-01-01"): echo "Fecha";
                            else: echo "<a href='reporte_ventas_x_empleado.php?e=$estado&pn=$page&nrop=$num_results_on_page&iprod=$iprod&iclie=$iclie&iempl=$iempl' class='btn btn-link btn-sm'>Fecha <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                            endif; ?>
                        </th>
                        <th class="text-center">Precio Venta X Unidad</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio Venta Total</th>
                        <th class="text-center">
                            <?php if ($iclie == -1): echo "Cliente";
                            else: echo "<a href='reporte_ventas_x_empleado.php?e=$estado&pn=$page&nrop=$num_results_on_page&iprod=$iprod&iempl=$iempl&fecha=$fecha' class='btn btn-link btn-sm'>Cliente <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                            endif; ?>
                        </th>
                        <?php if ($_SESSION['usuario']["rol"] == 1): ?>
                            <th class="text-center">
                                <?php if ($iempl == -1): echo "Empleado";
                                else: echo "<a href='reporte_ventas_x_empleado.php?e=$estado&pn=$page&nrop=$num_results_on_page&iprod=$iprod&iclie=$iclie' class='btn btn-link btn-sm'>Empleado <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-bar-down' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6'/></svg></a>";
                                endif; ?>
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a href="reporte_ventas_x_empleado.php?e=<?php echo $estado; ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $row['id_producto'] ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>" class="btn btn-link btn-sm">
                                    <?php echo $row['descripcion']; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="reporte_ventas_x_empleado.php?e=<?php echo $estado; ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $row['fecha'] ?>" class="btn btn-link btn-sm">
                                    <?php
                                    $timestamp = strtotime($row['fecha']);
                                    echo date('d/m/Y', $timestamp);
                                    ?>
                                </a>
                            </td>
                            <td class="text-end"><?php echo number_format($row['precio_venta_x_unidad'], 0, '', '.'); ?></td>
                            <td class="text-end"><?php echo $row['cantidad']; ?></td>
                            <td class="text-end"><?php echo number_format($row['precio_venta_total'], 0, '', '.'); ?></td>
                            <td>
                                <a href="reporte_ventas_x_empleado.php?e=<?php echo $estado; ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $row['id_cliente'] ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>" class="btn btn-link btn-sm">
                                    <?php echo $row['cedula']; ?> - <?php echo $row['nombre']; ?> <?php echo $row['apellido']; ?>
                                </a>
                            </td>
                            <?php if ($_SESSION['usuario']["rol"] == 1): ?>
                                <td>
                                    <a href="reporte_ventas_x_empleado.php?e=<?php echo $estado; ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $row['id_empleado'] ?>&fecha=<?php echo $fecha ?>" class="btn btn-link btn-sm">
                                        <?php echo $row['nombre_empleado']; ?>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
            <nav aria-label="Navegación de la página" class="py-1">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href='reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_ventas_x_empleado.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&iprod=<?php echo $iprod ?>&iclie=<?php echo $iclie ?>&iempl=<?php echo $iempl ?>&fecha=<?php echo $fecha ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>