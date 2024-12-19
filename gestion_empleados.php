<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Empleados.php';
$Empleados = new Empleados();
include_once("procesos/Puntos_venta.php");
$Puntos_venta = new Puntos_venta();
include_once("procesos/Roles.php");
$Roles = new Roles();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Número de resultados para mostrar en cada página, si no devuelve el número de registros por página predeterminado es 5.
    $num_results_on_page = isset($_GET['nrop']) && is_numeric($_GET['nrop']) ? $_GET['nrop'] : 5;
    // Verifique si se especifica el número de página y verifique si es un número, si no devuelve el número de página predeterminado que es 1.
    $page = isset($_GET['pn']) && is_numeric($_GET['pn']) ? $_GET['pn'] : 1;
    // Verifique si se especifica el estado y verifique si es un string, si no devuelve el valor del estado predeterminado que es 'TODO'.
    $estado = isset($_GET['e']) && is_string($_GET['e']) ? $_GET['e'] : 'TODO';

    $total_pages = $Empleados->getTotalItemsEmpleados($estado);

    if (isset($_GET["id_empleado"]) && $_GET["id_empleado"] >= 0) {
        $result = $Empleados->getEmpleado($_GET["id_empleado"]);
    } else {
        $result = $Empleados->getEmpleados($estado, $page, $num_results_on_page);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["id_empleado"]) && $_POST["id_empleado"] >= 0) {
        $resultado = $Empleados->updateEmpleado($_POST);
        $id_empleado = $_POST["id_empleado"];

        if ($resultado > 0) {
            header("Location: gestion_empleados.php?id_empleado=$id_empleado");
        } else {
            #header("Location: gestion_empleados.php");
            die("Error al guardar el empleado.");
            $result = $Empleados->getEmpleado($_POST["id_empleado"]);
        }
    } else {
        $resultado = $Empleados->insertEmpleado($_POST);

        if ($resultado > 0) {
            header("Location: gestion_empleados.php");
        } else {
            #header("Location: gestion_empleados.php");
            die("Error al guardar el empleado.");
            $result = $Empleados->getEmpleados();
        }
    }
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
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
        <h2>Gestión de Empleados</h2>
        <a href="#" class="btn btn-principal mb-3" data-bs-toggle="modal" data-bs-target="#addEmpleadoModal">Agregar Empleado</a>

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
                            <li><a class="dropdown-item" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=5">5</a></li>
                            <li><a class="dropdown-item" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=10">10</a></li>
                            <li><a class="dropdown-item" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                        endif; ?>pn=<?php echo $page ?>&nrop=15">15</a></li>
                        </ul>
                    </div>
                </caption>
                <thead class="table-principal">
                    <tr>
                        <th>Punto Venta</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>
                            <div class="btn-group">
                                <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="EstadoDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="EstadoDropdown">
                                    <li><a class="dropdown-item" href="gestion_empleados.php?e=TODO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">TODO</a></li>
                                    <li><a class="dropdown-item" href="gestion_empleados.php?e=ACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">ACTIVO</a></li>
                                    <li><a class="dropdown-item" href="gestion_empleados.php?e=INACTIVO&pn=<?php echo $page ?>&nrop=<?php echo $num_results_on_page ?>">INACTIVO</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($empleado = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $empleado['id_punto_venta']; ?> - <?php echo $empleado['punto_venta_nombre']; ?></td>
                            <td><?php echo $empleado['cedula']; ?></td>
                            <td><?php echo $empleado['nombre']; ?></td>
                            <td><?php echo $empleado['apellido']; ?></td>
                            <td><?php echo $empleado['email']; ?></td>
                            <td><?php echo $empleado['nombre_rol']; ?></td>
                            <td><?php echo $empleado['estado']; ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updEmpleadoModal" onclick="loadData(<?php echo htmlspecialchars(json_encode($empleado)); ?>)">Editar</a>
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
                            <a class="page-link" href='gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>'><span aria-hidden="true">&laquo;</span></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=1&nrop=<?php echo $num_results_on_page ?>">1</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 2 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page - 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page - 1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active">
                        <span class="page-link"><?php echo $page ?></span>
                    </li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 1 ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 2 ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo $page + 2 ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo ceil($total_pages / $num_results_on_page) ?>&nrop=<?php echo $num_results_on_page ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="gestion_empleados.php?<?php if ($estado != "TODO"): echo "e=$estado&";
                                                                                endif; ?>pn=<?php echo $page + 1 ?>&nrop=<?php echo $num_results_on_page ?>"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Modal para agregar empleados -->
    <div class="modal fade" id="addEmpleadoModal" tabindex="-1" aria-labelledby="addEmpleadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmpleadoModalLabel">Agregar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="empleado-add-form" action="gestion_empleados.php" method="POST" class="row g-3 was-validated">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="cedula" class="form-label">Cedula</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                                </div>
                                <div class="col-md">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="id_punto_venta" class="form-label">Punto Venta</label>
                            <select class="form-select" id="id_punto_venta" name="id_punto_venta" required>
                                <option selected value="">Seleccionar</option>
                                <?php
                                $puntos_venta_total_pages = $Puntos_venta->getTotalItemsPuntos_venta('ACTIVO');
                                $puntos_venta_result = $Puntos_venta->getPuntos_venta('ACTIVO', 1, $puntos_venta_total_pages);
                                while ($row = $puntos_venta_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_punto_venta']; ?>"><?php echo $row['nombre']; ?> - <?php echo $row['direccion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-principal">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar empleadoes -->
    <div class="modal fade" id="updEmpleadoModal" tabindex="-1" aria-labelledby="updEmpleadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updEmpleadoModalLabel">Modificar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="empleado-edit-form" action="gestion_empleados.php" method="POST" class="row g-3 was-validated">
                        <input type="hidden" name="id_empleado" id="id_empleado">
                        <div class="col-md-2 px-1">
                            <label for="cedula" class="form-label">Cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required readonly>
                        </div>
                        <div class="col-md-5 px-1">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-5 px-1">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="col-md-6 px-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required readonly>
                        </div>
                        <div class="col-md-6 px-1">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <?php
                                $roles_total_pages = $Roles->getTotalItemsRoles('ACTIVO');
                                $roles_result = $Roles->getRoles('ACTIVO', 1, $roles_total_pages);
                                while ($row = $roles_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_rol']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 px-1">
                            <label for="id_punto_venta" class="form-label">Punto Venta</label>
                            <select class="form-select" id="id_punto_venta" name="id_punto_venta" required>
                                <?php
                                $puntos_venta_total_pages = $Puntos_venta->getTotalItemsPuntos_venta('ACTIVO');
                                $puntos_venta_result = $Puntos_venta->getPuntos_venta('ACTIVO', 1, $puntos_venta_total_pages);
                                while ($row = $puntos_venta_result->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['id_punto_venta']; ?>"><?php echo $row['nombre']; ?> - <?php echo $row['direccion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 px-1">
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
    //
    function loadData(empleado) {
        let empleadoForm = document.getElementById("empleado-edit-form");
        empleadoForm.querySelector('#id_empleado').value = empleado.id_empleado;
        empleadoForm.querySelector('#id_punto_venta').value = empleado.id_punto_venta;
        empleadoForm.querySelector('#cedula').value = empleado.cedula;
        empleadoForm.querySelector('#nombre').value = empleado.nombre;
        empleadoForm.querySelector('#apellido').value = empleado.apellido;
        empleadoForm.querySelector('#email').value = empleado.email;
        empleadoForm.querySelector('#id_rol').value = empleado.id_rol;
        empleadoForm.querySelector('#estado').value = empleado.estado;
    };
</script>