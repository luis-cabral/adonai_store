<?php
$id_rol = $_SESSION['usuario']['rol'];  // Obtenemos el rol del usuario desde la sesión
#echo $id_rol;
include_once 'procesos/Ventanas.php';
$Ventanas = new Ventanas();
?>

<link href="./assets/css/style-principal.css" rel="stylesheet">
<style>
    .navbar-adonai-store {
        font-family: sans-serif;
    }
</style>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light navbar-adonai-store bg-principal">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="color: #333333; font-weight: bold;">Adonai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php
                $GruposVentanas = $Ventanas->getGruposVentanasPorRol($id_rol);
                while ($grupoVentana = $GruposVentanas->fetch_assoc()) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown<?php echo $grupoVentana['grupo']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #333333;">
                            <?php echo $grupoVentana['grupo']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $grupoVentana['grupo']; ?>">
                            <?php
                            $ventanas = $Ventanas->getVentanasPorRolGrupo($id_rol, $grupoVentana['grupo']);
                            while ($ventana = $ventanas->fetch_assoc()) {
                            ?>
                                <li><a class="dropdown-item" href="<?php echo $ventana['id_ventana']; ?>" style="color: #333333;"><?php echo $ventana['descripcion']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <!-- Enlace para desloguearse -->
            <a class="nav-item nav-link btn btn-outline-danger d-flex text-danger ps-0" style="border: none;" tabindex="-1" href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</nav>