<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Productos.php';
$productos = new Productos();
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


    if (isset($_GET["id_producto"]) && $_GET["id_producto"] >= 0) {
        $total_pages = $productos->getTotalItemsProductos($estado, $_GET["id_producto"]);
        $result = $productos->getProducto($_GET["id_producto"]);
    } else {
        $total_pages = $productos->getTotalItemsProductos($estado);
        $result = $productos->getProductos($estado, $page, $num_results_on_page);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["CompraModal"]) && $_POST["CompraModal"] >= 0 and isset($_POST["id_producto"]) && $_POST["id_producto"] >= 0) {
        $resultado = $Compras->insertCompra($_POST);
        header("Location: gestion_productos.php");
    } else
    if (isset($_POST["VentaModal"]) && $_POST["VentaModal"] >= 0 and isset($_POST["id_producto"]) && $_POST["id_producto"] >= 0) {
        if (isset($_POST["add_cliente"]) && $_POST["add_cliente"] >= 0) {
            $resultado = $Clientes->insertCliente($_POST);
            $rows = $Clientes->getClientePorCedula($_POST["cedula"]);
            if ($rows->num_rows > 0) {
                $row = $rows->fetch_assoc();
                $_POST["id_cliente"] = $row['id_cliente'];
            }
        }
        $resultado = $Ventas->insertVenta($_POST);
        header("Location: gestion_productos.php");
    } else
    if (isset($_POST["id_producto"]) && $_POST["id_producto"] >= 0) {
        $resultado = $productos->updateProducto($_POST);
        header("Location: gestion_productos.php");
    } else {
        $resultado = $productos->insertProducto($_POST);
        header("Location: gestion_productos.php");
    }
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
        <h2>Gestión de Productos</h2>
        <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 3): ?><a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addProductoModal">Agregar Producto</a><?php endif; ?>

        <!-- Tabla de productos -->
        <table class="table table-striped table-responsive caption-top mb-3">
            <caption>
                <div class="btn-group">
                    <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        Lista de <?php echo $num_results_on_page ?> Registros de <?php echo $total_pages ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                        <li><a class="dropdown-item" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page ?>&nrop=5">5</a></li>
                        <li><a class="dropdown-item" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page ?>&nrop=10">10</a></li>
                        <li><a class="dropdown-item" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                    endif; ?>pn=<?php echo $page ?>&nrop=15">15</a></li>
                    </ul>
                </div>
            </caption>
            <thead class="table-principal">
                <tr>
                    <th class="text-center">Descripcion</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Proveedor</th>
                    <th class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                Estado
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                                <li><a class="dropdown-item" href="gestion_productos.php?e=TODO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">TODO</a></li>
                                <li><a class="dropdown-item" href="gestion_productos.php?e=ACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">ACTIVO</a></li>
                                <li><a class="dropdown-item" href="gestion_productos.php?e=INACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">INACTIVO</a></li>
                            </ul>
                        </div>
                    </th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <tr <?php if ($producto['stock'] < 5): echo 'class="table-danger"';
                        endif; ?>>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td class="text-center"><?php echo $producto['stock']; ?></td>
                        <td>
                            <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 3): ?><a href="gestion_proveedores.php?id_proveedor=<?php echo $producto['id_proveedor'] ?>" class="btn btn-link btn-sm"><?php endif; ?>
                                <?php
                                $rows = $Proveedores->getProveedor($producto['id_proveedor']);
                                if ($rows->num_rows > 0) {
                                    $row = $rows->fetch_assoc();
                                    echo $row['nombre'];
                                }
                                ?>
                                <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 3): ?></a><?php endif; ?>
                        </td>
                        <td><?php echo $producto['estado']; ?></td>
                        <td class="text-center">
                            <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 2): ?>
                                <a href="#" class="btn btn-success btn-sm <?php if ($producto['stock'] <= 0): echo 'disabled';
                                                                            endif; ?>" data-bs-toggle="modal" data-bs-target="#addVentaModal" onclick="loadDataVentaModal(<?php echo htmlspecialchars(json_encode($producto)); ?>)" <?php if ($producto['stock'] <= 0): echo ' tabindex="-1" aria-disabled="true"';
                                                                                                                                                                                                                                    endif; ?>>Vender</a>
                            <?php endif; ?>

                            <?php if ($_SESSION['usuario']["rol"] == 1 || $_SESSION['usuario']["rol"] == 3): ?>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupAcciones<?php echo $producto['id_proveedor'] ?>" type="button" class="btn btn-sm btn-principal dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupAcciones<?php echo $producto['id_proveedor'] ?>">
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updProductoModal" onclick="loadData(<?php echo htmlspecialchars(json_encode($producto)); ?>)">Editar Producto</a></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addCompraModal" onclick="loadDataCompraModal(<?php echo htmlspecialchars(json_encode($producto)); ?>)">Registrar Compra</a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
            <nav aria-label="Navegación de la página" class="py-1">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href='gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_productos.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Modal para agregar productos -->
    <div class="modal fade" id="addProductoModal" tabindex="-1" aria-labelledby="addProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductoModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productos-add-form" action="gestion_productos.php" method="POST" class="row g-3">
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_proveedor" class="form-label">Proveedor</label>
                            <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                                <?php
                                $proveedores_total_pages = $Proveedores->getTotalItemsProveedores('ACTIVO');
                                $proveedores_result = $Proveedores->getProveedores('ACTIVO', 1, $proveedores_total_pages);
                                while ($row = $proveedores_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_proveedor']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar productos -->
    <div class="modal fade" id="updProductoModal" tabindex="-1" aria-labelledby="updProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updProductoModalLabel">Modificar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="producto-edit-form" action="gestion_productos.php" method="POST" class="row g-3">
                        <input type="hidden" name="id_producto" id="id_producto">
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_proveedor" class="form-label">Proveedor</label>
                            <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                                <?php
                                $proveedores_total_pages = $Proveedores->getTotalItemsProveedores('ACTIVO');
                                $proveedores_result = $Proveedores->getProveedores('ACTIVO', 1, $proveedores_total_pages);
                                while ($row = $proveedores_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_proveedor']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="ACTIVO">Activo</option>
                                <option value="INACTIVO">Inactivo</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar Compras -->
    <div class="modal fade" id="addCompraModal" tabindex="-1" aria-labelledby="addCompraModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompraModalLabel">Registrar Compra de Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-compra-modal-form" action="gestion_productos.php" method="POST" class="row g-3">
                        <input type="hidden" name="CompraModal" id="CompraModal">
                        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $_SESSION['usuario']["id_empleado"]; ?>">
                        <div class="col-md-3">
                            <label for="id_producto" class="form-label">Id</label>
                            <input type="number" class="form-control" id="id_producto" name="id_producto" required readonly>
                        </div>
                        <div class="col-md-9">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="precio_compra_x_unidad" class="form-label">Precio Compra X Unidad</label>
                            <input type="number" class="form-control" id="precio_compra_x_unidad" name="precio_compra_x_unidad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar Ventas -->
    <div class="modal fade" id="addVentaModal" tabindex="-1" aria-labelledby="addVentaModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="addVentaModalContent">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVentaModalLabel">Registrar Venta de Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    ?>
                    <form id="add-venta-modal-form" action="gestion_productos.php" method="POST" class="row g-3">
                        <input type="hidden" name="VentaModal" id="VentaModal">
                        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $_SESSION['usuario']["id_empleado"]; ?>">
                        <input type="hidden" name="id_punto_venta" id="id_punto_venta" value="<?php echo $_SESSION['usuario']["id_punto_venta"]; ?>">
                        <div class="col-md-3">
                            <label for="id_producto" class="form-label">Id</label>
                            <input type="number" class="form-control" id="id_producto" name="id_producto" required readonly>
                        </div>
                        <div class="col-md-9">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="precio_venta_x_unidad" class="form-label">Precio Venta X Unidad</label>
                            <input type="number" class="form-control" id="precio_venta_x_unidad" name="precio_venta_x_unidad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="nuevoClienteButton" class="btn btn-secondary" onclick="nuevoClienteBandera(true)">Nuevo Cliente</button>
                            <button type="button" id="atrasNuevoClienteButton" style="display: none;" class="btn btn-secondary" onclick="nuevoClienteBandera(false)">Atras</button>
                        </div>
                        <div class="col-md-6" id="dropDownCliente">
                            <label for="id_cliente" class="form-label">Cliente</label>
                            <select class="form-select" id="id_cliente" name="id_cliente" required>
                                <?php
                                $clientes_total_pages = $Clientes->getTotalItemsClientes('ACTIVO');
                                $clientes_result = $Clientes->getClientes('ACTIVO', 1, $clientes_total_pages);
                                while ($row = $clientes_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_cliente']; ?>"><?php echo $row['nombre']; ?> <?php echo $row['apellido']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12" id="NuevoClienteCliente" style="display: none;">
                            <div class="row">
                                <input type="text" class="form-control" id="add_cliente" hidden>
                                <div class="col-md-4">
                                    <label for="cedula" class="form-label">Cedula</label>
                                    <input type="text" class="form-control" id="cedula">
                                </div>
                                <div class="col-md-4">
                                    <label for="ruc" class="form-label">RUC</label>
                                    <input type="text" class="form-control" id="ruc">
                                </div>
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre">
                                </div>
                                <div class="col-md-4">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono" class="form-label">Telefono</label>
                                    <input type="text" class="form-control" id="telefono">
                                </div>
                                <div class="col-md-4">
                                    <label for="direccion" class="form-label">Direccion</label>
                                    <input type="text" class="form-control" id="direccion">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    function loadData(producto) {
        let productoForm = document.getElementById("producto-edit-form");
        productoForm.querySelector('#id_producto').value = producto.id_producto;
        productoForm.querySelector('#nombre').value = producto.nombre;
        productoForm.querySelector('#descripcion').value = producto.descripcion;
        productoForm.querySelector('#categoria').value = producto.categoria;
        productoForm.querySelector('#talla').value = producto.talla;
        productoForm.querySelector('#color').value = producto.color;
        productoForm.querySelector('#precio_compra').value = producto.precio_compra;
        productoForm.querySelector('#precio_venta').value = producto.precio_venta;
        productoForm.querySelector('#stock').value = producto.stock;
        productoForm.querySelector('#estado').value = producto.estado;
    };
    //
    function loadDataCompraModal(producto) {
        let productoForm = document.getElementById("add-compra-modal-form");
        productoForm.querySelector('#id_producto').value = producto.id_producto;
        productoForm.querySelector('#descripcion').value = producto.descripcion;
    };
    //
    function loadDataVentaModal(producto) {
        let productoForm = document.getElementById("add-venta-modal-form");
        productoForm.querySelector('#id_producto').value = producto.id_producto;
        productoForm.querySelector('#descripcion').value = producto.descripcion;
        productoForm.querySelector('#cantidad').setAttribute("max", producto.stock);
    };
    //
    function nuevoClienteBandera(mostrar) {
        let atrasNuevoClienteButton = document.getElementById("atrasNuevoClienteButton");
        let nuevoClienteButton = document.getElementById("nuevoClienteButton");
        let dropDownCliente = document.getElementById("dropDownCliente");
        let NuevoClienteCliente = document.getElementById("NuevoClienteCliente");
        let addVentaModalContent = document.getElementById("addVentaModalContent");
        //
        let id_cliente = document.getElementById("id_cliente");
        let add_cliente = document.getElementById("add_cliente");
        let cedula = document.getElementById("cedula");
        let ruc = document.getElementById("ruc");
        let nombre = document.getElementById("nombre");
        let apellido = document.getElementById("apellido");
        let telefono = document.getElementById("telefono");
        let direccion = document.getElementById("direccion");
        //
        if (mostrar) {
            atrasNuevoClienteButton.style.display = "block";
            nuevoClienteButton.style.display = "none";
            dropDownCliente.style.display = "none";
            NuevoClienteCliente.style.display = "block";
            addVentaModalContent.classList.add("modal-xl");
            //
            id_cliente.removeAttribute("required");
            id_cliente.removeAttribute("name");
            //
            add_cliente.setAttribute("name", "add_cliente");
            cedula.setAttribute("required", true);
            cedula.setAttribute("name", "cedula");
            ruc.setAttribute("name", "ruc");
            nombre.setAttribute("required", true);
            nombre.setAttribute("name", "nombre");
            apellido.setAttribute("required", true);
            apellido.setAttribute("name", "apellido");
            telefono.setAttribute("required", true);
            telefono.setAttribute("name", "telefono");
            direccion.setAttribute("required", true);
            direccion.setAttribute("name", "direccion");
        } else {
            atrasNuevoClienteButton.style.display = "none";
            nuevoClienteButton.style.display = "block";
            dropDownCliente.style.display = "block";
            NuevoClienteCliente.style.display = "none";
            addVentaModalContent.classList.remove("modal-xl");
            //
            id_cliente.setAttribute("required", true);
            id_cliente.setAttribute("name", "id_cliente");
            add_cliente.removeAttribute("name");
            cedula.removeAttribute("required");
            cedula.removeAttribute("name");
            cedula.value = null;
            ruc.value = null;
            ruc.removeAttribute("name");
            nombre.removeAttribute("required");
            nombre.removeAttribute("name");
            nombre.value = null;
            apellido.removeAttribute("required");
            apellido.removeAttribute("name");
            apellido.value = null;
            telefono.removeAttribute("required");
            telefono.removeAttribute("name");
            telefono.value = null;
            direccion.removeAttribute("required");
            direccion.removeAttribute("name");
            direccion.value = null;
        }
    };
</script>