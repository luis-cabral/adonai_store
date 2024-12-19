<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Puntos_venta.php';
$Puntos_venta = new Puntos_venta();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Número de resultados para mostrar en cada página, si no devuelve el número de registros por página predeterminado es 5.
    $num_results_on_page = isset($_GET['nrop']) && is_numeric($_GET['nrop']) ? $_GET['nrop'] : 5;
    // Verifique si se especifica el número de página y verifique si es un número, si no devuelve el número de página predeterminado que es 1.
    $page = isset($_GET['pn']) && is_numeric($_GET['pn']) ? $_GET['pn'] : 1;
    // Verifique si se especifica el estado y verifique si es un string, si no devuelve el valor del estado predeterminado que es 'TODO'.
    $estado = isset($_GET['e']) && is_string($_GET['e']) ? $_GET['e'] : 'TODO';

    $total_pages = $Puntos_venta->getTotalItemsPuntos_venta($estado);

    if (isset($_GET["id_punto_venta"]) && $_GET["id_punto_venta"] >= 0) {
        $result = $Puntos_venta->getPunto_venta($_GET["id_punto_venta"]);
    } else {
        $result = $Puntos_venta->getPuntos_venta($estado, $page, $num_results_on_page);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["id_punto_venta"]) && $_POST["id_punto_venta"] >= 0) {
        $resultado = $Puntos_venta->updatePunto_venta($_POST);

        if ($resultado > 0) {
            header("Location: gestion_puntos_venta.php");
        } else {
            #header("Location: gestion_puntos_venta.php");
            echo "Error al guardar el punto_venta.";
            $result = $Puntos_venta->getPunto_venta($_POST["id_punto_venta"]);
        }
    } else {
        $resultado = $Puntos_venta->insertPunto_venta($_POST);

        if ($resultado > 0) {
            header("Location: gestion_puntos_venta.php");
        } else {
            #header("Location: gestion_puntos_venta.php");
            echo "Error al guardar el punto_venta.";
            $result = $Puntos_venta->getPuntos_venta();
        }
    }
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Puntos de Venta</title>
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
        <h2>Gestión de Puntos de Venta</h2>
        <a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addPunto_ventaModal">Agregar Punto_venta</a>

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
                            <li><a class="dropdown-item" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=5">5</a></li>
                            <li><a class="dropdown-item" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=10">10</a></li>
                            <li><a class="dropdown-item" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=15">15</a></li>
                        </ul>
                    </div>
                </caption>
                <thead class="table-principal">
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>
                            <div class="btn-group">
                                <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                                    <li><a class="dropdown-item" href="gestion_puntos_venta.php?e=TODO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">TODO</a></li>
                                    <li><a class="dropdown-item" href="gestion_puntos_venta.php?e=ACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">ACTIVO</a></li>
                                    <li><a class="dropdown-item" href="gestion_puntos_venta.php?e=INACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">INACTIVO</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($punto_venta = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $punto_venta['nombre']; ?></td>
                            <td><?php echo $punto_venta['direccion']; ?></td>
                            <td><?php echo $punto_venta['estado']; ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updPunto_ventaModal" onclick="loadData(<?php echo htmlspecialchars(json_encode($punto_venta)); ?>)">Editar</a>
                            </td>
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
                            <a class="page-link" href='gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_puntos_venta.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Modal para agregar puntos_venta -->
    <div class="modal fade" id="addPunto_ventaModal" tabindex="-1" aria-labelledby="addPunto_ventaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPunto_ventaModalLabel">Agregar Punto de Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="gestion_puntos_venta.php" method="POST" class="row g-3 was-validated">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar puntos_venta -->
    <div class="modal fade" id="updPunto_ventaModal" tabindex="-1" aria-labelledby="updPunto_ventaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updPunto_ventaModalLabel">Modificar Punto de Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="punto_venta-edit-form" action="gestion_puntos_venta.php" method="POST" class="row g-3 was-validated">
                        <input type="hidden" name="id_punto_venta" id="id_punto_venta">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    function loadData(punto_venta) {
        let punto_ventaForm = document.getElementById("punto_venta-edit-form");
        punto_ventaForm.querySelector('#id_punto_venta').value = punto_venta.id_punto_venta;
        punto_ventaForm.querySelector('#nombre').value = punto_venta.nombre;
        punto_ventaForm.querySelector('#direccion').value = punto_venta.direccion;
        punto_ventaForm.querySelector('#estado').value = punto_venta.estado;
    };
</script>