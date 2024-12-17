<?php
class Productos
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsProductos($estado = 'TODO', $id_producto = -1, $id_proveedor = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "productos".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener productos
        $sql = "SELECT COUNT(*) total_registros FROM productos";
        if ($estado == 'TODO') {
            $sql = "$sql where (estado = ? or estado = estado)";
        } else {
            $sql = "$sql where estado = ?";
        }
        if ($id_producto > -1) {
            $sql = "$sql and id_producto = ?";
        } else {
            $sql = "$sql and (id_producto = ? or id_producto = id_producto)";
        }
        if ($id_proveedor > -1) {
            $sql = "$sql and id_proveedor = ?";
        } else {
            $sql = "$sql and (id_proveedor = ? or id_proveedor = id_proveedor)";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sii", $estado, $id_producto, $id_proveedor);
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

    public function getProductos($estado = 'TODO', $page = 1, $num_results_on_page = 5, $id_producto = -1, $id_proveedor = -1)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener productos
        $sql = "SELECT * FROM productos";
        if ($estado == 'TODO') {
            $sql = "$sql where (estado = ? or estado = estado)";
        } else {
            $sql = "$sql where estado = ?";
        }
        if ($id_producto > -1) {
            $sql = "$sql and id_producto = ?";
        } else {
            $sql = "$sql and (id_producto = ? or id_producto = id_producto)";
        }
        if ($id_proveedor > -1) {
            $sql = "$sql and id_proveedor = ?";
        } else {
            $sql = "$sql and (id_proveedor = ? or id_proveedor = id_proveedor)";
        }
        $sql = "$sql ORDER BY id_producto LIMIT ?,?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("siiii", $estado, $id_producto, $id_proveedor, $calc_page, $num_results_on_page);
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

    public function getProducto($id_producto)
    {
        $conn = $this->dbConnect;
        // Función para obtener productos
        $sql = "SELECT * FROM productos where id_producto = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("i", $id_producto);
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

    public function getNextIdProducto()
    {
        $next_id_producto = 1;
        $conn = $this->dbConnect;
        // Función para obtener productos
        $sql = "SELECT coalesce(max(id_producto), 0) + 1 next_id_producto FROM productos";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_producto = $row['next_id_producto'];
        }
        if (!(isset($next_id_producto) && $next_id_producto >= 0)) {
            $next_id_producto = 1;
        }

        return $next_id_producto;
    }

    public function insertProducto($_post)
    {
        $conn = $this->dbConnect;
        $id_producto = $this->getNextIdProducto();
        $descripcion = mysqli_real_escape_string($conn, $_post['descripcion']);
        $id_proveedor = mysqli_real_escape_string($conn, $_post['id_proveedor']);
        // Insertar producto
        $sql = "INSERT INTO productos (id_producto, descripcion, id_proveedor) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("isi", $id_producto, $descripcion, $id_proveedor);
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

    public function updateProducto($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_producto = mysqli_real_escape_string($conn, $_post['id_producto']);
        $descripcion = mysqli_real_escape_string($conn, $_post['descripcion']);
        $id_proveedor = mysqli_real_escape_string($conn, $_post['id_proveedor']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar producto
        $sql = "UPDATE productos set descripcion = ?, id_proveedor = ?, estado = ? where id_producto = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sisi", $descripcion, $id_proveedor, $estado, $id_producto);
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
