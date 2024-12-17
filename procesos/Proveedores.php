<?php
class Proveedores
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsProveedores($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "proveedores".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener proveedores
        $sql = "SELECT COUNT(*) total_registros FROM proveedores";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?)";
        } else {
            $sql = "$sql where estado = ?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("s", $estado);
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

    public function getProveedores($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener proveedores
        $sql = "SELECT * FROM proveedores";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_proveedor LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_proveedor LIMIT ?,?";
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

    public function getProveedor($id_proveedor)
    {
        $conn = $this->dbConnect;
        // Función para obtener proveedores
        $sql = "SELECT * FROM proveedores where id_proveedor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_proveedor);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdProveedor()
    {
        $next_id_proveedor = 1;
        $conn = $this->dbConnect;
        // Función para obtener proveedores
        $sql = "SELECT coalesce(max(id_proveedor), 0) + 1 next_id_proveedor FROM proveedores";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_proveedor = $row['next_id_proveedor'];
        }
        if (!(isset($next_id_proveedor) && $next_id_proveedor >= 0)) {
            $next_id_proveedor = 1;
        }

        return $next_id_proveedor;
    }

    public function insertProveedor($_post)
    {
        $conn = $this->dbConnect;
        #$id_proveedor = $this->getNextIdProveedor();
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $contacto = mysqli_real_escape_string($conn, $_post['contacto']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        // Insertar proveedor
        $sql = "INSERT INTO proveedores (nombre, contacto, direccion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sss", $nombre, $contacto, $direccion);
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

    public function updateProveedor($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_proveedor = mysqli_real_escape_string($conn, $_post['id_proveedor']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $contacto = mysqli_real_escape_string($conn, $_post['contacto']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar proveedor
        $sql = "UPDATE proveedores set nombre = ?, contacto = ?, direccion = ?, estado = ? where id_proveedor = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("ssssi", $nombre, $contacto, $direccion, $estado, $id_proveedor);
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
