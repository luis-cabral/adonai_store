<?php
session_start();
// Aseguramos que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
//
include_once 'procesos/Productos.php';
$Productos = new Productos();
include_once 'procesos/Ventas.php';
$Ventas = new Ventas();

// Obtenga el número total de registros de nuestra tabla "productos".
$total_pages = $Productos->getTotalItemsProductos('ACTIVO');
$result = $Productos->getProductos('ACTIVO', 1, $total_pages);
// Crear un arreglo para almacenar los datos
$productos_list = array();
while ($row = $result->fetch_assoc()) {
    // $row['bajo_stock'] = ($row['stock'] < 3) ? 'Sí' : 'No';
    $productos_list[] = $row;
}

// Obtenga el número total de registros de nuestra tabla "ventas".
if ($_SESSION['usuario']["rol"] == 1) {
    $result = $Ventas->getVentasXProductoXFecha();
} else {
    $result = $Ventas->getVentasXProductoXFecha($_SESSION['usuario']["id_empleado"]);
}
// Crear un arreglo para almacenar los datos
$ventas_list = array();
while ($row = $result->fetch_assoc()) {
    $ventas_list[] = $row;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adonai Store</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style-adonaiPrincipal.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    h1 {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    p {
        font-size: 1.2rem;
    }

    h1,
    p {
        opacity: 0;
        animation: fadeIn 1.5s forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn {
        transition: background-color 0.3s, color 0.3s;
    }

    .btn:hover {
        background-color: #C9302C;
        /* Más oscuro al pasar el cursor */
        color: #FFFFFF;
    }

    /* Asegura que el contenedor del gráfico sea flexible */
    .chart-container {
        position: relative;
        width: 100%;
        height: 50vh;
        /* Esto asegura que la altura sea responsive */
    }

    /* Opcional: Puedes añadir un poco de margen o padding para un mejor diseño en dispositivos móviles */
    @media (max-width: 768px) {
        .chart-container {
            height: 40vh;
            /* Ajusta la altura en pantallas más pequeñas */
        }
    }
</style>

<body class="container-index">
    <?php
    include_once("navbar.php")
    ?>

    <div id="indexCarouselIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="10000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-flex justify-content-center mt-1">
                    <div class="text-center p-1" style="filter: brightness(0.8); background-color: rgba(0, 0, 0, 0.5); border-radius: 10px;">
                        <h2 class="text-white fw-bold mb-0">Bienvenido a Adonai Store</h2>
                        <p class="pb-0 mb-0 text-white ">Stock de Productos</p>
                    </div>
                </div>
                <div class="container bg-white mt-1 chart-container" style="max-height: 460px;">
                    <canvas id="productosChart"></canvas>
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center mt-1">
                    <div class="text-center p-1" style="filter: brightness(0.8); background-color: rgba(0, 0, 0, 0.5); border-radius: 10px;">
                        <h2 class="text-white fw-bold mb-0">Bienvenido a Adonai Store</h2>
                        <p class="pb-0 mb-0 text-white ">Cantidad de productos vendidos por fecha en los ultimos 5 dias</p>
                    </div>
                </div>
                <div class="container bg-white mt-1 chart-container" style="max-height: 460px;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#indexCarouselIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#indexCarouselIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>


    <script>
        // Datos para el gráfico
        var labelsProductos = [];
        var dataProductos = [];
        <?php foreach ($productos_list as $producto): ?>
            labelsProductos.push('<?php echo $producto['id_producto']; ?> - <?php echo $producto['descripcion']; ?>');
            dataProductos.push(<?php echo $producto['stock']; ?>);
        <?php endforeach; ?>

        // Crear el gráfico
        let ctxProductos = document.getElementById('productosChart').getContext('2d');
        let productosChart = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: labelsProductos,
                datasets: [{
                    label: 'Stock de Productos',
                    data: dataProductos,
                    backgroundColor: function(context) {
                        let index = context.dataIndex;
                        let value = dataProductos[index];
                        return value < 5 ? 'rgba(255, 51, 57, 0.2)' : 'rgba(54, 162, 235, 0.2)';
                    },
                    borderColor: function(context) {
                        let index = context.dataIndex;
                        let value = dataProductos[index];
                        return value < 5 ? 'rgba(255, 51, 57, 1)' : 'rgba(54, 162, 235, 1)';
                    },
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Hacer el gráfico responsive
                maintainAspectRatio: false, // No mantener la relación de aspecto original
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        let index = elements[0].index;
                        let productos = <?php echo json_encode($productos_list); ?>;
                        console.log(index, productos[index])
                        let idProducto = productos[index]['id_producto'];
                        let url = 'gestion_productos.php?id_producto=' + idProducto;
                        window.location.href = url;
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index, ticks) {
                                const stock = dataProductos[index];
                                if (stock < 5) {
                                    return `${this.getLabelForValue(value)}`;
                                }
                                return this.getLabelForValue(value);
                            },
                            color: function(context) {
                                const stock = dataProductos[context.index];
                                return stock < 5 ? 'red' : 'black'; // Cambia el color del texto
                            }
                        }
                    },
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            }
        });
        //
        // Datos para el gráfico
        // Obtener todas las fechas únicas
        let data = <?php echo json_encode($ventas_list); ?>;
        console.log(data);
        const fechas = [...new Set(data.map(item => item.fecha))];

        // Organizar datos por descripción
        const productos = {};
        data.forEach(item => {
            if (!productos[item.descripcion]) {
                productos[item.descripcion] = Array(fechas.length).fill(0);
            }
            const index = fechas.indexOf(item.fecha);
            productos[item.descripcion][index] = item.cantidad;
        });

        // Generar datasets para Chart.js
        const datasets = Object.keys(productos).map((descripcion, i) => ({
            label: descripcion,
            data: productos[descripcion],
            backgroundColor: `rgba(${50 + i * 50}, ${100 + i * 30}, ${150 + i * 20}, 0.6)`,
            borderColor: `rgba(${50 + i * 50}, ${100 + i * 30}, ${150 + i * 20}, 1)`,
            borderWidth: 1
        }));

        // Crear el gráfico
        const ventaschart = document.getElementById('ventasChart').getContext('2d');
        new Chart(ventaschart, {
            type: 'bar',
            data: {
                labels: fechas,
                datasets: datasets
            },
            options: {
                responsive: true, // Hacer el gráfico responsive
                maintainAspectRatio: false, // No mantener la relación de aspecto original
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</html>