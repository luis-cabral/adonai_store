<?php
class Usuarios
{
    private $dbConnect = null;
    //id_usuario, nombre, apellido, email, contraseña, rol, estado, fch_estado
    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsUsuarios($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "usuarios".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener usuarios
        $sql = "SELECT COUNT(*) total_registros FROM usuarios";
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

    public function getUsuarios($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener usuarios
        $sql = "SELECT * FROM usuarios";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_usuario LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_usuario LIMIT ?,?";
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

    public function getUsuario($id_usuario)
    {
        $conn = $this->dbConnect;
        // Función para obtener usuarios
        $sql = "SELECT * FROM usuarios where id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getUsuarioPorEmail($email)
    {
        $conn = $this->dbConnect;
        // Función para obtener usuarios
        $sql = "SELECT * FROM usuarios where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getUsuarioRolPorEmail($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los valores del formulario
        $email = mysqli_real_escape_string($conn, $_post['email']);
        $contraseña = mysqli_real_escape_string($conn, $_post['contraseña']);
        // Función para obtener usuarios
        $sql = "SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.id_rol, r.nombre AS rol_nombre, u.contraseña, ? as contraseña_in FROM usuarios u JOIN rol r ON u.id_rol = r.id_rol WHERE u.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $contraseña, $email);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdUsuario()
    {
        $next_id_usuario = 1;
        $conn = $this->dbConnect;
        // Función para obtener usuarios
        $sql = "SELECT coalesce(max(id_usuario), 0) + 1 next_id_usuario FROM usuarios";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_usuario = $row['next_id_usuario'];
        }
        if (!(isset($next_id_usuario) && $next_id_usuario >= 0)) {
            $next_id_usuario = 1;
        }

        return $next_id_usuario;
    }

    public function insertUsuario($_post)
    {
        $conn = $this->dbConnect;
        $id_usuario = $this->getNextIdUsuario();
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $email = mysqli_real_escape_string($conn, $_post['email']);
        $contraseña = mysqli_real_escape_string($conn, $_post['contraseña']);
        //
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);  // Contraseña encriptada
        //
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        // Insertar usuario
        $sql = "INSERT INTO usuarios (id_usuario, nombre, apellido, email, contraseña, id_rol) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("issssi", $id_usuario, $nombre, $apellido, $email, $contraseña, $id_rol);
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

    public function updateUsuario($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_usuario = mysqli_real_escape_string($conn, $_post['id_usuario']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $email = mysqli_real_escape_string($conn, $_post['email']);
        //
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar usuario
        $sql = "UPDATE usuarios set nombre = ?, apellido = ?, email = ?, id_rol = ?, estado = ? where id_usuario = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sssisi", $nombre, $apellido, $email, $id_rol, $estado, $id_usuario);
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
