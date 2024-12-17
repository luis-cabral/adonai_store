<?php
class Ventas
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsVentas($estado = 'TODO', $id_venta = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "ventas".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "SELECT COUNT(*) total_registros FROM ventas";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'ANULADO', ?)";
        } else {
            $sql = "$sql where estado = ?";
        }
        if ($id_venta > -1) {
            $sql = "$sql and id_venta = ?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        if ($id_venta > -1) {
            $result = $stmt->bind_param("si", $estado, $id_venta);
        } else {
            $result = $stmt->bind_param("s", $estado);
        }
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_registros = $row['total_registros'];
        }
        $stmt->close();
        return $total_registros;
    }

    public function getVentas($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "SELECT * FROM ventas";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'ANULADO', ?) ORDER BY id_venta LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_venta LIMIT ?,?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sii", $estado, $calc_page, $num_results_on_page);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function getVentasXProductoXFecha($id_empleado = -1, $id_producto = -1)
    {
        //
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "select vent.id_producto, prod.descripcion, vent.fecha, sum(vent.cantidad) cantidad from ventas vent, productos prod where vent.id_producto=prod.id_producto and vent.fecha >= DATE_SUB(NOW(), INTERVAL 5 DAY) and vent.estado='ACTIVO' ";
        if ($id_empleado != -1) {
            $sql = "$sql and vent.id_empleado = ? ";
        } else {
            $sql = "$sql and (vent.id_empleado = ? or vent.id_empleado = vent.id_empleado) ";
        }
        if ($id_producto > -1) {
            $sql = "$sql and vent.id_producto = ?";
        } else {
            $sql = "$sql and (vent.id_producto = ? or vent.id_producto = vent.id_producto) ";
        }
        $sql = "$sql group by vent.id_producto, prod.descripcion, vent.fecha ORDER BY vent.fecha, vent.id_producto";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("ii", $id_empleado, $id_producto);
        if (false === $result) {
            die('bind_param() failed' . $stmt->error);
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function getTotalItemsVentasReporteEmpleado($id_empleado = -1, $id_producto = -1, $id_cliente = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "ventas".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "select count(*) as total_registros from ventas vent, productos prod, clientes clie, empleados empl where vent.id_producto=prod.id_producto and clie.id_cliente=vent.id_cliente and empl.id_empleado=vent.id_empleado and vent.estado = 'ACTIVO' ";
        if ($id_empleado != -1) {
            $sql = "$sql and vent.id_empleado = ? ";
        } else {
            $sql = "$sql and (vent.id_empleado = ? or vent.id_empleado = vent.id_empleado) ";
        }
        if ($id_producto > -1) {
            $sql = "$sql and vent.id_producto = ?";
        } else {
            $sql = "$sql and (vent.id_producto = ? or vent.id_producto = vent.id_producto) ";
        }
        if ($id_cliente > -1) {
            $sql = "$sql and vent.id_cliente = ?";
        } else {
            $sql = "$sql and (vent.id_cliente = ? or vent.id_cliente = vent.id_cliente) ";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iii", $id_empleado, $id_producto, $id_cliente);
        if (false === $result) {
            die('bind_param() failed' . $stmt->error);
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_registros = $row['total_registros'];
        }
        $stmt->close();
        return $total_registros;
    }

    public function getVentasReporteEmpleado($id_empleado = -1, $id_producto = -1, $id_cliente = -1, $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "select vent.id_venta, vent.id_producto, prod.descripcion, vent.fecha, vent.precio_venta_x_unidad, vent.cantidad, vent.precio_venta_total, vent.id_cliente, clie.cedula, clie.nombre, clie.apellido, vent.id_empleado, CONCAT(empl.nombre, ' ', empl.apellido) nombre_empleado from ventas vent, productos prod, clientes clie, empleados empl where vent.id_producto=prod.id_producto and clie.id_cliente=vent.id_cliente and empl.id_empleado=vent.id_empleado and vent.estado = 'ACTIVO' ";
        if ($id_empleado != -1) {
            $sql = "$sql and vent.id_empleado = ? ";
        } else {
            $sql = "$sql and (vent.id_empleado = ? or vent.id_empleado = vent.id_empleado) ";
        }
        if ($id_producto > -1) {
            $sql = "$sql and vent.id_producto = ?";
        } else {
            $sql = "$sql and (vent.id_producto = ? or vent.id_producto = vent.id_producto) ";
        }
        if ($id_cliente > -1) {
            $sql = "$sql and vent.id_cliente = ?";
        } else {
            $sql = "$sql and (vent.id_cliente = ? or vent.id_cliente = vent.id_cliente) ";
        }
        $sql = "$sql ORDER BY vent.fecha desc LIMIT ?,?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iiiii", $id_empleado, $id_producto, $id_cliente, $calc_page, $num_results_on_page);
        if (false === $result) {
            die('bind_param() failed' . $stmt->error);
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function getVenta($id_venta)
    {
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "SELECT * FROM ventas where id_venta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_venta);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdVenta()
    {
        $next_id_venta = 1;
        $conn = $this->dbConnect;
        // Función para obtener ventas
        $sql = "SELECT coalesce(max(id_venta), 0) + 1 next_id_venta FROM ventas";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_venta = $row['next_id_venta'];
        }
        if (!(isset($next_id_venta) && $next_id_venta >= 0)) {
            $next_id_venta = 1;
        }

        return $next_id_venta;
    }

    public function insertVenta($_post)
    {
        $conn = $this->dbConnect;
        $id_venta = $this->getNextIdVenta();
        $id_producto = mysqli_real_escape_string($conn, $_post['id_producto']);
        $precio_venta_x_unidad = mysqli_real_escape_string($conn, $_post['precio_venta_x_unidad']);
        $cantidad = mysqli_real_escape_string($conn, $_post['cantidad']);
        $id_cliente = mysqli_real_escape_string($conn, $_post['id_cliente']);
        $id_punto_venta = mysqli_real_escape_string($conn, $_post['id_punto_venta']);
        $id_empleado = mysqli_real_escape_string($conn, $_post['id_empleado']);
        // Insertar venta
        $sql = "INSERT INTO ventas (id_venta, id_producto, precio_venta_x_unidad, cantidad, id_cliente, id_punto_venta, id_empleado) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iiiiiii", $id_venta, $id_producto, $precio_venta_x_unidad, $cantidad, $id_cliente, $id_punto_venta, $id_empleado);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function updateVenta($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_venta = mysqli_real_escape_string($conn, $_post['id_venta']);
        $id_producto = mysqli_real_escape_string($conn, $_post['id_producto']);
        $precio_venta_x_unidad = mysqli_real_escape_string($conn, $_post['precio_venta_x_unidad']);
        $cantidad = mysqli_real_escape_string($conn, $_post['cantidad']);
        $id_cliente = mysqli_real_escape_string($conn, $_post['id_cliente']);
        $id_punto_venta = mysqli_real_escape_string($conn, $_post['id_punto_venta']);
        $id_empleado = mysqli_real_escape_string($conn, $_post['id_empleado']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar venta
        $sql = "UPDATE ventas set id_producto = ?, precio_venta_x_unidad = ?, cantidad = ?, id_cliente = ?, id_punto_venta = ?, id_empleado = ?, estado = ? where id_venta = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iiiiiisi", $id_producto, $precio_venta_x_unidad, $cantidad, $id_cliente, $id_punto_venta, $id_empleado, $estado, $id_venta);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }
}
