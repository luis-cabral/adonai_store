<?php
class Roles
{
    private $dbConnect = null;
    //
    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsRoles($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "roles".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener roles
        $sql = "SELECT COUNT(*) total_registros FROM roles";
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

    public function getRoles($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener roles
        $sql = "SELECT * FROM roles";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_rol LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_rol LIMIT ?,?";
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

    public function getRol($id_rol)
    {
        $conn = $this->dbConnect;
        // Función para obtener roles
        $sql = "SELECT * FROM roles where id_rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_rol);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdRol()
    {
        $next_id_rol = 1;
        $conn = $this->dbConnect;
        // Función para obtener rol
        $sql = "SELECT coalesce(max(id_rol), 0) + 1 next_id_rol FROM roles";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_rol = $row['next_id_rol'];
        }
        if (!(isset($next_id_rol) && $next_id_rol >= 0)) {
            $next_id_rol = 1;
        }

        return $next_id_rol;
    }

    public function insertRol($_post)
    {
        $conn = $this->dbConnect;
        $id_rol = $this->getNextIdRol();
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_post['descripcion']);
        // Insertar rol
        $sql = "INSERT INTO roles (id_rol, nombre, descripcion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iss", $id_rol, $nombre, $descripcion);
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

    public function updateRol($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_post['descripcion']);

        // Insertar rol
        $sql = "UPDATE roles set nombre = ?, descripcion = ? where id_rol = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("ssi", $nombre, $descripcion, $id_rol);
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
