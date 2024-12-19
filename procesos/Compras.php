<?php
class Compras
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsCompras($estado = 'TODO', $id_compra = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "compras".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener compras
        $sql = "SELECT COUNT(*) total_registros FROM compras";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'ANULADO', ?)";
        } else {
            $sql = "$sql where estado = ?";
        }
        if ($id_compra > -1) {
            $sql = "$sql and id_compra = ?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        if ($id_compra > -1) {
            $result = $stmt->bind_param("si", $estado, $id_compra);
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

    public function getCompras($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener compras
        $sql = "SELECT * FROM compras";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'ANULADO', ?) ORDER BY id_compra LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_compra LIMIT ?,?";
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

    public function getCompra($id_compra)
    {
        $conn = $this->dbConnect;
        // Función para obtener compras
        $sql = "SELECT * FROM compras where id_compra = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_compra);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getPreciosComprasPorProducto($id_producto)
    {
        $conn = $this->dbConnect;
        // Función para obtener compras
        $sql = "SELECT min(precio_compra_x_unidad) min_precio_compra_x_unidad, max(precio_compra_x_unidad) max_precio_compra_x_unidad FROM compras where id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdCompra()
    {
        $next_id_compra = 1;
        $conn = $this->dbConnect;
        // Función para obtener compras
        $sql = "SELECT coalesce(max(id_compra), 0) + 1 next_id_compra FROM compras";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_compra = $row['next_id_compra'];
        }
        if (!(isset($next_id_compra) && $next_id_compra >= 0)) {
            $next_id_compra = 1;
        }

        return $next_id_compra;
    }

    public function insertCompra($_post)
    {
        $conn = $this->dbConnect;
        $id_compra = $this->getNextIdCompra();
        $id_producto = mysqli_real_escape_string($conn, $_post['id_producto']);
        $precio_compra_x_unidad = mysqli_real_escape_string($conn, $_post['precio_compra_x_unidad']);
        $cantidad = mysqli_real_escape_string($conn, $_post['cantidad']);
        $id_empleado = mysqli_real_escape_string($conn, $_post['id_empleado']);
        // Insertar compra
        $sql = "INSERT INTO compras (id_compra, id_producto, precio_compra_x_unidad, cantidad, id_empleado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iiiii", $id_compra, $id_producto, $precio_compra_x_unidad, $cantidad, $id_empleado);
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

    public function updateCompra($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_compra = mysqli_real_escape_string($conn, $_post['id_compra']);
        $id_producto = mysqli_real_escape_string($conn, $_post['id_producto']);
        $precio_compra_x_unidad = mysqli_real_escape_string($conn, $_post['precio_compra_x_unidad']);
        $cantidad = mysqli_real_escape_string($conn, $_post['cantidad']);
        $id_empleado = mysqli_real_escape_string($conn, $_post['id_empleado']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar compra
        $sql = "UPDATE compras set id_producto = ?, precio_compra_x_unidad = ?, cantidad = ?, id_empleado = ?, estado = ? where id_compra = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iiiisi", $id_producto, $precio_compra_x_unidad, $cantidad, $id_empleado, $estado, $id_compra);
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
