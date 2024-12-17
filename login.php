<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php"); // Si ya está logueado, redirige a la página principal.
    exit();
}

include_once("procesos/Empleados.php");
$Empleados = new Empleados();

// Verificar si el empleado ha cerrado sesión
if (isset($_GET['logged_out']) && $_GET['logged_out'] == 1) {
    echo '<div class="alert alert-success" role="alert">Has cerrado sesión con éxito.</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resultado = $Empleados->getEmpleadoRolPorEmail($_POST);

    if ($resultado->num_rows > 0) {
        $empleado = $resultado->fetch_assoc();
        // Verificar la contraseña (aquí asumimos que la contraseña está cifrada)
        if (password_verify($empleado['contraseña_in'], $empleado['contraseña'])) {
            // Iniciar sesión
            $_SESSION['usuario'] = [
                'id_empleado' => $empleado['id_empleado'],
                'nombre' => $empleado['nombre'],
                'apellido' => $empleado['apellido'],
                'email' => $empleado['email'],
                'rol' => $empleado['id_rol'],
                'rol_nombre' => $empleado['rol_nombre'],
                'id_punto_venta' => $empleado['id_punto_venta']
            ];
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El email no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Adonai Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style-adonaiPrincipal.css" rel="stylesheet">
</head>

<body>
    <div class="container container-fluid">
        <!-- Mostrar errores si los hay -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!--  -->
        <section class="p-3 pt-1 p-md-4 pt-md-2 p-xl-5 pt-xl-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 bsb-tpl-bg-platinum">
                        <div class="d-flex flex-column justify-content-between h-100 p-3 pt-1 p-md-4 pt-md-2 p-xl-5 pt-xl-3">
                            <h3 class="m-0 text-adonaiPrincipal">¡Bienvenido al Sistema de Gestión de Inventario de Adonai Store!</h3>
                            <img class="img-fluid rounded-circle mx-auto my-2" loading="lazy" src="./assets/img/bsb-logo.webp" width="140" height="80" alt="BootstrapBrain Logo">
                            <p class="mb-1">Accede para administrar el inventario y mantener nuestras operaciones organizadas:</p>
                            <ul>
                                <li>Actualiza los registros de productos.</li>
                                <li>Consulta los niveles de stock en tiempo real.</li>
                                <li>Gestiona el ingreso y salida de mercancías.</li>
                            </ul>
                            <p class="mb-1">Este sistema está diseñado para facilitar tu trabajo y garantizar que la tienda funcione de manera eficiente.</p>
                            <p class="mb-0"><strong>Por favor, ingresa tus credenciales para continuar.</strong></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
                        <div class="p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h3 class="text-adonaiPrincipal">Acceder</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="login.php" method="POST">
                                <div class="row gy-3 gy-md-4 overflow-hidden">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@gmail.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="contraseña" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-adonaiPrincipal" type="submit">Inicie sesión ahora</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>