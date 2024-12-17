<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Productos.php';
$Productos = new Productos();
include_once 'procesos/Proveedores.php';
$Proveedores = new Proveedores();
include_once 'procesos/Compras.php';
$Compras = new Compras();
include_once 'procesos/Ventas.php';
$Ventas = new Ventas();
include_once 'procesos/Clientes.php';
$Clientes = new Clientes();
include_once 'procesos/Puntos_venta.php';
$Puntos_venta = new Puntos_venta();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Número de resultados para mostrar en cada página, si no devuelve el número de registros por página predeterminado es 5.
    $num_results_on_page = isset($_GET['nrop']) && is_numeric($_GET['nrop']) ? $_GET['nrop'] : 5;
    // Verifique si se especifica el número de página y verifique si es un número, si no devuelve el número de página predeterminado que es 1.
    $page = isset($_GET['pn']) && is_numeric($_GET['pn']) ? $_GET['pn'] : 1;
    // Verifique si se especifica el estado y verifique si es un string, si no devuelve el valor del estado predeterminado que es 'TODO'.
    $estado = isset($_GET['e']) && is_string($_GET['e']) ? $_GET['e'] : 'TODO';
    $id_proveedor = isset($_GET['prov']) && is_string($_GET['prov']) ? $_GET['prov'] : -1;
    $id_producto = isset($_GET['id_producto']) && is_string($_GET['id_producto']) ? $_GET['id_producto'] : -1;

    $total_pages = $Productos->getTotalItemsProductos($estado, $id_producto, $id_proveedor);
    $result = $Productos->getProductos($estado, $page, $num_results_on_page, $id_producto, $id_proveedor);
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Stock de Productos</title>
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
        <h2>Reporte de Stock de Productos</h2>
        <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 3): ?><a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addProductoModal">Agregar Producto</a><?php endif; ?>

        <!-- Tabla de productos -->
        <table class="table table-striped table-responsive caption-top mb-3">
            <caption>
                <div class="btn-group">
                    <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        Lista de <?php echo $num_results_on_page ?> Registros de <?php echo $total_pages ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                        <li><a class="dropdown-item" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=5&prov=<?php echo $id_proveedor; ?>">5</a></li>
                        <li><a class="dropdown-item" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=10&prov=<?php echo $id_proveedor; ?>">10</a></li>
                        <li><a class="dropdown-item" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=15&prov=<?php echo $id_proveedor; ?>">15</a></li>
                    </ul>
                </div>
            </caption>
            <thead class="table-principal">
                <tr>
                    <th>Descripcion</th>
                    <th>Stock</th>
                    <th>
                        <div class="btn-group">
                            <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="ProveedorDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                Proveedor
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="ProveedorDropdown">
                                <li><a class="dropdown-item" href="reporte_stock_productos.php?e=<?php echo $estado ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">TODO</a></li>
                                <?php
                                $proveedores_total_pages = $Proveedores->getTotalItemsProveedores('ACTIVO');
                                $proveedores_result = $Proveedores->getProveedores('ACTIVO', 1, $proveedores_total_pages);
                                while ($row = $proveedores_result->fetch_assoc()) {
                                ?>
                                    <li><a class="dropdown-item" href="reporte_stock_productos.php?e=<?php echo $estado ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $row['id_proveedor']; ?>"><?php echo $row['nombre']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </th>
                    <th>
                        <div class="btn-group">
                            <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                Estado
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                                <li><a class="dropdown-item" href="reporte_stock_productos.php?e=TODO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>">TODO</a></li>
                                <li><a class="dropdown-item" href="reporte_stock_productos.php?e=ACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>">ACTIVO</a></li>
                                <li><a class="dropdown-item" href="reporte_stock_productos.php?e=INACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>">INACTIVO</a></li>
                            </ul>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <tr <?php if ($producto['stock'] < 5): echo 'class="table-danger"';
                        endif; ?>>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['stock']; ?></td>
                        <td>
                            <?php
                            $rows = $Proveedores->getProveedor($producto['id_proveedor']);
                            if ($rows->num_rows > 0) {
                                $row = $rows->fetch_assoc();
                                echo $row['nombre'];
                            }
                            ?>
                        </td>
                        <td><?php echo $producto['estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
            <nav aria-label="Navegación de la página" class="py-1">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href='reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="reporte_stock_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&prov=<?php echo $id_proveedor; ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>