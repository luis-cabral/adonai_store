<?php
class Puntos_venta
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsPuntos_venta($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "puntos_venta".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener puntos_venta
        $sql = "SELECT COUNT(*) total_registros FROM puntos_venta";
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

    public function getPuntos_venta($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener puntos_venta
        $sql = "SELECT * FROM puntos_venta";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_punto_venta LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_punto_venta LIMIT ?,?";
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

    public function getPunto_venta($id_punto_venta)
    {
        $conn = $this->dbConnect;
        // Función para obtener puntos_venta
        $sql = "SELECT * FROM puntos_venta where id_punto_venta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_punto_venta);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdPunto_venta()
    {
        $next_id_punto_venta = 1;
        $conn = $this->dbConnect;
        // Función para obtener puntos_venta
        $sql = "SELECT coalesce(max(id_punto_venta), 0) + 1 next_id_punto_venta FROM puntos_venta";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_punto_venta = $row['next_id_punto_venta'];
        }
        if (!(isset($next_id_punto_venta) && $next_id_punto_venta >= 0)) {
            $next_id_punto_venta = 1;
        }

        return $next_id_punto_venta;
    }

    public function insertPunto_venta($_post)
    {
        $conn = $this->dbConnect;
        $id_punto_venta = $this->getNextIdPunto_venta();
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        // Insertar punto_venta
        $sql = "INSERT INTO puntos_venta (id_punto_venta, nombre, direccion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iss", $id_punto_venta, $nombre, $direccion);
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

    public function updatePunto_venta($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_punto_venta = mysqli_real_escape_string($conn, $_post['id_punto_venta']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar punto_venta
        $sql = "UPDATE puntos_venta set nombre = ?, direccion = ?, estado = ? where id_punto_venta = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sssi", $nombre, $direccion, $estado, $id_punto_venta);
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
