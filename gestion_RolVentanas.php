<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/RolVentanas.php';
$rolventanas = new RolVentanas();
include_once("procesos/Roles.php");
$Roles = new Roles();
include_once("procesos/Ventanas.php");
$Ventanas = new Ventanas();
$rol_ventana_upd = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Número de resultados para mostrar en cada página, si no devuelve el número de registros por página predeterminado es 5.
    $num_results_on_page = isset($_GET['nrop']) && is_numeric($_GET['nrop']) ? $_GET['nrop'] : 5;
    // Verifique si se especifica el número de página y verifique si es un número, si no devuelve el número de página predeterminado que es 1.
    $page = isset($_GET['pn']) && is_numeric($_GET['pn']) ? $_GET['pn'] : 1;
    // Verifique si se especifica el estado y verifique si es un string, si no devuelve el valor del estado predeterminado que es 'TODO'.
    $estado = isset($_GET['e']) && is_string($_GET['e']) ? $_GET['e'] : 'TODO';
    //
    $irol = isset($_GET['irol']) && is_string($_GET['irol']) ? $_GET['irol'] : "-1";
    //
    $id_ventana = isset($_GET['id_ventana']) && is_string($_GET['id_ventana']) ? $_GET['id_ventana'] : 'TODO';
    //
    $result = $rolventanas->getRolVentanas($estado, $page, $num_results_on_page, $irol, $id_ventana);
    $total_pages = $rolventanas->getTotalItemsRol_ventanas($estado, $id_ventana, $irol);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["_method"]) && $_POST["_method"] == "UPD") {
        $resultado = $rolventanas->updateRolVentana($_POST);
        header("Location: gestion_RolVentanas.php");
    } else
    if (isset($_POST["_method"]) && $_POST["_method"] == "ADD") {
        $resultado = $rolventanas->insertRolVentana($_POST);
        header("Location: gestion_RolVentanas.php");
    } else
    if (isset($_POST["_method"]) && $_POST["_method"] == "ADD_ROL") {
        $resultado = $Roles->insertRol($_POST);
        header("Location: gestion_RolVentanas.php");
    }
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Rol de Ventanas</title>
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
        <h2>Gestión de Rol de Ventanas</h2>
        <a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addRolModal">Agregar Rol</a>
        <a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addRolVentanaModal">Agregar Rol de Ventanas</a>

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
                            <li><a class="dropdown-item" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=5&irol=<?php echo $irol; ?>">5</a></li>
                            <li><a class="dropdown-item" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=10&irol=<?php echo $irol; ?>">10</a></li>
                            <li><a class="dropdown-item" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=15&irol=<?php echo $irol; ?>">15</a></li>
                        </ul>
                    </div>
                </caption>
                <thead class="table-principal">
                    <tr>
                        <th>Ventana</th>
                        <th>
                            <div class="btn-group">
                                <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="RolDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Rol
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="RolDropdown">
                                    <li><a class="dropdown-item" href="gestion_rolventanas.php?e=<?php echo $estado ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">TODO</a></li>
                                    <?php
                                    $roles_total_pages = $Roles->getTotalItemsRoles('ACTIVO');
                                    $roles_result = $Roles->getRoles('ACTIVO', 1, $roles_total_pages);
                                    while ($row = $roles_result->fetch_assoc()) {
                                    ?>
                                        <li><a class="dropdown-item" href="gestion_rolventanas.php?e=<?php echo $estado ?>&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $row['id_rol']; ?>"><?php echo $row['nombre']; ?></a></li>
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
                                    <li><a class="dropdown-item" href="gestion_rolventanas.php?pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>">TODO</a></li>
                                    <li><a class="dropdown-item" href="gestion_rolventanas.php?e=ACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>">ACTIVO</a></li>
                                    <li><a class="dropdown-item" href="gestion_rolventanas.php?e=INACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>">INACTIVO</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rolventana = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php
                                $ventanas = $Ventanas->getVentana($rolventana['id_ventana']);
                                if ($ventanas->num_rows > 0) {
                                    $row_v = $ventanas->fetch_assoc();
                                    $descripcion = $row_v['descripcion'];
                                    $grupo = $row_v['grupo'];
                                    $rolventana['descripcion'] = $descripcion;
                                    $rolventana['grupo'] = $grupo;
                                    echo "$grupo -> $descripcion";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $roles = $Roles->getRol($rolventana['id_rol']);
                                if ($roles->num_rows > 0) {
                                    $rol = $roles->fetch_assoc();
                                    echo $rol['nombre'];
                                }
                                ?>
                            </td>
                            <td><?php echo $rolventana['estado']; ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updRolVentanaModal" onclick="loadData(<?php echo htmlspecialchars(json_encode($rolventana)); ?>)">Editar</a>
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
                            <a class="page-link" href='gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_rolventanas.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>&irol=<?php echo $irol; ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Modal para agregar rolventanas -->
    <div class="modal fade" id="addRolVentanaModal" tabindex="-1" aria-labelledby="addRolVentanaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRolVentanaModalLabel">Agregar Rol de Ventana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="gestion_RolVentanas.php" method="POST" class="row g-3 was-validated">
                        <input type="text" class="form-control" id="_method" name="_method" value="ADD" hidden>
                        <div class="col-md-12">
                            <label for="id_ventana" class="form-label">Ventana</label>
                            <select class="form-select" id="id_ventana" name="id_ventana" value="" required>
                                <option selected value="">Seleccionar</option>
                                <?php
                                $ventanas_total_pages = $Ventanas->getTotalItemsVentanas('ACTIVO');
                                $ventanas_result = $Ventanas->getVentanas('ACTIVO', 1, $ventanas_total_pages);
                                while ($row = $ventanas_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_ventana']; ?>"><?php echo $row['grupo']; ?> -> <?php echo $row['descripcion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <option selected value="">Seleccionar</option>
                                <?php
                                $roles_total_pages = $Roles->getTotalItemsRoles('ACTIVO');
                                $roles_result = $Roles->getRoles('ACTIVO', 1, $roles_total_pages);
                                while ($row = $roles_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar rol -->
    <div class="modal fade" id="addRolModal" tabindex="-1" aria-labelledby="addRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRolModalLabel">Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="gestion_RolVentanas.php" method="POST" class="row g-3 was-validated">
                        <input type="text" class="form-control" id="_method" name="_method" value="ADD_ROL" hidden>
                        <div class="col-md-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar rolventanas -->
    <div class="modal fade" id="updRolVentanaModal" tabindex="-1" aria-labelledby="updRolVentanaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updRolVentanaModalLabel">Modificar Rol de Ventana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rolVentana-edit-form" action="gestion_RolVentanas.php" method="POST" class="row g-3 was-validated">
                        <input type="text" class="form-control" id="_method" name="_method" value="UPD" hidden>
                        <input type="text" class="form-control" id="id_rol" name="id_rol" hidden>
                        <div class="col-md-6">
                            <label for="id_ventana" class="form-label">Ventana</label>
                            <input type="text" class="form-control" id="id_ventana" name="id_ventana" hidden>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="id_rol_" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol_" name="id_rol_" disabled>
                                <?php
                                $roles_total_pages = $Roles->getTotalItemsRoles('ACTIVO');
                                $roles_result = $Roles->getRoles('ACTIVO', 1, $roles_total_pages);
                                while ($row = $roles_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nombre']; ?></option>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    function loadData(rolventana) {
        var rolventanaForm = document.getElementById("rolVentana-edit-form");
        rolventanaForm.querySelector('#id_ventana').value = rolventana.id_ventana;
        rolventanaForm.querySelector('#id_rol_').value = rolventana.id_rol;
        rolventanaForm.querySelector('#id_rol').value = rolventana.id_rol;
        rolventanaForm.querySelector('#estado').value = rolventana.estado;
        rolventanaForm.querySelector('#descripcion').value = rolventana.grupo + " -> " + rolventana.descripcion;
    };
</script>