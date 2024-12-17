<?php
class Empleados
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsEmpleados($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "empleados".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener empleados
        $sql = "SELECT COUNT(*) total_registros FROM empleados";
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

    public function getEmpleados($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener empleados
        $sql = "SELECT empl.*, puve.nombre as punto_venta_nombre, puve.direccion as punto_venta_direccion, role.nombre as nombre_rol FROM empleados empl, roles role, puntos_venta puve where empl.id_punto_venta=puve.id_punto_venta and role.id_rol=empl.id_rol ";
        if ($estado == 'TODO') {
            $sql = "$sql and empl.estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY empl.id_empleado LIMIT ?,?";
        } else {
            $sql = "$sql and empl.estado = ? ORDER BY empl.id_empleado LIMIT ?,?";
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

    public function getEmpleado($id_empleado)
    {
        $conn = $this->dbConnect;
        // Función para obtener empleados
        $sql = "SELECT empl.*, puve.nombre as punto_venta_nombre, puve.direccion as punto_venta_direccion, role.nombre as nombre_rol FROM empleados empl, roles role, puntos_venta puve where empl.id_punto_venta=puve.id_punto_venta and role.id_rol=empl.id_rol and empl.id_empleado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_empleado);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getEmpleadoPorEmail($email)
    {
        $conn = $this->dbConnect;
        // Función para obtener empleados
        $sql = "SELECT * FROM empleados where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getEmpleadoRolPorEmail($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los valores del formulario
        $email = mysqli_real_escape_string($conn, $_post['email']);
        $contraseña = mysqli_real_escape_string($conn, $_post['contraseña']);
        // Función para obtener empleados
        $sql = "SELECT empl.*, role.nombre AS rol_nombre, ? as contraseña_in FROM empleados empl JOIN roles role ON empl.id_rol = role.id_rol WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $contraseña, $email);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdEmpleado()
    {
        $next_id_empleado = 1;
        $conn = $this->dbConnect;
        // Función para obtener empleados
        $sql = "SELECT coalesce(max(id_empleado), 0) + 1 next_id_empleado FROM empleados";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_empleado = $row['next_id_empleado'];
        }
        if (!(isset($next_id_empleado) && $next_id_empleado >= 0)) {
            $next_id_empleado = 1;
        }

        return $next_id_empleado;
    }

    public function insertEmpleado($_post)
    {
        $conn = $this->dbConnect;
        $id_empleado = $this->getNextIdEmpleado();
        $id_punto_venta = mysqli_real_escape_string($conn, $_post['id_punto_venta']);
        $cedula = mysqli_real_escape_string($conn, $_post['cedula']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $email = mysqli_real_escape_string($conn, $_post['email']);
        $contraseña = mysqli_real_escape_string($conn, $_post['contraseña']);
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);  // Contraseña encriptada
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        // Insertar empleado
        $sql = "INSERT INTO empleados (id_empleado, id_punto_venta, cedula, nombre, apellido, email, contraseña, id_rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("iisssssi", $id_empleado, $id_punto_venta, $cedula, $nombre, $apellido, $email, $contraseña, $id_rol);
        if (false === $result) {
            die("bind_param() failed 'iisssssi', $id_empleado, $id_punto_venta, $cedula, $nombre, $apellido, $email, $contraseña, $id_rol");
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function updateEmpleado($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_empleado = mysqli_real_escape_string($conn, $_post['id_empleado']);
        $id_punto_venta = mysqli_real_escape_string($conn, $_post['id_punto_venta']);
        $cedula = mysqli_real_escape_string($conn, $_post['cedula']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $email = mysqli_real_escape_string($conn, $_post['email']);
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar empleado
        $sql = "UPDATE empleados set id_punto_venta = ?, cedula = ?, nombre = ?, apellido = ?, email = ?, id_rol = ?, estado = ? where id_empleado = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("issssisi", $id_punto_venta, $cedula, $nombre, $apellido, $email, $id_rol, $estado, $id_empleado);
        if (false === $result) {
            die("bind_param() failed 'issssisi', $id_punto_venta, $cedula, $nombre, $apellido, $email, $id_rol, $estado, $id_empleado");
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
